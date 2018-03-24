@extends('spark::layouts.form')

@section('title', __('commercial.DebitNotes'))

@section('form')
    <form-list inline-template>
        <div>
            <div v-if="status === 0">
                @include('commercial/debit-note/list')
            </div>
            <div v-else>
                @include('commercial/debit-note/form')
            </div>
        </div>
    </form-list>
@endsection
