@extends('spark::layouts.form')

@section('title', __('commercial.CreditNotes'))

@section('form')
    <model :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}"
        url="commercial/get_credit-notes" editurl="/commercial/get_credit_noteByID/" deleteurl="commercial/credit-notes"
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
