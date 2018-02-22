@extends('spark::layouts.form')

@section('title', 'Debit Note')

@section('form')

    @include('commercial/debit-note/form')
    @include('commercial/debit-note/list')

@endsection
