@extends('spark::layouts.form')

@section('title', __('commercial.CreditNotes'))

@section('form')
    @php
    $defaultCurrency = Config::get('countries.' . request()->route('taxPayer')->country . '.default-currency');

    @endphp
    <form-view :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}"
        baseurl="commercial/credit_notes" taxpayercurrency="{{$defaultCurrency}}"
        inline-template>
        <div>
            <div v-if="status === 1">
                @include('commercial/credit-note/form')
            </div>
            <div v-if="status === 0">
                @include('commercial/credit-note/list')
            </div>
        </div>
    </model>
@endsection
