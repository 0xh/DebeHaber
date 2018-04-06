@extends('spark::layouts.form')

@section('title', __('commercial.PurchaseBook'))

@section('form')
    @php
    $defaultCurrency = Config::get('countries.' . request()->route('taxPayer')->country . '.default-currency');

    @endphp
    <model :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}" taxpayercurrency="{{$defaultCurrency}}"
        baseurl="commercial/purchases" 
        inline-template>
        <div>
            <div v-if="status===1">
                @include('commercial/purchase/form')
            </div>
            <div v-if="status===0">
                @include('commercial/purchase/list')
            </div>
        </div>
    </model>
@endsection
