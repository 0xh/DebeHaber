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
                            <input type="number" v-model="data.credit" name="">
                        </div>
                    </div>
                </div>
                
            </div>
        </cycle>
    </div>
@endsection
