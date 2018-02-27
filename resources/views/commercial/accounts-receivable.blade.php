@extends('spark::layouts.form')

@section('title', 'Accounts Receivables')

@section('form')
  <form-list  inline-template>
  <div>
    <div v-if="status===1">
      @include('commercial/account-receivable/form')
    </div>
    <div v-if="status===0">
      @include('commercial/account-receivable/list')
    </div>
  </div>
</form-list>


@endsection
