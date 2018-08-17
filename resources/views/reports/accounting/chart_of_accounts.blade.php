@extends('reports.master')
@section('reportName', __('accounting.ChartofAccounts'))

@section('data')
    <table class="u-full-width">
        <tbody>
            @foreach ($data->groupBy('type')->sortBy('type') as $groupedRows)
                <thead>
                    <tr>
                        <td colspan="2">
                            <h6>
                                @if ($groupedRows->first()->type == '1')
                                    @lang('enum.Assets')
                                @elseif ($groupedRows->first()->type == '2')
                                    @lang('enum.Liabilities')
                                @elseif ($groupedRows->first()->type == '3')
                                    @lang('enum.Equity')
                                @elseif ($groupedRows->first()->type == '4')
                                    @lang('enum.Revenues')
                                @elseif ($groupedRows->first()->type == '5')
                                    @lang('enum.Expenses')
                                @endif
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('global.Code')</th>
                        <th>@lang('accounting.ChartofAccounts')</th>
                        <th>@lang('global.SubType')</th>
                    </tr>
                </thead>

                    @foreach ($groupedRows as $row)
                        <tr>
                            <td class="important">{{ $row->code }}</td>
                            <td class="important">{{ $row->name }}</td>
                            <td>
                                @if ($row->type == '1')
                                    <b>{{ \App\Enums\ChartAssetTypeEnum::labels()[$row->sub_type] ?? '' }}</b>
                                @elseif ($row->type == '2')
                                    <b>{{ \App\Enums\ChartLiabilityTypeEnum::labels()[$row->sub_type] ?? '' }}</b>
                                @elseif ($row->type == '3')
                                    <b>{{ \App\Enums\ChartEquityTypeEnum::labels()[$row->sub_type] ?? '' }}</b>
                                @elseif ($row->type == '4')
                                    <b>{{ \App\Enums\ChartRevenueTypeEnum::labels()[$row->sub_type] ?? '' }}</b>
                                @elseif ($row->type == '5')
                                    <b>{{ \App\Enums\ChartExpenseTypeEnum::labels()[$row->sub_type] ?? '' }}</b>
                                @endif
                            </td>
                        </tr>
                    @endforeach
            @endforeach
        </tbody>
    </table>
@endsection
