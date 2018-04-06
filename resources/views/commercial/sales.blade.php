@extends('spark::layouts.form')

@section('title', __('commercial.SalesBook'))

@section('nav')

@endsection

@section('form')
  @php
  $defaultCurrency = Config::get('countries.' . request()->route('taxPayer')->country . '.default-currency');

  @endphp

    <model :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}" taxpayercurrency="{{$defaultCurrency}}"
        baseurl="commercial/sales" 
        inline-template>
        <div>
            <div v-if="status === 1">
                @include('commercial/sales/form')
            </div>
            <div v-else>
                @include('commercial/sales/list')
            </div>
        </div>
    </model>
@endsection
