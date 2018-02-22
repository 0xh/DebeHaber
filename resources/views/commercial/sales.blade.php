@extends('spark::layouts.form')

@section('title', 'Sales Book')

@section('form')

    @include('commercial/purchase/form')
    @include('commercial/purchase/list')

@endsection
