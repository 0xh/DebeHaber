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

    public function getJournals($taxPayerID,Cycle $cycle)
    {
        //friends column is used to display the button in data like dit ,delete
        $Transaction = Journal::Join('cycles', 'cycles.id', 'journals.cycle_id')
        ->Join('journal_details', 'journals.id', 'journal_details.journal_id')
        ->where('cycle_id', $cycle->id)->with('details')
        ->groupBy('journals.id')
        ->select(DB::raw('0 as friends,journals.id,max(journals.number) as number
        ,journals.comment,date,sum(debit) as debit,sum(credit) as credit'))
        ->get();
        return response()->json($Transaction);
    }
    public function getJournalsByID($taxPayerID,Cycle $cycle,$id)
    {
        //friends column is used to display the button in data like dit ,delete
        $Transaction = Journal::Join('cycles', 'cycles.id', 'journals.cycle_id')
        ->Join('journal_details', 'journals.id', 'journal_details.journal_id')
        ->where('journals.id', $id)->with('details')
        ->groupBy('journals.id')
        ->select(DB::raw('0 as friends,journals.id,journals.number
        ,journals.comment,date,sum(debit) as debit,sum(credit) as credit'))
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
    public function store(Request $request,Taxpayer $taxPayer,Cycle $cycle)
    {
        if ($request->id == 0)
        {
            $journal = new Journal();
        }
        else
        {
            $journal = Journal::where('id', $request->id)->first();
        }

        $journal->date = $request->date;
        $journal->number =$request->number ;
        $journal->comment = $request->comment;
        $journal->cycle_id = $cycle->id;

        $journal->save();

        foreach ($request->details as $detail)
        {
            if ($detail['id'] == 0)
            {
                $journalDetail = new JournalDetail();
            }
            else
            {
                $journalDetail = JournalDetail::where('id',$detail['id'])->first();
            }

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
