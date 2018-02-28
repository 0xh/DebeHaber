@extends('spark::layouts.form')

@section('title', __('commercial.CreditNote'))

@section('form')
  <form-list  inline-template>
    <div>
      <div v-if="status===1">
      @include('commercial/credit-note/form')
      </div>
      <div v-if="status===0">
      @include('commercial/credit-note/list')
    </div>
  </div>
  </form-list>




@endsection
