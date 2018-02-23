@extends('spark::layouts.form')

@section('title', 'Sales Book')

@section('nav')

@endsection

@section('form')
  <form-list  inline-template>
    <div>
      @include('commercial/sales/form')
      @include('commercial/sales/list')
    </div>
  </form-list>

@endsection
