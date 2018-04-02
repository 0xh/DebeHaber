@extends('spark::layouts.form')

@section('title', __('commercial.AccountsPayable'))

@section('form')
    <model :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}"
        :url="commercial/get_account_payables" editurl="/commercial/get_account_payableByID/"
        inline-template >
        <div>
            <div v-if="status===1">
                @include('commercial/account-payable/form')
            </div>
            <div v-if="status===0">
                @include('commercial/account-payable/list')
            </div>
        </div>
    </model>
@endsection
