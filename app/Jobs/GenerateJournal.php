<?php

namespace App\Jobs;

use DB;
use App\Inventory;
use App\AccountMovement;
use App\Transaction;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\DebitNoteController;
use App\Taxpayer;
use App\Cycle;
use App\JournalTransaction;
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

        //Log::info('start date: ' .$currentDate. ', end date: ' .$endDate);

        //Number of weeks helps with the for loop
        $numberOfMonths = $currentDate->diffInMonths($endDate);

        for ($x = 0; $x <= $numberOfMonths; $x++)
        {
            //Get current date start of and end of week to run the query.
            $startDate = Carbon::parse($currentDate->startOfMonth());
            $endDate = Carbon::parse($currentDate->endOfMonth());

            /*
            Sales Invoices
            */
            if (Transaction::MySalesForJournals($startDate, $endDate, $this->taxPayer->id)->count() > 0)
            {
                $controller = new SalesController();
                $controller->generate_Journals($startDate, $endDate, $this->taxPayer, $this->cycle);
            }

            /*
            Purchase Invoices
            */
            if (Transaction::MyPurchasesForJournals($startDate, $endDate, $this->taxPayer->id)->count() > 0)
            {
                $controller = new PurchaseController();
                $controller->generate_Journals($startDate, $endDate, $this->taxPayer);
            }

            /*
            Credit Notes
            */
            if (Transaction::MyCreditNotesForJournals($startDate, $endDate, $this->taxPayer->id)->count() > 0)
            {
                $controller = new CreditNoteController();
                $controller->generate_Journals($startDate, $endDate, $this->taxPayer);
            }

            /*
            Debit Notes
            */
            if (Transaction::MyDebitNotesForJournals($startDate, $endDate, $this->taxPayer->id)->count() > 0)
            {
                $controller = new DebitNoteController();
                $controller->generate_Journals($startDate, $endDate, $this->taxPayer);
            }

            /*
            Accounts Payables
            */
            if (AccountMovement::MyDebitNotesForJournals($startDate, $endDate, $this->taxPayer->id)->count() > 0)
            {
                $controller = new AccountsRecievableController();
                $controller->generate_Journals($startDate, $endDate, $this->taxPayer);
            }

            $currentDate = $endDate->addDay();
        }
    }


    public function generate_fromAccountsPayables($startDate, $endDate)
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

    public function generate_fromMoneyTransfers($startDate, $endDate)
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
