<?php

namespace App\Http\Controllers\Stats;

use App\Charts\TransactionBarChart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChartJsController extends Controller
{
    /**
    * Show a sample chart.
    *
    * @return Response
    */
    public function chart()
    {
        $chart = new TransactionBarChart;
        // Additional logic depending on the chart approach
        return view('chart_view', ['chart' => $chart]);
    }
}
