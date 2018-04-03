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

    public function purchases(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
    {
        if (isset($taxPayer))
        {
            $data = $this->vatPurchaseQuery($taxPayer, $startDate, $endDate);

            return view('reports/PRY/purchases')
            ->with('header', $taxPayer)
            ->with('data', $data)
            ->with('strDate', $startDate)
            ->with('endDate', $endDate);
        }
    }

    public function purchasesByVAT(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
    {
        if (isset($taxPayer))
        {
            $data = $this->vatPurchaseQuery($taxPayer, $startDate, $endDate);

            return view('reports/PRY/purchases_ByVAT')
            ->with('header', $taxPayer)
            ->with('data', $data)
            ->with('strDate', $startDate)
            ->with('endDate', $endDate);
        }
    }

    public function purchasesByChart(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
    {
        if (isset($taxPayer))
        {
            $data = $this->vatPurchaseQuery($taxPayer, $startDate, $endDate);

            return view('reports/PRY/purchases_byChart')
            ->with('header', $taxPayer)
            ->with('data', $data)
            ->with('strDate', $startDate)
            ->with('endDate', $endDate);
        }
    }

    public function purchasesBySupplier(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
    {
        if (isset($taxPayer))
        {
            $data = $this->vatPurchaseQuery($taxPayer, $startDate, $endDate);

            return view('reports/PRY/purchases_BySupplier')
            ->with('header', $taxPayer)
            ->with('data', $data)
            ->with('strDate', $startDate)
            ->with('endDate', $endDate);
        }
    }

    public function sales(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
    {
        if (isset($taxPayer))
        {
            $data = $this->vatSaleQuery($taxPayer, $startDate, $endDate);

            return view('reports/PRY/sales')
            ->with('header', $taxPayer)
            ->with('data', $data)
            ->with('strDate', $startDate)
            ->with('endDate', $endDate);
        }
    }

    public function salesByVAT(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
    {
        if (isset($taxPayer))
        {
            $data = $this->vatSaleQuery($taxPayer, $startDate, $endDate);

            return view('reports/PRY/sales_byVat')
            ->with('header', $taxPayer)
            ->with('data', $data)
            ->with('strDate', $startDate)
            ->with('endDate', $endDate);
        }
    }

    public function salesByChart(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
    {
        if (isset($taxPayer))
        {
            $data = $this->vatSaleQuery($taxPayer, $startDate, $endDate);

            return view('reports/PRY/sales_byVat')
            ->with('header', $taxPayer)
            ->with('data', $data)
            ->with('strDate', $startDate)
            ->with('endDate', $endDate);
        }
    }

    public function salesByCustomer(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
    {
        if (isset($taxPayer))
        {
            $data = $this->vatSaleQuery($taxPayer, $startDate, $endDate);

            return view('reports/PRY/sales_byCustomer')
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
        ->whereIn('transactions.type', [1, 2, 3])
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
        DB::raw(
            'transactions.rate * if(transactions.type = 3, -transaction_details.value, transaction_details.value) as localCurrencyValue,
            (transactions.rate * if(transactions.type = 3, -transaction_details.value, transaction_details.value)) / (vats.coefficient + 1) as vatValue'
            )
            )
            ->orderBy('transactions.date', 'asc')
            ->orderBy('transactions.number', 'asc')
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
            ->where('supplier.id', $taxPayer->id)
            ->whereIn('transactions.type', [4, 5])
            ->whereBetween('transactions.date', array(Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()))
            ->select('customer.name as customer',
            'customer.taxid as customer_code',
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
            DB::raw('transactions.rate * if(transactions.type = 5, -transaction_details.value, transaction_details.value) as localCurrencyValue,
            (transactions.rate * if(transactions.type = 5, -transaction_details.value, transaction_details.value)) / (vats.coefficient + 1) as vatValue')
            )
            ->orderBy('transactions.date', 'asc')
            ->orderBy('transactions.number', 'asc')
            ->get();
        }
    }
