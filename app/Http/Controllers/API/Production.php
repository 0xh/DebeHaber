<?php

namespace App\Http\Controller\API;

use App\Taxpayer;
use App\Cycle;
use App\ChartAlias;
use Illuminate\Http\Request;

class Production extends Controller
{
    public function start(Request $request)
    {
        //Convert data from
        $data = json_decode($request, true);
        //Process Transaction
        //
    }

    public function formatData($data)
    {
        return Transaction::make($data)->resolve();
    }

    public function processTransaction($data)
    {
        //process transaction

        //process detail

        //return transaction saved status (ok or error).

    }

    public function processDetail($detail)
    {

    }

}
