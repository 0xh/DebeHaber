@extends('spark::layouts.form')

@section('title', __('commercial.AccountsReceivable'))

@section('form')
    <model :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}"
        url="commercial/get_account_receivables" editurl="/commercial/get_account_receivableByID/"
        inline-template>
        <div>
            <div v-if="status === 1">
                @include('commercial/account-receivable/form')
            </div>
            <div v-if="status === 0">
                @include('commercial/account-receivable/list')
            </div>
        </div>
    </model>
@endsection
