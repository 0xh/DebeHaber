<?php

namespace App\Http\Controller\API;

use App\Taxpayer;
use App\Chart;
use App\Cycle;
use App\ChartAlias;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // public function formatData($data)
    // {
    //     return Transaction::make($data)->resolve();
    // }

    public function start(Request $request)
    {
        //Convert data from
        $data = collect(json_decode($request, true));

        //Process Transaction by 100 to speed up but not overload.
        foreach ($data->chunk(100) as $chunkedData)
        {
            $this->processTransaction($chunkedData);
        }
    }

    public function processTransaction($data)
    {
        //process transaction

        //process detail
        $details = $data->detail;
        $this->processDetail($details);
        //return transaction saved status (ok or error).

        $transactions = array(
            array('user_id'=>'Coder 1', 'subject_id'=> 4096),
            array('user_id'=>'Coder 2', 'subject_id'=> 2048),
        );

        Model::insert($transactions);

    }

    public function processDetail($details)
    {

    }

    public function checkChart()
    {

    }
}
