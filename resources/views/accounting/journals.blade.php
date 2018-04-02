@extends('spark::layouts.form')

@section('title', __('accounting.Journal'))

@section('nav')

@endsection

@section('form')
    <view inline-template>
        <div>
            <div v-if="status === 1">
                @include('accounting/journal/form')
            </div>
            <div v-else>
                @include('accounting/journal/list')
            </div>
        </div>
    </view>

    <model :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}"
        url="accounting/get_journals" editurl="accounting/get_journalByID" deleteurl="accounting/delete_journalByID"
        inline-template>
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
