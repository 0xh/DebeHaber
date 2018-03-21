<?php

namespace App\Http\Controllers\API\Paraguay;
use App\Transaction;
use App\TransactionDetail;
use App\Taxpayer;
use App\cycle;
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

    public function getHechaukaSales($taxpayer, $startDate, $endDate,$teamID)
    {



        //Get the Integration Once. No need to bring it into the Query.
        $integration = TaxpayerIntegration::where('taxpayer_id', $taxpayer->id)
        ->where('team_id', $teamID)
        ->first();

        $data = DB::select('select id, max(date) as date,max(number) as number,max(code) as code,
        max(code_expiry) as code_expiry ,max(payment_condition) as payment_condition, max(type) as type
        ,max(coefficient) as coefficient,sum(value) as value,max(customer) as customer,
        sum(valueByvat5) as valueByvat5,sum(valuevat5) as valuevat5,sum(valueByvat0) as valueByvat0,
        sum(valuevat0) as valuevat0,sum(valueByvat10) as valueByvat10,sum(valuevat10) as valuevat10
        from (select transactions.id, `customer`.`name` as `customer`, `customer`.`taxid` as `customerTaxID`, `customer`.`code` as `customerCode`,
        MAX(transactions.date) as date,
        MAX(transactions.number) as number,
        MAX(transactions.code) as code,
        MAX(transactions.code_expiry) as code_expiry,
        MAX(transactions.payment_condition) as payment_condition,
        MAX(transactions.rate) as rate, MAX(transactions.type) as type,
        SUM(transaction_details.value) as value, max(vat.coefficient) as coefficient,
        if(max(vat.coefficient) = 0.0500, SUM(transaction_details.value) / (1 + SUM(vat.coefficient)), 0) as valueByvat5,
        if(max(vat.coefficient) = 0.0500, SUM(transaction_details.value) - SUM(transaction_details.value) /(1 + SUM(vat.coefficient)), 0) as valuevat5,
        if((max(vat.coefficient)) is NULL, SUM(transaction_details.value),0) as valueByvat0,
        if(max(vat.coefficient) is NULL, SUM(transaction_details.value) - SUM(transaction_details.value),0) as valuevat0,
        if(max(vat.coefficient) = 0.1000,SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valueByvat10,
        if(max(vat.coefficient) = 0.1000,SUM(transaction_details.value) - SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valuevat10
        from `transaction_details`
        inner join `transactions` on `transactions`.`id` = `transaction_details`.`transaction_id`
        inner join `taxpayers` as `customer` on `customer`.`id` = `transactions`.`customer_id`
        inner join `charts` as `vat` on `vat`.`id` = `transaction_details`.`chart_vat_id`
        where `supplier_id` = '. $taxpayer->id .' and (`transactions`.`type` = 3 or `transactions`.`type` = 1)
        group by `transaction_details`.`chart_vat_id`,`transactions`.`id`) as i group by id');

        $cantidad_registros = 0;
        $cantidad_cuotas = 0;
        $ruc = 0;
        $dv = 0;
        $detalle = '';

        $date = date_create($data[0]->date);
        $fecha = date_format($date, 'd/m/Y');

        $agent = '';
        $agentTaxID = 0;
        $agentTaxCode = 0;

        if (isset($integration))
        {
            $agent = $integration->agent_name;
            $agentTaxID = $integration->agent_taxid;
            $agentTaxCode = $integration->agent_name;
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


        return Storage::download($data[0]->number .  '.txt');
    }


    public function getHechaukaPurchase($taxpayerID, $startDate, $endDate)
    {
        $taxpayer = Taxpayer::where('id', $taxpayerID)->first();

        //Get the Integration Once. No need to bring it into the Query.
        $integration = TaxpayerIntegration::where('taxpayer_id', $taxpayerID)
        ->where('team_id', Auth::user()->currentTeamID)
        ->first();

        $data = DB::select('select max(date) as date,max(number) as number,max(code) as code,
        max(code_expiry) as code_expiry ,max(payment_condition) as payment_condition,max(type) as type
        ,max(coefficient) as coefficient,sum(value) as value,max(supplier) as supplier,
        sum(valueByvat5) as valueByvat5,sum(valuevat5) as valuevat5,sum(valueByvat0) as valueByvat0,
        sum(valuevat0) as valuevat0,sum(valueByvat10) as valueByvat10,sum(valuevat10) as valuevat10
        from (select `supplier`.`name` as `supplier`, `supplier`.`taxid` as `supplierTaxID`, `supplier`.`code` as `supplierCode`,
        MAX(transactions.date) as date,
        MAX(transactions.number) as number,
        MAX(transactions.code) as code,
        MAX(transactions.code_expiry) as code_expiry,
        MAX(transactions.payment_condition) as payment_condition,
        MAX(transactions.rate) as rate, MAX(transactions.type) as type,
        SUM(transaction_details.value) as value, SUM(vat.coefficient) as coefficient,
        if(sum(vat.coefficient) = 0.0500,SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valueByvat5,
        if(sum(vat.coefficient) = 0.0500,SUM(transaction_details.value) - SUM(transaction_details.value) / (1 + SUM(vat.coefficient)), 0) as valuevat5,
        if((sum(vat.coefficient)) is NULL,SUM(transaction_details.value),0) as valueByvat0,
        if(sum(vat.coefficient) is NULL,SUM(transaction_details.value) - SUM(transaction_details.value),0) as valuevat0,
        if(sum(vat.coefficient) = 0.1000,SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valueByvat10,
        if(sum(vat.coefficient) = 0.1000,SUM(transaction_details.value) - SUM(transaction_details.value) / (1 + SUM(vat.coefficient)), 0) as valuevat10
        from `transaction_details`
        inner join `transactions` on `transactions`.`id` = `transaction_details`.`transaction_id`
        inner join `taxpayers` as `supplier` on `supplier`.`id` = `transactions`.`supplier_id`
        inner join `charts` as `vat` on `vat`.`id` = `transaction_details`.`chart_vat_id`
        where `customer_id` = 1 and (`transactions`.`type` =2 or `transactions`.`type` = 4)
        group by `transaction_details`.`chart_vat_id`,`transactions`.`id`) as i');

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

        $this->getHechaukaSales($taxPayer, $startDate, $endDate,Auth::user()->currentTeamID);

    }
}
