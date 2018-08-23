@extends('spark::layouts.dashboard')

@section('title', __('global.Dashboard',['team' => request()->route('taxPayer')->alias]))

@section('stats')
    <input type="text" name="" value="{{ $q }}">
@endsection

@section('content')
    {{ $foundItems }}

    <table>
        {{-- @foreach ($foundItems->sales as $sales)
            <tr>
                <td>{{ $sales->number }}</td>
                <td>{{ $sales->date }}</td>
                <td>{{ $sales->currency }}</td>
            </tr>
        @endforeach --}}
    </table>
@endsection
