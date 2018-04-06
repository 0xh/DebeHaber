@extends('spark::layouts.form')

@section('title', __('commercial.DebitNotes'))

@section('form')
  @php
    $defaultCurrency = Config::get('countries.' . request()->route('taxPayer')->country . '.default-currency');

    @endphp
    <form-view :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}" taxpayercurrency="{{$defaultCurrency}}"
        baseurl="commercial/debit_notes"
        inline-template>
        <div>
            <div v-if="status === 0">
                @include('commercial/debit-note/list')
            </div>
            <div v-else>
                @include('commercial/debit-note/form')
            </div>
        </div>
    </model>
@endsection
