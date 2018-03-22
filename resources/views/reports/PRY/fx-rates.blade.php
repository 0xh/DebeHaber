

@extends('reports.master')
@section('reportName', 'Monedas & Cotizaciones')

@section('data')
    <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css">
    <table class="u-full-width">
        <thead>
            <tr>
                <th>Fecha</th>
                <th class="number">Compra</th>
                <th></th>
                <th class="number">Venta</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($rates->groupBy('currency_id') as $groupedRates)

                @php
                $prevBuy = $groupedRates[0]->buy_rate;
                $prevSell = $groupedRates[0]->sell_rate;
                @endphp

                <tr class="group">
                    <th class="text-center">{{ $groupedRates[0]->currency->name }}</th>
                    <th class="number">{{ number_format($groupedRates->avg(buy_rate), 0, ',', '.') }}</th>
                    <th></th>
                    <th class="number">{{ number_format($groupedRates->avg(buy_rate), 0, ',', '.') }}</th>
                    <th></th>
                </tr>

                @foreach ($groupedRates as $rate)

                    @php

                    //Calculate delta before reseting values
                    $deltaBuy = $rate->buy_rate - $prevBuy;
                    $deltaSell = $rate->sell_rate - $prevSell;
                    //Store values for next loop
                    $prevBuy = $rate->buy_rate;
                    $prevSell = $rate->sell_rate;
                    @endphp

                    <tr>
                        <td>{{ \Carbon\Carbon::parse($rate->trans_date)->format('d/m/Y') }}</td>
                        <td class="number">{{ number_format($rate->buy_rate, 2, ',', '.') }}</td>
                        <td>
                            <small>
                                @if ($deltaBuy > 0)
                                    <span class="success">
                                        <i class="fa fa-caret-up"></i>
                                        <strong>{{ number_format($deltaBuy, 2, ',', '.') }}</strong>
                                    </span>
                                @elseif ($deltaBuy < 0)
                                    <span class="danger">
                                        <i class="fa fa-caret-down"></i>
                                        <strong>{{ number_format($deltaBuy, 2, ',', '.') }}</strong>
                                    </span>
                                @else
                                    --
                                @endif
                            </small>
                        </td>
                        <td class="number">{{ number_format($rate->sell_rate, 2, ',', '.') }}</td>
                        <td>
                            <small>
                                @if ($deltaSell > 0)
                                    <span class="success">
                                        <i class="fa fa-caret-up"></i>
                                        <strong>{{ number_format($deltaSell, 2, ',', '.') }}</strong>
                                    </span>
                                @elseif ($deltaSell < 0)
                                    <span class="danger">
                                        <i class="fa fa-caret-down"></i>
                                        <strong>{{ number_format($deltaSell, 2, ',', '.') }}</strong>
                                    </span>
                                @else
                                    --
                                @endif
                            </small>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection
