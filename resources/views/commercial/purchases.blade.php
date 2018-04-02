@extends('spark::layouts.form')

@section('title', __('commercial.PurchaseBook'))

@section('form')
    <model :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}"
        url="commercial/get_purchases" editurl="/commercial/get_purchasesByID/" deleteurl="commercial/purchases"
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
