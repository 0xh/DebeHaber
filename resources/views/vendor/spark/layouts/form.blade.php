@extends('spark::layouts.master')

@section('layout')
    <home :user="user" inline-template>
        <div class="card card-default">
            <div class="card-body">
                @yield('form')
            </div>
        </div>
    </home>
@endsection
