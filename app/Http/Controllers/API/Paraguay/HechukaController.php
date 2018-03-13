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


  public function calculate_dv($ruc)
  {

    $base_max = 11;
    $array_ruc = str_split($ruc);
    $n = count($array_ruc);

    $suma = 0;
    $k = 2;
    for ($i = $n - 1; $i >= 0; $i--) {

      if (is_numeric($array_ruc[$i])) {
        $k = $k > $base_max ? 2 : $k;
        $suma += ($array_ruc[$i] * $k++);
        //$k++;
      }

    }
    $v_resto = $suma % 11;
    $dv = $v_resto > 1 ? 11 - $v_resto : 0;
    return $dv;
    //dd($suma % 11 );
  }

  public function hechuka($taxpayer)
  {
    $taxpayers=Taxpayer::where('id',$taxpayer)->first();
    $transaction=Transaction::Join('taxpayers', 'taxpayers.id', 'transactions.customer_id')
    ->Join('taxpayer_integrations', 'taxpayer_integrations.taxpayer_id', 'taxpayers.id')
    ->Join('documents', 'documents.id', 'transactions.document_id')
    ->where('supplier_id', $taxpayer)
    ->where('transactions.type', 1)
    ->where('transactions.type', 3)
    ->select(DB::raw('transactions.id,taxpayers.name as Customer,taxpayers.taxid,taxpayer_integrations.agent_name
    ,customer_id,document_id,currency_id,rate,payment_condition,chart_account_id,date,documents.type
    ,number,transactions.code,transactions.code_expiry'))
    ->get();


    $cont = 0;
    $detalle = array();
    $cantidad_registros=0;
    foreach ($transaction as  $item)
    {
      $date = date_create($item->date);
      $fecha = date_format($date, 'd/m/Y');
      $ruc_r = 0;
      $dv_r = 0;

      $ruc = $this->dividirCodigo($taxpayers->taxid)[0];

      if (count($this->dividirCodigo($taxpayers->taxid)) > 1) {

        $dv = $this->dividirCodigo($taxpayers->taxid)[1];

      } else {

        $dv = $this->calculate_dv($ruc);



      }

      $ruc_r = $this->dividirCodigo($item->taxid)[0];
      if (count($this->dividirCodigo($item->taxid)) > 1) {

        $dv_r = $this->dividirCodigo($item->taxid)[1];

      } else {

        $dv_r = $this->calculate_dv($ruc_r);

        //  $this->update_ruc($item->id_empresa, $ruc, $dv);

      }


      $tipo_registro = 2;
      $suma_total=0;
      $cantidad_cuotas=0;

      $details=TransactionDetail::Join('charts', 'charts.id', 'transaction_details.chart_vat_id')
      ->where('transaction_id',$item->id)
      ->groupBy('chart_vat_id')
      ->select(DB::raw('charts.name as chart,sum(transaction_details.value) as Total,sum(transaction_details.value)/(1+charts.coefficient) as vat'))
      ->get();

      $str='';
      foreach ($details as $detail)
      {
        $suma_total=$suma_total + $detail->Total;
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

      dd($detalle);
      foreach ($detalle as $value) {

        Storage::disk('local')->append( $item->number . '.txt', $value);
      }


    }


  }
}
