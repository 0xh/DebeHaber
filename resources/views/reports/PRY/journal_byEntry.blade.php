@extends('reports.master')
@section('reportName', 'Libro Diario por Asientos')

@section('data')
    <table class="table u-full-width">
        <tbody>
            @foreach ($data->groupBy('code') as $groupedRows)
                <thead>
                    <tr>
                        <th>@lang('global.Date')</th>
                        <th colspan="2">Cuenta</th>
                        <th>Concepto</th>
                        <th class="number">Debito</th>
                        <th class="number">Crédito</th>
                    </tr>
                </thead>
                <tr class="group">
                    <td colspan="2">Asiento Nro. <b>{{ $groupedRows[0]->code ?? '--' }}</b></td>
                    <td></td>
                    <td class="number">Total de este Asiento</td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('debit'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('credit'), 0, ',', '.') }}</b></td>
                </tr>
                @foreach ($groupedRows as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row->trans_date)->format('d/m/Y') }}</td>
                        <td>{{ $row->chartCode }}</td>
                        <td>{{ $row->chart }}</td>
                        <td>{{ $row->comment }}</td>
                        <td class="number">{{ number_format($row->debit, 0, ',', '.') }}</td>
                        <td class="number">{{ number_format($row->credit, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
            <tr class="group">
                <td></td>
                <td></td>
                <td></td>
                <td>@lang('global.GrandTotal')</td>
                <td class="number"><b>{{ number_format($data->sum('debit'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->sum('credit'), 0, ',', '.') }}</b></td>
            </tr>
        </tbody>
    </table>
@endsection
