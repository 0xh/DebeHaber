<?php

namespace App\Http\Controllers;

use App\AccountMovement;
use App\JournalTransaction;
use App\Taxpayer;
use App\Cycle;
use App\Chart;
use App\Transaction;
use App\TransactionDetail;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;
use DB;

class PurchaseController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        return view('/commercial/purchases');
    }

    public function get_purchases(Taxpayer $taxPayer, Cycle $cycle)
    {
        //TODO improve query using sum of deatils instead of inner join.
        return TransactionResource::collection(
            Transaction::MyPurchases()
            ->join('taxpayers', 'taxpayers.id', 'transactions.supplier_id')
            ->join('currencies', 'transactions.currency_id','currencies.id')
            ->leftJoin('transaction_details as td', 'td.transaction_id', 'transactions.id')
            ->where('transactions.customer_id', $taxPayer->id)
            ->whereBetween('date', [$cycle->start_date, $cycle->end_date])
            ->groupBy('transactions.id')
            ->select(DB::raw('max(transactions.id) as ID'),
            DB::raw('max(taxpayers.name) as Supplier'),
            DB::raw('max(taxpayers.taxid) as SupplierTaxID'),
            DB::raw('max(currencies.code) as Currency'),
            DB::raw('max(transactions.payment_condition) as PaymentCondition'),
            DB::raw('max(transactions.date) as Date'),
            DB::raw('max(transactions.number) as Number'),
            DB::raw('sum(td.value) as Value'))
            ->orderByRaw('max(transactions.date)', 'desc')
            ->orderByRaw('max(transactions.number)', 'desc')
            ->paginate(50)
        );
    }

    public function getLastPurchase($taxPayerID)
    {
        $Transaction = Transaction::MyPurchases()
        ->join('taxpayers', 'taxpayers.id', 'transactions.supplier_id')
        ->where('customer_id', $taxPayerID)
        ->with('details')
        ->orderBy('date', 'desc')
        ->select(DB::raw(
            'taxpayers.name as Supplier,
            supplier_id,
            document_id,
            currency_id,
            rate,
            payment_condition,
            chart_account_id,
            date,
            number,
            transactions.code,
            code_expiry'))
            ->first();
            return response()->json($Transaction);
        }

        public function get_purchasesByID(Taxpayer $taxPayer, Cycle $cycle, $id)
        {
            $Transaction = Transaction::MyPurchases()
            ->join('taxpayers', 'taxpayers.id', 'transactions.supplier_id')
            ->where('customer_id', $taxPayer->id)
            ->where('transactions.id', $id)
            ->with('details')
            ->select(DB::raw('false as selected,transactions.id,taxpayers.name as supplier
            ,supplier_id,document_id,currency_id,rate,payment_condition,chart_account_id,date
            ,number,transactions.code,code_expiry'))
            ->get();

            return response()->json($Transaction);
        }

        /**
        * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
        */
        public function create()
        {
            //
        }

        /**
        * Store a newly created resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
        */
        public function store(Request $request,Taxpayer $taxPayer)
        {
            $transaction = $request->id == 0 ? new Transaction() : Transaction::where('id', $request->id)->first();
            $transaction->customer_id = $taxPayer->id;
            $transaction->supplier_id = $request->supplier_id;
            $transaction->document_id = $request->document_id > 0 ? $request->document_id : null;
            $transaction->currency_id = $request->currency_id;

            $transaction->rate = $request->rate;
            $transaction->payment_condition = $request->payment_condition;

            if ($request->chart_account_id > 0)
            {
                $transaction->chart_account_id = $request->chart_account_id;
            }

            $transaction->date = $request->date;
            $transaction->number = $request->number;
            $transaction->code = $request->code;
            $transaction->code_expiry = $request->code_expiry;
            $transaction->comment = $request->comment;
            $transaction->type = $request->type;
            $transaction->save();

            foreach ($request->details as $detail)
            {
                $transactionDetail = $detail['id'] == 0 ? new TransactionDetail() : TransactionDetail::where('id', $detail['id'])->first();
                $transactionDetail->transaction_id = $transaction->id;
                $transactionDetail->chart_id = $detail['chart_id'];
                $transactionDetail->chart_vat_id = $detail['chart_vat_id'];
                $transactionDetail->value = $detail['value'];
                $transactionDetail->save();
            }

            return response()->json('ok', 200);
        }

        /**
        * Display the specified resource.
        *
        * @param  \App\Transaction  $transaction
        * @return \Illuminate\Http\Response
        */
        public function show(Transaction $transaction)
        {
            //
        }

        /**
        * Show the form for editing the specified resource.
        *
        * @param  \App\Transaction  $transaction
        * @return \Illuminate\Http\Response
        */
        public function edit(Transaction $transaction)
        {
            //
        }

        /**
        * Update the specified resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \App\Transaction  $transaction
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request, Transaction $transaction)
        {
            //
        }

        /**
        * Remove the specified resource from storage.
        *
        * @param  \App\Transaction  $transaction
        * @return \Illuminate\Http\Response
        */
        public function destroy(Taxpayer $taxPayer, Cycle $cycle,$transactionID)
        {
            try
            {

                //TODO: Run Tests to make sure it deletes all journals related to transaction
                AccountMovement::where('transaction_id', $transactionID)->delete();
                JournalTransaction::where('transaction_id',$transactionID)->delete();
                Transaction::where('id',$transactionID)->delete();

                return response()->json('ok', 200);
            }
            catch (\Exception $e)
            {
                return response()->json($e, 500);
            }
        }
    }
