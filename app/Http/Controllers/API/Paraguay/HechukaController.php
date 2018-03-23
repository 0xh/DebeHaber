<?php

namespace App\Http\Controllers\API\Paraguay;
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
    public function dividirCodigo($codigo)
    {
        return $code = explode("-", $codigo);
    }

    public function getHechaukaSales($taxpayer, $startDate, $endDate, $teamID)
    {
        //Get the Integration Once. No need to bring it into the Query.
        $integration = TaxpayerIntegration::where('taxpayer_id', $taxpayer->id)
        ->where('team_id', $teamID)
        ->first();

        $data = DB::select('select
        max(t.id) as ID,
        max(customer.name), max(customer.taxid), max(customer.code),
        max(t.date) as Number,
        max(t.number) as Number,
        max(t.code) as Code,
        max(t.payment_condition) as Condition,
        max(t.code_expiry) as CodeExpiry,
        max(t.document_type) as DocumentType,
        (sum(td.ValueInZero) / t.rate) as ValueInZero,
        (sum(td.ValueInFive) / t.rate) as ValueInFive,
        (sum(td.ValueInFive) / t.rate) / 21 as VATInFive,
        (sum(td.ValueInTen) / t.rate) as ValueInTen,
        (sum(td.ValueInTen) / t.rate) / 11 as VATInTen
        from transactions as t
        join
        (
            select
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
            where supplier.taxid = ' . $taxpayer . ' and date between "' . $startDate . '" and "' . $endDate . '"
            group by t.id');

            $cantidad_registros = 0;
            $cantidad_cuotas = 0;
            $ruc = 0;
            $dv = 0;
            $detalle = '';

            if (count($data) > 0)
            {
                $date = date_create($data[0]->date);
                $fecha = date_format($date, 'd/m/Y');

                $agent = '';
                $agentTaxID = 0;
                $agentTaxCode = 0;

                if (isset($integration))
                {
                    $agent = $integration->agent_name;
                    $agentTaxID = $integration->agent_taxid;
                    $agentTaxCode = $integration->agent_code;
                }

                $encabezado = "1" . "\t" . $date->format('Y') . $date->format('m') . "\t" . "1" . "\t" . "921" . "\t" . "221" . "\t" .
                $ruc . "\t" . $dv . "\t" . $data[0]->customer . "\t" . $agentTaxID . "\t" . $agentTaxCode . "\t" . $agent . "\t" . $cantidad_registros .
                "\t" . round($data[0]->value) . "\t" . "2";

                Storage::disk('local')->append( $data[0]->number .  '.txt', $encabezado);


                //todo this is wrong. Your foreachs hould be smaller
                foreach ($data as  $item)
                {
                    $str = '';

                    $str = $str . round($item->valueByvat5) .  "\t" . round($item->valuevat5) . "\t" .
                    round($item->valueByvat10) .  "\t" . round($item->valuevat10) . "\t" .
                    round($item->valueByvat0) .  "\t" . round($item->valuevat0) . "\t";


                    $detalle = $detalle . "\n" . $item->type . "\t" . $ruc . "\t" . $dv . "\t" . $item->customer . "\t" . $item->type
                    . "\t" . $item->number . "\t" . $fecha . "\t" . $str
                    . "\t" . $item->payment_condition . "\t" . $cantidad_cuotas . "\t" . $item->code;

                }

                Storage::disk('local')->append( $data[0]->number .  '.txt', $detalle);
            }
        }


        public function getHechaukaPurchase($taxpayerID, $startDate, $endDate)
        {
            $taxpayer = Taxpayer::where('id', $taxpayerID)->first();

            //Get the Integration Once. No need to bring it into the Query.
            $integration = TaxpayerIntegration::where('taxpayer_id', $taxpayerID)
            ->where('team_id', Auth::user()->currentTeamID)
            ->first();

            $data = DB::select('select
            max(t.id) as ID,
            max(supplier.name), max(supplier.taxid), max(supplier.code),
            max(t.date) as Number,
            max(t.number) as Number,
            max(t.code) as Code,
            max(t.payment_condition) as Condition,
            max(t.code_expiry) as CodeExpiry,
            max(t.document_type) as DocumentType,
            (sum(td.ValueInZero) / t.rate) as ValueInZero,
            (sum(td.ValueInFive) / t.rate) as ValueInFive,
            (sum(td.ValueInFive) / t.rate) / 21 as VATInFive,
            (sum(td.ValueInTen) / t.rate) as ValueInTen,
            (sum(td.ValueInTen) / t.rate) / 11 as VATInTen
            from transactions as t
            join
            (
                select
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
                where supplier.taxid = ' . $taxpayer . ' and date between "' . $startDate . '" and "' . $endDate . '"
                group by t.id');

                $cantidad_registros = 0;
                $cantidad_cuotas = 0;
                $ruc = 0;
                $dv = 0;
                $agentTaxID = 0;
                $agentTaxCode = 0;
                $detalle = '';

                $date = date_create($data[0]->date);
                $fecha = date_format($date, 'd/m/Y');
                $agent = '';
                if (isset($integration))
                {
                    $agent = $integration->agent_name;
                }

                $encabezado = "1" . "\t" . $date->format('Y') . $date->format('m') . "\t" . "1" . "\t" . "921" . "\t" . "221" . "\t" .
                $ruc . "\t" . $dv . "\t" . $data[0]->supplier . "\t" . $agentTaxID . "\t" . $agentTaxCode . "\t" . $agent . "\t" . $cantidad_registros .
                "\t" . round($data[0]->value) . "\t" . "2";

                Storage::disk('local')->append( $data[0]->number .  '.txt', $encabezado);

                //todo this is wrong. Your foreachs hould be smaller
                foreach ($data as  $item)
                {
                    $str = '';

                    $str = $str . round($item->valueByvat5) .  "\t" . round($item->valuevat5) . "\t" .
                    round($item->valueByvat10) .  "\t" . round($item->valuevat10) . "\t" .
                    round($item->valueByvat0) .  "\t" . round($item->valuevat0) . "\t";

                    $detalle = $item->type . "\t" . $ruc . "\t" . $dv . "\t" . $item->supplier . "\t" . $item->type
                    . "\t" . $item->number . "\t" . $fecha . "\t" . $str
                    . "\t" . $item->payment_condition . "\t" . $cantidad_cuotas . "\t" . $item->code;

                    //Maybe save to string variable frist, and then append at the end.
                    Storage::disk('local')->append( $item->number .  '.txt', $detalle);
                }
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
                    //dd($zip);
                    $zip->close();

                    if ($directorio->exists("ventas-" . $taxPayer->taxid . '.txt'))
                    {
                        $directorio->delete("ventas-" . $taxPayer->taxid . '.txt');
                    }
                    return response()->download($zipname)->deleteFileAfterSend(true);
                }
                return redirect()->back();



            }
        }
