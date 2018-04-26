@extends('spark::layouts.form')

@section('title', __('accounting.AccountingCycle'))

@section('form')
    <div>
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

                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            Form
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--right m-tabs-line--brand" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#openingBalance" role="tab" aria-selected="false">
                                    <i class="la la-calculator"></i>
                                    @lang('accounting.OpeningBalance')
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#budget" role="tab" aria-selected="true">
                                    <i class="la la-briefcase"></i>
                                    @lang('accounting.Budget')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    {{-- Accounting Reports --}}
                    <div class="tab-pane" id="openingBalance" role="tabpanel">
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
                    </div>
                    <div class="tab-pane" id="budget" role="tabpanel">
                        <div class="row">
                            <div class="col-8">
                                <button v-on:click="onCycleBudgetSave($data)" class="btn btn-primary">
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
                        <div class="row m--margin-5" v-for="data in budgetlist">
                            <div class="col-2 m--align-left">
                                @{{ data.code }}
                            </div>
                            <div class="col-2">
                                @{{ data.name }}
                            </div>
                            <div v-if="data.is_accountable" class="col-2">
                                <input type="number" v-model="data.debit" name="">
                            </div>
                            <div v-if="data.is_accountable" class="col-2">
                                <input type="number" v-model="data.debit" name="">
                            </div>
                        </div>
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
    </div>
@endsection
