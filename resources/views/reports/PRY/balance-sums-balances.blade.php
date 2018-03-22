@extends('reports.master')
@section('reportName', 'Balance de Sumas y Saldos')

@section('data')
    <table class="table u-full-width">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th style="background-color:whitesmoke;" class="center" colspan="2"><strong>Sumas</strong></th>
                <th style="background-color:gainsboro;" class="center" colspan="2"><strong>Saldos</strong></th>
            </tr>
            <tr>
                <th>Codigo</th>
                <th>Cuenta</th>
                <th class="number">Debito</th>
                <th class="number">Credito</th>
                <th class="number">Deudor</th>
                <th class="number">Acreedor</th>
            </tr>
        </thead>
        <tbody>

            @php
            $totalCredit = 0;
            $totalDebt = 0;
            @endphp

            @foreach ($data->sortBy('chartCode')->groupBy('chartCode') as $groupedRows)

                @php
                    $balance = $groupedRows->sum('credit') - $groupedRows->sum('debit');

                    $totalDebt = $balance < 0 ? ($totalDebt + $balance * -1) : $totalDebt;
                    $totalCredit = $balance > 0 ? ($totalCredit + $balance) : $totalCredit;
                @endphp

                <tr>
                    <td><b>{{ $groupedRows[0]->chartCode }}</b></td>
                    <td><b><a href="{{ route('journal_charts',[request()->route('company'),$groupedRows[0]->chartID]) }}">{{ $groupedRows[0]->chart }}</a></b></td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('debit'), 0, ',', '.') }}</b></td>
                    <td class="number"><b>{{ number_format($groupedRows->sum('credit'), 0, ',', '.') }}</b></td>

                    @if ($balance < 0)
                        <td class="number"><b>{{ number_format($balance * -1, 0, ',', '.') }}</b></td>
                        <td class="number"><b></b></td>
                    @else
                        <td class="number"><b></b></td>
                        <td class="number"><b>{{ number_format($balance, 0, ',', '.') }}</b></td>
                    @endif
                </tr>

            @endforeach
            <tr class="group">
                <td></td>
                <td class="number">Resultados</td>
                <td class="number" style="background-color:whitesmoke;"><b>{{ number_format($data->sum('debit'), 0, ',', '.') }}</b></td>
                <td class="number" style="background-color:whitesmoke;"><b>{{ number_format($data->sum('credit'), 0, ',', '.') }}</b></td>
                <td class="number" style="background-color:gainsboro;"><b>{{ number_format($totalDebt, 0, ',', '.') }}</b></td>
                <td class="number" style="background-color:gainsboro;"><b>{{ number_format($totalCredit, 0, ',', '.') }}</b></td>
            </tr>
        </tbody>
    </table>
@endsection
