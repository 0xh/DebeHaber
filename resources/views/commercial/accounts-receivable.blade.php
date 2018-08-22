@extends('spark::layouts.form')

@section('title', __('commercial.AccountsReceivable'))

@section('stats')
    <div v-if="showList" class="row m-row--no-padding m-row--col-separator-xl">
        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="m-nav-grid m-nav-grid--skin-light">
                <div class="m-nav-grid__row">
                    <div class="m-nav-grid__item">
                        <img src="/img/icons/account-receivable.svg" alt="" width="64">
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
                    <li class="m-nav__section">
                        <span class="m-nav__section-text">
                        </span>
                    </li>
                    <li class="m-nav__item">
                        <i class="m-nav__link-icon la la-paper-plane-o"></i>
                        <span class="m-nav__link-text">@lang('commercial.SalesBook')</span>
                    </li>
                    <li class="m-nav__item">
                        <i class="m-nav__link-icon la la-shopping-cart"></i>
                        <span class="m-nav__link-text">Libro IVA Compras</span>
                    </li>
                    <li class="m-nav__item">
                        <i class="m-nav__link-icon la la-book"></i>
                        <span class="m-nav__link-text">Libro Mayor</span>
                    </li>
                    <li class="m-nav__item">
                        <i class="m-nav__link-icon la la-cloud-download"></i>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('form')
    <buefy taxpayer="{{ request()->route('taxPayer')->id }}"
        cycle="{{ request()->route('cycle')->id }}"
        baseurl="commercial/account_receivables"
        inline-template>
        <div>
            <div v-if="$parent.showList">
                @include('commercial/account-receivable/list')
            </div>
            <div v-else>
                @include('commercial/account-receivable/form')
            </div>
        </div>
    </buefy>
@endsection
