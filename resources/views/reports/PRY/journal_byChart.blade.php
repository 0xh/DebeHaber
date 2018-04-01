@extends('reports.master')
@section('reportName', 'Libro Major')

@section('data')
    <table class="table u-full-width" id="data">
        <thead>
            <tr>
                <th>@lang('global.Date')</th>
                <th>Nro. Asiento</th>
                <th>Concepto</th>
                <th class="number">Debito</th>
                <th class="number">Crédito</th>
                <th class="number">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->groupBy('chartCode') as $groupedRows)

                @php
                $balance = 0;
                @endphp

                <tr class="group">
                    <td><b>{{ $groupedRows->first()->chartCode }}</b></td>
                    <td><b><a href="{{ route('journal_charts',[request()->route('company'),$groupedRows->first()->chartID]) }}">{{ $groupedRows->first()->chart }}</a></b></td>
                    <td class="number">Total de esta Cuenta</td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('debit'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('credit'), 0, ',', '.') }}</b></td>
                    <td></td>
                </tr>

                @foreach ($groupedRows as $row)

                    @php
                    $balance = $balance + ($row->credit - $row->debit);
                    @endphp

                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row->trans_date)->format('d/m/Y') }}</td>
                        <td>{{ $row->code }}</td>
                        <td>{{ $row->comment }}</td>
                        <td class="number">{{ number_format($row->debit, 0, ',', '.') }}</td>
                        <td class="number">{{ number_format($row->credit, 0, ',', '.') }}</td>
                        <td class="number">{{ number_format($balance, 0, ',', '.') }}</td>
                    </tr>

                @endforeach

            @endforeach
            <tr class="group">
                <td></td>
                <td></td>
                <td>@lang('global.GrandTotal')</td>
                <td class="number"><b>{{ number_format($data->sum('debit'), 0, ',', '.') }}</b></td>
                <td class="number"><b>{{ number_format($data->sum('credit'), 0, ',', '.') }}</b></td>
            </tr>
        </tbody>
    </table>
@endsection
