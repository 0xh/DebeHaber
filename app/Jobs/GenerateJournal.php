<?php

namespace App\Jobs;

use App\Inventory;
use App\AccountMovement;
use App\Transaction;
use App\Taxpayer;
use App\Cycle;
use App\Journal;
use App\JournalDetail;
use App\JournalTransaction;
use App\Http\Controllers\ChartController;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\JournalCollection;
use Illuminate\Support\Facades\Log;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        //check
        $this->generateByMonth();
    }

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

    public function generateByMonth()
    {
        //Get startOf and endOf to cover entire week of range.
        $currentDate = Carbon::parse($this->startDate)->startOfMonth();
        $endDate = Carbon::parse($this->endDate)->endOfMonth();

        //Number of weeks helps with the for loop
        $numberOfMonths = $currentDate->diffInMonths($endDate);

        for ($x = 0; $x <= $numberOfMonths; $x++)
        {
            //Get current date start of and end of week to run the query.
            $monthStartDate = Carbon::parse($currentDate->startOfMonth());
            $monthEndDate = Carbon::parse($currentDate->endOfMonth());

            $this->query_Sales($this->taxPayer, $this->cycle, $monthStartDate, $monthEndDate);
            //$this->query_Purchases($this->taxPayer, $this->cycle, $monthStartDate, $monthEndDate)
            //$this->query_Payments($this->taxPayer, $this->cycle, $monthStartDate, $monthEndDate)
            //$this->query_Inventory($this->taxPayer, $this->cycle, $monthStartDate, $monthEndDate)

            //Finally add a month to go into next cycle
            $currentDate = $currentDate->addMonths(1);
        }
    }

    public function query_Sales($taxPayer, $cycle, $startDate, $endDate)
    {
        \DB::connection()->disableQueryLog();

        $journal = Journal::where('is_automatic', 1)
        ->whereBetween('date', [$startDate, $endDate])
        ->whereNull('deleted_at')
        ->with('details')
        ->first()
        ??
        new Journal();

        $comment = __('accounting.SalesBookComment', ['startDate' => $monthStartDate->toDateString(), 'endDate' => $monthEndDate->toDateString()]);

        $journal->cycle_id = $cycle->id; //TODO: Change this for specific cycle that is in range with transactions
        $journal->date = $sales->last()->date;
        $journal->comment = $comment;
        $journal->save();

        //New Query:
        //select rate,
        //(select sum(value) from transaction_detail where transaction_id = transactions.id)
        //from transactions
        //where supplier_id = $taxPayer->id and payment_condition == 0
        //group by chart_account_id,
        $cashAccounts = Transaction::with('details:value')
        ->whereBetween('date', [$startDate, $endDate])
        ->where('supplier_id', $taxPayer->id)
        ->where('payment_condition', 0)
        ->otherCurrentStatus(['Finalized', 'Annuled'])
        ->groupBy('rate', 'chart_account_id')
        ->select('rate', 'chart_account_id')
        ->get();

        //run code for cash sales (insert detail into journal)
        foreach($cashAccounts as $row)
        {
            //search if a similar chart is already existing in journal details. if not, create a new detail.
            $accountChartID = $row->chart_account_id ?? $ChartController->createIfNotExists_CashAccounts($taxPayer, $cycle, $row->chart_account_id)->id;

            $value = $row->details->sum('value') * $row->rate;

            $detail = $journal->details->where('chart_id', $accountChartID)->first() ?? new JournalDetail();

            if ($detail->credit != $value)
            {
                $detail->debit = 0;
                $detail->credit = $value;
                $detail->chart_id = $accountChartID;
                $detail->journal_id = $journal->id;
                $detail->save();
            }
        }

        //2nd Query:
        //select rate, customer_id
        //(select sum(value) from transaction_detail where transaction_id = transactions.id)
        //from transactions
        //where supplier_id = $taxPayer->id and payment_condition > 0
        //group by customer_id, currency_rate
        $creditAccounts = Transaction::with('details:value')
        ->whereBetween('date', [$startDate, $endDate])
        ->where('supplier_id', $taxPayer->id)
        ->where('payment_condition', '>', 0)
        ->otherCurrentStatus(['Finalized', 'Annuled'])
        ->groupBy('rate', 'customer_id')
        ->select('rate', 'customer_id')
        ->get();

        //run code for credit sales (insert detail into journal)
        foreach($creditAccounts as $row)
        {
            $customerChartID = $row->chart_account_id ?? $ChartController->createIfNotExists_AccountsReceivables($taxPayer, $cycle, $row->customer_id)->id;

            $value = $row->details->sum('value') * $row->rate;

            $detail = $journal->details->where('chart_id', $chartAccountID)->first() ?? new JournalDetail();

            if ($detail->credit != $value)
            {
                $detail->debit = 0;
                $detail->credit = $value;
                $detail->chart_id = $customerChartID;
                $detail->journal_id = $journal->id;
                $detail->save();
            }
        }

        //3rd Query: for vat
        //select rate, customer_id
        //(select sum(value) from transaction_detail where transaction_id = transactions.id)
        //from transactions
        //where supplier_id = $taxPayer->id and payment_condition > 0
        //group by customer_id, currency_rate
        $vatAccounts = TransactionDetail::with('transaction:rate')
        ->whereHas('transaction', function ($query) {
            $query->whereBetween('date', [$startDate, $endDate])
            ->where('supplier_id', $taxPayer->id);
        })
        ->groupBy('chart_vat_id')
        ->select('chart_vat_id', 'value')
        ->get();

        //run code for credit sales (insert detail into journal)
        foreach($vatAccounts as $row)
        {
            $detail = $journal->details->where('chart_id', $row->chart_vat_id)->first() ?? new JournalDetail();

            if ($detail->debit != ($row->$value * $row->transaction->rate))
            {
                $detail->debit = $value;
                $detail->credit = 0;
                $detail->chart_id = $vatChart->id;
                $detail->journal_id = $journal->id;
                $detail->save();
            }
        }

        //3rd Query: for item or cost center
        //select rate, customer_id
        //(select sum(value) from transaction_detail where transaction_id = transactions.id)
        //from transactions
        //where supplier_id = $taxPayer->id and payment_condition > 0
        //group by customer_id, currency_rate
        $itemAccounts = TransactionDetail::with('transaction:rate')
        ->whereHas('transaction', function ($query) {
            $query->whereBetween('date', [$startDate, $endDate])
            ->where('supplier_id', $taxPayer->id);
        })
        ->groupBy('chart_id')
        ->select('chart_id', 'value')
        ->get();

        //run code for credit sales (insert detail into journal)
        foreach($vatAccounts as $row)
        {
            $detail = $journal->details->where('chart_id', $row->chart_id)->first() ?? new JournalDetail();

            if ($detail->debit != ($row->$value * $row->transaction->rate))
            {
                $detail->debit = $value;
                $detail->credit = 0;
                $detail->chart_id = $vatChart->id;
                $detail->journal_id = $journal->id;
                $detail->save();
            }
        }

        //End of for each
    }

    //Generates Journals for a given range of Transactions. If one is passed, it will create one journal.
    //If multiple is passed, it will create one journal that takes into account all the details for each account.
    public function generate_fromSales(Taxpayer $taxPayer, Cycle $cycle, Journal $journal, $transactions)
    {
        //Create chart controller we might need it further in the code to lookup charts.
        $ChartController = new ChartController();

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

            //search if a similar chart is already existing in journal details. if not, create a new detail.
            $detail = $journal->details->where('chart_account_id', $chart->id)->first() ?? new JournalDetail();
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
            $detail = JournalDetail::where('chart_id', )->first() ?? new JournalDetail();
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
    }

    public function query_Purchases($taxPayer, $cycle, $monthStartDate, $monthEndDate)
    {
        DB::connection()->disableQueryLog();

        $purchases = Transaction::whereBetween('date', [$monthStartDate, $monthEndDate])
        ->with('details')
        ->where('customer_id', $taxPayer->id)
        ->whereNull('deleted_at')
        ->whereIn('type', [1, 2])
        ->orderBy('date')
        ->otherCurrentStatus(['Finalized', 'Annuled'])
        ->get();

        if ($purchases->count() > 0)
        {
            $comment = __('accounting.PurchaseBookComment', ['startDate' => $monthStartDate->toDateString(), 'endDate' => $monthEndDate->toDateString()]);
            $this->generate_fromPurchases($taxPayer, $cycle, $purchases, $comment);
        }
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

    public function query_Credits($taxPayer, $cycle, $monthStartDate, $monthEndDate)
    {
        DB::connection()->disableQueryLog();

        $credits = Transaction::whereBetween('date', [$monthStartDate, $monthEndDate])
        ->with('details')
        ->where('supplier_id', $taxPayer->id)
        ->whereNull('deleted_at')
        ->where('type', 5)
        ->orderBy('date')
        ->otherCurrentStatus(['Finalized', 'Annuled'])
        ->get();

        if ($credits->count() > 0)
        {
            $comment = __('accounting.CreditNoteComment', ['startDate' => $monthStartDate->toDateString(), 'endDate' => $monthEndDate->toDateString()]);
            $this->generate_fromCreditNotes($taxPayer, $cycle, $credits, $comment);
        }
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

    public function query_Debits($taxPayer, $cycle, $monthStartDate, $monthEndDate)
    {
        DB::connection()->disableQueryLog();

        //
        $debits = Transaction::whereBetween('date', [$monthStartDate, $monthEndDate])
        ->with('details')
        ->where('customer_id', $taxPayer->id)
        ->whereNull('deleted_at')
        ->where('type', 3)
        ->orderBy('date')
        ->otherCurrentStatus(['Finalized', 'Annuled'])
        ->get();

        if ($debits->count() > 0)
        {
            $comment = __('accounting.DebitNoteComment', ['startDate' => $monthStartDate->toDateString(), 'endDate' => $monthEndDate->toDateString()]);
            $this->generate_fromDebitNotes($taxPayer, $cycle, $debits, $comment);
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
