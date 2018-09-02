@extends('reports.master')

@section('reportName', __('accounting.LedgerOf', ['attribute' => 'Month']))

@section('data')

    <table class="u-full-width">
        <tbody>
            <thead>
                <tr>
                    <th>@lang('global.Code')</th>
                    <th>@lang('accounting.Accounts')</th>
                    <th class="number">@lang('accounting.OpeningBalance')</th>
                    @foreach ($period as $month)
                        <th class="number">{{ $month->format('M-Y') }}</th>
                    @endforeach
                </tr>
            </thead>
            @foreach ($data->groupBy('type') as $groupedByType)
                <tr>
                    <td colspan="2">
                        @if (in_array($groupedByType->first()->type, [1,2,3,4,5]))
                            <h6 class="title is-6">{{ \App\Enums\ChartTypeEnum::labels()[$groupedByType->first()->type] }}</h6>
                        @else
                            <b>Special</b>
                        @endif
                    </td>
                </tr>

                @foreach ($groupedByType->groupBy('chartSubType') as $groupedBySubType)
                    <tr>
                        <td colspan="3">
                            @if ($groupedBySubType->first()->type == '1')
                                <b>{{ \App\Enums\ChartAssetTypeEnum::labels()[$groupedBySubType->first()->chartSubType ?? 1] }}</b>
                            @elseif ($groupedBySubType->first()->type == '2')
                                <b>{{ \App\Enums\ChartLiabilityTypeEnum::labels()[$groupedBySubType->first()->chartSubType ?? 1] }}</b>
                            @elseif ($groupedBySubType->first()->type == '3')
                                <b>{{ \App\Enums\ChartEquityTypeEnum::labels()[$groupedBySubType->first()->chartSubType ?? 1] }}</b>
                            @elseif ($groupedBySubType->first()->type == '4')
                                <b>{{ \App\Enums\ChartRevenueTypeEnum::labels()[$groupedBySubType->first()->chartSubType ?? 1] }}</b>
                            @elseif ($groupedBySubType->first()->type == '5')
                                <b>{{ \App\Enums\ChartExpenseTypeEnum::labels()[$groupedBySubType->first()->chartSubType ?? 1] }}</b>
                            @endif
                        </td>
                    </tr>

                    @foreach ($groupedBySubType->groupBy('chart_id') as $groupedRow)
                        <tr>
                            <td>{{ $groupedRow->first()->chartCode }}</td>
                            <td>{{ $groupedRow->first()->chartName }}</td>

                            @php
                            $openningBalance = $groupedRow->where('is_first', '=', 1);
                            $prevRunningTotal = $openningBalance->sum(function ($data) { return $data->credit - $data->debit; }) ?? 0;
                            @endphp

                            <td class="number">{{ $prevRunningTotal }}</td>

                            @foreach ($period as $month)
                                @php
                                $dateRange = $groupedRow->where('date', '<=', $month->endOfMonth());
                                $runningTotal = $dateRange->sum(function ($data) { return $data->credit - $data->debit; });
                                @endphp

                                <td class="number">
                                    @if ($runningTotal > $prevRunningTotal)
                                        <span style="color:limegreen">{{ number2Human($runningTotal - $prevRunningTotal) }}</span>
                                        &nbsp;
                                    @elseif ($runningTotal < $prevRunningTotal)
                                        <span style="color:red">[{{ number2Human($runningTotal - $prevRunningTotal) }}]</span>
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
