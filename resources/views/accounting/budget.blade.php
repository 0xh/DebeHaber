@extends('spark::layouts.form')

@section('title', __('accounting.OpeningBalance'))

@section('stats')
    <div v-if="showList" class="row m-row--no-padding m-row--col-separator-xl">
        <div class="col-md-12 col-lg-4 col-xl-4">
            <div class="m-nav-grid m-nav-grid--skin-light">
                <div class="m-nav-grid__row">
                    <div class="m-nav-grid__item">
                        <figure class="image is-64x64">
                            <img src="/img/icons/budget.svg" width="64">
                        </figure>
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
                            <figure class="image is-48x48">
                                <img src="/img/icons/opening.svg" width="48">
                            </figure>
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
                            <figure class="image is-48x48">
                                <img src="/img/icons/closing.svg" width="48">
                            </figure>
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
                            <figure class="image is-48x48">
                                <img src="/img/icons/budget.svg" width="48">
                            </figure>
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

    <div class="m-form__heading">
        <h3 class="m-form__heading-title">Budget Information</h3>
    </div>
    <div>
        <div>
            <button v-on:click="onCycleBudgetSave($data)" class="btn btn-primary">
                @lang('global.Save')
            </button>
            <div class="row">
                <div class="col-2">
                    <span class="m--font-boldest">
                        @lang('global.Code')
                    </span>
                </div>
                <div class="col-4">
                    <span class="m--font-boldest">
                        @lang('accounting.ChartofAccounts')
                    </span>
                </div>
                <div class="col-3">
                    <span class="m--font-boldest">
                        @lang('accounting.Debit')
                    </span>
                </div>
                <div class="col-3">
                    <span class="m--font-boldest">
                        @lang('accounting.Credit')
                    </span>
                </div>
            </div>
            <hr>
            <div class="row m--margin-bottom-10" v-for="data in budgetchart">
                <div class="col-2 m--align-right">
                    @{{ data.code }}
                </div>
                <div class="col-4">
                    @{{ data.name }}
                </div>
                <div v-if="data.is_accountable" class="col-3">
                    <input type="number" v-model="data.debit">
                </div>
                <div v-if="data.is_accountable" class="col-3">
                    <input type="number" v-model="data.credit">
                </div>
            </div>
        </div>
    </div>

@endsection
