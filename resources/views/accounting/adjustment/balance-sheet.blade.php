@extends('spark::layouts.form')

@section('title', __('accounting.BalanceSheet'))

@section('form')
    <table class="m-datatable__table">
        <thead class="m-datatable__head">
            <tr class="m-datatable__row">
                <th class="m-datatable__cell">@lang('global.Code')</th>
                <th class="m-datatable__cell">@lang('accounting.Accounts')</th>
                <th class="m-datatable__cell">@lang('accounting.OpeningBalance')</th>
                @foreach ($period as $month)
                    <th class="m-datatable__cell">{{ $month->format('M-Y') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="m-datatable__body ps ps--active-x">
            @foreach ($journals->groupBy('chartType') as $groupedByType)
                <tr class="m-datatable__row">
                    <td class="m-datatable__cell" colspan="2">
                        <h6 class="title is-6">{{ \App\Enums\ChartTypeEnum::labels()[$groupedByType->first()->chartType] }}</h6>
                    </td>
                </tr>

                @foreach ($groupedByType->groupBy('chartSubType') as $groupedBySubType)
                    <tr class="m-datatable__row">
                        <td class="m-datatable__cell" colspan="3">
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
                        <tr class="m-datatable__row">
                            <td class="m-datatable__cell">{{ $groupedRow->first()->chartCode }}</td>
                            <td class="m-datatable__cell">{{ $groupedRow->first()->chartName }}</td>

                            @php
                            $openningBalance = $groupedRow->where('is_first', '=', 1);
                            $prevRunningTotal = $openningBalance->sum(function ($data) { return $data->credit - $data->debit; }) ?? 0;
                            @endphp

                            <td class="m-datatable__cell">{{ $prevRunningTotal }}</td>

                            @foreach ($period as $month)

                                @php
                                $dateRange = $groupedRow->where('date', '<=', $month->endOfMonth())->where('date', '>=', $month->startOfMonth());
                                @endphp

                                <td class="m-datatable__cell">
                                    {{ number_format($dateRange->sum(function ($data) { return $data->credit - $data->debit; }), 0, ',', '.') }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
            @endforeach

        </tbody>
    </table>

@endsection
