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
                    <th class="number">@lang('accounting.Debit')</th>
                    <th class="number">@lang('accounting.Credit')</th>
                </tr>
            </thead>
            @foreach ($data as $row)
                <tr>
                    <td>{{  }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
