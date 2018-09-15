@extends('spark::layouts.form')

@section('title', __('commercial.SalesBook'))

@section('stats')
    <div v-if="showList" class="row m-row--no-padding m-row--col-separator-xl">
        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="m-nav-grid m-nav-grid--skin-light">
                <div class="m-nav-grid__row">
                    <div class="m-nav-grid__item">
                        <img src="/img/icons/sales.svg" alt="" width="64">
                        <span class="m-nav-grid__text">
                            <button @click="onCreate()" class="btn btn-outline-primary m-btn m-btn--icon m-btn--outline-2x">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        @lang('global.Create', ['model' => __('commercial.Sales')])
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
                                @lang('commercial.SalesBook')
                            </span>
                        </div>
                        <div class="m-widget4__ext">
                            <span class="m-widget4__number m--font-danger">
                                <i class="la la-paper-plane-o"></i>
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
                                @lang('commercial.SalesByVAT')
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
                            <a href="../reports/sales-byCustomers/{{ (new Carbon\Carbon('first day of last month'))->toDateString() }}/{{ (new Carbon\Carbon('last day of last month'))->toDateString() }}" class="m-widget4__icon m--font-brand">
                                <i class="flaticon-file-1"></i>
                            </a>
                        </div>
                        <div class="m-widget4__info">
                            <span class="m-widget4__text">
                                @lang('commercial.SalesByCustomer')
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
    <buefy taxpayer="{{ request()->route('taxPayer')->id }}" cycle="{{ request()->route('cycle')->id }}" baseurl="commercial/sales" inline-template>
        <div>
            <div v-if="$parent.showList">
                @include('commercial/sales/list')
            </div>
            <div v-else>
                @include('commercial/sales/form')
            </div>
        </div>
    </buefy>
@endsection
