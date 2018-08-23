@extends('spark::layouts.dashboard')

@section('title', __('global.Dashboard',['team' => request()->route('taxPayer')->alias]))

@section('stats')
    <input type="text" class="col-12" name="" value="{{ $q }}">
@endsection

@section('content')

    @foreach ($foundItems as $results)
        {{ $results->first() }}
        <br>
        <br>
    @endforeach

@endsection
