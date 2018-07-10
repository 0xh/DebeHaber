

@extends('reports.master')
@section('reportName', __('commercial.PurchaseBySuppliers'))

@section('data')
    <table class="u-full-width">
        <tbody>
            @foreach ($data->groupBy('supplier') as $groupedRows)
                <thead>
                    <tr>
                        <th>@lang('global.Date')</th>
                        <th class="number">{{ Config::get('countries.' . request()->route('taxPayer')->country . '.document-code') }}</th>
                        <th>@lang('commercial.InvoiceNumber')</th>
                        <th>@lang('commercial.Condition')</th>
                        <th>@lang('accounting.ChartofAccounts')</th>
                        <th class="number">@lang('commercial.Taxable') 10%</th>
                        <th class="number">@lang('commercial.SalesTax') 10%</th>
                        <th class="number">@lang('commercial.Taxable') 5%</th>
                        <th class="number">@lang('commercial.SalesTax') 5%</th>
                        <th class="number">@lang('commercial.Exempt')</th>
                        <th class="number">@lang('global.Total')</th>
                    </tr>
                </thead>
                <tr class="group">
                    <td class="number"><b>{{ $groupedRows->first()->supplier_code }}</b></td>
                    <td colspan="2"><b>{{ $groupedRows->first()->supplier }}</b></td>
                    <td></td>
                    <td>Total del Proveedor</td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coefficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>0</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coefficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>0</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coefficient', '=', 0.00)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('localCurrencyValue'), 0, ',', '.') }}</b></td>
                </tr>
                @foreach ($groupedRows->groupBy('purchaseID') as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row->first()->date)->format('d/m/Y')}}</td>

                        <td class="number">{{ $row->first()->code }}</td>

                        <td class="important">
                            <a href="{{route('purchases.edit', [request()->route('taxPayer')->id, request()->route('cycle')->id, $row->first()->purchaseID])}}" target="_blank">
                                {{ $row->first()->number }}
                            </a>
                        </td>

                        <td>{{ $row->first()->payment_condition > 0 ? __('commercial.Credit') : __('commercial.Cash') }}</td>

                        <td class="text">{{ $row->first()->costCenter }}</td>

                        <td class="number important">
                            {{ number_format($row->where('coefficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}
                        </td>

                        <td class="number important">
                            {{ number_format($row->where('coefficient', '=', 0.1)->sum('localCurrencyValue') - $row->where('coefficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}
                        </td>

                        <td class="number important">
                            {{ number_format($row->where('coefficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}
                        </td>

                        <td class="number important">
                            {{ number_format($row->where('coefficient', '=', 0.05)->sum('localCurrencyValue') - $row->where('coefficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}
                        </td>

                        <td class="number important">
                            {{ number_format($row->where('coefficient', '=', 0)->sum('localCurrencyValue'), 0, ',', '.') }}
                        </td>

                        <td class="number important">{{ number_format($row->sum('localCurrencyValue'), 0, ',', '.') }}</td>
                    </tr>
                @endforeach
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
            </tr>
        </tbody>
    </table>
@endsection
