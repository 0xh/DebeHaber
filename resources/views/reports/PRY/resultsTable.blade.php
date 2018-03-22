@extends('reports.master')
@section('reportName', 'Cuadro de Resultado')

@section('data')

    <table class="u-full-width">
        <tbody>
            <tr>
              @foreach($data as $item)
                @foreach($item as $row)
                    {{ $row }}
                @endforeach
                @endforeach
            </tr>
        </tbody>
    </table>

@endsection
