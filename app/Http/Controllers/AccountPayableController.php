<?php

namespace App\Http\Controllers;

use App\AccountMovement;
use App\JournalTransaction;
use App\Transaction;
use App\Taxpayer;
use App\Cycle;
use App\Chart;
use App\Http\Resources\ModelResource;
use Illuminate\Http\Request;
use DB;

class AccountPayableController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        $chart = Chart::MoneyAccounts()->orderBy('name')
        ->select('name', 'id', 'sub_type')
        ->get();

        return view('/commercial/accounts-payable')->with('charts',$chart);
    }

    public function get_account_payable(Taxpayer $taxPayer, Cycle $cycle)
    {
        $transactions = Transaction::MyPurchases()
        ->join('taxpayers', 'taxpayers.id', 'transactions.supplier_id')
        ->join('currencies', 'transactions.currency_id','currencies.id')
        ->join('transaction_details as td', 'td.transaction_id', 'transactions.id')
        ->where('transactions.customer_id', $taxPayer->id)
        ->where('transactions.payment_condition', '>', 0)
        ->groupBy('transactions.id')
        ->select(DB::raw('max(transactions.id) as id'),
        DB::raw('max(taxpayers.name) as Supplier'),
        DB::raw('max(taxpayers.taxid) as SupplierTaxID'),
        DB::raw('max(currencies.code) as Currency'),
        DB::raw('max(transactions.payment_condition) as PaymentCondition'),
        DB::raw('max(transactions.date) as Date'),
        DB::raw('DATE_ADD(max(transactions.date), INTERVAL max(transactions.payment_condition) DAY) as Expiry'),
        DB::raw('max(transactions.number) as Number'),
        DB::raw('(select ifnull(sum(account_movements.debit * account_movements.rate), 0)  from account_movements where `transactions`.`id` = `account_movements`.`transaction_id`) as Paid'),
        DB::raw('sum(td.value * transactions.rate) as Value'),
        DB::raw('(sum(td.value * transactions.rate)
        - (select
        ifnull(sum(account_movements.debit * account_movements.rate), 0)
        from account_movements
        where transactions.id = account_movements.transaction_id))
        as Balance')
        )
        ->orderByRaw('DATE_ADD(max(transactions.date), INTERVAL max(transactions.payment_condition) DAY)', 'desc')
        ->orderByRaw('max(transactions.number)', 'desc')
        ->paginate(100);

        return ModelResource::collection($transactions);
    }

    public function get_account_payableByID(Taxpayer $taxPayer, Cycle $cycle,$id)
    {
        $accountMovement = Transaction::MyPurchases()
        ->join('taxpayers', 'taxpayers.id', 'transactions.supplier_id')
        ->join('currencies', 'transactions.currency_id','currencies.id')
        ->join('transaction_details as td', 'td.transaction_id', 'transactions.id')
        ->where('transactions.customer_id', $taxPayer->id)
        ->where('transactions.id', $id)
        ->where('transactions.payment_condition', '>', 0)
        ->groupBy('transactions.id')
        ->select(DB::raw('max(transactions.id) as id'),
        DB::raw('max(taxpayers.name) as Supplier'),
        DB::raw('max(taxpayers.taxid) as SupplierTaxID'),
        DB::raw('max(currencies.code) as currency_code'),
        DB::raw('max(transactions.payment_condition) as payment_condition'),
        DB::raw('max(transactions.date) as date'),
        DB::raw('DATE_ADD(max(transactions.date), INTERVAL max(transactions.payment_condition) DAY) as code_expiry'),
        DB::raw('max(transactions.number) as number'),
        DB::raw('(select ifnull(sum(account_movements.debit * account_movements.rate), 0)  from account_movements where `transactions`.`id` = `account_movements`.`transaction_id`) as Paid'),
        DB::raw('sum(td.value * transactions.rate) as Value'),
        DB::raw('(sum(td.value * transactions.rate) - (select
        ifnull(sum(account_movements.debit * account_movements.rate), 0)
        from account_movements
        where transactions.id = account_movements.transaction_id))
        as Balance')
        )
        ->get();

        return response()->json($accountMovement);
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
    public function store(Request $request)
    {
        if ($request->payment_value > 0)
        {
            $accountMovement = new AccountMovement();
            $accountMovement->taxpayer_id = $request->taxpayer_id;
            $accountMovement->chart_id = $request->chart_account_id ;
            $accountMovement->date = $request->date;

            $accountMovement->transaction_id = $request->id != '' ? $request->id : null;
            $accountMovement->currency_id = $request->currency_id;
            $accountMovement->rate = $request->rate ?? 1;
            $accountMovement->debit = $request->payment_value != '' ? $request->payment_value : 0;
            $accountMovement->comment = $request->comment;

            $accountMovement->save();

            return response()->json('ok', 200);
        }

        return response()->json('no value', 403);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\AccountMovement  $accountMovement
    * @return \Illuminate\Http\Response
    */
    public function show(AccountMovement $accountMovement)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\AccountMovement  $accountMovement
    * @return \Illuminate\Http\Response
    */
    public function edit(AccountMovement $accountMovement)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\AccountMovement  $accountMovement
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, AccountMovement $accountMovement)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\AccountMovement  $accountMovement
    * @return \Illuminate\Http\Response
    */
    public function destroy(Taxpayer $taxPayer, Cycle $cycle, $transactionID)
    {
        // try
        // {
        //     //TODO: Run Tests to make sure it deletes all journals related to transaction
        //     AccountMovement::where('transaction_id', $transactionID)->delete();
        //     JournalTransaction::where('transaction_id', $transactionID)->delete();
        //     Transaction::where('id', $transactionID)->delete();
        //
        //     return response()->json('ok', 200);
        // }
        // catch (\Exception $e)
        // {
        //     return response()->json($e, 500);
        // }
    }

    public function generate_Journals($startDate, $endDate, $taxPayer, $cycle)
    {
        \DB::connection()->disableQueryLog();

        $queryAccountPayables = AccountMovement::MyAccountPayablesForJournals($startDate, $endDate, $taxPayer->id)
        ->get();

        if ($queryAccountPayables->where('journal_id', '!=', null)->count() > 0)
        {
            $arrJournalIDs = $queryAccountPayables->where('journal_id', '!=', null)->pluck('journal_id');
            //## Important! Null all references of Journal in Transactions.
            AccountMovement::whereIn('journal_id', [$arrJournalIDs])
            ->update(['journal_id' => null]);

            //Delete the journals & details with id
            \App\JournalDetail::whereIn('journal_id', [$arrJournalIDs])
            ->forceDelete();
            \App\Journal::whereIn('id', [$arrJournalIDs])
            ->forceDelete();
        }

        $journal = new \App\Journal();
        $comment = __('accounting.AccountsPayableComment', ['startDate' => $startDate->toDateString(), 'endDate' => $endDate->toDateString()]);

        $journal->cycle_id = $cycle->id;
        $journal->date = $endDate;
        $journal->comment = $comment;
        $journal->is_automatic = 1;
        $journal->save();

        //Assign all transactions the new journal_id.
        //No need for If Count > 0, because if it was 0, it would not have gone in this function.
        AccountMovement::whereIn('id', $queryAccountPayables->pluck('id'))
        ->update(['journal_id' => $journal->id]);

        $chartController= new ChartController();

        //1st Query: Sales Transactions done in Credit. Must affect customer credit account.
        $listOfPays = AccountMovement::MyAccountPayablesForJournals($startDate, $endDate, $taxPayer->id)
        ->groupBy('rate', 'supplier_id')
        ->select(DB::raw('max(rate) as rate'),
        DB::raw('max(supplier_id) as supplier_id'),
        DB::raw('sum(debit) as debit'),
        DB::raw('sum(credit) as credit'))
        ->get();

        //run code for credit purchase (insert detail into journal)
        foreach($listOfPayables as $row)
        {
            $supplierChartID = $chartController->createIfNotExists_AccountsPayables($taxPayer, $cycle, $row->customer_id)->id;
            $value = $row->total * $row->rate;

            $detail = $journal->details->where('chart_id', $supplierChartID)->first() ?? new \App\JournalDetail();
            $detail->credit = 0;
            $detail->debit += $value;
            $detail->chart_id = $customerChartID;
            $journal->details()->save($detail);

            $totalDebits += $value;
        }

        $listOfPayables = AccountMovement::MyAccountPayablesForJournals($startDate, $endDate, $taxPayer->id)
        ->groupBy('rate', 'supplier_id')
        ->select(DB::raw('max(rate) as rate'),
        DB::raw('max(supplier_id) as supplier_id'),
        DB::raw('sum(debit) as debit'),
        DB::raw('sum(credit) as credit'))
        ->get();

        //run code for credit purchase (insert detail into journal)
        foreach($listOfPayables->groupBy('rate') as $groupedRow)
        {
            $accountChartID = $groupedRow->first()->chart_account_id ?? $ChartController->createIfNotExists_CashAccounts($taxPayer, $cycle, $row->chart_account_id)->id;

            $detail = $journal->details->where('chart_id', $groupedRow->first()->chart_vat_id)->first() ?? new \App\JournalDetail();
            $detail->credit = $groupedRow->sum('total') * $groupedRow->rate;
            $detail->debit = 0;
            $detail->chart_id = $accountChartID;
            $journal->details()->save($detail);

            $totalCredits += $groupedRow->sum('total') * $groupedRow->rate;
        }

        //get the total credits and debits to see if there is a difference in account.
        //TODO. sum of credits is in local currency. you need to convert to default.
        //$totalCredits = $journal->details()->sum('credit');
        //$totalDebits = $journal->details()->sum('debit');

        //Credit is greater than Debit
        if ($totalCredits > $totalDebits)
        {
            $detail = new \App\JournalDetail();
            $detail->credit = $totalCredits - $totalDebits;
            $detail->debit = 0;
            $detail->chart_id = $ChartController->createIfNotExists_IncomeFromFX($taxPayer, $cycle)->id;
            $journal->details()->save($detail);
        }
        //Debit is greater than Credit
        else if($totalCredits < $totalDebits)
        {
            $detail = new \App\JournalDetail();
            $detail->credit = 0;
            $detail->debit = $totalDebits - $totalCredits;
            $detail->chart_id = $ChartController->createIfNotExists_ExpenseFromFX($taxPayer, $cycle)->id;
            $journal->details()->save($detail);
        }

        //End of Code
    }
}
