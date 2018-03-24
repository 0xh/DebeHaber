

@extends('reports.master')
@section('reportName', 'Libro IVA Compras por Proveedor')

@section('data')
    <table class="u-full-width">
        <tbody>
            @foreach ($data->groupBy('supplier') as $groupedRows)
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
                    <td class="number"><b>{{ $groupedRows->first()->supplier_code }}</b></td>
                    <td colspan="2"><b>{{ $groupedRows->first()->supplier }}</b></td>
                    <td></td>
                    <td>Total del Proveedor</td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coeficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>0</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coeficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>0</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coeficient', '=', 0.00)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('vatValue'), 0, ',', '.') }}</b></td>
                </tr>
                @foreach ($groupedRows->groupBy('purchaseID') as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row->first()->invoice_date)->format('d/m/Y')}}</td>

                        <td class="number">{{ $row->first()->invoice_code }}</td>

                        <td class="important">
                            <a href="{{route('purchases.edit', [request()->route('taxPayer')->id, request()->route('cycle')->id, $row->first()->purchaseID])}}" target="_blank">
                                {{ $row->first()->invoice_number }}
                            </a>
                        </td>

                        <td>{{ $row->first()->payment_condition > 0 ? 'Credito' : 'Contado' }}</td>

                        <td class="text">{{ $row->first()->costCenter }}</td>

                        <td class="number important">
                            {{ number_format($row->where('coeficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}
                        </td>

                        <td class="number important">
                            {{ number_format($row->where('coeficient', '=', 0.1)->sum('localCurrencyValue') - $row->where('coeficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}
                        </td>

                        <td class="number important">
                            {{ number_format($row->where('coeficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}
                        </td>

                        <td class="number important">
                            {{ number_format($row->where('coeficient', '=', 0.05)->sum('localCurrencyValue') - $row->where('coeficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}
                        </td>

                        <td class="number important">
                            {{ number_format($row->where('coeficient', '=', 0)->sum('localCurrencyValue'), 0, ',', '.') }}
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
                <td>Gran Total</td>
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
