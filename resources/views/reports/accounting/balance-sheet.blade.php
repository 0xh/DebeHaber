@extends('reports.master')

@section('reportName', __('accounting.BalanceSheet'))

@section('data')
    <table class="u-full-width">
        <tbody>
            <thead>
                <th>@lang('global.Code')</th>
                <th>@lang('accounting.Account')</th>
                <th>@lang('global.Type')</th>
                <th class="number">@lang('global.Balance')</th>
            </thead>
            @foreach ($data as $row)
                <tr>
                    <td> {{ $row->code }} </td>
                    <td> {{ $row->name }} </td>
                    <td>
                        @if ($row->type == 1 && $row->sub_type > 0)
                            {{ collect(\App\Enums\ChartAssetTypeEnum::labels())[$row->sub_type] }}
                        @elseif ($row->type == 2 && $row->sub_type > 0)
                            {{ collect(\App\Enums\ChartLiabilityTypeEnum::labels())[$row->sub_type] }}
                        @elseif ($row->type == 3 && $row->sub_type > 0)
                            {{ collect(\App\Enums\ChartEquityTypeEnum::labels())[$row->sub_type] }}
                        @elseif ($row->type == 4 && $row->sub_type > 0)
                            {{ collect(\App\Enums\ChartRevenueTypeEnum::labels())[$row->sub_type] }}
                        @elseif ($row->type == 5 && $row->sub_type > 0)
                            {{ collect(\App\Enums\ChartExpenseTypeEnum::labels())[$row->sub_type] }}
                        @endif

                    </td>
                    <td class="number">
                        @if ($row->sub_type > 0)
                            {{ number_format($row->balance, 0, ',', '.') }}
                        @else
                            <b>
                                {{ number_format($row->balance, 0, ',', '.') }}
                            </b>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
