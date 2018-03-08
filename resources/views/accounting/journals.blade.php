@extends('spark::layouts.form')

@section('title', __('commercial.SalesBook'))

@section('nav')

@endsection

@section('form')
  <form-list inline-template>
      <div>
          <div v-if="status===1">
              @include('accounting/journal/form')
          </div>
          <div v-else>
              @include('accounting/journal/list')
          </div>
      </div>
  </form-list>

@endsection
