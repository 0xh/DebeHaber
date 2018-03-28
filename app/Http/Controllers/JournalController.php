<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use App\Journal;
use App\JournalDetail;
use DB;
use Illuminate\Http\Request;

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

    public function getJournals($taxPayerID, Cycle $cycle, $skip)
    {
        $journals = Journal::join('journal_details', 'journals.id', 'journal_details.journal_id')
        ->where('journals.cycle_id', $cycle->id)
        ->groupBy('journals.id')
        ->select(DB::raw('max(journals.id) as ID'),
        DB::raw('max(journals.number) as Number'),
        DB::raw('max(journals.comment) as Comment'),
        DB::raw('max(journals.date) as Date'),
        DB::raw('sum(journal_details.credit) as Credit'),
        DB::raw('sum(journal_details.debit) as Debit')
        )->skip($skip)
        ->take(100)
        ->get();

        return response()->json($journals);
    }

    public function getJournalsByID($taxPayerID, Cycle $cycle, $id)
    {
        $journal = Journal::join('journal_details', 'journals.id', 'journal_details.journal_id')
        ->where('journals.id', $id)
        ->groupBy('journals.id')
        ->select(DB::raw('max(journals.id) as ID'),
        DB::raw('max(journals.number) as Number'),
        DB::raw('max(journals.number) as Number'),
        DB::raw('max(journals.comment) as Comment'),
        DB::raw('max(journals.date) as Date'),
        DB::raw('sum(journal_details.credit) as Credit'),
        DB::raw('sum(journal_details.debit) as Debit')
        )->first();

        return response()->json($journal);
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
        $journal->number =$request->number ;
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
}
