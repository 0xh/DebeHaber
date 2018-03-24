<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Taxpayer;
use App\TransactionDetail;
use App\Cycle;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        return view('reports/index');
    }

    public function vatPurchase(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
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
    public function vatSales(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
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

        return TransactionDetail::join('charts', 'charts.id', 'transaction_details.chart_id')
        ->join('charts as vats', 'vats.id', 'transaction_details.chart_vat_id')
        ->join('transactions', 'transactions.id', 'transaction_details.transaction_id')
        ->join('taxpayers as supplier', 'transactions.supplier_id', 'supplier.id')
        ->join('taxpayers as customer', 'transactions.customer_id', 'customer.id')
        ->where('customer.id', $taxPayer->id)
        ->whereBetween('transactions.date', array(Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()))
        ->select('supplier.name as supplier',
        'supplier.taxid as supplier_code',
        'transactions.type',
        'transactions.id as purchaseID',
        'transactions.date',
        'transactions.code',
        'transactions.number',
        'transactions.payment_condition',
        'transactions.comment',
        'transactions.rate',
        'charts.name as costCenter',
        'vats.name as vat',
        'vats.coefficient',
        DB::raw('transactions.rate * if(transactions.type = 4,
        -transaction_details.value,
        transaction_details.value) as localCurrencyValue,
        (transactions.rate * if(transactions.type = 4,
        -transaction_details.value,
        transaction_details.value)) / (vats.coefficient + 1) as vatValue'
        )
        )
        ->orderBy('transactions.date', 'asc')
        ->get();
    }

    public function vatSaleQuery(Taxpayer $taxPayer, $startDate, $endDate)
    {
        DB::connection()->disableQueryLog();

        return TransactionDetail::join('charts', 'charts.id', 'transaction_details.chart_id')
        ->join('charts as vats', 'vats.id', 'transaction_details.chart_vat_id')
        ->join('transactions', 'transactions.id', 'transaction_details.transaction_id')
        ->join('taxpayers as supplier', 'transactions.supplier_id', 'supplier.id')
        ->join('taxpayers as customer', 'transactions.customer_id', 'customer.id')
        ->where('customer.id', $taxPayer->id)
        ->whereBetween('transactions.date', array(Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()))
        ->select('supplier.name as supplier',
        'supplier.taxid as supplier_code',
        'transactions.type',
        'transactions.id as salesID',
        'transactions.date',
        'transactions.code',
        'transactions.number',
        'transactions.payment_condition',
        'transactions.comment',
        'transactions.rate',
        'charts.name as costCenter',
        'vats.name as vat',
        'vats.coefficient',
        DB::raw('transactions.rate * if(transactions.type = 4,
        -transaction_details.value,
        transaction_details.value) as localCurrencyValue,
        (transactions.rate * if(transactions.type = 4,
        -transaction_details.value,
        transaction_details.value)) / (vats.coefficient + 1) as vatValue'
        )
        )
        ->orderBy('transactions.date', 'asc')
        ->get();
    }


}
