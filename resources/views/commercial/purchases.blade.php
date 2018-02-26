@extends('spark::layouts.form')

@section('title', 'Purchase Book')

@section('form')

  <form-list  inline-template>
    <div>
      <div v-if="status===1">
      @include('commercial/purchase/form')
      </div>
      <div v-if="status===0">
      @include('commercial/purchase/list')
      </div>
    </div>
  </form-list>
  


@endsection
