@extends('spark::layouts.form')

@section('title', 'Credit Note')

@section('form')
  <form-list  inline-template>
    <div>
      <div v-if="status===1">
      @include('commercial/documents/form')
      </div>
      <div v-if="status===0">
      @include('commercial/documents/list')
    </div>
  </div>
  </form-list>




@endsection
