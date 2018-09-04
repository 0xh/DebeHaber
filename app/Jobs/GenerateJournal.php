<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Auth;

use DB;
use App\Inventory;
use App\AccountMovement;
use App\Transaction;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\DebitNoteController;
use App\Http\Controllers\AccountPayableController;
use App\Http\Controllers\AccountReceivableController;
use App\Http\Controllers\AccountMovementController;
use App\Taxpayer;
use App\Cycle;
use Carbon\Carbon;
use App\Http\Controllers\ChartController;
use Illuminate\Http\Request;
use App\Http\Resources\JournalCollection;

use App\Notifications\JournalCompleted;

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
        $this->generateByMonth();

        Auth::user()->notify(new JournalCompleted);
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

            $this->generateJournals($startDate, $endDate);

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

        //Number of weeks helps with the for loop
        $numberOfMonths = $currentDate->diffInMonths($endDate);

        for ($x = 0; $x <= $numberOfMonths; $x++)
        {
            //Get current date start of and end of week to run the query.
            $startDate = Carbon::parse($currentDate->startOfMonth());
            $endDate = Carbon::parse($currentDate->endOfMonth());

            $this->generateJournals($startDate, $endDate);

            $currentDate = $endDate->addDay();
        }
    }

    public function generateJournals($startDate, $endDate)
    {
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
            $controller->generate_Journals($startDate, $endDate, $this->taxPayer, $this->cycle);
        }

        /*
        Credit Notes
        */
        if (Transaction::MyCreditNotesForJournals($startDate, $endDate, $this->taxPayer->id)->count() > 0)
        {
            $controller = new CreditNoteController();
            $controller->generate_Journals($startDate, $endDate, $this->taxPayer, $this->cycle);
        }

        /*
        Debit Notes
        */
        if (Transaction::MyDebitNotesForJournals($startDate, $endDate, $this->taxPayer->id)->count() > 0)
        {
            $controller = new DebitNoteController();
            $controller->generate_Journals($startDate, $endDate, $this->taxPayer, $this->cycle);
        }

        /*
        Accounts Payable
        */
        if (AccountMovement::My($startDate, $endDate, $this->taxPayer->id)->count() > 0)
        {
            $controller = new AccountMovementController();
            $controller->generate_Journals($startDate, $endDate, $this->taxPayer, $this->cycle);
        }
    }
}
