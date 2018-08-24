@extends('spark::layouts.form')

@section('title', __('accounting.AccountingCycle'))

@section('stats')
    <div v-if="showList" class="row m-row--no-padding m-row--col-separator-xl">
        <div class="col-md-12 col-lg-4 col-xl-4">
            <div class="m-nav-grid m-nav-grid--skin-light">
                <div class="m-nav-grid__row">
                    <div class="m-nav-grid__item">
                        <img src="/img/icons/cycle.svg" alt="" width="64">
                        {{-- <h3 class="title is-3">@lang('commercial.SalesBook')</h3> --}}
                        <span class="m-nav-grid__text">
                            <button @click="onCreateCyclce()" class="btn btn-outline-primary m-btn m-btn--icon m-btn--outline-2x">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        @lang('accounting.AccountingCycle')
                                    </span>
                                </span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4 col-xl-4">
            <div class="m-nav-grid m-nav-grid--skin-light">
                <div class="m-nav-grid__row">
                    <div class="m-nav-grid__item">
                        <blockquote class="blockquote">
                            <p class="mb-0">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                            </p>
                            <footer class="blockquote-footer">
                                Someone famous in
                                <cite title="Source Title">
                                    <a href="https://support.debehaber.com/cycles">Get Help</a>
                                </cite>
                            </footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4 col-xl-4">

            <div  class="container">
                <div class="m-widget4 m-widget4--chart-bottom">
                    <div class="m-widget4__item">
                        <div class="m-widget4__img">
                            <img src="/img/icons/opening.svg" width="42">
                        </div>
                        <div class="m-widget4__info">
                            <span class="m-widget4__title">
                                <a href="#" @click="onOpeningBalance()">
                                    @lang('accounting.OpeningBalance')
                                </a>
                            </span>
                            <br>
                            <span class="m-widget4__sub">
                                Create an opening balance
                            </span>
                        </div>
                    </div>
                    <div class="m-widget4__item">
                        <div class="m-widget4__img">
                            <img src="/img/icons/closing.svg" width="42">
                        </div>
                        <div class="m-widget4__info">
                            <span class="m-widget4__title">
                                <a href="#" @click="onClosingBalance()">
                                    @lang('accounting.ClosingBalance')
                                </a>
                            </span>
                            <br>
                            <span class="m-widget4__sub">
                                Create a closing balance
                            </span>
                        </div>
                    </div>
                    <div class="m-widget4__item">
                        <div class="m-widget4__img">
                            <img src="/img/icons/budget.svg" width="42">
                        </div>
                        <div class="m-widget4__info">
                            <span class="m-widget4__title">
                                <a href="#" @click="onCycleBudget()">
                                    @lang('accounting.AccountingBudget')
                                </a>
                            </span>
                            <br>
                            <span class="m-widget4__sub">
                                State your budget for the year
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('form')

    <cycle :taxpayer="{{ request()->route('taxPayer')->id }}"
        :cycle="{{ request()->route('cycle')->id }}"
        :cycles="{{ $cycles }}"
        :charts="{{ $charts }}"
        :budgetchart="{{ $charts }}"
            :budgets="{{ $budgets }}"
        :versions="{{ $versions }}"
        inline-template>
        <div>
            <div v-if="$parent.showCycle === 1">
                @include('accounting/cycle/form')
            </div>
            <div v-else-if="$parent.showCycle === 2">
                @include('accounting/cycle/budget')
            </div>
            <div v-else-if="$parent.showCycle === 3">
                @include('accounting/cycle/opening-balance')
            </div>
            <div v-else-if="$parent.showCycle === 4">
                @include('accounting/cycle/closing-balance')
            </div>
            <div v-else>
                @include('accounting/cycle/list')
            </div>
        </div>
    </div>

@endsection
