@extends('reports.master')

@section('reportName', __('accounting.SubLedger'))

@section('data')

    <table class="u-full-width">
        <tbody>
            <thead>
                <tr>
                    <th>@lang('global.Code')</th>
                    <th>@lang('accounting.Account')</th>
                    <th>@lang('global.Comment')</th>

                    @foreach ($period as $month)
                        <th colspan="2" class="number">{{ $month->format('M-Y') }}</th>
                    @endforeach
                </tr>
            </thead>
            @foreach ($data->groupBy('chartCode')->sortBy('chartCode') as $groupedRow)
                <tr>
                    <td>{{ $groupedRow->first()->chartCode }}</td>
                    <td>{{ $groupedRow->first()->chartName }}</td>
                    <td>{{ $groupedRow->first()->Comment }}</td>

                    @php
                    $prevRunningTotal = 0;
                    @endphp

                    @foreach ($period as $month)
                        @php
                        $dateRange = $groupedRow->where('date', '<=', $month->endOfMonth());
                        $runningTotal = $dateRange->sum(function ($data) { return $data->credit - $data->debit; });
                        @endphp

                        <td class="number">
                            {{ number_format($runningTotal, 0, ',', '.') }}
                        </td>
                        <td class="number" width="8">
                            @if ($runningTotal > $prevRunningTotal && $prevRunningTotal != 0)
                                <span class="small" style="color:limegreen">{{ number_format(($runningTotal / $prevRunningTotal) * 100, 0, ',', '.') }}%</span>
                            @elseif ($runningTotal < $prevRunningTotal && $prevRunningTotal != 0)
                                <span class="small" style="color:red">[{{ number_format(($runningTotal / $prevRunningTotal) * 100, 0, ',', '.') }}%]</span>
                            @elseif ($prevRunningTotal == 0 || $runningTotal == $prevRunningTotal)
                                <span class="small" style="color:silver">0%</span>
                            @endif

                            @php
                            $prevRunningTotal = $runningTotal;
                            @endphp
                        </td>

                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
