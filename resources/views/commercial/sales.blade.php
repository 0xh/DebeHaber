@extends('spark::layouts.form')

@section('title', 'Sales Book')

@section('nav')

@endsection

@section('form')

    @include('commercial/purchase/form')
    @include('commercial/purchase/list')

@endsection
