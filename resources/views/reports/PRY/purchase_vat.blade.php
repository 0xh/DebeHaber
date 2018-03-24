

@extends('reports.master')
@section('reportName', 'Libro IVA Compras')

@section('data')
    <table class="u-full-width">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>RUC</th>
                <th>Rázon Social</th>
                <th class="number">Timbrado</th>
                <th>Factura</th>
                <th class="number">Gravada 10%</th>
                <th class="number">IVA 10%</th>
                <th class="number">Gravada 5%</th>
                <th class="number">IVA 5%</th>
                <th class="number">Exenta</th>
                <th class="number">Total</th>
                <th>Concepto</th>
                <th>Condición</th>
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
                        <a href="/current/{{ (request()->route('taxPayer'))->id }}/purchases/{{ $row->first()->purchaseID }}/edit" target="_blank">
                            {{ $row->first()->number }}
                        </a>
                    </td>

                    @php
                    $vat10 = $row->where('coeficient', '=', 0.1)->sum('vatValue');
                    $vat5 = $row->where('coeficient', '=', 0.05)->sum('vatValue');

                    $base10 = $row->where('coeficient', '=', 0.1)->sum('localCurrencyValue');
                    $base5 = $row->where('coeficient', '=', 0.05)->sum('localCurrencyValue');
                    $exe = $row->where('coeficient', '=', 0)->sum('localCurrencyValue');
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

                    <td>{{ $row->first()->payment_condition > 0 ? 'Credito' : 'Contado' }}</td>

                </tr>
            @endforeach
            <tr class="group">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Gran Total</td>
                <td class="number"><b>{{ number_format($data->where('coeficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format(($data->where('coeficient', '=', 0.1)->sum('localCurrencyValue') - $data->where('coeficient', '=', 0.1)->sum('vatValue')), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->where('coeficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format(($data->where('coeficient', '=', 0.05)->sum('localCurrencyValue') - $data->where('coeficient', '=', 0.05)->sum('vatValue')), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->where('coeficient', '=', 0.00)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->sum('localCurrencyValue'), 0, ',', '.') }}</b></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
@endsection
