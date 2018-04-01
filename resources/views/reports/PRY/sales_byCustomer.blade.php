

@extends('reports.master')
@section('reportName', 'Libro IVA Ventas por Cliente')

@section('data')
    <table class="u-full-width">
        <tbody>
            @foreach ($data->groupBy('customer') as $groupedRows)

                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th class="number">Timbrado</th>
                        <th>Factura</th>
                        <th>Cond.</th>
                        <th>Concepto</th>
                        <th class="number">Grav. 10%</th>
                        <th class="number">IVA 10%</th>
                        <th class="number">Grav. 5%</th>
                        <th class="number">IVA 5%</th>
                        <th class="number">Exenta</th>
                        <th class="number">Total</th>
                    </tr>
                </thead>
                <tr class="group">
                    <td class="number"><b>{{ $groupedRows->first()->customer_code }}</b></td>
                    <td colspan="3"><b>{{ $groupedRows->first()->customer }}</b></td>
                    <td>Total del Cliente</td>
                    <td class="number"><b>{{ number_format($groupedRows->where('status', '!=', 3)->where('coefficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('status', '!=', 3)->where('coefficient', '=', 0.1)->sum('localCurrencyValue') - $groupedRows->where('status', '!=', 3)->where('coefficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('status', '!=', 3)->where('coefficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('status', '!=', 3)->where('coefficient', '=', 0.05)->sum('localCurrencyValue') - $groupedRows->where('status', '!=', 3)->where('coefficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('status', '!=', 3)->where('coefficient', '=', 0.00)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('status', '!=', 3)->sum('vatValue'), 0, ',', '.') }}</b></td>
                </tr>

                @foreach ($groupedRows->groupBy('salesID') as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row->first()->date)->format('d/m/Y')}}</td>

                        <td class="number">{{ $row->first()->code }}</td>

                        <td class="important">
                            <a href="{{route('sales.edit', [request()->route('taxPayer')->id, request()->route('cycle')->id, $row->first()->salesID])}}" target="_blank">
                                {{ $row->first()->number }}
                            </a>
                        </td>

                        <td>{{ $row->first()->payment_condition > 0 ? 'Credito' : 'Contado' }}</td>

                        <td class="text">
                            @foreach ($row->groupBy('costCenter') as $detail)
                                {{ $detail->first()->costCenter }},
                            @endforeach
                        </td>

                        @if ($row->first()->status != 3)

                            @php
                            $vat10 = $row->where('coefficient', '=', 0.1)->sum('vatValue');
                            $vat5 = $row->where('coefficient', '=', 0.05)->sum('vatValue');

                            $base10 = $row->where('coefficient', '=', 0.1)->sum('localCurrencyValue');
                            $base5 = $row->where('coefficient', '=', 0.05)->sum('localCurrencyValue');
                            $exe = $row->where('coefficient', '=', 0)->sum('localCurrencyValue');
                            @endphp

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
                        @else

                            <td class="number important">{{ number_format(0, 0, ',', '.') }}</td>
                            <td class="number important">{{ number_format(0, 0, ',', '.') }}</td>
                            <td class="number important">{{ number_format(0, 0, ',', '.') }}</td>
                            <td class="number important">{{ number_format(0, 0, ',', '.') }}</td>
                            <td class="number important">{{ number_format(0, 0, ',', '.') }}</td>
                            <td class="number important">{{ number_format(0, 0, ',', '.') }}</td>

                        @endif
                    </tr>
                @endforeach
            @endforeach
            <tr class="group">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Gran Total</td>
                <td class="number"><b>{{ number_format($data->where('status', '!=', 3)->where('coefficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number">
                    <b>
                        {{ number_format(($data->where('status', '!=', 3)->where('coefficient', '=', 0.1)->sum('localCurrencyValue') -
                            $data->where('status', '!=', 3)->where('coefficient', '=', 0.1)->sum('vatValue')), 0, ',', '.') }}
                        </b>
                    </td>
                    <td class="number"><b>{{ number_format($data->where('status', '!=', 3)->where('coefficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format(($data->where('status', '!=', 3)->where('coefficient', '=', 0.05)->sum('localCurrencyValue') - $data->where('status', '!=', 3)->where('coefficient', '=', 0.05)->sum('vatValue')), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($data->where('status', '!=', 3)->where('coefficient', '=', 0.00)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($data->where('status', '!=', 3)->sum('localCurrencyValue'), 0, ',', '.') }}</b></td>
                </tr>
            </tbody>
        </table>
    @endsection
