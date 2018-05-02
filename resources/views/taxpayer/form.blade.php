@extends('spark::layouts.app')

@section('title', __('global.Create', ['model' => __('global.Taxpayer')]))

@section('content')
    <taxpayer inline-template>
        <form class="m-form m-form--fit m-form--label-align-right">
            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <b>1. </b> @lang('global.Create', ['model' => __('global.Taxpayer')]) <small></small>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body row">
                    <div class="form-group m-form__group col-8">
                        <label>
                            @lang('global.Taxid')
                        </label>
                        <div class="input-group m-input-group">
                            <input type="number" class="form-control m-input" v-model="taxid">
                            <div class="input-group-append">
                                <input type="number" class="form-control m-input" v-model="taxid">
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-form__group col-8">
                        <label for="lblTaxpayer">
                            @lang('global.Taxpayer')
                        </label>
                        <input type="text" class="form-control form-control-lg m-input" v-model="taxpayer">
                    </div>

                    <div class="form-group m-form__group col-8">
                        <label for="lblAlias">
                            @lang('global.Alias')
                        </label>
                        <input type="text" class="form-control form-control-lg m-input" v-model="alias">
                    </div>

                    <div class="form-group m-form__group col-8">
                        <label>
                            @lang('global.Address')
                        </label>
                        <textarea class="form-control m-input" id="exampleTextarea" rows="3" v-model="address"></textarea>
                    </div>

                    <div class="form-group m-form__group col-8">
                        <label>
                            @lang('global.Telephone')
                        </label>
                        <input type="text" class="form-control form-control-lg m-input" v-model="telephone">
                    </div>

                    <div class="form-group m-form__group col-8">
                        <label>
                            @lang('global.Email')
                        </label>
                        <input type="email" class="form-control form-control-lg m-input" v-model="email">
                    </div>
                </div>

                {{--
                <div class="col-6">
                <div class="form-group m-form__group row">
                <div class="col-8">
                <button v-on:click="onSave($data)" class="btn btn-brand">
                @lang('global.Save')
                --}}

            </div>

            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <b>2. </b> @lang('global.ProfileAndSettings') <small></small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label">
                                Account Type
                            </label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="m-option m-option--plain">
                                            <span class="m-option__control">
                                                <span class="m-radio m-radio--brand">
                                                    <input type="radio" name="m_option_1" value="1">
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="m-option__label">
                                                <span class="m-option__head">
                                                    <span class="m-option__title">
                                                        @lang('global.Accountant')
                                                    </span>
                                                </span>
                                                <span class="m-option__body">
                                                    @lang('global.AccountantDesc')
                                                    <hr>
                                                    <ul>
                                                        <li class="m--font-info">@lang('global.ViewData', ['module' => __('global.Commercial')])</li>
                                                        <li class="m--font-info">@lang('global.ManageData', ['module' => __('global.Commercial')])</li>
                                                        <li class="m--font-info">@lang('global.ViewData', ['module' => __('accounting.Accounting')])</li>
                                                        <li class="m--font-info">@lang('global.ManageData', ['module' => __('accounting.Accounting')])</li>
                                                        <li class="m--font-info">@lang('global.Post', ['module' => __('global.Comment')])</li>
                                                        <li class="m--font-danger">@lang('global.AuditorPlatform') <small>[@lang('SpecialReport_KPI')]</small></li>
                                                    </ul>
                                                </span>
                                            </span>

                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="m-option m-option--plain">
                                            <span class="m-option__control">
                                                <span class="m-radio m-radio--brand">
                                                    <input type="radio" name="m_option_1" value="1">
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="m-option__label">
                                                <span class="m-option__head">
                                                    <span class="m-option__title">
                                                        @lang('global.Personal')
                                                    </span>
                                                </span>
                                                <span class="m-option__body">
                                                    @lang('global.PersonalDesc')
                                                    <hr>
                                                    <ul>
                                                        <li class="m--font-info">@lang('global.ViewData', ['module' => __('global.Commercial')])</li>
                                                        <li class="m--font-info">@lang('global.ManageData', ['module' => __('global.Commercial')])</li>
                                                        <li class="m--font-info">@lang('global.ViewData', ['module' => __('accounting.Accounting')])</li>
                                                        <li class="m--font-danger">@lang('global.ManageData', ['module' => __('accounting.Accounting')])</li>
                                                        <li class="m--font-info">@lang('global.Post', ['module' => __('global.Comment')])</li>
                                                        <li class="m--font-danger">@lang('global.AuditorPlatform') <small>[@lang('SpecialReport_KPI')]</small></li>
                                                    </ul>
                                                </span>
                                            </span>

                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="m-option m-option--plain">
                                            <span class="m-option__control">
                                                <span class="m-radio m-radio--brand">
                                                    <input type="radio" name="m_option_1" value="1">
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="m-option__label">
                                                <span class="m-option__head">
                                                    <span class="m-option__title">
                                                        @lang('global.Auditor')
                                                    </span>
                                                </span>
                                                <span class="m-option__body">
                                                    @lang('global.AuditorDesc')
                                                    <hr>
                                                    <ul>
                                                        <li class="m--font-info">@lang('global.ViewData', ['module' => __('global.Commercial')])</li>
                                                        <li class="m--font-danger">@lang('global.ManageData', ['module' => __('global.Commercial')])</li>
                                                        <li class="m--font-info">@lang('global.ViewData', ['module' => __('accounting.Accounting')])</li>
                                                        <li class="m--font-danger">@lang('global.ManageData', ['module' => __('accounting.Accounting')])</li>
                                                        <li class="m--font-info">@lang('global.Post', ['module' => __('global.Comment')])</li>
                                                        <li class="m--font-info">@lang('global.AuditorPlatform') <small>[@lang('SpecialReport_KPI')]</small></li>
                                                    </ul>
                                                </span>
                                            </span>

                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </taxpayer>

@endsection
