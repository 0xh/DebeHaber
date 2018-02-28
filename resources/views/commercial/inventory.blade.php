@extends('spark::layouts.form')

@section('title', __('commercial.Inventory'))

@section('form')

  <form-list  inline-template>
    <div>
      <div v-if="status===1">
      @include('commercial/inventory/form')
      </div>
      <div v-if="status===0">
      @include('commercial/inventory/list')
      </div>
    </div>
  </form-list>



@endsection
