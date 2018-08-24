@extends('reports.master')

@section('reportName', __('accounting.LedgerOf', ['attribute' => 'Expenses']))

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
            @foreach ($data->groupBy('chartType') as $groupedByType)
                <tr>
                    <td colspan="2">
                        <h6 class="title is-6">{{ \App\Enums\ChartTypeEnum::labels()[$groupedByType->first()->chartType] }}</h6>
                    </td>
                </tr>

                @foreach ($groupedByType->groupBy('chartSubType') as $groupedBySubType)
                    <tr>
                        <td colspan="3">
                            @if ($groupedBySubType->first()->chartType == '1')
                                <b>{{ \App\Enums\ChartAssetTypeEnum::labels()[$groupedBySubType->first()->chartSubType ?? 1] }}</b>
                            @elseif ($groupedBySubType->first()->chartType == '2')
                                <b>{{ \App\Enums\ChartLiabilityTypeEnum::labels()[$groupedBySubType->first()->chartSubType ?? 1] }}</b>
                            @elseif ($groupedBySubType->first()->chartType == '3')
                                <b>{{ \App\Enums\ChartEquityTypeEnum::labels()[$groupedBySubType->first()->chartSubType ?? 1] }}</b>
                            @elseif ($groupedBySubType->first()->chartType == '4')
                                <b>{{ \App\Enums\ChartRevenueTypeEnum::labels()[$groupedBySubType->first()->chartSubType ?? 1] }}</b>
                            @elseif ($groupedBySubType->first()->chartType == '5')
                                <b>{{ \App\Enums\ChartExpenseTypeEnum::labels()[$groupedBySubType->first()->chartSubType ?? 1] }}</b>
                            @endif
                        </td>
                    </tr>

                    @foreach ($groupedBySubType->groupBy('chart_id') as $groupedRow)
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
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection
