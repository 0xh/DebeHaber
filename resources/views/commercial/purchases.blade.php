@extends('spark::layouts.form')

@section('title', __('commercial.PurchaseBook'))

@section('stats')
    <div v-if="showList" class="row m-row--no-padding m-row--col-separator-xl">
        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="m-nav-grid m-nav-grid--skin-light">
                <div class="m-nav-grid__row">
                    <div class="m-nav-grid__item">
                        <img src="/img/icons/purchase.svg" alt="" width="64">
                        {{-- <h3 class="title is-3">@lang('commercial.PurchaseBook')</h3> --}}
                        {{-- <hr> --}}
                        <span class="m-nav-grid__text">
                            <button @click="onCreate()" class="btn btn-outline-primary m-btn m-btn--icon m-btn--outline-2x">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        @lang('global.Create', ['model' => __('commercial.Purchase')])
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
                <div class="m-widget4 m-widget4--chart-bottom">
                    <div class="m-widget4__item">
                        <div class="m-widget4__ext">
                            <a class="m-widget4__icon m--font-brand" href="../reports/sales/{{ (new Carbon\Carbon('first day of last month'))->toDateString() }}/{{ (new Carbon\Carbon('last day of last month'))->toDateString() }}" target="_blank">
                                <i class="flaticon-file-1"></i>
                            </a>
                        </div>
                        <div class="m-widget4__info">
                            <span class="m-widget4__text">
                                @lang('commercial.PurchaseBook')
                            </span>
                        </div>
                        <div class="m-widget4__ext">
                            <span class="m-widget4__number m--font-danger">
                                <i class="la la-shopping-cart"></i>
                            </span>
                        </div>
                    </div>
                    <div class="m-widget4__item">
                        <div class="m-widget4__ext">
                            <a href="../reports/sales-byVATs/{{ (new Carbon\Carbon('first day of last month'))->toDateString() }}/{{ (new Carbon\Carbon('last day of last month'))->toDateString() }}" class="m-widget4__icon m--font-brand">
                                <i class="flaticon-file-1"></i>
                            </a>
                        </div>
                        <div class="m-widget4__info">
                            <span class="m-widget4__text">
                                @lang('commercial.PurchaseByVAT')
                            </span>
                        </div>
                        <div class="m-widget4__ext">
                            <span class="m-widget4__stats m--font-info">
                                <span class="m-widget4__number m--font-warning">
                                    <i class="la la-university"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="m-widget4__item">
                        <div class="m-widget4__ext">
                            <a href="../reports/purchases-bySupplier/{{ (new Carbon\Carbon('first day of last month'))->toDateString() }}/{{ (new Carbon\Carbon('last day of last month'))->toDateString() }}" class="m-widget4__icon m--font-brand">
                                <i class="flaticon-file-1"></i>
                            </a>
                        </div>
                        <div class="m-widget4__info">
                            <span class="m-widget4__text">
                                @lang('commercial.PurchaseBySuppliers')
                            </span>
                        </div>
                        <div class="m-widget4__ext">
                            <span class="m-widget4__stats m--font-info">
                                <span class="m-widget4__number m--font-success">
                                    <i class="la la-users"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('form')
    <buefy :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}" baseurl="commercial/purchases" inline-template>
        <div>
            <div v-if="$parent.showList">
                @include('commercial/purchase/list')
            </div>
            <div v-else>
                @include('commercial/purchase/form')
            </div>
        </div>
    </buefy>
@endsection
