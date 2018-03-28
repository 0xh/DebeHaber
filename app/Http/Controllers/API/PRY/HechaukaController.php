<?php

namespace App\Http\Controllers\API\PRY;

use App\Transaction;
use App\TransactionDetail;
use App\Taxpayer;
use App\Cycle;
use App\TaxpayerIntegration;
//use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;
use DB;
use File;
use ZipArchive;


class HechaukaController extends Controller
{
    public function generateFiles(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
    {
        //Get the Integration Once. No need to bring it into the Query.
        $integration = TaxpayerIntegration::where('taxpayer_id', $taxPayer->id)
        ->where('team_id', Auth::user()->current_team_id)
        ->first();

        //TODO: This function is wrong. It will take all files from a path.
        //$files = File::allFiles($path);

        $zipname = 'Hechauka -' . $taxPayer->name . ' - ' . Carbon::now()->toDateString() . '.zip';

        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);

        $this->generateSales($startDate, $endDate, $taxPayer, $integration, $zip);
        $this->generatePurchases($startDate, $endDate, $taxPayer, $integration, $zip);
        //dd($zip);
        $zip->close();

        return response()->download($zipname)->deleteFileAfterSend(true);

        return redirect()->back();
    }

    public function generateSales($startDate, $endDate, $taxPayer, $integration, $zip)
    {
        $raw = DB::select('
        select
        max(t.id) as ID,
        max(customer.name) Partner,
        max(customer.taxid) PartnerTaxID,
        max(customer.code) PartnerTaxCode,
        max(t.date) as Date,
        max(t.number) as Number,
        max(t.code) as Code,
        max(t.payment_condition) as PaymentCondition,
        max(t.code_expiry) as CodeExpiry,
        max(t.document_type) as DocumentType,
        ROUND(sum(td.ValueInZero) / max(t.rate)) as ValueInZero,
        ROUND(sum(td.ValueInFive) / max(t.rate)) as ValueInFive,
        ROUND((sum(td.ValueInFive) / max(t.rate)) / 21) as VATInFive,
        ROUND(sum(td.ValueInTen) / max(t.rate)) as ValueInTen,
        ROUND((sum(td.ValueInTen) / max(t.rate)) / 11) as VATInTen
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
        where t.supplier_id = ' . $taxPayer->id . ' and date between "' . $startDate . '" and "' . $endDate . '"
        and t.type in (3, 4)
        group by t.id');

        $raw = collect($raw);
        $i = 1;

        foreach ($raw->chunk(1500) as $data)
        {
            $taxPayerTaxID = $taxPayer->taxid;
            $taxPayerTaxCode = $taxPayer->code;

            $fileName = 'Hechauka Ventas #' . $i . '-' . $date->format('M-Y') . '.txt';

            if (isset($integration))
            {
                $agentName = $integration->agent_name;
                $agentTaxID = $integration->agent_taxid;
                $agentTaxCode = 0;
            }

            $obligationCode = 921;
            $formCode = 221;

            $date = Carbon::parse($data->first()->Date);
            $dateCode = $date->format('Y') . $date->format('m');

            $header =
            /* 1 */ '1' .
            /* 2 */ " \t " . $dateCode .
            /* 3 */ " \t " . '1' .
            /* 4 */ " \t " . $obligationCode .
            /* 5 */ " \t " . $formCode .
            /* 6 */ " \t " . $taxPayerTaxID .
            /* 7 */ " \t " . $taxPayerTaxCode .
            /* 8 */ " \t " . $taxPayer->name .
            /* 9 */ " \t " . $agentTaxID .
            /* 10 */ " \t " . $agentTaxCode .
            /* 11 */ " \t " . $agentName .
            /* 12 */ " \t " . ($data->count() ?? 0) .
            /* 13 */ " \t " . (($data->sum('ValueInTen') ?? 0) + ($data->sum('ValueInFive') ?? 0 ) + ($data->sum('ValueInZero') ?? 0)).
            /* 14 */ " \t " . "2";


            //Improve Naming convention, also add Taxpayer Folder.
            Storage::disk('local')->append($fileName, $header);

            $detail = '';

            //todo this is wrong. Your foreachs hould be smaller
            foreach ($data as  $row)
            {
                $date = Carbon::parse($row->Date);
                //Check if Partner has TaxID and TaxCode properly coded, or else substitute for generic user.
                $detail = $detail .
                /* 1 */ '2' .
                /* 2 */ " \t " . $row->PartnerTaxID .
                /* 3 */ " \t " . ($row->PartnerTaxCode) .
                /* 4 */ " \t " . ($row->Partner) .
                /* 5 */ " \t " . ($row->DocumentType) .
                /* 6 */ " \t " . ($row->Number) .
                /* 7 */ " \t " . (date_format($date, 'd/m/Y') ).
                /* 8 */ " \t " .( $row->ValueInTen - $row->VATInTen) .
                /* 9 */ " \t " . ($row->VATInTen ).
                /* 10 */ " \t " . ($row->ValueInFive - $row->VATInFive).
                /* 11 */ " \t " .($row->VATInFive) .
                /* 12 */ " \t " . ($row->ValueInZero) .
                /* 13 */ " \t " . ($row->ValueInTen + $row->ValueInFive + $row->ValueInZero) .
                /* 14 */ " \t " . ($row->PaymentCondition == 0 ? 1 : 2) .
                /* 15 */ " \t " . ($row->PaymentCondition ).
                /* 16 */ " \t " . ($row->Code) . " \n";

            }

            //Maybe save to string variable frist, and then append at the end.
            Storage::disk('local')->append($fileName, $detail);

            $file = Storage::disk('local');


            $path = $file->getDriver()->getAdapter()->getPathPrefix();

            $zip->addFile($path . $fileName, $fileName);

            //$file->delete($fileName);

            $i += 1;
        }
    }

    public function generatePurchases($startDate, $endDate, $taxPayer, $integration, $zip)
    {

        $raw = DB::select('select
        max(t.id) as ID,
        max(supplier.name) as Partner,
        max(supplier.taxid) as PartnerTaxID,
        max(supplier.code) as PartnerTaxCode,
        max(t.date) as Date,
        max(t.number) as Number,
        max(t.code) as Code,
        max(t.payment_condition) as PaymentCondition,
        max(t.code_expiry) as CodeExpiry,
        max(t.document_type) as DocumentType,
        -- max(t.operation_type) as OperationType,
        ROUND(sum(td.ValueInZero) / max(t.rate)) as ValueInZero,
        ROUND(sum(td.ValueInFive) / max(t.rate)) as ValueInFive,
        ROUND((sum(td.ValueInFive) / max(t.rate)) / 21) as VATInFive,
        ROUND(sum(td.ValueInTen) / max(t.rate)) as ValueInTen,
        ROUND((sum(td.ValueInTen) / max(t.rate)) / 11) as VATInTen
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
        t.customer_id = ' . $taxPayer->id . ' and
        date between "' . $startDate . '" and "' . $endDate . '" and
        t.type in (1, 2, 5)
        group by t.id');

        $raw = collect($raw);
        $i = 1;

        foreach ($raw->chunk(15000) as $data)
        {
            $taxPayerTaxID = $taxPayer->taxid;
            $taxPayerTaxCode = $taxPayer->code;

            $fileName = 'Hechauka Compras #' . $i . '-' . $date->format('M-Y') . '.txt';

            if (isset($integration))
            {
                $agentName = $integration->agent_name;
                $agentTaxID = $integration->agent_taxid;
                $agentTaxCode = 0;
            }

            $obligationCode = 911;
            $formCode = 211;

            $date = Carbon::parse($data->first()->Date);
            $dateCode = $date->format('Y') . $date->format('m');

            $header =
            /* 1 */ '1' .
            /* 2 */ " \t " . $dateCode .
            /* 3 */ " \t " . '1' .
            /* 4 */ " \t " . $obligationCode .
            /* 5 */ " \t " . $formCode .
            /* 6 */ " \t " . $taxPayerTaxID .
            /* 7 */ " \t " . $taxPayerTaxCode .
            /* 8 */ " \t " . $taxPayer->name .
            /* 9 */ " \t " . $agentTaxID .
            /* 10 */ " \t " . $agentTaxCode .
            /* 11 */ " \t " . $agentName .
            /* 12 */ " \t " . ($data->count() ?? 0) .
            /* 13 */ " \t " . (($data->sum('ValueInTen') ?? 0 )+ ($data->sum('ValueInFive') ?? 0) + ($data->sum('ValueInZero') ?? 0) ).
            /* 14 */ " \t " . ($taxPayer->regime_type == 1 ? 'Si' : 'No' ) .
            /* 15 */ " \t " . "2";


            //Improve Naming convention, also add Taxpayer Folder.
            Storage::disk('local')->append($fileName, $header);

            $detail = '';

            //todo this is wrong. Your foreachs hould be smaller
            foreach ($data as  $row)
            {
                $date = Carbon::parse($row->Date);
                //Check if Partner has TaxID and TaxCode properly coded, or else substitute for generic user.
                $detail = $detail .
                /* 1 */ '2' .
                /* 2 */ " \t " . ($row->PartnerTaxID) .
                /* 3 */ " \t " . ($row->PartnerTaxCode) .
                /* 4 */ " \t " . ($row->Partner) .
                /* 5 */ " \t " . ($row->Code) .
                /* 6 */ " \t " . ($row->DocumentType) .
                /* 7 */ " \t " . ($row->Number) .
                /* 8 */ " \t " . (date_format($date, 'd/m/Y')) .
                /* 9 */ " \t " . ($row->ValueInTen - $row->VATInTen) .
                /* 10 */ " \t " . ($row->VATInTen) .
                /* 11 */ " \t " . ($row->ValueInFive - $row->VATInFive) .
                /* 12 */ " \t " . ($row->VATInFive) .
                /* 13 */ " \t " . ($row->ValueInZero) .
                /* 14 */ //" \t " . $row->OperationType ?? 0 .
                /* 14 */ " \t " . 0 .
                /* 15 */ " \t " . ($row->PaymentCondition == 0 ? 1 : 2) .
                /* 16 */ " \t " . ($row->PaymentCondition);
            }

            //Maybe save to string variable frist, and then append at the end.
            Storage::disk('local')->append($fileName, $detail);

            $file = Storage::disk('local');
            $path = $file->getDriver()->getAdapter()->getPathPrefix();

            $zip->addFile($path . $fileName, $fileName);

            //$file->delete($fileName);

            $i += 1;
        }
    }

    public function dividirCodigo($codigo)
    {
        return $code = explode("-", $codigo);
    }
}
