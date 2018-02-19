@extends('spark::layouts.master')

@section('contents')

    <div class="m-content m--margin-top-30">
        @yield('content')

        @if (Auth::check())
            @include('spark::modals.notifications')
            @include('spark::modals.support')
            @include('spark::modals.session-expired')
        @endif
    </div>

@endsection
