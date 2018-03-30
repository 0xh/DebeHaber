@extends('spark::layouts.form')

@section('title', __('commercial.MoneyTransfers'))

@section('form')
    <form-list inline-template>
        <div>
            <div v-if="status===1">
                @include('commercial/money-transfer/form')
            </div>
            <div v-if="status===0">
                @include('commercial/money-transfer/list')
            </div>
        </div>
    </form-list>
@endsection
