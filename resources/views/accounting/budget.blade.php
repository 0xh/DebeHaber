@extends('spark::layouts.form')

@section('title', __('accounting.OpeningBalance'))

@section('stats')
    <div class="row m-row--no-padding m-row--col-separator-xl">
        <div class="col-md-12 col-lg-4 col-xl-4">
            <div class="m-nav-grid m-nav-grid--skin-light">
                <div class="m-nav-grid__row">
                    <div class="m-nav-grid__item">
                        <figure class="image is-64x64">
                            <img src="/img/icons/opening.svg" width="64">
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
            <div class="m-widget4">
                <div class="m-widget4__item m--margin-10">
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
                <div class="m-widget4__item m--margin-10">
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
                <div class="m-widget4__item m--margin-10">
                    <div class="m-widget4__img">
                        <figure class="image is-48x48">
                            <img src="/img/icons/budget.svg" width="48">
                        </figure>
                    </div>
                    <div class="m-widget4__info">
                        <span class="m-widget4__title">
                            <a href="#" @click="onCycleBudget()">
                                @lang('accounting.AnnualBudget')
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
@endsection

@section('form')

    <div class="m-form__heading">
        <h3 class="m-form__heading-title">Opening Balance</h3>
    </div>

    <div>
        <buefy taxpayer="{{ request()->route('taxPayer')->id }}"
            cycle="{{ request()->route('cycle')->id }}"
            baseurl="accounting/budget" inline-template>
            <div>
                <button v-on:click="saveBudget($data.data)" class="btn btn-primary">
                    @lang('global.Save')
                </button>
                <div class="row">
                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('global.Code')
                        </span>
                    </div>
                    <div class="col-6">
                        <span class="m--font-boldest">
                            @lang('commercial.Account')
                        </span>
                    </div>

                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('accounting.Credit')
                        </span>
                    </div>

                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('accounting.Debit')
                        </span>
                    </div>
                </div>

                <hr>

                <div class="row m--margin-bottom-10" v-for="balance in data">
                    <div class="col-1">
                        @{{ balance.id }}
                    </div>
                    <div class="col-2 m--align-left">
                        <span v-if="balance.type == 1" class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                            <b>@{{ balance.code }}</b>
                        </span>
                        <span v-else-if="balance.type == 2" class="m-badge m-badge--brand m-badge--wide m-badge--rounded">
                            <b>@{{ balance.code }}</b>
                        </span>
                        <span v-else-if="balance.type == 3" class="m-badge m-badge--warning m-badge--wide m-badge--rounded">
                            <b>@{{ balance.code }}</b>
                        </span>
                        <span v-else-if="balance.type == 4" class="m-badge m-badge--success m-badge--wide m-badge--rounded">
                            <b>@{{ balance.code }}</b>
                        </span>
                        <span v-else-if="balance.type == 5" class="m-badge m-badge--danger m-badge--wide m-badge--rounded">
                            <b>@{{ balance.code }}</b>
                        </span>
                        <span v-else class="m-badge m-badge--metal m-badge--wide m-badge--rounded">
                            <b>@{{ balance.code }}</b>
                        </span>
                    </div>

                    <div class="col-5">
                        @{{ balance.name }}
                    </div>

                    <div v-if="balance.is_accountable" class="col-2">
                        <b-input placeholder="@lang('accounting.Credit')" v-model="balance.credit" type="number" min="0"></b-input>
                    </div>

                    <div v-if="balance.is_accountable" class="col-2">
                        <b-input placeholder="@lang('accounting.Debit')" v-model="balance.debit" type="number" min="0"></b-input>
                    </div>
                </div>

                <button v-on:click="saveBudget($data.data)" class="btn btn-primary">
                    @lang('global.Save')
                </button>
            </div>
        </buefy>
    </div>

@endsection
