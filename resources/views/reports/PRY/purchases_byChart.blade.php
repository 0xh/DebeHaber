

@extends('reports.master')
@section('reportName', __('commercial.PurchaseByChart'))

@section('data')
    <table class="u-full-width">
        <tbody>
            @foreach ($data->groupBy('costCenter') as $groupedRows)
                <thead>
                    <tr>
                        <th>@lang('global.Date')</th>
                        <th>@lang('global.Taxid')</th>
                        <th>@lang('global.Taxpayer')</th>
                        <th class="number">Timbrado</th>
                        <th>@lang('commercial.InvoiceNumber')</th>
                        <th>@lang('commercial.Condition')</th>
                        <th class="number">@lang('commercial.Taxable') 10%</th>
                        <th class="number">@lang('commercial.SalesTax') 10%</th>
                        <th class="number">@lang('commercial.Taxable') 5%</th>
                        <th class="number">@lang('commercial.SalesTax') 5%</th>
                        <th class="number">@lang('commercial.Exempt')</th>
                        <th class="number">@lang('global.Total')</th>
                    </tr>
                </thead>
                <tr class="group">
                    <td colspan="3"><b>{{ $groupedRows->first()->costCenter }}</b></td>
                    <td></td>
                    <td colspan="2">Sub Total</td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coeficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format(($groupedRows->where('coeficient', '=', 0.1)->sum('localCurrencyValue') - $groupedRows->where('coeficient', '=', 0.1)->sum('vatValue')), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coeficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format(($groupedRows->where('coeficient', '=', 0.05)->sum('localCurrencyValue') - $groupedRows->where('coeficient', '=', 0.05)->sum('vatValue')), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coeficient', '=', 0.00)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('vatValue'), 0, ',', '.') }}</b></td>
                </tr>
                @foreach ($groupedRows as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}</td>

                        <td class="important">{{ $row->supplier_code }}</td>

                        <td class="text">{{ $row->supplier }}</td>

                        <td class="number">{{ $row->code }}</td>

                        <td class="important">
                            <a href="{{route('purchases.edit', [request()->route('taxPayer')->id, request()->route('cycle')->id, $row->first()->purchaseID])}}" target="_blank">
                                {{ $row->number }}
                            </a>
                        </td>

                        <td>{{ $row->payment_condition > 0 ? __('commercial.Credit') : __('commercial.Cash') }}</td>

                        <td class="number important">
                            {{ $row->coeficient == 0.1 ? number_format($row->vatValue, 0, ',', '.') : 0 }}
                        </td>

                        <td class="number important">
                            {{ $row->coeficient == 0.1 ? number_format(($row->localCurrencyValue - $row->vatValue), 0, ',', '.') : 0 }}
                        </td>

                        <td class="number important">
                            {{ $row->coeficient == 0.05 ? number_format($row->vatValue, 0, ',', '.') : 0 }}
                        </td>

                        <td class="number important">
                            {{ $row->coeficient == 0.05 ? number_format(($row->localCurrencyValue - $row->vatValue), 0, ',', '.') : 0 }}
                        </td>


                        <td class="number important">
                            {{ $row->coeficient == 0.00 ? number_format($row->localCurrencyValue, 0, ',', '.') : 0 }}
                        </td>

                        <td class="number important">{{ number_format($row->localCurrencyValue, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
            <tr class="group">
                <td></td><td></td><td></td>
                <td></td>
                <td></td>
                <td>@lang('global.GrandTotal')</td>
                <td class="number"><b>{{ number_format($data->where('coeficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format(($data->where('coeficient', '=', 0.1)->sum('localCurrencyValue') - $data->where('coeficient', '=', 0.1)->sum('vatValue')), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->where('coeficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format(($data->where('coeficient', '=', 0.05)->sum('localCurrencyValue') - $data->where('coeficient', '=', 0.05)->sum('vatValue')), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->where('coeficient', '=', 0.00)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->sum('localCurrencyValue'), 0, ',', '.') }}</b></td>
            </tr>
        </tbody>
    </table>
@endsection
