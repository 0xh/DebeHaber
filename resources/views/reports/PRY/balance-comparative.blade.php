@extends('reports.master')
@section('reportName', 'Balance General Comparativo')

@section('data')

    <h6>
        Balance Comparativo de <strong>Activos</strong>
        <br>
        <small>Saldo {{ number_format($data->where('chart_type', 1)->first()->currentBalance, 0, ',', '.') }} PYG</small>
    </h6>

    @if ($data->where('chart_type', 2)->count() > 0)
        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Cuentas</th>
                    <th class="number">{{ $data->first()->current_year  }}</th>
                    <th class="number">{{ $data->first()->past_year }}</th>
                    <th class="number"><small>Diferencia</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->where('chart_type', 1) as $chart)

                    @php
                    //Calculate delta before reseting values
                    $prevValue = $chart->prevBalance;
                    $delta = $prevValue > 0 ? ($chart->currentBalance / $prevValue) : null;
                    @endphp

                    @if ($chart->is_automatic)
                        <tr>
                            <td><a href="{{ route('journal_charts',[request()->route('company'), $chart->id]) }}">{{ $chart->code }} - {{ $chart->name }}</a></td>
                            <td class="number">{{ number_format($chart->currentBalance, 0, ',', '.') }} &nbsp;&nbsp;</td>
                            <td class="number">{{ number_format($chart->prevBalance, 0, ',', '.') }} &nbsp;&nbsp;</td>
                            <td class="number">
                                <small>
                                    @if ($prevValue > 0)
                                        <span class="success">
                                            <i class="fa fa-caret-up"></i>
                                            <strong>{{ number_format($delta, 2, ',', '.') }}%</strong>
                                        </span>
                                    @elseif ($prevValue < 0)
                                        <span class="danger">
                                            <i class="fa fa-caret-down"></i>
                                            <strong>{{ number_format($delta, 2, ',', '.') }}%</strong>
                                        </span>
                                    @else
                                        --
                                    @endif
                                </small>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td><b>{{ $chart->code }} - {{ $chart->name }}</b></td>
                            <td class="number"><b>{{ number_format($chart->currentBalance, 0, ',', '.') }} </b></td>
                            <td class="number"><b>{{ number_format($chart->prevBalance, 0, ',', '.') }} </b></td>
                            <td class="number">
                                <small>
                                    @if ($prevValue > 0)
                                        <span class="success">
                                            <i class="fa fa-caret-up"></i>
                                            <strong>{{ number_format($delta, 2, ',', '.') }}%</strong>
                                        </span>
                                    @elseif ($prevValue < 0)
                                        <span class="danger">
                                            <i class="fa fa-caret-down"></i>
                                            <strong>{{ number_format($delta, 2, ',', '.') }}%</strong>
                                        </span>
                                    @else
                                        --
                                    @endif
                                </small>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    <hr>

    <h6>
        Balance Comparativo de <strong>Passivos</strong>
        <br>
        <small>Saldo {{ number_format($data->where('chart_type', 2)->first()->currentBalance * -1, 0, ',', '.') }} PYG</small>
    </h6>
    @if ($data->where('chart_type', 2)->count() > 0)
        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Cuentas</th>
                    <th class="number">{{ $data->first()->current_year  }}</th>
                    <th class="number">{{ $data->first()->past_year }}</th>
                    <th class="number"><small>Diferencia</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->where('chart_type', 2) as $chart)
                    @php
                    //Calculate delta before reseting values
                    $prevValue = $chart->prevBalance;
                    $delta = $prevValue > 0 ? ($chart->currentBalance / $prevValue) : null;
                    @endphp

                    @if ($chart->is_automatic)
                        <tr>
                            <td><a href="{{ route('journal_charts',[request()->route('company'), $chart->id]) }}">{{ $chart->code }} - {{ $chart->name }}</a></td>
                            <td class="number">{{ number_format($chart->currentBalance * -1, 0, ',', '.') }} &nbsp;&nbsp;</td>
                            <td class="number">{{ number_format($chart->prevBalance * -1, 0, ',', '.') }} &nbsp;&nbsp;</td>
                            <td class="number">
                                <small>
                                    @if ($prevValue > 0)
                                        <span class="success">
                                            <i class="fa fa-caret-up"></i>
                                            <strong>{{ number_format($delta, 2, ',', '.') }}%</strong>
                                        </span>
                                    @elseif ($prevValue < 0)
                                        <span class="danger">
                                            <i class="fa fa-caret-down"></i>
                                            <strong>{{ number_format($delta, 2, ',', '.') }}%</strong>
                                        </span>
                                    @else
                                        --
                                    @endif
                                </small>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td><b>{{ $chart->code }} - {{ $chart->name }}</b></td>
                            <td class="number"><b>{{ number_format($chart->currentBalance * -1, 0, ',', '.') }}</b></td>
                            <td class="number"><b>{{ number_format($chart->prevBalance * -1, 0, ',', '.') }}</b></td>
                            <td class="number">
                                <small>
                                    @if ($prevValue > 0)
                                        <span class="success">
                                            <i class="fa fa-caret-up"></i>
                                            <strong>{{ number_format($delta, 2, ',', '.') }}%</strong>
                                        </span>
                                    @elseif ($prevValue < 0)
                                        <span class="danger">
                                            <i class="fa fa-caret-down"></i>
                                            <strong>{{ number_format($delta, 2, ',', '.') }}%</strong>
                                        </span>
                                    @else
                                        --
                                    @endif
                                </small>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    <hr>

    <h6>
        Balance Comparativo de <strong>Patrimonio Neto</strong>
        <br>
        <small>Saldo {{ number_format($data->where('chart_type', 3)->first()->currentBalance, 0, ',', '.') }} PYG</small>
    </h6>
    @if ($data->where('chart_type', 3)->count() > 0)
        <table class="u-full-width">
            <thead>
                <tr>
                    <th>Cuentas</th>
                    <th class="number">{{ $data->first()->current_year  }}</th>
                    <th class="number">{{ $data->first()->past_year }}</th>
                    <th class="number"><small>Diferencia</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->where('chart_type', 3) as $chart)
                    @if ($chart->is_automatic)
                        <tr>
                            <td><a href="{{ route('journal_charts',[request()->route('company'), $chart->id]) }}">{{ $chart->code }} - {{ $chart->name }}</a></td>
                            <td class="number"><b>{{ number_format($chart->currentBalance, 0, ',', '.') }} &nbsp;&nbsp;</b></td>
                            <td class="number">{{ number_format($chart->prevBalance, 0, ',', '.') }} &nbsp;&nbsp;</td>
                        </tr>
                    @else
                        <tr>
                            <td><b>{{ $chart->code }} - {{ $chart->name }}</b></td>
                            <td class="number"><b>{{ number_format($chart->currentBalance, 0, ',', '.') }}</b></td>
                            <td class="number"><b>{{ number_format($chart->prevBalance, 0, ',', '.') }}</b></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
