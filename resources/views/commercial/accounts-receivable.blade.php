@extends('spark::layouts.form')

@section('title', 'Accounts Receivables')

@section('form')

    @include('commercial/account-receivable/form')
    @include('commercial/account-receivable/list')

@endsection
