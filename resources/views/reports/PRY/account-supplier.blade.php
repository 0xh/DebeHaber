@extends('reports.master')
@section('reportName', 'Estado Cuentas Proveedores')

@section('data')
  @foreach($data as $item)

    {{ $item }}

@endforeach
    {{-- <table class="u-full-width">
        <tbody>
            @foreach ($data->groupBy('journal_details.chart_id') as $groupedRows)
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>RUC</th>
                        <th>Rázon Social</th>
                        <th class="number">Timbrado</th>
                        <th>Factura</th>
                        <th>Condición</th>
                        <th class="number">Gravada 10%</th>
                        <th class="number">IVA 10%</th>
                        <th class="number">Gravada 5%</th>
                        <th class="number">IVA 5%</th>
                        <th class="number">Exenta</th>
                        <th class="number">Total</th>
                    </tr>
                </thead>
                <tr class="group">
                    <td colspan="3"><b>{{ $groupedRows[0]->branch }}</b></td>
                    <td></td>
                    <td></td>
                    <td>Total del Concepto</td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coeficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>0</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coeficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>0</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->where('coeficient', '=', 0.00)->sum('vatValue'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('vatValue'), 0, ',', '.') }}</b></td>
                </tr>
                @foreach ($groupedRows as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y')}}</td>

                        <td class="important">{{ $row->supplier_code }}</td>

                        <td class="text">{{ $row->supplier }}</td>

                        <td class="number">{{ $row->invoice_code }}</td>

                        <td class="important">
                            <a href="/current/{{ (request()->route('company'))->id }}/purchases/{{ $row->purchaseID }}/edit" target="_blank">
                                {{ $row->invoice_number }}
                            </a>
                        </td>

                        <td>{{ $row->payment_condition > 0 ? 'Credito' : 'Contado' }}</td>

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
                <td>Gran Total</td>
                <td class="number"><b>{{ number_format($data->where('coeficient', '=', 0.1)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format(($data->where('coeficient', '=', 0.1)->sum('localCurrencyValue') - $data->where('coeficient', '=', 0.1)->sum('vatValue')), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->where('coeficient', '=', 0.05)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format(($data->where('coeficient', '=', 0.05)->sum('localCurrencyValue') - $data->where('coeficient', '=', 0.05)->sum('vatValue')), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->where('coeficient', '=', 0.00)->sum('vatValue'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->sum('vatValue'), 0, ',', '.') }}</b></td>
            </tr>
        </tbody>
    </table> --}}
@endsection
