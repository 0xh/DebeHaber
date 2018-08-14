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
                    @foreach ($data->groupBy(function($q) { return \Carbon\Carbon::parse($q->date)->format('m'); }) as $groupedRow)
                        <th class="number">{{ \Carbon\Carbon::parse($groupedRow->first()->date)->format('M') }}</th>
                    @endforeach
                </tr>
            </thead>
            @foreach ($data->groupBy('chartCode')->sortBy('chartCode') as $groupedRow)
                <tr>
                    <td>{{ $groupedRow->first()->chartCode }}</td>
                    <td>{{ $groupedRow->first()->chartName }}</td>
                    <td>{{ $groupedRow->first()->Comment }}</td>
                    @foreach ($groupedRow->groupBy(function($q) { return \Carbon\Carbon::parse($q->date)->format('m'); }) as $dataRow)
                        <td class="number">
                            {{ number_format(($dataRow->sum('credit') - $dataRow->sum('debit')), 0, ',', '.') }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
