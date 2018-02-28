@extends('spark::layouts.form')

@section('title', __('commercial.AccountsPayable'))

@section('form')
    <form-list inline-template>
        <div>
            <div v-if="status===1">
                @include('commercial/account-payable/form')
            </div>
            <div v-if="status===0">
                @include('commercial/account-payable/list')
            </div>
        </div>
    </form-list>


@endsection
