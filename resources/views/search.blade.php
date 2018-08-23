@extends('spark::layouts.dashboard')

@section('title', __('global.Dashboard',['team' => request()->route('taxPayer')->alias]))

@section('stats')
    <input type="text" class="col-12" name="" value="{{ $q }}">
@endsection

@section('content')

{{ $sales }}

    <table>
        <tr>
            <th>Customer</th>
            <th>Supplier</th>
            <th>Total</th>
        </tr>
        @foreach ($sales as $sale)
            <tr>
                {{-- <td>{{ $sale->customer }}</td> --}}
                {{-- <td>{{ $sale->supplier }}</td> --}}
                {{-- <td>{{ $sale->total }}</td> --}}
            </tr>
        @endforeach
    </table>

    {{ $taxPayers }}


    <table class="m-table">
        <tr>
            <th>Name</th>
            <th>Alias</th>
            <th>Gov Tax Code</th>
        </tr>
        @foreach ($taxPayers as $taxPayer)
            <tr>
                {{-- <td>{{ $taxPayer->name }}</td>
                <td>{{ $taxPayer->alias }}</td>
                <td>{{ $taxPayer->taxid }}</td> --}}
            </tr>
        @endforeach
    </table>

@endsection
