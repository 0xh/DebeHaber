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
                    <td> {{ $row->type }} </td>
                    <td class="number"> {{ number_format($row->balance, 0, ',', '.') }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
