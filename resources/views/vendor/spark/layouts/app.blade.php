@extends('spark::layouts.master')

@section('styles')
    <link href="{{ mix(Spark::usesRightToLeftTheme() ? 'css/app-rtl.css' : 'css/app.css') }}" rel="stylesheet">
@endsection

@section('layout')
    <div class="m-content m--margin-top-30">
        @yield('content')
    </div>
@endsection
