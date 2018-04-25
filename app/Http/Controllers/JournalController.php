<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\AccountMovement;
use App\Transaction;
use App\Taxpayer;
use App\Cycle;
use App\Journal;
use App\JournalDetail;
use App\JournalTransaction;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\JournalCollection;
use Illuminate\Support\Facades\Log;


class JournalController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        return view('/accounting/journals');
    }

    public function getJournals(Taxpayer $taxPayer, Cycle $cycle, $skip)
    {
        $journals = Journal::with('details:id,journal_id,chart_id,debit,credit')
        ->with('details.chart:id,name,code')
        ->orderBy('date', 'desc')

        ->take(100)
        ->skip($skip)
        ->get();

        // return new JournalCollection($journals);
        return response()->json($journals);
    }

    public function getJournalsByID($taxPayerID, Cycle $cycle, $id)
    {
        $journals = Journal::with('details:id,journal_id,chart_id,debit,credit')
        ->where('journals.id', $id)
        ->get();

        return response()->json($journals);
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
    public function store(Request $request,Taxpayer $taxPayer,Cycle $cycle)
    {
        $journal = $request->id == 0 ? new Journal() : Journal::where('id', $request->id)->first();

        $journal->date = $request->date;
        $journal->number = $request->number ;
        $journal->comment = $request->comment;
        $journal->cycle_id = $cycle->id;
        $journal->save();

        foreach ($request->details as $detail)
        {
            $journalDetail = $detail['id'] == 0 ? new JournalDetail() : JournalDetail::where('id', $detail['id'])->first();
            $journalDetail->journal_id = $journal->id;
            $journalDetail->chart_id = $detail['chart_id'];
            $journalDetail->debit = $detail['debit'];
            $journalDetail->credit = $detail['credit'];
            $journalDetail->save();
        }

        return response()->json('ok');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Journal  $journal
    * @return \Illuminate\Http\Response
    */
    public function show(Journal $journal)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Journal  $journal
    * @return \Illuminate\Http\Response
    */
    public function edit(Journal $journal)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Journal  $journal
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Journal $journal)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Journal  $journal
    * @return \Illuminate\Http\Response
    */
    public function destroy(Journal $journal)
    {
        //
    }


    public function generateJournalsByRange(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
    {
        //Get startOf and endOf to cover entire week of range.
        $currentDate = Carbon::parse($startDate)->startOfMonth();
        $endDate = Carbon::parse($endDate)->endOfMonth();

        //Number of weeks helps with the for loop
        $numberOfMonths = $currentDate->diffInMonths($endDate);

        for ($x = 0; $x <= $numberOfMonths; $x++)
        {
            //Get current date start of and end of week to run the query.
            $monthStartDate = Carbon::parse($currentDate->startOfMonth());
            $monthEndDate = Carbon::parse($currentDate->endOfMonth());

            DB::connection()->disableQueryLog();

            //Do not get items that already have current status "Accounted" or "Finalized"
            $transactions = Transaction::whereBetween('date', [$monthStartDate, $monthEndDate])
            ->with('details')
            ->where('supplier_id', $taxPayer->id)
            ->whereIn('type', [4, 5])
            ->orderBy('date')
            ->otherCurrentStatus(['Accounted', 'Finalized', 'Annuled'])
            ->get() ?? null;

            foreach ($transactions->groupBy('type') as $groupedTransactions)
            {
                $sales = collect($groupedTransactions->where('type', 4)) ?? null;

                if ($sales->count() > 0)
                {
                    $comment = __('accounting.SalesBookComment', ['startDate' => $monthStartDate->toDateString(), 'endDate' => $monthEndDate->toDateString()]);
                    $this->generate_fromSales($taxPayer, $cycle, $sales, $comment);
                }

                //Add other types of transactions here to include into accounting.
                $credits = collect($groupedTransactions->where('type', 5)) ?? null;
                if ($credits->count() > 0)
                {
                    $comment = __('accounting.CreditNoteComment', ['startDate' => $monthStartDate->toDateString(), 'endDate' => $monthEndDate->toDateString()]);
                    $this->generate_fromCreditNotes($taxPayer, $cycle, $credits, $comment);
                }
            }

            $transactions = Transaction::whereBetween('date', [$monthStartDate, $monthEndDate])
            ->with('details')
            ->where('customer_id', $taxPayer->id)
            ->whereIn('type', [1, 2, 3])
            ->orderBy('date')
            ->otherCurrentStatus(['Accounted', 'Finalized', 'Annuled'])
            ->get() ?? null;

            foreach ($transactions->groupBy('type') as $groupedTransactions)
            {
                $purchases = collect($groupedTransactions->whereIn('type', [1, 2])) ?? null;
                if ($purchases->count() > 0)
                {
                    $comment = __('accounting.PurchaseBookComment', ['startDate' => $monthStartDate->toDateString(), 'endDate' => $monthEndDate->toDateString()]);
                    $this->generate_fromPurchases($taxPayer, $cycle, $purchases, $comment);
                }

                $debits = collect($groupedTransactions->where('type', 3)) ?? null;
                if ($debits->count() > 0)
                {
                    $comment = __('accounting.DebitNoteComment', ['startDate' => $monthStartDate->toDateString(), 'endDate' => $monthEndDate->toDateString()]);
                    $this->generate_fromDebitNotes($taxPayer, $cycle, $debits, $comment);
                }
            }

            $accounts = AccountMovement::whereBetween('date', [$monthStartDate, $monthEndDate])
            ->with(['transaction', 'chart'])
            ->where('taxpayer_id', $taxPayer->id)
            ->orderBy('date')
            ->otherCurrentStatus(['Accounted', 'Finalized', 'Annuled'])
            ->get() ?? null;

            if ($accounts->count() > 0)
            {
                //Accounts Receivable
                $accReceivables = $accounts->transaction()->where(function($query) use($taxPayer)
                {
                    $query
                    ->where('supplier_id', $taxPayer->id)
                    ->where('type', 4);
                })
                ->get();

                if ($accReceivables->count() > 0)
                {
                    // code...
                }

                //Accounts Payable
                $accPayables = $accounts->transaction()->where(function($query) use($taxPayer)
                {
                    $query
                    ->where('customer_id', $taxPayer->id)
                    ->whereIn('type', [1, 2]);
                })
                ->get();

                if ($accPayables->count() > 0)
                {
                    // code...
                }

                //Money Transfers
                $accMovements = $accounts->whereNull('transaction_id')->get();
                if ($accMovements->count() > 0)
                {
                    // code...
                }
            }

            //Inventory
            $inventories = Inventory::whereBetween('end_date', [$monthStartDate, $monthEndDate])
            ->where('taxpayer_id', $taxPayer->id)
            ->get();
            if ($inventories->count() > 0)
            {

            }

            //Finally add a month to go into next cycle
            $currentDate = $currentDate->addMonths(1);
        }

        return back();
    }

    //Generates Journals for a given range of Transactions. If one is passed, it will create one journal.
    //If multiple is passed, it will create one journal that takes into account all the details for each account.
    public function generate_fromSales(Taxpayer $taxPayer, Cycle $cycle, $transactions, $comment)
    {
        //Create chart controller we might need it further in the code to lookup charts.
        $ChartController = new ChartController();

        //get sum of all transactions divided by exchange rate.
        $journal = new Journal();
        $journal->cycle_id = $cycle->id; //TODO: Change this for specific cycle that is in range with transactions
        $journal->date = $transactions->last()->date; //
        $journal->comment = $comment;
        $journal->save();

        //Affect all Cash Sales and uses Cash Accounts
        foreach ($transactions->where('payment_condition','=', 0)->groupBy('chart_account_id') as $groupedTransactions)
        {
            $value = 0;

            //calculate value by currency. fx. TODO, Include Rounding depending on Main Curreny from Taxpayer Country.
            foreach ($groupedTransactions->groupBy('rate') as $groupedByRate)
            {
                foreach ($groupedByRate as $transaction)
                {
                    $value += ($transaction->details->sum('value') * $groupedByRate->first()->rate);
                }
            }

            //Check for Cash Account used.

            $chart = $ChartController->createIfNotExists_CashAccounts($taxPayer, $cycle, $groupedTransactions->first()->chart_id);

            $detail = new JournalDetail();
            $detail->debit = 0;
            $detail->credit = $value;
            $detail->chart_id = $chart->id;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //Affects all Credit Sales and uses Customer Account for distribution
        foreach ($transactions->where('payment_condition', '>', 0)->groupBy('customer_id') as $groupedTransactions)
        {
            $value = 0;
            //calculate value by currency. fx
            foreach ($groupedTransactions->groupBy('rate') as $groupedByRate)
            {
                foreach ($groupedByRate as $transaction)
                {
                    $value += ($transaction->details->sum('value') * $groupedByRate->first()->rate);
                }
            }

            $chart = $ChartController->createIfNotExists_AccountsReceivables($taxPayer, $cycle, $groupedTransactions->first()->customer_id);

            //Create Generic if not
            $detail = new JournalDetail();
            $detail->debit = 0;
            $detail->credit = $value;
            $detail->chart_id = $chart->id;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        $details =[];
        foreach ($transactions as $transaction)
        {
            foreach ($transaction->details as $detail)
            {
                array_push($details, $detail);
            }
        }

        $details = collect($details);

        //Loop through each type of VAT. It will group by similar VATs to reduce number of rows.
        foreach ($details->groupBy('chart_vat_id') as $groupedByVATs)
        {
            if ($groupedByVATs->first()->chart_vat_id != null)
            {
                $vatChart = $groupedByVATs->first()->vat;

                $value = 0;
                foreach ($groupedByVATs as $detail)
                {
                    $value += ((($detail->value * $detail->transaction->rate) / ($vatChart->coefficient + 1)) * $vatChart->coefficient);
                }

                if ($value > 0)
                {
                    $detail = new JournalDetail();
                    $detail->debit = $value;
                    $detail->credit = 0;
                    $detail->chart_id = $vatChart->id;
                    $detail->journal_id = $journal->id;
                    $detail->save();
                }
            }
        }

        //Loop through each type of expense. It will group by similar expenses to reduce number of rows.
        foreach ($details->groupBy('chart_id') as $groupedByCharts)
        {
            $value = 0;

            foreach ($groupedByCharts->groupBy('chart_vat_id') as $groupedByVAT)
            {
                $vatChart = $groupedByVAT->first()->vat;
                foreach ($groupedByVAT as $detail)
                {
                    $value += (($detail->value * $detail->transaction->rate) / ($vatChart->coefficient + 1));
                }
            }

            $detail = new JournalDetail();
            $detail->debit = $value;
            $detail->credit = 0;
            $detail->chart_id = $groupedByCharts->first()->chart_id;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //TODO: Run validation to check if journal is balanced before saving
        //if not delete the journal and all details
        $sumDebit = $journal->details->sum('debit') ?? 0;
        $sumCredit = $journal->details->sum('credit') ?? 0;

        // if ($sumDebit == $sumCredit)
        // {
        //If everything is fine then save at the same time.
        //$journal->save();

        foreach ($transactions as $transaction)
        {
            $transaction->setStatus('Accounted');

            $journalTransaction = new JournalTransaction();
            $journalTransaction->journal_id = $journal->id;
            $journalTransaction->transaction_id = $transaction->id;
            $journalTransaction->save();
        }
        // }
        // else
        // {
        //     $journal->delete();
        //     Log::info($journal);
        // }
    }

    public function generate_fromPurchases(Taxpayer $taxPayer, Cycle $cycle, $transactions, $comment)
    {
        //Create chart controller we might need it further in the code to lookup charts.
        $ChartController = new ChartController();

        //get sum of all transactions divided by exchange rate.
        $journal = new Journal();
        $journal->cycle_id = $cycle->id; //TODO: Change this for specific cycle that is in range with transactions
        $journal->date = $transactions->last()->date; //
        $journal->comment = $comment;
        $journal->save();

        $details =[];

        foreach ($transactions as $transaction)
        {
            foreach ($transaction->details as $detail)
            {
                array_push($details, $detail);
            }
        }

        $details = collect($details);

        //Loop through each type of VAT. It will group by similar VATs to reduce number of rows.
        foreach ($details->groupBy('chart_vat_id') as $groupedByVATs)
        {
            if ($groupedByVATs->first()->chart_vat_id != null)
            {
                $vatChart = $groupedByVATs->first()->vat;

                $value = 0;
                foreach ($groupedByVATs as $detail)
                {
                    $value += ((($detail->value * $detail->transaction->rate) / ($vatChart->coefficient + 1)) * $vatChart->coefficient);
                }

                if ($value > 0)
                {
                    $detail = new JournalDetail();
                    $detail->debit = 0;
                    $detail->credit = $value;
                    $detail->chart_id = $vatChart->id;
                    $detail->journal_id = $journal->id;
                    $detail->save();
                }
            }
        }

        //Loop through each type of expense. It will group by similar expenses to reduce number of rows.
        foreach ($details->groupBy('chart_id') as $groupedByCharts)
        {
            //Check if Journal contains chart_id as detail.
            //$detail = JournalDetail::where('chart_id', $groupedByCharts->first()->chart_id)->where('journal_id', $journal->id)->first() ?? new JournalDetail();
            $value = 0;

            foreach ($groupedByCharts->groupBy('chart_vat_id') as $groupedByVAT)
            {
                $vatChart = $groupedByVAT->first()->vat;
                foreach ($groupedByVAT as $detail)
                {
                    $value += (($detail->value * $detail->transaction->rate) / ($vatChart->coefficient + 1));
                }
            }

            if ($value > 0)
            {
                $detail = new JournalDetail();
                $detail->debit = 0;
                $detail->credit = $value;
                $detail->chart_id = $groupedByCharts->first()->chart_id;
                $detail->journal_id = $journal->id;
                $detail->save();
            }
        }

        //Affect all Cash Sales and uses Cash Accounts
        foreach ($transactions->where('payment_condition', '=', 0)->groupBy('chart_account_id') as $groupedTransactions)
        {
            $value = 0;

            //calculate value by currency. fx. TODO, Include Rounding depending on Main Curreny from Taxpayer Country.
            foreach ($groupedTransactions->groupBy('rate') as $groupedByRate)
            {
                foreach ($groupedByRate as $transaction)
                {
                    $value += ($transaction->details->sum('value') * $groupedByRate->first()->rate);
                }
            }

            //Check for Cash Account used.
            $chart = $ChartController->createIfNotExists_CashAccounts($taxPayer, $cycle, $groupedTransactions->first()->chart_id);

            $detail = new JournalDetail();
            $detail->debit = $value;
            $detail->credit = 0;
            $detail->chart_id = $chart->id;
            //$detail->journal()->associate($journal);
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //Affects all Credit Sales and uses Customer Account for distribution
        foreach ($transactions->where('payment_condition', '>', 0)->groupBy('supplier_id') as $groupedTransactions)
        {
            $value = 0;
            //calculate value by currency. fx
            foreach ($groupedTransactions->groupBy('rate') as $groupedByRate)
            {
                foreach ($groupedByRate as $transaction)
                {
                    $value += ($transaction->details->sum('value') * $groupedByRate->first()->rate);
                }
            }

            $chart = $ChartController->createIfNotExists_AccountsPayable($taxPayer, $cycle, $groupedTransactions->first()->supplier_id);

            //Create Generic if not
            $detail = new JournalDetail();
            $detail->debit = $value;
            $detail->credit = 0;
            $detail->chart_id = $chart->id;
            //$detail->journal()->associate($journal);
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //TODO: Run validation to check if journal is balanced before saving
        //if not delete the journal and all details
        $sumDebit = $journal->details->sum('debit') ?? 0;
        $sumCredit = $journal->details->sum('credit') ?? 0;

        // if ($sumDebit == $sumCredit)
        // {
        foreach ($transactions as $transaction)
        {
            $transaction->setStatus('Accounted');

            $journalTransaction = new JournalTransaction();
            $journalTransaction->journal_id = $journal->id;
            $journalTransaction->transaction_id = $transaction->id;
            $journalTransaction->save();
        }
        // }
        // else
        // {
        //     $journal->delete();
        //     Log::info($journal);
        // }
    }

    public function generate_fromCreditNotes(Taxpayer $taxPayer, Cycle $cycle, $transactions, $comment)
    {
        //Create chart controller we might need it further in the code to lookup charts.
        $ChartController = new ChartController();

        //get sum of all transactions divided by exchange rate.
        $journal = new Journal();
        $journal->cycle_id = $cycle->id; //TODO: Change this for specific cycle that is in range with transactions
        $journal->date = $transactions->sortBy('date')->last()->date; //
        $journal->comment = $comment;
        $journal->save();

        $details =[];

        foreach ($transactions as $transaction)
        {
            foreach ($transaction->details as $detail)
            {
                array_push($details, $detail);
            }
        }

        $details = collect($details);

        //Loop through each type of VAT. It will group by similar VATs to reduce number of rows.
        foreach ($details->groupBy('chart_vat_id') as $groupedByVATs)
        {
            if ($groupedByVATs->first()->chart_vat_id != null)
            {
                $vatChart = $groupedByVATs->first()->vat;

                $value = 0;
                foreach ($groupedByVATs as $detail)
                {
                    $value += ((($detail->value * $detail->transaction->rate) / ($vatChart->coefficient + 1)) * $vatChart->coefficient);
                }

                if ($value > 0)
                {
                    $detail = new JournalDetail();
                    $detail->debit = 0;
                    $detail->credit = $value;
                    $detail->chart_id = $vatChart->id;
                    $detail->journal_id = $journal->id;
                    $detail->save();
                }
            }
        }

        //Loop through each type of expense. It will group by similar expenses to reduce number of rows.
        foreach ($details->groupBy('chart_id') as $groupedByCharts)
        {
            //Check if Journal contains chart_id as detail.
            //$detail = JournalDetail::where('chart_id', $groupedByCharts->first()->chart_id)->where('journal_id', $journal->id)->first() ?? new JournalDetail();
            $value = 0;

            foreach ($groupedByCharts->groupBy('chart_vat_id') as $groupedByVAT)
            {
                $vatChart = $groupedByVAT->first()->vat;
                foreach ($groupedByVAT as $detail)
                {
                    $value += (($detail->value * $detail->transaction->rate) / ($vatChart->coefficient + 1));
                }
            }

            if ($value > 0)
            {
                $detail = new JournalDetail();
                $detail->debit = 0;
                $detail->credit = $value;
                $detail->chart_id = $groupedByCharts->first()->chart_id;
                $detail->journal_id = $journal->id;
                $detail->save();
            }
        }

        //Affect all Cash Sales and uses Cash Accounts
        foreach ($transactions->where('payment_condition', '=', 0)->groupBy('chart_account_id') as $groupedTransactions)
        {
            $value = 0;

            //calculate value by currency. fx. TODO, Include Rounding depending on Main Curreny from Taxpayer Country.
            foreach ($groupedTransactions->groupBy('rate') as $groupedByRate)
            {
                foreach ($groupedByRate as $transaction)
                {
                    $value += ($transaction->details->sum('value') * $groupedByRate->first()->rate);
                }
            }

            //Check for Cash Account used.
            $chart = $ChartController->createIfNotExists_CashAccounts($taxPayer, $cycle, $groupedTransactions->first()->chart_id);

            $detail = new JournalDetail();
            $detail->debit = $value;
            $detail->credit = 0;
            $detail->chart_id = $chart->id;
            //$detail->journal()->associate($journal);
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //Affects all Credit Sales and uses Customer Account for distribution
        foreach ($transactions->where('payment_condition', '>', 0)->groupBy('customer_id') as $groupedTransactions)
        {
            $value = 0;
            //calculate value by currency. fx
            foreach ($groupedTransactions->groupBy('rate') as $groupedByRate)
            {
                foreach ($groupedByRate as $transaction)
                {
                    $value += ($transaction->details->sum('value') * $groupedByRate->first()->rate);
                }
            }

            $chart = $ChartController->createIfNotExists_AccountsReceivables($taxPayer, $cycle, $groupedTransactions->first()->customer_id);

            //Create Generic if not
            $detail = new JournalDetail();
            $detail->debit = $value;
            $detail->credit = 0;
            $detail->chart_id = $chart->id;
            //$detail->journal()->associate($journal);
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //TODO: Run validation to check if journal is balanced before saving
        //if not delete the journal and all details
        $sumDebit = $journal->details->sum('debit') ?? 0;
        $sumCredit = $journal->details->sum('credit') ?? 0;

        // if ($sumDebit == $sumCredit)
        // {
        foreach ($transactions as $transaction)
        {
            $transaction->setStatus('Accounted');

            $journalTransaction = new JournalTransaction();
            $journalTransaction->journal_id = $journal->id;
            $journalTransaction->transaction_id = $transaction->id;
            $journalTransaction->save();
        }
    }

    public function generate_fromDebitNotes(Taxpayer $taxPayer, Cycle $cycle, $transactions, $comment)
    {
        //Create chart controller we might need it further in the code to lookup charts.
        $ChartController = new ChartController();

        //get sum of all transactions divided by exchange rate.
        $journal = new Journal();
        $journal->cycle_id = $cycle->id; //TODO: Change this for specific cycle that is in range with transactions
        $journal->date = $transactions->last()->date; //
        $journal->comment = $comment;
        $journal->save();

        //Affect all Cash Sales and uses Cash Accounts
        foreach ($transactions->where('payment_condition', '=', 0)->groupBy('chart_account_id') as $groupedTransactions)
        {
            $value = 0;

            //calculate value by currency. fx. TODO, Include Rounding depending on Main Curreny from Taxpayer Country.
            foreach ($groupedTransactions->groupBy('rate') as $groupedByRate)
            {
                foreach ($groupedByRate as $transaction)
                {
                    $value += ($transaction->details->sum('value') * $groupedByRate->first()->rate);
                }
            }

            //Check for Cash Account used.

            $chart = $ChartController->createIfNotExists_CashAccounts($taxPayer, $cycle, $groupedTransactions->first()->chart_id);

            $detail = new JournalDetail();
            $detail->debit = 0;
            $detail->credit = $value;
            $detail->chart_id = $chart->id;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //Affects all Credit Sales and uses Customer Account for distribution
        foreach ($transactions->where('payment_condition', '>', 0)->groupBy('customer_id') as $groupedTransactions)
        {
            $value = 0;
            //calculate value by currency. fx
            foreach ($groupedTransactions->groupBy('rate') as $groupedByRate)
            {
                foreach ($groupedByRate as $transaction)
                {
                    $value += ($transaction->details->sum('value') * $groupedByRate->first()->rate);
                }
            }

            $chart = $ChartController->createIfNotExists_AccountsReceivables($taxPayer, $cycle, $groupedTransactions->first()->customer_id);

            //Create Generic if not
            $detail = new JournalDetail();
            $detail->debit = 0;
            $detail->credit = $value;
            $detail->chart_id = $chart->id;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        $details = [];
        foreach ($transactions as $transaction)
        {
            foreach ($transaction->details as $detail)
            {
                array_push($details, $detail);
            }
        }

        $details = collect($details);

        //Loop through each type of VAT. It will group by similar VATs to reduce number of rows.
        foreach ($details->groupBy('chart_vat_id') as $groupedByVATs)
        {
            if ($groupedByVATs->first()->chart_vat_id != null)
            {
                $vatChart = $groupedByVATs->first()->vat;

                $value = 0;
                foreach ($groupedByVATs as $detail)
                {
                    $value += ((($detail->value * $detail->transaction->rate) / ($vatChart->coefficient + 1)) * $vatChart->coefficient);
                }

                if ($value > 0)
                {
                    $detail = new JournalDetail();
                    $detail->debit = $value;
                    $detail->credit = 0;
                    $detail->chart_id = $vatChart->id;
                    $detail->journal_id = $journal->id;
                    $detail->save();
                }
            }
        }

        //Loop through each type of expense. It will group by similar expenses to reduce number of rows.
        foreach ($details->groupBy('chart_id') as $groupedByCharts)
        {
            $value = 0;

            foreach ($groupedByCharts->groupBy('chart_vat_id') as $groupedByVAT)
            {
                $vatChart = $groupedByVAT->first()->vat;
                foreach ($groupedByVAT as $detail)
                {
                    $value += (($detail->value * $detail->transaction->rate) / ($vatChart->coefficient + 1));
                }
            }

            $detail = new JournalDetail();
            $detail->debit = $value;
            $detail->credit = 0;
            $detail->chart_id = $groupedByCharts->first()->chart_id;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //TODO: Run validation to check if journal is balanced before saving
        //if not delete the journal and all details
        $sumDebit = $journal->details->sum('debit') ?? 0;
        $sumCredit = $journal->details->sum('credit') ?? 0;

        foreach ($transactions as $transaction)
        {
            $transaction->setStatus('Accounted');

            $journalTransaction = new JournalTransaction();
            $journalTransaction->journal_id = $journal->id;
            $journalTransaction->transaction_id = $transaction->id;
            $journalTransaction->save();
        }
    }

    public function generate_fromAccountsReceivables(Taxpayer $taxPayer, Cycle $cycle, $accMovements, $comment)
    {
        //Create chart controller we might need it further in the code to lookup charts.
        $ChartController = new ChartController();

        //get sum of all transactions divided by exchange rate.
        $journal = new Journal();
        $journal->cycle_id = $cycle->id; //TODO: Change this for specific cycle that is in range with transactions
        $journal->date = $accMovements->last()->date; //
        $journal->comment = $comment;
        $journal->save();

        //Affect all Cash Sales and uses Cash Accounts
        foreach ($accMovements->groupBy('chart_id') as $groupedByAccount)
        {
            $value = 0;

            //calculate value by currency. fx. TODO, Include Rounding depending on Main Curreny from Taxpayer Country.
            foreach ($groupedByAccount->groupBy('rate') as $groupedByRate)
            {
                $value += $groupedByRate->sum('credit') * $groupedByRate->first()->rate;
            }

            if ($value > 0)
            {
                //Check for Cash Account used.
                $chart = $ChartController->createIfNotExists_CashAccounts($taxPayer, $cycle, $groupedByAccount->first()->chart_id);

                $detail = new JournalDetail();
                $detail->debit = 0;
                $detail->credit = $value;
                $detail->chart_id = $chart->id;
                $detail->journal_id = $journal->id;
                $detail->save();
            }
        }

        //Affect all Cash Sales and uses Cash Accounts
        foreach ($accMovements->transaction->groupBy('customer_id') as $groupedByInvoice)
        {
            $value = 0;

            //calculate value by currency. fx. TODO, Include Rounding depending on Main Curreny from Taxpayer Country.
            foreach ($groupedByInvoice->groupBy('rate') as $groupedByRate)
            {
                $value += $groupedByRate->sum('credit') * $groupedByRate->first()->rate;
            }

            if ($value > 0)
            {
                //Check for Account Receivables used.
                $chart = $ChartController->createIfNotExists_AccountsReceivables($taxPayer, $cycle, $groupedByInvoice->first()->customer_id);

                $detail = new JournalDetail();
                $detail->debit = $value;
                $detail->credit = 0;
                $detail->chart_id = $chart->id;
                $detail->journal_id = $journal->id;
                $detail->save();
            }
        }

        foreach ($accMovements as $mov)
        {
            $mov->setStatus('Accounted');

            $journalAccountMovement = new JournalAccountMovement();
            $journalAccountMovement->journal_id = $journal->id;
            $journalAccountMovement->account_movement_id = $mov->id;
            $journalAccountMovement->save();
        }
    }

    public function generate_fromAccountsPayables(Taxpayer $taxPayer, Cycle $cycle, $transactions, $comment)
    {
        //Create chart controller we might need it further in the code to lookup charts.
        $ChartController = new ChartController();

        //get sum of all transactions divided by exchange rate.
        $journal = new Journal();
        $journal->cycle_id = $cycle->id; //TODO: Change this for specific cycle that is in range with transactions
        $journal->date = $accMovements->last()->date; //
        $journal->comment = $comment;
        $journal->save();

        //Affect all Cash Sales and uses Cash Accounts
        foreach ($accMovements->groupBy('chart_id') as $groupedByAccount)
        {
            $value = 0;

            //calculate value by currency. fx. TODO, Include Rounding depending on Main Curreny from Taxpayer Country.
            foreach ($groupedByAccount->groupBy('rate') as $groupedByRate)
            {
                $value += $groupedByRate->sum('debit') * $groupedByRate->first()->rate;
            }

            if ($value > 0)
            {
                //Check for Cash Account used.
                $chart = $ChartController->createIfNotExists_CashAccounts($taxPayer, $cycle, $groupedByAccount->first()->chart_id);

                $detail = new JournalDetail();
                $detail->debit = $value;
                $detail->credit = 0;
                $detail->chart_id = $chart->id;
                $detail->journal_id = $journal->id;
                $detail->save();
            }
        }

        //Affect all Cash Sales and uses Cash Accounts
        foreach ($accMovements->transaction->groupBy('supplier_id') as $groupedByInvoice)
        {
            $value = 0;

            //calculate value by currency. fx. TODO, Include Rounding depending on Main Curreny from Taxpayer Country.
            foreach ($groupedByInvoice->groupBy('rate') as $groupedByRate)
            {
                $value += $groupedByRate->sum('debit') * $groupedByRate->first()->rate;
            }

            if ($value > 0)
            {
                //Check for Account Receivables used.
                $chart = $ChartController->createIfNotExists_AccountsReceivables($taxPayer, $cycle, $groupedByInvoice->first()->supplier_id);

                $detail = new JournalDetail();
                $detail->debit = 0;
                $detail->credit = $value;
                $detail->chart_id = $chart->id;
                $detail->journal_id = $journal->id;
                $detail->save();
            }
        }

        foreach ($accMovements as $mov)
        {
            $mov->setStatus('Accounted');

            $journalAccountMovement = new JournalAccountMovement();
            $journalAccountMovement->journal_id = $journal->id;
            $journalAccountMovement->account_movement_id = $mov->id;
            $journalAccountMovement->save();
        }
    }

    public function generate_fromMoneyTransfers(Taxpayer $taxPayer, Cycle $cycle, $transactions, $comment)
    {
        // //Make Journal
        // $journal = new Journal();
        // $journal->cycle_id = $cycle->id; //TODO: Change this for specific cycle that is in range with transactions
        // $journal->date = $transactions->last()->date;
        // $journal->comment = __('PurchaseBookComment', [$transactions->first()->date, $transactions->last()->date]);
        // $journal->save();
        //
        // //Find
    }

    public function generate_fromProductions()
    {

    }
}
