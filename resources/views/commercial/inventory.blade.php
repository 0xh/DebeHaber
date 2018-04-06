@extends('spark::layouts.form')

@section('title', __('commercial.Inventory'))

@section('form')
    <form-view :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}" 
        :url="commercial/inventories"
        inline-template>
        <div>
            <div v-if="status===1">
                @include('commercial/inventory/form')
            </div>
            <div v-if="status===0">
                @include('commercial/inventory/list')
            </div>
        </div>
    </model>
@endsection
