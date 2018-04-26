@extends('spark::layouts.form')

@section('title', __('accounting.AccountingCycle'))

@section('stats')
    <div v-if="showList" class="row m-row--no-padding m-row--col-separator-xl">
        <div class="col-md-12 col-lg-4 col-xl-4">
            <div class="m-nav-grid m-nav-grid--skin-light">
                <div class="m-nav-grid__row">
                    <div class="m-nav-grid__item">
                        <img src="/img/icons/cycle.svg" alt="" width="64">
                        {{-- <h3>@lang('commercial.SalesBook')</h3> --}}
                        <span class="m-nav-grid__text">
                            <button @click="onCreate()" class="btn btn-outline-primary m-btn m-btn--icon m-btn--outline-2x">
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
            <div class="container">
                <div class="m-widget4 m-widget4--chart-bottom">
                    <div class="m-widget4__item">
                        <div class="m-widget4__img">
                            <img src="/img/icons/opening.svg" width="42">
                        </div>
                        <div class="m-widget4__info">
                            <span class="m-widget4__title">
                                <a href="#">@lang('accounting.OpeningBalance')</a>

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
                                <a href="#">@lang('accounting.ClosingBalance')</a>
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
                                <a href="#">@lang('accounting.AccountingBudget')</a>
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
    <infinity taxpayer="{{ request()->route('taxPayer')->id}}"
        cycle="{{ request()->route('cycle')->id }}"
        baseurl="accounting/cycles/" inline-template>
        <div>
            <cycle :taxpayer="{{ request()->route('taxPayer')->id }}"
                :cycle="{{ request()->route('cycle')->id }}"
                :cycles="{{ $cycles }}"
                :charts="{{ $charts }}"
                :budgetchart="{{ $charts }}"
                :versions="{{ $versions }}"
                inline-template>
                <div>
                    <div v-if="data.show = Cycle">
                        @include('accounting/cycle/form')
                    </div>
                    <div v-else-if="data.show == Budget">
                        @include('accounting/cycle/budget')
                    </div>
                    <div v-else-if="data.show == Opening">
                        @include('accounting/cycle/opening-balance')
                    </div>
                    <div v-else-if="data.show == Closing">
                        @include('accounting/cycle/closing-balance')
                    </div>
                    <div v-else>
                        @include('accounting/cycle/list')
                    </div>
                </div>
            </div>
        </div>
    </infinity>

    {{-- <div>
    <cycle :taxpayer="{{ request()->route('taxPayer')->id }}"
    :cycle="{{ request()->route('cycle')->id }}"
    :cycles="{{ $cycles }}"
    :charts="{{ $charts }}"
    :budgetchart="{{ $charts }}"
    :versions="{{ $versions }}"
    inline-template>
    <div>
    <div class="row">
    <div class="col-6">
    <div class="form-group m-form__group row">
    <label for="example-text-input" class="col-4 col-form-label">
    @lang('accounting.ChartVersion')
</label>
<div class="col-8">
<select v-model="chart_version_id" required class="custom-select" >
<option v-for="chartversion in chartversions" :value="chartversion.id">@{{ chartversion.name }}</option>
</select>
</div>
</div>
</div>
<div class="col-6">
<div class="form-group m-form__group row">
<label for="example-text-input" class="col-4 col-form-label">
@lang('global.Year')
</label>
<div class="col-8">
<input type="text" class="form-control" v-model="year" />
</div>
</div>
</div>
<div class="col-6">
<div class="form-group m-form__group row">
<label for="example-text-input" class="col-4 col-form-label">
@lang('global.StartDate')
</label>
<div class="col-8">
<input type="date" class="form-control" v-model="start_date" />
</div>
</div>
</div>
<div class="col-6">
<div class="form-group m-form__group row">
<label for="example-text-input" class="col-4 col-form-label">
@lang('global.EndDate')
</label>
<div class="col-8">
<input type="date" class="form-control" v-model="end_date" />
</div>
</div>
</div>
<div class="col-6">
<div class="form-group m-form__group row">

<div class="col-8">
<button v-on:click="onSave($data)" class="btn btn-primary">
@lang('global.Save')
</button>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-8">
<button v-on:click="onJournalSave($data)" class="btn btn-primary">
@lang('global.Save')
</button>
</div>
<div class="col-2">
<span class="m--font-boldest">
@lang('accounting.Code')
</span>
</div>
<div class="col-2">
<span class="m--font-boldest">
@lang('global.Account')
</span>
</div>
<div class="col-2">
<span class="m--font-boldest">
@lang('global.Debit')
</span>
</div>
<div class="col-2">
<span class="m--font-boldest">
@lang('global.Credit')
</span>
</div>
</div>
<hr>
<div class="row m--margin-5" v-for="data in chartlist">
<div class="col-2 m--align-left">
<span v-if="data.type == 1" class="m-badge m-badge--info m-badge--wide m-badge--rounded">
<b>@{{ data.code }}</b>
</span>
<span v-else-if="data.type == 2" class="m-badge m-badge--brand m-badge--wide m-badge--rounded">
<b>@{{ data.code }}</b>
</span>
<span v-else-if="data.type == 3" class="m-badge m-badge--warning m-badge--wide m-badge--rounded">
<b>@{{ data.code }}</b>
</span>
<span v-else-if="data.type == 4" class="m-badge m-badge--success m-badge--wide m-badge--rounded">
<b>@{{ data.code }}</b>
</span>
<span v-else-if="data.type == 5" class="m-badge m-badge--danger m-badge--wide m-badge--rounded">
<b>@{{ data.code }}</b>
</span>
</div>
<div class="col-2">
<span v-if="data.is_accountable" class="m--font-bolder">
@{{ data.name }}
</span>
<span v-else class="m--font-bolder m--font-metal m--font-transform-u">
@{{ data.name }}
</span>
</div>
<div class="col-3 m--align-right" v-if="data.is_accountable">
<input type="number" v-model="data.credit" name="">
</div>
<div class="col-3 m--align-right" v-if="data.is_accountable">
<input type="number" v-model="data.debit" name="">
</div>
<div class="col-3 m--align-right" v-else>
Non Accountable Charts
</div>
</div>

<hr>
<div class="row">
<div class="col-2">
<span class="m--font-boldest">
@lang('accounting.ChartVersion')
</span>
</div>
<div class="col-2">
<span class="m--font-boldest">
@lang('global.Year')
</span>
</div>
<div class="col-2">
<span class="m--font-boldest">
@lang('global.StartDate')
</span>
</div>
<div class="col-2">
<span class="m--font-boldest">
@lang('global.EndDate')
</span>
</div>
<div class="col-2">
<span class="m--font-boldest">
@lang('global.Action')
</span>
</div>
</div>
<hr>
<div class="row" v-for="data in list">
<div class="col-2">
@{{ data.chart_version_name }}
</div>
<div class="col-2">
@{{ data.year }}
</div>
<div class="col-2">
@{{ data.start_date }}
</div>
<div class="col-2">
@{{ data.end_date }}
</div>
<div class="col-1">

<button v-on:click="onEdit(data)" class="btn btn-outline-pencil m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
<i class="la la-pencil"></i>
</button>
</div>
</div>
</div>
</cycle>
</div> --}}
@endsection
