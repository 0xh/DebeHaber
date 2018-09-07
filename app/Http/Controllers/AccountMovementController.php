<?php

namespace App\Http\Controllers;


use App\AccountMovement;
use App\Taxpayer;
use App\Cycle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Http\Resources\ModelResource;
use Carbon\Carbon;
use DB;
use Auth;

class AccountMovementController extends Controller
{
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        return view('commercial/money-movements');
    }

    public function getMovement(Taxpayer $taxPayer, Cycle $cycle)
    {
        return ModelResource::collection(
            AccountMovement::
            orderBy('date', 'DESC')
            ->with('chart')
            ->with('transaction:id,number,code,code_expiry,is_deductible,comment')
            ->with('currency')
            ->paginate(100)
        );
    }

    public function store(Request $request, Taxpayer $taxPayer, Cycle $cycle)
    {
        if ($request->type != 2)
        {
            $accountMovement = new AccountMovement();
            $accountMovement->taxpayer_id = $request->taxpayer_id;
            $accountMovement->chart_id = $request->from_chart_id ;
            $accountMovement->date =  Carbon::now();;

            $accountMovement->debit = $request->debit ?? 0;
            $accountMovement->credit = $request->credit ?? 0;

            $accountMovement->currency_id = $request->currency_id;
            $accountMovement->rate = $request->rate ?? 1;
            $accountMovement->comment = $request->comment;

            $accountMovement->save();
        }
        else
        {
            $fromAccountMovement = new AccountMovement();
            $fromAccountMovement->taxpayer_id = $request->taxpayer_id;
            $fromAccountMovement->chart_id = $request->from_chart_id ;
            $fromAccountMovement->date =  Carbon::now();;
            $fromAccountMovement->debit = $request->debit ?? 0;
            $fromAccountMovement->currency_id = $request->currency_id;
            $fromAccountMovement->rate = $request->rate ?? 1;
            $fromAccountMovement->comment = $request->comment;
            $fromAccountMovement->save();

            $toAccountMovement = new AccountMovement();
            $toAccountMovement->taxpayer_id = $request->taxpayer_id;
            $toAccountMovement->chart_id = $request->to_chart_id ;
            $toAccountMovement->date =  Carbon::now();;
            $toAccountMovement->credit = $request->credit ?? 0;
            $toAccountMovement->currency_id = $request->currency_id;
            $toAccountMovement->rate = $request->rate ?? 1;
            $toAccountMovement->comment = $request->comment;
            $toAccountMovement->save();
        }

        return response()->json('Ok', 200);
    }

    public function generate_Journals($startDate, $endDate, $taxPayer, $cycle)
    {
        \DB::connection()->disableQueryLog();

        $queryAccountPayables = AccountMovement::My($startDate, $endDate, $taxPayer->id);

        if ($queryAccountPayables->where('journal_id', '!=', null)->count() > 0)
        {
            $arrJournalIDs = $queryAccountPayables->where('journal_id', '!=', null)->pluck('journal_id')->get();

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
        $comment = __('accounting.AccountsComment', ['startDate' => $startDate->toDateString(), 'endDate' => $endDate->toDateString()]);

        $journal->cycle_id = $cycle->id;
        $journal->date = $endDate;
        $journal->comment = $comment;
        $journal->is_automatic = 1;
        $journal->save();

        //Assign all transactions the new journal_id.
        //No need for If Count > 0, because if it was 0, it would not have gone in this function.
        AccountMovement::whereIn('id', $queryAccountPayables->pluck('id')->get())
        ->update(['journal_id' => $journal->id]);

        $chartController= new ChartController();

        //1st Query: Sales Transactions done in Credit. Must affect customer credit account.
        $listOfPays = AccountMovement::My($startDate, $endDate, $taxPayer->id)
        ->groupBy('rate', 'chart_id')
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

        $listOfPayables = AccountMovement::My($startDate, $endDate, $taxPayer->id)
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
