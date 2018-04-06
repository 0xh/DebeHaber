@extends('spark::layouts.form')

@section('title', __('accounting.Journal'))

@section('stats')

@endsection

@section('form')

    <model :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}"
        baseurl="accounting/journals"  inline-template>
        <div>
            <div v-if="status === 1">
                @include('accounting/journal/form')
            </div>
            <div v-else>
                @include('accounting/journal/list')
            </div>
        </div>
    </model>

@endsection
