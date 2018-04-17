@extends('reports.master')
@section('reportName', __('accounting.ChartofAccounts'))

@section('data')
    <table class="u-full-width">
        <tbody>
            @foreach ($data->groupBy('type') as $groupedRows)
                <thead>
                    <tr>
                        <td>
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
                        <th>@lang('global.Name')</th>
                        <th>@lang('global.Type')</th>
                        <th>@lang('global.SubType')</th>
                    </tr>
                </thead>

                @foreach ($groupedRows as $row)
                    <tr>
                        <td class="important">{{ $row->code }}</td>
                        <td class="important">{{ $row->name }}</td>
                        <td>{{ $row->type }}</td>
                        <td>{{ $row->sub_type }}</td>
                    </tr>
                @endforeach

            @endforeach
        </tbody>
    </table>
@endsection
