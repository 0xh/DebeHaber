@extends('spark::layouts.form')

@section('title', __('commercial.SalesBook'))

@section('nav')

@endsection

@section('form')
    <model :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}"
        url="commercial/get_sales" editurl="/commercial/get_salesByID/" deleteurl="commercial/sales"
        inline-template>
        <div>
            <div v-if="status === 1">
                @include('commercial/sales/form')
            </div>
            <div v-else>
                @include('commercial/sales/list')
            </div>
        </div>
    </model>
@endsection
