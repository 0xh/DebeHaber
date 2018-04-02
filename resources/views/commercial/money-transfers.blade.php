@extends('spark::layouts.form')

@section('title', __('commercial.MoneyTransfers'))

@section('form')
    <model :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}"
        url="commercial/get_money_transfers"  editurl="/commercial/get_money_transferByID/"
        inline-template>
        <div>
            <div v-if="status===1">
                @include('commercial/money-transfer/form')
            </div>
            <div v-if="status===0">
                @include('commercial/money-transfer/list')
            </div>
        </div>
    </model>
@endsection
