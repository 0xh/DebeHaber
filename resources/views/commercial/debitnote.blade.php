@extends('spark::layouts.form')

@section('title', __('commercial.DebitNotes'))

@section('stats')
    <div v-if="showList" class="row m-row--no-padding m-row--col-separator-xl">
        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="m-nav-grid m-nav-grid--skin-light">
                <div class="m-nav-grid__row">
                    <div class="m-nav-grid__item">
                        <img src="/img/icons/credit-note.svg" alt="" width="64">
                        <span class="m-nav-grid__text">
                            <button @click="onCreate()" class="btn btn-outline-primary m-btn m-btn--icon m-btn--outline-2x">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        @lang('global.Create', ['model' => __('commercial.DebitNotes')])
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
    @php
    $defaultCurrency = Config::get('countries.' . request()->route('taxPayer')->country . '.default-currency');
    @endphp
    <buefy :taxpayer="{{ request()->route('taxPayer')->id}}"
        :cycle="{{ request()->route('cycle')->id }}"
        baseurl="commercial/debit-notes"
        inline-template>

        <div>
            <div v-if="$parent.showList">
                @include('commercial/debit-note/list')
            </div>
            <div v-else>
                @include('commercial/debit-note/form')
            </div>
        </div>
    </buefy>
@endsection
