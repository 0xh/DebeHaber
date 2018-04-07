<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class SalesBarChart extends Chart
{
    /**
    * Initializes the chart.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    public function chart()
    {
        $chart = new SalesBarChart;

        // Additional logic depending on the chart approach
        return view('chart_view', ['chart' => $chart]);
    }
}
