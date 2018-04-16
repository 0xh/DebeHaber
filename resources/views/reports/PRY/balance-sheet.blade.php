@extends('reports.master')
@section('reportName', 'Balance General')

@section('data')

    <h6>
        Balance de <strong>Activos</strong>
        <br>
        <small>Saldo {{ number_format($data->where('chart_type', 1)->first()->saldo, 0, ',', '.') }} PYG</small>
    </h6>

    @if ($data->where('chart_type', 2)->count() > 0)
        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Cuentas</th>
                    <th class="number">Saldos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->where('chart_type', 1) as $chart)
                    @if ($chart->is_automatic)
                        <tr>
                            <td>
                                <a href="{{ route('journal_charts',[request()->route('company'), $chart->id]) }}">
                                    {{ $chart->code }} - {{ $chart->name }}
                                </a>
                            </td>
                            <td class="number">{{ number_format($chart->saldo, 0, ',', '.') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td><b>{{ $chart->code }} - {{ $chart->name }}</b></td>
                            <td class="number"><b>{{ number_format($chart->saldo, 0, ',', '.') }}</b></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    <hr>

    <h6>
        Balance de <strong>Passivos</strong>
        <br>
        <small>Saldo {{ number_format($data->where('chart_type', 2)->first()->saldo * -1, 0, ',', '.') }} PYG</small>
    </h6>
    @if ($data->where('chart_type', 2)->count() > 0)
        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Cuentas</th>
                    <th class="number">Saldos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->where('chart_type', 2) as $chart)
                    @if ($chart->is_automatic)
                        <tr>
                            <td><a href="{{ route('journal_charts',[request()->route('company'), $chart->id]) }}">{{ $chart->code }} - {{ $chart->name }}</a></td>
                            <td class="number">{{ number_format($chart->saldo * -1, 0, ',', '.') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td><b>{{ $chart->code }} - {{ $chart->name }}</b></td>
                            <td class="number"><b>{{ number_format($chart->saldo * -1, 0, ',', '.') }}</b></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    <hr>

    <h6>
        Balance de <strong>Patrimonio Neto</strong>
        <br>
        <small>Saldo {{ number_format($data->where('chart_type', 3)->first()->saldo, 0, ',', '.') }} PYG</small>
    </h6>
    @if ($data->where('chart_type', 3)->count() > 0)
        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Cuentas</th>
                    <th class="number">Mayorizador</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->where('chart_type', 3) as $chart)
                    @if ($chart->is_automatic)
                        <tr>
                            <td><a href="{{ route('journal_charts',[request()->route('company'), $chart->id]) }}">{{ $chart->code }} - {{ $chart->name }}</a></td>
                            <td class="number">{{ number_format($chart->saldo, 0, ',', '.') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td><b>{{ $chart->code }} - {{ $chart->name }}</b></td>
                            <td class="number"><b>{{ number_format($chart->saldo, 0, ',', '.') }}</b></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
