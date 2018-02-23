@extends('spark::layouts.form')

@section('title', 'Sales Book')

@section('nav')

@endsection

@section('form')
  <form-list  inline-template>
    <div>
      <div v-if="status===1">
        @include('commercial/sales/form')
      </div>
      <div v-if="status===0">
        @include('commercial/sales/list')
      </div>
    </div>
  </form-list>

@endsection
