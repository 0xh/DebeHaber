@extends('spark::layouts.form')

@section('title', __('commercial.SalesBook'))

@section('nav')

@endsection

@section('form')
    <form-list inline-template>
        <div>

            <div>
                @include('accounting/journal/list')
            </div>
        </div>
    </form-list>
@endsection
