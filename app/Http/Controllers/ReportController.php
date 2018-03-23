<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Taxpayer;
use App\TransactionDetail;
use App\Cycle;
use DB;

class ReportController extends Controller
{
  public function index(Taxpayer $taxPayer, Cycle $cycle)
  {
    return view('reports/index');
  }
  public function vatPurchase(Taxpayer $taxPayer, $startDate, $endDate)
  {


    if (isset($taxPayer))
    {
      $data = $this->vatPurchaseQuery($taxPayer, $startDate, $endDate);

      return view('reports/PRY/purchase_vat')
      ->with('header', $taxPayer)
      ->with('data', $data)
      ->with('strDate', $startDate)
      ->with('endDate', $endDate);
    }
  }
  public function vatSales(Taxpayer $taxPayer, $startDate, $endDate)
  {


    if (isset($taxPayer))
    {
      $data = $this->vatSaleQuery($taxPayer, $startDate, $endDate);

      return view('reports/PRY/sales_vat')
      ->with('header', $taxPayer)
      ->with('data', $data)
      ->with('strDate', $startDate)
      ->with('endDate', $endDate);
    }
  }
  public function vatPurchaseQuery(Taxpayer $taxPayer, $startDate, $endDate)
  {

    DB::connection()->disableQueryLog();



    // return TransactionDetail::vat()
    // ->where('customer.id', $company->id)
    // ->whereIn('commercial_invoices.type', array(1, 3, 4, 8))
    // ->where(function ($query)
    // {
    //   $query
    //   ->whereIn('commercial_invoices.status', array(1, 2))
    //   ->orWhere('commercial_invoices.status', null);
    // })
    // ->whereBetween('commercial_invoices.invoice_date', array($this->carbonStartDate($startDate), $this->carbonEndDate($endDate)))
    // ->select('supplier.name as supplier',
    // 'supplier.gov_code as supplier_code',
    // 'commercial_invoices.type',
    // 'commercial_invoices.id as purchaseID',
    // 'commercial_invoices.invoice_date',
    // 'commercial_invoices.invoice_code',
    // 'commercial_invoices.invoice_number',
    // 'commercial_invoices.payment_condition',
    // 'commercial_invoices.comment',
    // 'commercial_invoices.rate',
    //
    // 'commercial_invoice_vats.comment',
    // 'cost_centers.name as costCenter',
    // 'vats.name as vat',
    // 'vats.coeficient',
    // 'branches.name as branch',
    // DB::raw('commercial_invoices.rate * if(commercial_invoices.type = 4, -commercial_invoice_vats.value, commercial_invoice_vats.value) as localCurrencyValue,
    // (commercial_invoices.rate * if(commercial_invoices.type = 4, -commercial_invoice_vats.value, commercial_invoice_vats.value)) / (vats.coeficient + 1) as vatValue'
    // )
    // )
    // ->orderBy('commercial_invoices.invoice_date', asc)
    // ->get();
  }

  public function vatSaleQuery(Taxpayer $taxPayer, $startDate, $endDate)
  {

    DB::connection()->disableQueryLog();



    // return TransactionDetail::vat()
    // ->where('customer.id', $company->id)
    // ->whereIn('commercial_invoices.type', array(1, 3, 4, 8))
    // ->where(function ($query)
    // {
    //   $query
    //   ->whereIn('commercial_invoices.status', array(1, 2))
    //   ->orWhere('commercial_invoices.status', null);
    // })
    // ->whereBetween('commercial_invoices.invoice_date', array($this->carbonStartDate($startDate), $this->carbonEndDate($endDate)))
    // ->select('supplier.name as supplier',
    // 'supplier.gov_code as supplier_code',
    // 'commercial_invoices.type',
    // 'commercial_invoices.id as purchaseID',
    // 'commercial_invoices.invoice_date',
    // 'commercial_invoices.invoice_code',
    // 'commercial_invoices.invoice_number',
    // 'commercial_invoices.payment_condition',
    // 'commercial_invoices.comment',
    // 'commercial_invoices.rate',
    //
    // 'commercial_invoice_vats.comment',
    // 'cost_centers.name as costCenter',
    // 'vats.name as vat',
    // 'vats.coeficient',
    // 'branches.name as branch',
    // DB::raw('commercial_invoices.rate * if(commercial_invoices.type = 4, -commercial_invoice_vats.value, commercial_invoice_vats.value) as localCurrencyValue,
    // (commercial_invoices.rate * if(commercial_invoices.type = 4, -commercial_invoice_vats.value, commercial_invoice_vats.value)) / (vats.coeficient + 1) as vatValue'
    // )
    // )
    // ->orderBy('commercial_invoices.invoice_date', asc)
    // ->get();
  }


}
