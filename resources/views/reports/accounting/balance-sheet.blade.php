@extends('reports.master')

@section('reportName', __('accounting.BalanceSheet'))

@section('data')

    @php

        foreach ($data as $row)
        {
            # code...
        }

    @endphp

    <table class="u-full-width">
        <tbody>
            <thead>
                <th>@lang('global.Code')</th>
                <th>@lang('accounting.Account')</th>
                <th>@lang('global.Comment')</th>
                <th class="number">@lang('accounting.Debit')</th>
                <th class="number">@lang('accounting.Credit')</th>
            </thead>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row->date }}</td>
                    <td>{{ $row->chartName }}</td>
                    <td>{{ $row->Comment }}</td>
                    <td class="number">{{ $row->Debit }}</td>
                    <td class="number">{{ $row->Credit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
