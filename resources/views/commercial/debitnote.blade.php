@extends('spark::layouts.form')

@section('title', 'Debit Note')

@section('form')
  <form-list  inline-template>
    <div>
      <div v-if="status===1">
        @include('commercial/debit-note/form')
      </div>
      <div v-if="status===0">
        @include('commercial/debit-note/list')
      </div>
    </div>
  </form-list>




@endsection
