@extends('spark::layouts.dashboard')

@section('content')

    <home :user="user" inline-template>
        <div class="card card-default">
            <div class="card-body">
                @yield('form')
            </div>
        </div>
    </home>

@endsection
