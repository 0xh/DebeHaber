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

        $data = TransactionDetail::join('transactions', 'transactions.id', 'transaction_details.transaction_id')
        ->join('taxpayers as customer', 'customer.id', 'transactions.customer_id')
        ->join('charts as vat', 'customer.id', 'transaction_details.chart_vat_id')
        ->where('supplier_id',$taxpayerID)
        ->Where(function ($z)
        {
            //Bring all Expenses except for Wages, Depreciation, these accounts you cannot purchase.

            $z->orWhere('transactions.type', 3);
            $z->orWhere('transactions.type', 1);

        })


        ->groupBy('transaction_details.chart_vat_id')
        ->select('customer.name as customer', 'customer.taxid as customerTaxID', 'customer.code as customerCode',
        DB::raw("MAX(transactions.date) as date"), DB::raw("MAX(transactions.number) as number"),
        DB::raw("MAX(transactions.code) as code"), DB::raw("MAX(transactions.code_expiry) as code_expiry"),
        DB::raw("MAX(transactions.payment_condition) as payment_condition"),
        DB::raw("MAX(transactions.rate) as rate"),
        DB::raw("MAX(transactions.type) as type"),
        DB::raw("SUM(transaction_details.value) as value"),
        DB::raw("SUM(vat.coefficient) as coefficient"),
        DB::raw("SUM(transaction_details.value) /(1+ SUM(vat.coefficient)) as valueByvat"),
        DB::raw("SUM(transaction_details.value) - SUM(transaction_details.value) /(1+ SUM(vat.coefficient)) as valuewithoutvat")
        )
        ->get();

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

        $date = date_create($data->first()->date);
        $fecha = date_format($date, 'd/m/Y');
        $agent='';
        if (isset($integration)) {
            $agent=$integration->agent_name;
        }
        $encabezado = "1" . "\t" . $date->format('Y') . $date->format('m') . "\t" . "1" . "\t" . "921" . "\t" . "221" . "\t" .
        $ruc . "\t" . $dv . "\t" . $data->first()->customer . "\t" . $ruc_r . "\t" . $dv_r . "\t" . $agent . "\t" . $cantidad_registros .
        "\t" . round($data->first()->value) . "\t" . "2";

        Storage::disk('local')->append( $data->first()->number .  '.txt', $encabezado);


        //todo this is wrong. Your foreachs hould be smaller
        foreach ($data as  $item)
        {

            $str = '';


            $str = $str . round($item->valueByvat) .  "\t" . round($item->valuewithoutvat) . "\t";


            $detalle = $item->type . "\t" . $ruc . "\t" . $dv . "\t" . $item->Customer . "\t" . $item->type
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

        $data = TransactionDetail::join('transactions', 'transactions.id', 'transaction_details.transaction_id')
        ->join('taxpayers as supplier', 'supplier.id', 'transactions.supplier_id')
        ->join('charts as vat', 'customer.id', 'transaction_details.chart_vat_id')
        ->where('customer_id',$taxpayerID)
        ->Where(function ($z)
        {
            //Bring all Expenses except for Wages, Depreciation, these accounts you cannot purchase.

            $z->orWhere('transactions.type', 2);
            $z->orWhere('transactions.type', 4);

        })


        ->groupBy('transaction_details.chart_vat_id')
        ->select('supplier.name as supplier', 'supplier.taxid as supplierTaxID', 'supplier.code as supplierCode',
        DB::raw("MAX(transactions.date) as date"), DB::raw("MAX(transactions.number) as number"),
        DB::raw("MAX(transactions.code) as code"), DB::raw("MAX(transactions.code_expiry) as code_expiry"),
        DB::raw("MAX(transactions.payment_condition) as payment_condition"),
        DB::raw("MAX(transactions.rate) as rate"),
        DB::raw("MAX(transactions.type) as type"),
        DB::raw("SUM(transaction_details.value) as value"),
        DB::raw("SUM(vat.coefficient) as coefficient"),
        DB::raw("SUM(transaction_details.value) /(1+ SUM(vat.coefficient)) as valueByvat"),
        DB::raw("SUM(transaction_details.value) - SUM(transaction_details.value) /(1+ SUM(vat.coefficient)) as valuewithoutvat")
        )
        ->get();

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

        $date = date_create($data->first()->date);
        $fecha = date_format($date, 'd/m/Y');
        $agent='';
        if (isset($integration)) {
            $agent=$integration->agent_name;
        }
        $encabezado = "1" . "\t" . $date->format('Y') . $date->format('m') . "\t" . "1" . "\t" . "921" . "\t" . "221" . "\t" .
        $ruc . "\t" . $dv . "\t" . $data->first()->customer . "\t" . $ruc_r . "\t" . $dv_r . "\t" . $agent . "\t" . $cantidad_registros .
        "\t" . round($data->first()->value) . "\t" . "2";

        Storage::disk('local')->append( $data->first()->number .  '.txt', $encabezado);


        //todo this is wrong. Your foreachs hould be smaller
        foreach ($data as  $item)
        {

            $str = '';


            $str = $str . round($item->valueByvat) .  "\t" . round($item->valuewithoutvat) . "\t";


            $detalle = $item->type . "\t" . $ruc . "\t" . $dv . "\t" . $item->Customer . "\t" . $item->type
            . "\t" . $item->number . "\t" . $fecha . "\t" . $str
            . "\t" . $item->payment_condition . "\t" . $cantidad_cuotas . "\t" . $item->code;
            Storage::disk('local')->append( $item->number .  '.txt', $detalle);
        }
    }
}
