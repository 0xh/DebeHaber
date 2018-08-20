
@extends('spark::layouts.form')

@section('title',  __('accounting.Movement'))



@section('form')


    <infinity taxpayer="{{ request()->route('taxPayer')->id}}" cycle="{{ request()->route('cycle')->id }}"
      baseurl="accounting/movements" inline-template>
        <div>
            @include('accounting/movement/list')

        </div>
    </infinity>
@endsection
