@extends('reports.master')

@section('reportName', __('accounting.SubLedger'))

@section('data')

    <table class="u-full-width">
        <tbody>
            <thead>
                <tr>
                    <th>@lang('global.Code')</th>
                    <th>@lang('accounting.Accounts')</th>

                    @foreach ($period as $month)
                        <th class="number">{{ $month->format('M-Y') }}</th>
                    @endforeach
                </tr>
            </thead>
            @foreach ($data->groupBy('chart_id') as $groupedRow)
                <tr>
                    <td>{{ $groupedRow->first()->chartCode }}</td>
                    <td>{{ $groupedRow->first()->chartName }}</td>

                    @php
                    $prevRunningTotal = 0;
                    @endphp

                    @foreach ($period as $month)
                        @php
                        $dateRange = $groupedRow->where('date', '<=', $month->endOfMonth());
                        $runningTotal = $dateRange->sum(function ($data) { return $data->credit - $data->debit; });
                        @endphp

                        <td class="number">
                            @if ($runningTotal > $prevRunningTotal && $prevRunningTotal != 0)
                                <span style="color:limegreen">{{ number_format(($runningTotal / $prevRunningTotal) * 100, 0, ',', '.') }}%</span>
                                &nbsp;
                            @elseif ($runningTotal < $prevRunningTotal && $prevRunningTotal != 0)
                                <span style="color:red">[{{ number_format(($runningTotal / $prevRunningTotal) * 100, 0, ',', '.') }}%]</span>
                                &nbsp;
                            @endif

                            {{ number_format($runningTotal, 0, ',', '.') }}
                        </td>

                        @php
                        $prevRunningTotal = $runningTotal;
                        @endphp

                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
