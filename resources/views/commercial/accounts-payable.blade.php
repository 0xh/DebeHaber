@extends('spark::layouts.form')

@section('title', 'Accounts Receivables')

@section('form')
    <div>
    <div v-if="status===1">
    @include('commercial/account-payable/form')
    </div>
    <div v-if="status===0">
@include('commercial/account-payable/list')
    </div>
  </div>



@endsection
