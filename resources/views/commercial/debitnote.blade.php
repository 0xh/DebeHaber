@extends('spark::layouts.form')

@section('title', __('commercial.DebitNotes'))

@section('form')
    <model :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}" 
        :url="commercial/debit-notes"
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
