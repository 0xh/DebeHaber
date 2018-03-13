<?php

namespace App\Http\Controllers\API\Paraguay;
use App\Transaction;
use App\TransactionDetail;
use App\Taxpayer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
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

        $data = Transaction::join('transactions', 'transactions.id', 'transaction_details.transaction_id')
        ->join('taxpayers as customer', 'customer.id', 'transactions.customer_id')
        ->join('charts as vat', 'customer.id', 'transaction_details.chart_vat_id')
        ->where('supplier_id', $taxpayerID)
        ->where('transactions.type', 1)
        ->where('transactions.type', 3)
        ->groupBy('transaction_details.chart_vat_id')
        ->select('customer.name as customer', 'customer.taxid as customerTaxID', 'customer.code as customerCode',
        'transactions.date', 'transactions.number', 'transactions.code', 'transactions.code_expiry', 'transactions.payment_condition', 'transactions.rate',
        DB::raw("SUM(transaction_details.value) as valueByVAT"),
        'vat.coefficient'
        )
        ->sum('transaction_details')
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

        $cont = 0;
        $detalle = array();
        $cantidad_registros = 0;

        //todo this is wrong. Your foreachs hould be smaller
        foreach ($transaction as  $item)
        {
            $date = date_create($item->date);
            $fecha = date_format($date, 'd/m/Y');

            $ruc_r = 0;
            $dv_r = 0;

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

            $tipo_registro = 2;
            $suma_total = 0;
            $cantidad_cuotas = 0;

            //Also no good. This will cause N+1 Problems

            // $details = TransactionDetail::Join('charts', 'charts.id', 'transaction_details.chart_vat_id')
            // ->where('transaction_id', $item->id)
            // ->groupBy('chart_vat_id')
            // ->select(DB::raw('charts.name as chart, sum(transaction_details.value) as Total, sum(transaction_details.value) / (1 + charts.coefficient) as vat'))
            // ->get();

            $str = '';

            foreach ($details as $detail)
            {
                $suma_total = $suma_total + $detail->Total;
                $str = $str . round($detail->Total * $item->rate) .  "\t" . round($detail->Total * $item->rate) . "\t";
                $cantidad_registros++;
            }

            $detalle[$cont] = $tipo_registro . "\t" . $ruc . "\t" . $dv . "\t" . $item->Customer . "\t" . $item->type
            . "\t" . $item->number . "\t" . $fecha . "\t" . $str
            . "\t" . $item->payment_condition . "\t" . $cantidad_cuotas . "\t" . $item->code;


            $encabezado = "1" . "\t" . $date->format('Y') . $date->format('m') . "\t" . "1" . "\t" . "921" . "\t" . "221" . "\t" .
            $ruc . "\t" . $dv . "\t" . $item->Customer . "\t" . $ruc_r . "\t" . $dv_r . "\t" . $item->agent_name . "\t" . $cantidad_registros .
            "\t" . round($suma_total) . "\t" . "2";

            Storage::disk('local')->append( $item->number .  '.txt', $encabezado);

            foreach ($detalle as $value)
            {
                Storage::disk('local')->append( $item->number . '.txt', $value);
            }
        }
    }
}
