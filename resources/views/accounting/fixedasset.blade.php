
@extends('spark::layouts.form')

@section('title',  __('accounting.FixedAssests'))

@section('stats')
    <div v-if="showList" class="row m-row--no-padding m-row--col-separator-xl">
        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="m-nav-grid m-nav-grid--skin-light">
                <div class="m-nav-grid__row">
                    <div class="m-nav-grid__item">
                        {{-- <img src="/img/icons/chart-of-accounts.svg" alt="" width="64"> --}}
                        {{-- <h3>@lang('commercial.SalesBook')</h3> --}}
                        <span class="m-nav-grid__text">
                            <button @click="onCreate()" class="btn btn-outline-primary m-btn m-btn--icon m-btn--outline-2x">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        @lang('global.Create', ['model' => __('commercial.FixedAsset')])
                                    </span>
                                </span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="m-widget24">
                <div class="m-widget24__item">

                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-3">
            <!--begin::New Feedbacks-->
            <div class="m-widget24">
                <div class="m-widget24__item">

                </div>
            </div>
            <!--end::New Feedbacks-->
        </div>
        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="container">
                <ul class="m-nav">

                </ul>
            </div>
        </div>
    </div>
@endsection

@section('form')


    <infinity taxpayer="{{ request()->route('taxPayer')->id}}"
        cycle="{{ request()->route('cycle')->id }}"
      baseurl="accounting/fixedasset/fixedassets" inline-template>
        <div>
            <div v-if="$parent.showList">
                @include('accounting/fixedasset/list')
            </div>
            <div v-else>
                @include('accounting/fixedasset/form')
            </div>
        </div>
    </infinity>
@endsection
