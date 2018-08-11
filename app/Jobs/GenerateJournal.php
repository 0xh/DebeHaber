<?php

namespace App\Jobs;

use DB;
use App\Inventory;
use App\AccountMovement;
use App\Transaction;
use App\TransactionDetail;
use App\Taxpayer;
use App\Cycle;
use App\Journal;
use App\JournalDetail;
use App\JournalTransaction;
use Log;
use Carbon\Carbon;
use App\Http\Controllers\ChartController;
use Illuminate\Http\Request;
use App\Http\Resources\JournalCollection;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Log\Logger;

class GenerateJournal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $taxPayer;
    protected $cycle;
    protected $startDate;
    protected $endDate;
    protected $type;

    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct(Taxpayer $taxPayer, Cycle $cycle, $startDate, $endDate)
    {
        $this->taxPayer = $taxPayer;
        $this->cycle = $cycle;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        $this->generateByMonth();
    }

    /**
    * Generate journals on daily basis. This function is for PAID customers only.
    */
    public function generateByDay()
    {
        //Get startOf and endOf to cover entire week of range.
        $currentDate = Carbon::parse($this->startDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        //Number of weeks helps with the for loop
        $numberOfDays = $currentDate->diffInDays($endDate);

        for ($x = 0; $x <= $numberOfDays; $x++)
        {
            //Get current date start of and end of week to run the query.
            $dayStartDate = Carbon::parse($currentDate->startOfDay());
            $dayEndDate = Carbon::parse($currentDate->endOfDay());

            $this->query_Sales($this->taxPayer, $this->cycle, $dayStartDate, $dayEndDate);

            //Finally add a month to go into next cycle
            $currentDate = $currentDate->addDays(1);
        }
    }

    /**
    * Generate journals on monthly basis.
    */
    public function generateByMonth()
    {
        //Get startOf and endOf to cover entire week of range.
        $currentDate = Carbon::parse($this->startDate)->startOfMonth();
        $endDate = Carbon::parse($this->endDate)->endOfMonth();

        Log::info('start date: ' .$currentDate. ', end date: ' .$endDate);

        //Number of weeks helps with the for loop
        $numberOfMonths = $currentDate->diffInMonths($endDate);

        for ($x = 0; $x <= $numberOfMonths; $x++)
        {
            //Get current date start of and end of week to run the query.
            $startDate = Carbon::parse($currentDate->startOfMonth());
            $endDate = Carbon::parse($currentDate->endOfMonth());

            //SALES
            //Create sales query, since the same query is called multiple times.

            //if the count is less than 0, no need to go inside and run additional code.
            if (Transaction::MySalesForJournals($startDate, $endDate, $this->taxPayer->id)->count() > 0)
            {
                $this->query_Sales($startDate, $endDate);
            }

            //PURCHASES
            //Create purchase query, since the same query is called multiple times.
            // $purchaseQuery = Transaction::whereBetween('date', [$startDate, $endDate])
            // ->otherCurrentStatus(['Annuled'])
            // ->where('customer_id', $this->taxPayer->id);
            //
            // $purcahsejournalQuery =Transaction::whereBetween('date', [$startDate, $endDate])
            // ->otherCurrentStatus(['Annuled'])
            // ->where('customer_id', $this->taxPayer->id)->groupBy('journal_id')
            // ->select('journal_id')->get();

            //if the count is less than 0, no need to go inside and run additional code.
            // if ($purchaseQuery->count() > 0)
            // {
            //     $this->query_Purchases($purchaseQuery,$purcahsejournalQuery, $startDate, $endDate);
            // }

            //$this->query_Credits($startDate, $endDate);
            //$this->query_Debits($startDate, $endDate);

            //Finally add a month to go into next cycle
            $currentDate = $endDate->addDay();
        }
    }


    /**
    * Generates one journal for all sales in date range.
    */
    public function query_Sales($startDate, $endDate)
    {
        \DB::connection()->disableQueryLog();

        $querySales = Transaction::MySalesForJournals($startDate, $endDate, $this->taxPayer->id)
        ->get();

        if ($querySales->where('journal_id', '!=', null)->count() > 0)
        {
            $arrJournalIDs = $querySales->where('journal_id', '!=', null)->pluck('journal_id');
            //## Important! Null all references of Journal in Transactions.
            Transaction::whereIn('journal_id', [$arrJournalIDs])
            ->update(['journal_id' => null]);

            //Delete the journals & details with id
            JournalDetail::whereIn('journal_id', [$arrJournalIDs])
            ->forceDelete();
            Journal::whereIn('id', [$arrJournalIDs])
            ->forceDelete();
        }

        $journal = new Journal();
        $comment = __('accounting.SalesBookComment', ['startDate' => $startDate->toDateString(), 'endDate' => $endDate->toDateString()]);

        $journal->cycle_id = $this->cycle->id; //TODO: Change this for specific cycle that is in range with transactions
        $journal->date = $endDate;
        $journal->comment = $comment;
        $journal->is_automatic = 1;
        $journal->save();

        //Assign all transactions the new journal_id.
        //No need for If Count > 0, because if it was 0, it would not have gone in this function.
        Transaction::whereIn('id', $querySales->pluck('id'))
        ->update(['journal_id' => $journal->id]);

        $ChartController= new ChartController();

        $salesInCash = Transaction::MySalesForJournals($startDate, $endDate, $this->taxPayer->id)
        ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
        ->groupBy('rate', 'chart_account_id')
        ->where('payment_condition', '=', 0)
        ->select(DB::raw('max(rate) as rate'),
        DB::raw('max(chart_account_id) as chart_account_id'),
        DB::raw('sum(transaction_details.value) as total'))
        ->get();

        //run code for cash sales (insert detail into journal)
        foreach($salesInCash as $row)
        {
            //search if a similar chart is already existing in journal details. if not, create a new detail.
            $accountChartID = $row->chart_account_id ?? $ChartController->createIfNotExists_CashAccounts($this->taxPayer, $this->cycle, $row->chart_account_id)->id;

            $value = $row->total * $row->rate;

            $detail = new JournalDetail();
            $detail->debit = 0;
            $detail->credit = $value;
            $detail->chart_id = $accountChartID;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //2nd Query:
        $creditSales = Transaction::MySalesForJournals($startDate, $endDate, $this->taxPayer->id)
        ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
        ->groupBy('rate', 'customer_id')
        ->where('payment_condition', '>', 0)
        ->select(DB::raw('max(rate) as rate'),
        DB::raw('max(customer_id) as customer_id'),
        DB::raw('sum(transaction_details.value) as total'))
        ->get();

        //run code for credit sales (insert detail into journal)
        foreach($creditSales as $row)
        {
            $customerChartID = $row->chart_account_id ?? $ChartController->createIfNotExists_AccountsReceivables($this->taxPayer, $this->cycle, $row->customer_id)->id;

            $value = $row->total * $row->rate;

            $detail = new JournalDetail();
            $detail->debit = 0;
            $detail->credit = $value;
            $detail->chart_id = $customerChartID;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        $detailAccounts = Transaction::MySalesForJournals($startDate, $endDate, $this->taxPayer->id)
        ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
        ->join('charts', 'charts.id', '=', 'transaction_details.chart_vat_id')
        ->groupBy('rate', 'transaction_details.chart_id', 'transaction_details.chart_vat_id')
        ->select(DB::raw('max(rate) as rate'),
        DB::raw('max(charts.coefficient) as coefficient'),
        DB::raw('max(transaction_details.chart_vat_id) as chart_vat_id'),
        DB::raw('max(transaction_details.chart_id) as chart_id'),
        DB::raw('sum(transaction_details.value) as total'))
        ->get();

        //run code for credit sales (insert detail into journal)
        foreach($detailAccounts->groupBy('chart_vat_id') as $groupedRow)
        {
            $groupTotal = $groupedRow->sum('total');
            $value = ($groupTotal - ($groupTotal / (1 + $groupedRow->first()->coefficient))) * $groupedRow->first()->rate;

            $detail = $journal->details->where('chart_vat_id', $groupedRow->first()->chart_vat_id)->first() ?? new JournalDetail();
            $detail->debit += $value;
            $detail->credit = 0;
            $detail->chart_id = $groupedRow->first()->chart_vat_id;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //run code for credit sales (insert detail into journal)
        foreach($detailAccounts->groupBy('chart_id') as $groupedRow)
        {
            $value = 0;

            //Discount Vat Value for these items.
            foreach($groupedRow->groupBy('coefficient') as $row)
            {
                $value += ($row->sum('total') / (1 + $row->first()->coefficient)) * $row->first()->rate;
            }

            $detail = $journal->details->where('chart_id', $groupedRow->first()->chart_id)->first() ?? new JournalDetail();
            $detail->debit += $value;
            $detail->credit = 0;
            $detail->chart_id = $groupedRow->first()->chart_id;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //End of Sales Code
    }

    public function query_Purchases($purchaseQuery,$purcahsejournalQuery, $startDate, $endDate)
    {
        \DB::connection()->disableQueryLog();

        $purchaseQuery = Transaction::MyPurchasesForJournals($startDate, $endDate, $this->taxPayer->id)
        ->get();

        if ($purchaseQuery->where('journal_id', '!=', null)->count() > 0)
        {
            $arrJournalIDs = $purchaseQuery->where('journal_id', '!=', null)->pluck('journal_id');
            //## Important! Null all references of Journal in Transactions.
            Transaction::whereIn('journal_id', [$arrJournalIDs])
            ->update(['journal_id' => null]);

            //Delete the journals & details with id
            JournalDetail::whereIn('journal_id', [$arrJournalIDs])
            ->forceDelete();
            Journal::whereIn('id', [$arrJournalIDs])
            ->forceDelete();
        }

        $journal = new Journal();
        $comment = __('accounting.PurchaseBookComment', ['startDate' => $startDate->toDateString(), 'endDate' => $endDate->toDateString()]);

        $journal->cycle_id = $this->cycle->id; //TODO: Change this for specific cycle that is in range with transactions
        $journal->date = $endDate;
        $journal->comment = $comment;
        $journal->is_automatic = 1;
        $journal->save();

        //Assign all transactions the new journal_id.
        //No need for If Count > 0, because if it was 0, it would not have gone in this function.
        Transaction::whereIn('id', $purchaseQuery->pluck('id'))
        ->update(['journal_id' => $journal->id]);

        $ChartController= new ChartController();

        $purchasesInCash = Transaction::MyPurchasesForJournals($startDate, $endDate, $this->taxPayer->id)
        ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
        ->groupBy('rate', 'chart_account_id')
        ->where('payment_condition', '=', 0)
        ->select(DB::raw('max(rate) as rate'),
        DB::raw('max(chart_account_id) as chart_account_id'),
        DB::raw('sum(transaction_details.value) as total'))
        ->get();

        //run code for cash sales (insert detail into journal)
        foreach($purchasesInCash as $row)
        {
            //search if a similar chart is already existing in journal details. if not, create a new detail.
            $accountChartID = $row->chart_account_id ?? $ChartController->createIfNotExists_CashAccounts($this->taxPayer, $this->cycle, $row->chart_account_id)->id;

            $value = $row->total * $row->rate;

            $detail = new JournalDetail();
            $detail->credit = 0;
            $detail->debit = $value;
            $detail->chart_id = $accountChartID;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //2nd Query:
        $purchasesOnCredit = Transaction::MyPurchasesForJournals($startDate, $endDate, $this->taxPayer->id)
        ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
        ->groupBy('rate', 'supplier_id')
        ->where('payment_condition', '>', 0)
        ->select(DB::raw('max(rate) as rate'),
        DB::raw('max(supplier_id) as customer_id'),
        DB::raw('sum(transaction_details.value) as total'))
        ->get();

        //run code for credit sales (insert detail into journal)
        foreach($purchasesOnCredit as $row)
        {
            $customerChartID = $row->chart_account_id ?? $ChartController->createIfNotExists_AccountsPayable($this->taxPayer, $this->cycle, $row->supplier_id)->id;

            $value = $row->total * $row->rate;

            $detail = new JournalDetail();
            $detail->credit = 0;
            $detail->debit = $value;
            $detail->chart_id = $customerChartID;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        $detailAccounts = Transaction::MyPurchasesForJournals($startDate, $endDate, $this->taxPayer->id)
        ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
        ->join('charts', 'charts.id', '=', 'transaction_details.chart_vat_id')
        ->groupBy('rate', 'transaction_details.chart_id', 'transaction_details.chart_vat_id')
        ->select(DB::raw('max(rate) as rate'),
        DB::raw('max(charts.coefficient) as coefficient'),
        DB::raw('max(transaction_details.chart_vat_id) as chart_vat_id'),
        DB::raw('max(transaction_details.chart_id) as chart_id'),
        DB::raw('sum(transaction_details.value) as total'))
        ->get();

        //run code for credit sales (insert detail into journal)
        foreach($detailAccounts->groupBy('chart_vat_id') as $groupedRow)
        {
            $groupTotal = $groupedRow->sum('total');
            $value = ($groupTotal - ($groupTotal / (1 + $groupedRow->first()->coefficient))) * $groupedRow->first()->rate;

            $detail = $journal->details->where('chart_vat_id', $groupedRow->first()->chart_vat_id)->first() ?? new JournalDetail();
            $detail->credit += $value;
            $detail->debit = 0;
            $detail->chart_id = $groupedRow->first()->chart_vat_id;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

        //run code for credit sales (insert detail into journal)
        foreach($detailAccounts->groupBy('chart_id') as $groupedRow)
        {
            $value = 0;

            //Discount Vat Value for these items.
            foreach($groupedRow->groupBy('coefficient') as $row)
            {
                $value += ($row->sum('total') / (1 + $row->first()->coefficient)) * $row->first()->rate;
            }

            $detail = $journal->details->where('chart_id', $groupedRow->first()->chart_id)->first() ?? new JournalDetail();
            $detail->credit += $value;
            $detail->debit = 0;
            $detail->chart_id = $groupedRow->first()->chart_id;
            $detail->journal_id = $journal->id;
            $detail->save();
        }

    }

    public function query_Credits($startDate, $endDate)
    {
        DB::connection()->disableQueryLog();

        $credits = Transaction::whereBetween('date', [$startDate, $endDate])
        ->with('details')
        ->where('supplier_id', $this->taxPayer->id)
        ->whereNull('deleted_at')
        ->where('type', 5)
        ->orderBy('date')
        ->otherCurrentStatus(['Annuled'])
        ->get();

        if ($credits->count() > 0)
        {
            $comment = __('accounting.CreditNoteComment', ['startDate' => $startDate->toDateString(), 'endDate' => $endDate->toDateString()]);
            $this->generate_fromCreditNotes($this->taxPayer, $this->cycle, $credits, $comment);
        }
    }

    public function generate_fromCreditNotes($transactions, $comment)
    {
        //Create chart controller we might need it further in the code to lookup charts.
        $ChartController = new ChartController();

        //get sum of all transactions divided by exchange rate.
        $journal = new Journal();
        $journal->cycle_id = $this->cycle->id; //TODO: Change this for specific cycle that is in range with transactions
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
            $chart = $ChartController->createIfNotExists_CashAccounts($this->taxPayer, $this->cycle, $groupedTransactions->first()->chart_id);

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

            $chart = $ChartController->createIfNotExists_AccountsReceivables($this->taxPayer, $this->cycle, $groupedTransactions->first()->customer_id);

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

    public function query_Debits($startDate, $endDate)
    {
        DB::connection()->disableQueryLog();

        //
        $debits = Transaction::whereBetween('date', [$startDate, $endDate])
        ->with('details')
        ->where('customer_id', $this->taxPayer->id)
        ->whereNull('deleted_at')
        ->where('type', 3)
        ->orderBy('date')
        ->otherCurrentStatus(['Annuled'])
        ->get();

        if ($debits->count() > 0)
        {
            $comment = __('accounting.DebitNoteComment', ['startDate' => $startDate->toDateString(), 'endDate' => $endDate->toDateString()]);
            $this->generate_fromDebitNotes($this->taxPayer, $this->cycle, $debits, $comment);
        }
    }

    public function generate_fromDebitNotes($transactions, $comment)
    {
        //Create chart controller we might need it further in the code to lookup charts.
        $ChartController = new ChartController();

        //get sum of all transactions divided by exchange rate.
        $journal = new Journal();
        $journal->cycle_id = $this->cycle->id; //TODO: Change this for specific cycle that is in range with transactions
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

            $chart = $ChartController->createIfNotExists_CashAccounts($this->taxPayer, $this->cycle, $groupedTransactions->first()->chart_id);

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

            $chart = $ChartController->createIfNotExists_AccountsReceivables($this->taxPayer, $this->cycle, $groupedTransactions->first()->customer_id);

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

    public function generate_fromAccountsReceivables($accMovements, $comment)
    {
        //Create chart controller we might need it further in the code to lookup charts.
        $ChartController = new ChartController();

        //get sum of all transactions divided by exchange rate.
        $journal = new Journal();
        $journal->cycle_id = $this->cycle->id; //TODO: Change this for specific cycle that is in range with transactions
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
                $chart = $ChartController->createIfNotExists_CashAccounts($this->taxPayer, $this->cycle, $groupedByAccount->first()->chart_id);

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
                $chart = $ChartController->createIfNotExists_AccountsReceivables($this->taxPayer, $this->cycle, $groupedByInvoice->first()->customer_id);

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

    public function generate_fromAccountsPayables($transactions, $comment)
    {
        //Create chart controller we might need it further in the code to lookup charts.
        $ChartController = new ChartController();

        //get sum of all transactions divided by exchange rate.
        $journal = new Journal();
        $journal->cycle_id = $this->cycle->id; //TODO: Change this for specific cycle that is in range with transactions
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
                $chart = $ChartController->createIfNotExists_CashAccounts($this->taxPayer, $this->cycle, $groupedByAccount->first()->chart_id);

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
                $chart = $ChartController->createIfNotExists_AccountsReceivables($this->taxPayer, $this->cycle, $groupedByInvoice->first()->supplier_id);

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

    public function generate_fromMoneyTransfers($transactions, $comment)
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
