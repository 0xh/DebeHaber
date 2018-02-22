@extends('spark::layouts.form')

@section('title', 'Purchase Book')

@section('form')

    @include('commercial/purchase/form')
    @include('commercial/purchase/list')

@endsection
