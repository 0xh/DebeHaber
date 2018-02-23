@extends('spark::layouts.form')

@section('title', 'Credit Note')

@section('form')

    @include('commercial/credit-note/form')
    @include('commercial/credit-note/list')

@endsection
