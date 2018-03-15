<?php

namespace App\Http\Controllers\API\Paraguay;
use App\Transaction;
use App\TransactionDetail;
use App\Taxpayer;
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

    public function getHechaukaSales($taxpayerID, $startDate, $endDate)
    {

        $taxpayer = Taxpayer::where('id', $taxpayerID)->first();

        //Get the Integration Once. No need to bring it into the Query.
        $integration = TaxpayerIntegration::where('taxpayer_id', $taxpayerID)
        ->where('team_id', Auth::user()->currentTeamID)
        ->first();

        $data = DB::select('select max(date) as date,max(number) as number,max(code) as code,
        max(code_expiry) as code_expiry ,max(payment_condition) as payment_condition,max(type) as type
        ,max(coefficient) as coefficient,sum(value) as value,max(customer) as customer,
sum(valueByvat5) as valueByvat5,sum(valuevat5) as valuevat5,sum(valueByvat0) as valueByvat0,
sum(valuevat0) as valuevat0,sum(valueByvat10) as valueByvat10,sum(valuevat10) as valuevat10
from (select `customer`.`name` as `customer`, `customer`.`taxid` as `customerTaxID`, `customer`.`code` as `customerCode`,
 MAX(transactions.date) as date,
 MAX(transactions.number) as number,
 MAX(transactions.code) as code,
 MAX(transactions.code_expiry) as code_expiry,
 MAX(transactions.payment_condition) as payment_condition,
 MAX(transactions.rate) as rate, MAX(transactions.type) as type,
 SUM(transaction_details.value) as value, SUM(vat.coefficient) as coefficient,
 if(sum(vat.coefficient)=0.0500,SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valueByvat5,
if(sum(vat.coefficient)=0.0500,SUM(transaction_details.value) - SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valuevat5,
 if((sum(vat.coefficient)) is NULL,SUM(transaction_details.value),0) as valueByvat0,
 if(sum(vat.coefficient) is NULL,SUM(transaction_details.value) - SUM(transaction_details.value),0) as valuevat0,
 if(sum(vat.coefficient)=0.1000,SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valueByvat10,
 if(sum(vat.coefficient)=0.1000,SUM(transaction_details.value) - SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valuevat10
 from `transaction_details`
 inner join `transactions` on `transactions`.`id` = `transaction_details`.`transaction_id`
 inner join `taxpayers` as `customer` on `customer`.`id` = `transactions`.`customer_id`
 inner join `charts` as `vat` on `vat`.`id` = `transaction_details`.`chart_vat_id`
 where `supplier_id` = 1 and (`transactions`.`type` = 3 or `transactions`.`type` = 1)
 group by `transaction_details`.`chart_vat_id`,`transactions`.`id`) as i');


        //This query is no good. IT does not take advantage of grouping and sum. like the one above.

        // $transaction = Transaction::Join('taxpayers', 'taxpayers.id', 'transactions.customer_id')
        // //This is wrong. if there are multiple integrations it will cause duplicate data to show up.
        // ->Join('taxpayer_integrations', 'taxpayer_integrations.taxpayer_id', 'taxpayers.id')
        // ->Join('documents', 'documents.id', 'transactions.document_id')
        // ->where('supplier_id', $taxpayerID)
        // ->where('transactions.type', 1)
        // ->where('transactions.type', 3)
        // ->select(DB::raw(
        //     'transactions.id,
        // taxpayers.name as Customer,
        // taxpayers.taxid,
        // taxpayer_integrations.agent_name
        // ,customer_id,document_id,currency_id,rate,payment_condition,chart_account_id,date,documents.type
        // ,number,transactions.code,transactions.code_expiry'))
        // ->get();



        $cantidad_registros = 0;
        $cantidad_cuotas=0;
        $ruc = 0;
        $dv = 0;
        $ruc_r = 0;
        $dv_r = 0;
        $detalle='';
        // $ruc = $this->dividirCodigo($taxpayer->taxid)[0];
        //
        // if (count($this->dividirCodigo($taxpayer->taxid)) > 1)
        // {
        //     $dv = $this->dividirCodigo($taxpayer->taxid)[1];
        // }
        // else
        // {
        //     $dv = $this->calculateDV($ruc);
        // }
        //
        // $ruc_r = $this->dividirCodigo($item->taxid)[0];
        //
        // if (count($this->dividirCodigo($item->taxid)) > 1)
        // {
        //     $dv_r = $this->dividirCodigo($item->taxid)[1];
        // }
        // else
        // {
        //     $dv_r = $this->calculateDV($ruc_r);
        // }

        $date = date_create($data[0]->date);
        $fecha = date_format($date, 'd/m/Y');
        $agent='';
        if (isset($integration)) {
            $agent=$integration->agent_name;
        }
        $encabezado = "1" . "\t" . $date->format('Y') . $date->format('m') . "\t" . "1" . "\t" . "921" . "\t" . "221" . "\t" .
        $ruc . "\t" . $dv . "\t" . $data[0]->customer . "\t" . $ruc_r . "\t" . $dv_r . "\t" . $agent . "\t" . $cantidad_registros .
        "\t" . round($data[0]->value) . "\t" . "2";

        Storage::disk('local')->append( $data[0]->number .  '.txt', $encabezado);


        //todo this is wrong. Your foreachs hould be smaller
        foreach ($data as  $item)
        {

            $str = '';


            $str = $str . round($item->valueByvat5) .  "\t" . round($item->valuevat5) . "\t" .
             round($item->valueByvat10) .  "\t" . round($item->valuevat10) . "\t" .
              round($item->valueByvat0) .  "\t" . round($item->valuevat0) . "\t";


            $detalle = $item->type . "\t" . $ruc . "\t" . $dv . "\t" . $item->customer . "\t" . $item->type
            . "\t" . $item->number . "\t" . $fecha . "\t" . $str
            . "\t" . $item->payment_condition . "\t" . $cantidad_cuotas . "\t" . $item->code;
            Storage::disk('local')->append( $item->number .  '.txt', $detalle);
        }
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
 if(sum(vat.coefficient)=0.0500,SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valueByvat5,
if(sum(vat.coefficient)=0.0500,SUM(transaction_details.value) - SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valuevat5,
 if((sum(vat.coefficient)) is NULL,SUM(transaction_details.value),0) as valueByvat0,
 if(sum(vat.coefficient) is NULL,SUM(transaction_details.value) - SUM(transaction_details.value),0) as valuevat0,
 if(sum(vat.coefficient)=0.1000,SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valueByvat10,
 if(sum(vat.coefficient)=0.1000,SUM(transaction_details.value) - SUM(transaction_details.value) /(1+ SUM(vat.coefficient)),0) as valuevat10
 from `transaction_details`
 inner join `transactions` on `transactions`.`id` = `transaction_details`.`transaction_id`
 inner join `taxpayers` as `supplier` on `supplier`.`id` = `transactions`.`supplier_id`
 inner join `charts` as `vat` on `vat`.`id` = `transaction_details`.`chart_vat_id`
 where `customer_id` = 1 and (`transactions`.`type` =2 or `transactions`.`type` = 4)
 group by `transaction_details`.`chart_vat_id`,`transactions`.`id`) as i');

        //This query is no good. IT does not take advantage of grouping and sum. like the one above.

        // $transaction = Transaction::Join('taxpayers', 'taxpayers.id', 'transactions.customer_id')
        // //This is wrong. if there are multiple integrations it will cause duplicate data to show up.
        // ->Join('taxpayer_integrations', 'taxpayer_integrations.taxpayer_id', 'taxpayers.id')
        // ->Join('documents', 'documents.id', 'transactions.document_id')
        // ->where('supplier_id', $taxpayerID)
        // ->where('transactions.type', 1)
        // ->where('transactions.type', 3)
        // ->select(DB::raw(
        //     'transactions.id,
        // taxpayers.name as Customer,
        // taxpayers.taxid,
        // taxpayer_integrations.agent_name
        // ,customer_id,document_id,currency_id,rate,payment_condition,chart_account_id,date,documents.type
        // ,number,transactions.code,transactions.code_expiry'))
        // ->get();



        $cantidad_registros = 0;
        $cantidad_cuotas=0;
        $ruc = 0;
        $dv = 0;
        $ruc_r = 0;
        $dv_r = 0;
        $detalle='';
        // $ruc = $this->dividirCodigo($taxpayer->taxid)[0];
        //
        // if (count($this->dividirCodigo($taxpayer->taxid)) > 1)
        // {
        //     $dv = $this->dividirCodigo($taxpayer->taxid)[1];
        // }
        // else
        // {
        //     $dv = $this->calculateDV($ruc);
        // }
        //
        // $ruc_r = $this->dividirCodigo($item->taxid)[0];
        //
        // if (count($this->dividirCodigo($item->taxid)) > 1)
        // {
        //     $dv_r = $this->dividirCodigo($item->taxid)[1];
        // }
        // else
        // {
        //     $dv_r = $this->calculateDV($ruc_r);
        // }

        $date = date_create($data[0]->date);
        $fecha = date_format($date, 'd/m/Y');
        $agent='';
        if (isset($integration)) {
            $agent=$integration->agent_name;
        }
        $encabezado = "1" . "\t" . $date->format('Y') . $date->format('m') . "\t" . "1" . "\t" . "921" . "\t" . "221" . "\t" .
        $ruc . "\t" . $dv . "\t" . $data[0]->supplier . "\t" . $ruc_r . "\t" . $dv_r . "\t" . $agent . "\t" . $cantidad_registros .
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
            Storage::disk('local')->append( $item->number .  '.txt', $detalle);
        }
    }
}
