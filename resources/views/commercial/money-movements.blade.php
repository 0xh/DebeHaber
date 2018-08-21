
@extends('spark::layouts.form')

@section('title',  __('commercial.MoneyMovements'))

@section('form')
    <infinity taxpayer="{{ request()->route('taxPayer')->id}}" cycle="{{ request()->route('cycle')->id }}" baseurl="commercial/money-movements" inline-template>
        <div>
            @include('commercial/money-movement/list')
        </div>
    </infinity>
@endsection
