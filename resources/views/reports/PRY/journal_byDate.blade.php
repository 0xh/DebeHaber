@extends('reports.master')
@section('reportName', 'Libro Diario por Fecha')

@section('data')
    <table class="table u-full-width">
        <tbody>
            @foreach ($data->groupBy('trans_date') as $groupedRows)
                <thead>
                    <tr>
                        <th>Nro. Asiento</th>
                        <th colspan="2">Cuenta</th>
                        <th>Concepto</th>
                        <th class="number">Debito</th>
                        <th class="number">Crédito</th>
                    </tr>
                </thead>
                <tr class="group">
                    <td colspan="2"><b>{{ \Carbon\Carbon::parse($groupedRows[0]->trans_date)->format('d/m/Y') }}</b></td>
                    <td></td>
                    <td class="number">Total de la Fecha</td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('debit'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('credit'), 0, ',', '.') }}</b></td>
                </tr>
                @foreach ($groupedRows as $row)
                    <tr>
                        <td>{{ $row->code }}</td>
                        <td><a href="{{ route('journal_charts',[request()->route('company'),$row->chartID]) }}">{{ $row->chartCode }}</a></td>
                        <td><a href="{{ route('journal_charts',[request()->route('company'),$row->chartID]) }}">{{ $row->chart }}</a></td>
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
                <td>Gran Total</td>
                <td class="number"><b>{{ number_format($data->sum('debit'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->sum('credit'), 0, ',', '.') }}</b></td>
            </tr>
        </tbody>
    </table>
@endsection
