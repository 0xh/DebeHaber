

@extends('reports.master')
@section('reportName', __('commercial.PurchaseBook'))

@section('data')
    <table class="u-full-width">
        <thead>
            <tr>
                <th>@lang('global.Date')</th>
                <th>@lang('global.Taxid')</th>
                <th>@lang('global.Taxpayer')</th>
                <th class="number">Timbrado</th>
                <th>@lang('commercial.InvoiceNumber')</th>
                <th class="number">@lang('commercial.Taxable') 10%</th>
                <th class="number">@lang('commercial.SalesTax') 10%</th>
                <th class="number">@lang('commercial.Taxable') 5%</th>
                <th class="number">@lang('commercial.SalesTax') 5%</th>
                <th class="number">@lang('commercial.Exempt')</th>
                <th class="number">@lang('global.Total')</th>
                <th>Concepto</th>
                <th>@lang('commercial.Condition')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->groupBy('purchaseID') as $row)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row->first()->date)->format('d/m/Y')}}</td>

                    <td class="important">{{ $row->first()->supplier_code }}</td>

                    <td class="text">{{ $row->first()->supplier }}</td>

                    <td class="number">{{ $row->first()->code }}</td>

                    <td class="important">
                        <a href="{{route('purchases.edit', [request()->route('taxPayer')->id, request()->route('cycle')->id, $row->first()->purchaseID])}}" target="_blank">
                            {{ $row->first()->number }}
                        </a>
                    </td>

                    @php
                    $vat10 = $row->where('coefficient', '=', 0.1)->sum('vatValue');
                    $vat5 = $row->where('coefficient', '=', 0.05)->sum('vatValue');

                    $base10 = $row->where('coefficient', '=', 0.1)->sum('localCurrencyValue');
                    $base5 = $row->where('coefficient', '=', 0.05)->sum('localCurrencyValue');
                    $exe = $row->where('coefficient', '=', 0)->sum('localCurrencyValue');
                    @endphp

                    <td class="number important">
                        {{ number_format($vat10, 0, ',', '.') }}
                    </td>

                    <td class="number important">
                        {{ number_format($base10 - $vat10, 0, ',', '.') }}
                    </td>

                    <td class="number important">
                        {{ number_format($vat5, 0, ',', '.') }}
                    </td>

                    <td class="number important">
                        {{ number_format($base5 - $vat5, 0, ',', '.') }}
                    </td>

                    <td class="number important">
                        {{ number_format($exe, 0, ',', '.') }}
                    </td>

                    <td class="number important">{{ number_format($row->sum('localCurrencyValue'), 0, ',', '.') }}</td>

                    <td class="text">
                        @foreach ($row as $detail)
                            {{ $detail->costCenter }},
                        @endforeach
                    </td>

                    <td>{{ $row->first()->payment_condition > 0 ? __('commercial.Credit') : __('commercial.Cash') }}</td>

                </tr>
            @endforeach
            <tr class="group">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>@lang('global.GrandTotal')</td>
                <td class="number"><b>{{ number_format($data->where('coefficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format(($data->where('coefficient', '=', 0.1)->sum('localCurrencyValue') - $data->where('coefficient', '=', 0.1)->sum('vatValue')), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->where('coefficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format(($data->where('coefficient', '=', 0.05)->sum('localCurrencyValue') - $data->where('coefficient', '=', 0.05)->sum('vatValue')), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->where('coefficient', '=', 0.00)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->sum('localCurrencyValue'), 0, ',', '.') }}</b></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
@endsection
