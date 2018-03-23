<?php

namespace App\Http\Controllers\API\PRY;
use App\Transaction;
use App\TransactionDetail;
use App\Taxpayer;
use App\Cycle;
use App\TaxpayerIntegration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use DB;
use File;
use Storage;
use ZipArchive;

class HechukaController extends Controller
{
    public function getHechauka(Taxpayer $taxPayer, $startDate, $endDate, $teamID)
    {
        //$taxpayer = Taxpayer::where('id', $taxPayer)->first();

        //Get the Integration Once. No need to bring it into the Query.
        $integration = TaxpayerIntegration::where('taxpayer_id', $taxPayer->id)
        ->where('team_id', Auth::user()->currentTeamID)
        ->first();

        $this->generateSales($startDate, $endDate, $taxpayer, $integration);
        $this->generatePurchases($startDate, $endDate, $taxpayer, $integration);
    }

    public function generateSales($startDate, $endDate, $taxPayer, $integration)
    {
        $data = DB::select('
        select
        max(t.id) as ID,
        max(customer.name) Partner,
        max(customer.taxid) PartnerTaxID,
        max(customer.code) PartnerTaxCode,
        max(t.date) as Date,
        max(t.number) as Number,
        max(t.code) as Code,
        max(t.payment_condition) as Condition,
        max(t.code_expiry) as CodeExpiry,
        max(t.document_type) as DocumentType,
        ROUND(sum(td.ValueInZero) / t.rate) as ValueInZero,
        ROUND(sum(td.ValueInFive) / t.rate) as ValueInFive,
        ROUND((sum(td.ValueInFive) / t.rate) / 21) as VATInFive,
        ROUND(sum(td.ValueInTen) / t.rate) as ValueInTen,
        ROUND((sum(td.ValueInTen) / t.rate) / 11) as VATInTen
        from transactions as t
        join
        ( select
        max(transaction_id) as transaction_id,
        sum(value) as value,
        max(c.coefficient) as coefficient,
        if(max(c.coefficient) = 0, sum(value), 0) as ValueInZero,
        if(max(c.coefficient) = 0.5, sum(value), 0) as ValueInFive,
        if(max(c.coefficient) = 0.1, sum(value), 0) as ValueInTen
        from transaction_details
        join charts as c on transaction_details.chart_vat_id = c.id
        group by transaction_id, transaction_details.chart_vat_id
        ) as td on td.transaction_id = t.id
        join taxpayers as customer on t.customer_id = customer.id
        where supplier.taxid = ' . $taxPayer->id . ' and date between "' . $startDate . '" and "' . $endDate . '" and
        t.type in [3,4]
        group by t.id');

        foreach ($raw->chunk(15000) as $data)
        {
            $taxPayerTaxID = $taxPayer->taxid;
            $taxPayerTaxCode = $taxPayer->code;

            if (isset($integration))
            {
                $agentName = $integration->agent_name;
                $agentTaxID = $integration->agent_taxid;
                $agentTaxCode = 0;
            }

            $obligationCode = 921;
            $formCode = 221;

            $dateCode = $data->first()->$date->format('Y') . $data->first()->$date->format('m');

            $header =
            /* 1 */ '1' .
            /* 2 */ '\t' . $dateCode .
            /* 3 */ '\t' . '1' .
            /* 4 */ '\t' . $obligationCode .
            /* 5 */ '\t' . $formCode .
            /* 6 */ '\t' . $taxPayerTaxID .
            /* 7 */ '\t' . $taxPayerTaxCode .
            /* 8 */ '\t' . $taxPayer->name .
            /* 9 */ '\t' . $agentTaxID .
            /* 10 */ '\t' . $agentTaxCode .
            /* 11 */ '\t' . $agentName .
            /* 12 */ '\t' . $data->count() ?? 0 .
            /* 13 */ '\t' . $data->sum($ValueInTen) + $data->sum($ValueInFive) + $data->sum($ValueInZero) .
            /* 14 */ '\t' . "2";

            //Improve Naming convention, also add Taxpayer Folder.
            Storage::disk('local')->append('Hechauka ' . $dateCode  . '.txt', $header);

            $detail = '';

            //todo this is wrong. Your foreachs hould be smaller
            foreach ($data as  $row)
            {
                //Check if Partner has TaxID and TaxCode properly coded, or else substitute for generic user.
                $detail = $detail .
                /* 1 */ '2' .
                /* 2 */ '\t' . $row->PartnerTaxID .
                /* 3 */ '\t' . $row->PartnerTaxCode .
                /* 4 */ '\t' . $row->Partner .
                /* 5 */ '\t' . $row->DocumentType .
                /* 6 */ '\t' . $row->Number .
                /* 7 */ '\t' . date_format($row->Date, 'd/m/Y') .
                /* 8 */ '\t' . $row->ValueInTen .
                /* 9 */ '\t' . $row->VATInTen .
                /* 10 */ '\t' . $row->ValueInFive .
                /* 11 */ '\t' . $row->VATInFive .
                /* 12 */ '\t' . $row->ValueInZero .
                /* 13 */ '\t' . $data->ValueInTen + $data->ValueInFive + $data->ValueInZero .
                /* 14 */ '\t' . $row->Condition == 0 ? 1 : 2 .
                /* 15 */ '\t' . $row->Condition .
                /* 16 */ '\t' . $row->Code;
            }

            //Maybe save to string variable frist, and then append at the end.
            Storage::disk('local')->append( 'Test.txt', $detail);
        }
    }

    public function generatePurchases($startDate, $endDate, $taxPayer, $integration)
    {
        $data = DB::select('select
        max(t.id) as ID,
        max(supplier.name) as Partner,
        max(supplier.taxid) as PartnerTaxID,
        max(supplier.code) as PartnerTaxCode,
        max(t.date) as Date,
        max(t.number) as Number,
        max(t.code) as Code,
        max(t.payment_condition) as Condition,
        max(t.code_expiry) as CodeExpiry,
        max(t.document_type) as DocumentType,
        -- max(t.operation_type) as OperationType,
        ROUND(sum(td.ValueInZero) / t.rate) as ValueInZero,
        ROUND(sum(td.ValueInFive) / t.rate) as ValueInFive,
        ROUND((sum(td.ValueInFive) / t.rate) / 21) as VATInFive,
        ROUND(sum(td.ValueInTen) / t.rate) as ValueInTen,
        ROUND((sum(td.ValueInTen) / t.rate) / 11) as VATInTen
        from transactions as t
        join
        ( select
        max(transaction_id) as transaction_id,
        sum(value) as value,
        max(c.coefficient) as coefficient,
        if(max(c.coefficient) = 0, sum(value), 0) as ValueInZero,
        if(max(c.coefficient) = 0.5, sum(value), 0) as ValueInFive,
        if(max(c.coefficient) = 0.1, sum(value), 0) as ValueInTen
        from transaction_details
        join charts as c on transaction_details.chart_vat_id = c.id
        group by transaction_id, transaction_details.chart_vat_id
        ) as td on td.transaction_id = t.id
        join taxpayers as supplier on t.supplier_id = supplier.id
        where
        supplier.taxid = ' . $taxPayer->id . ' and
        date between "' . $startDate . '" and "' . $endDate . '" and
        t.type in [1,2,5]
        group by t.id');

        foreach ($raw->chunk(15000) as $data)
        {
            $taxPayerTaxID = $taxPayer->taxid;
            $taxPayerTaxCode = $taxPayer->code;

            if (isset($integration))
            {
                $agentName = $integration->agent_name;
                $agentTaxID = $integration->agent_taxid;
                $agentTaxCode = 0;
            }

            $obligationCode = 911;
            $formCode = 211;

            $dateCode = $data->first()->$date->format('Y') . $data->first()->$date->format('m');

            $header =
            /* 1 */ '1' .
            /* 2 */ '\t' . $dateCode .
            /* 3 */ '\t' . '1' .
            /* 4 */ '\t' . $obligationCode .
            /* 5 */ '\t' . $formCode .
            /* 6 */ '\t' . $taxPayerTaxID .
            /* 7 */ '\t' . $taxPayerTaxCode .
            /* 8 */ '\t' . $taxPayer->name .
            /* 9 */ '\t' . $agentTaxID .
            /* 10 */ '\t' . $agentTaxCode .
            /* 11 */ '\t' . $agentName .
            /* 12 */ '\t' . $data->count() ?? 0 .
            /* 13 */ '\t' . $data->sum($ValueInTen) + $data->sum($ValueInFive) + $data->sum($ValueInZero) .
            /* 14 */ '\t' . $taxPayer->is_exporter ? 'Si' : 'No' .
            /* 15 */ '\t' . "2";

            //Improve Naming convention, also add Taxpayer Folder.
            Storage::disk('local')->append('Hechauka ' . $dateCode  . '.txt', $header);

            $detail = '';

            //todo this is wrong. Your foreachs hould be smaller
            foreach ($data as  $row)
            {
                //Check if Partner has TaxID and TaxCode properly coded, or else substitute for generic user.
                $detail = $detail .
                /* 1 */ '2' .
                /* 2 */ '\t' . $row->PartnerTaxID .
                /* 3 */ '\t' . $row->PartnerTaxCode .
                /* 4 */ '\t' . $row->Partner .
                /* 5 */ '\t' . $row->Code .
                /* 6 */ '\t' . $row->DocumentType .
                /* 7 */ '\t' . $row->Number .
                /* 8 */ '\t' . date_format($row->Date, 'd/m/Y') .
                /* 9 */ '\t' . $row->ValueInTen .
                /* 10 */ '\t' . $row->VATInTen .
                /* 11 */ '\t' . $row->ValueInFive .
                /* 12 */ '\t' . $row->VATInFive .
                /* 13 */ '\t' . $row->ValueInZero .
                /* 14 */ '\t' . $row->OperationType ?? 0 .
                /* 15 */ '\t' . $row->Condition == 0 ? 1 : 2 .
                /* 16 */ '\t' . $row->Condition;
            }

            //Maybe save to string variable frist, and then append at the end.
            Storage::disk('local')->append( 'Test.txt', $detail);
        }
    }

    public function loadData($hechaukaType, $taxPayer, $integration, $raw)
    {

    }

    public function generateFiles(Taxpayer $taxPayer,Cycle $cycle, $startDate, $endDate)
    {
        $directorio = Storage::disk('local');

        $path = $directorio->getDriver()->getAdapter()->getPathPrefix();
        $this->getHechaukaSales($taxPayer, $startDate, $endDate,Auth::user()->currentTeamID);
        $files = File::allFiles($path);

        $zipname = 'Hechauka.zip';
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);

        if ($files != [])
        {
            foreach ($files as $file)
            {
                $zip->addFile($path . $file->getFilename(), $file->getFilename());
            }

            $zip->close();

            if ($directorio->exists("ventas-" . $taxPayer->taxid . '.txt'))
            {
                $directorio->delete("ventas-" . $taxPayer->taxid . '.txt');
            }

            return response()->download($zipname)->deleteFileAfterSend(true);
        }

        return redirect()->back();
    }

    public function dividirCodigo($codigo)
    {
        return $code = explode("-", $codigo);
    }
}
