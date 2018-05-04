@extends('spark::layouts.app')

@section('title', __('global.Create', ['model' => __('global.Taxpayer')]))

@section('content')
    <taxpayer inline-template>
        <div class="row">
            <div class="col-xl-9">
                <!--Begin::Main Portlet-->
                <div class="m-portlet">
                    <!--begin: Portlet Head-->
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    @lang('global.Create', ['model' => __('global.Taxpayer')])
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="#" data-toggle="m-tooltip" class="m-portlet__nav-link m-portlet__nav-link--icon" data-direction="left" data-width="auto" title="" data-original-title="Get help with filling up this form">
                                        <i class="flaticon-info m--icon-font-size-lg3"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="m-wizard m-wizard--2 m-wizard--success m-wizard--step-first" id="m_wizard">
                        <div class="m-wizard__head m-portlet__padding-x">
                            <!--begin: Form Wizard Progress -->
                            <div class="m-wizard__progress">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: @{{ pageProg }}%"></div>
                                </div>
                            </div>
                            <div class="m-wizard__nav">
                                <div class="m-wizard__steps">
                                    <div class="m-wizard__step m-wizard__step--current" data-wizard-target="#m_wizard_form_step_1" v-if="page == 1">
                                        <a @click="page = 1" href="#" class="m-wizard__step-number">
                                            <span>
                                                <i class="la la-briefcase"></i>
                                            </span>
                                        </a>
                                        <div class="m-wizard__step-info">
                                            <div class="m-wizard__step-title">
                                                @lang('global.Taxpayer')
                                            </div>
                                            <div class="m-wizard__step-desc">
                                                All Taxpayer related information
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-wizard__step m-wizard__step--done" data-wizard-target="#m_wizard_form_step_1" v-else>
                                        <a @click="page = 1" href="#" class="m-wizard__step-number">
                                            <span>
                                                <i class="la la-briefcase"></i>
                                            </span>
                                        </a>
                                        <div class="m-wizard__step-info">
                                            <div class="m-wizard__step-title">
                                                @lang('global.Taxpayer')
                                            </div>
                                            <div class="m-wizard__step-desc">
                                                All Taxpayer related information
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-wizard__step m-wizard__step--current" data-wizard-target="#m_wizard_form_step_2" v-if="owner_name == '' && page == 2">
                                        <a @click="page = 2" href="#" class="m-wizard__step-number">
                                            <span>
                                                <i class="la la-gear"></i>
                                            </span>
                                        </a>
                                        <div class="m-wizard__step-info">
                                            <div class="m-wizard__step-title">
                                                @lang('global.Settings')
                                            </div>
                                            <div class="m-wizard__step-desc">
                                                All accounting information
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-wizard__step m-wizard__step--done" data-wizard-target="#m_wizard_form_step_2" v-else-if="owner_name == '' && page > 2">
                                        <a @click="page = 2" href="#" class="m-wizard__step-number">
                                            <span>
                                                <i class="la la-gear"></i>
                                            </span>
                                        </a>
                                        <div class="m-wizard__step-info">
                                            <div class="m-wizard__step-title">
                                                @lang('global.Settings')
                                            </div>
                                            <div class="m-wizard__step-desc">
                                                All accounting information
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-wizard__step" data-wizard-target="#m_wizard_form_step_2" v-else>
                                        <a @click="page = 2" href="#" class="m-wizard__step-number">
                                            <span>
                                                <i class="la la-gear"></i>
                                            </span>
                                        </a>
                                        <div class="m-wizard__step-info">
                                            <div class="m-wizard__step-title">
                                                @lang('global.Settings')
                                            </div>
                                            <div class="m-wizard__step-desc">
                                                All accounting information
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-wizard__step m-wizard__step--current" data-wizard-target="#m_wizard_form_step_3" v-if="page == 3">
                                        <a @click="page = 3" href="#" class="m-wizard__step-number">
                                            <span>
                                                <i class="la la-check"></i>
                                            </span>
                                        </a>
                                        <div class="m-wizard__step-info">
                                            <div class="m-wizard__step-title">
                                                @lang('global.Confirmation')
                                            </div>
                                            <div class="m-wizard__step-desc">
                                                Check data and save.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-wizard__step" data-wizard-target="#m_wizard_form_step_3" v-else>
                                        <a @click="page = 3" href="#" class="m-wizard__step-number">
                                            <span>
                                                <i class="la la-check"></i>
                                            </span>
                                        </a>
                                        <div class="m-wizard__step-info">
                                            <div class="m-wizard__step-title">
                                                @lang('global.Confirmation')
                                            </div>
                                            <div class="m-wizard__step-desc">
                                                Check data and save.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-wizard__form">
                            <form class="m-form m-form--label-align-left- m-form--state-" id="m_form" novalidate="novalidate">
                                <div class="m-portlet__body">
                                    <div class="m-wizard__form-step m-wizard__form-step--current" v-if="page == 1">
                                        <div class="row">
                                            <div class="col-xl-11 offset-xl-1">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="m-form__heading">
                                                        <h3>
                                                            @lang('global.Create', ['model' => __('global.Taxpayer')])
                                                        </h3>
                                                    </div>
                                                    <div class="form-group m-form__group">
                                                        <div class="row">
                                                            <div class="col-11">
                                                                <div class="alert m-alert m-alert--default" role="alert">
                                                                    Search for your taxpayer by name or identification number. In case you can't find it in our database ...
                                                                    <a @click="clearPage()" href="#taxpayer">
                                                                        @lang('global.Create', ['model' => __('global.Taxpayer')]).
                                                                    </a>
                                                                </div>

                                                                <router-view name="SearchBoxTaxPayer" country="PRY">
                                                                </router-view>

                                                            </div>
                                                        </div>

                                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>

                                                        <div class="m-form__heading">
                                                            <h3 class="m-form__heading-title">
                                                                <i class="la la-briefcase"></i>
                                                                @lang('global.Taxpayer')
                                                            </h3>
                                                        </div>

                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                <a id="taxpayer"></a>
                                                                @lang('global.Taxid')
                                                            </label>
                                                            <div class="col-7">
                                                                <input v-if="id == 0" type="text" class="form-control m-input" v-model="taxid">
                                                                <input v-else disabled="disabled" class="form-control m-input" v-model="taxid">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                @lang('global.NameOf', ['model' => __('global.Taxpayer')])
                                                            </label>
                                                            <div class="col-7">
                                                                <input v-if="id == 0" type="text" class="form-control m-input" v-model="name">
                                                                <input v-else disabled="disabled" class="form-control m-input" v-model="name">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                @lang('global.Alias')
                                                            </label>
                                                            <div class="col-7">
                                                                <input type="text" class="form-control m-input" v-model="alias">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group">

                                                        <div class="m-form__heading">
                                                            <h3 class="m-form__heading-title">
                                                                <i class="la la-phone"></i>
                                                                @lang('global.ContactData')
                                                            </h3>
                                                        </div>

                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                @lang('global.Telephone')
                                                            </label>
                                                            <div class="col-7">
                                                                <input type="text" class="form-control m-input" v-model="telephone">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                @lang('global.Email')
                                                            </label>
                                                            <div class="col-7">
                                                                <input type="email" class="form-control m-input" v-model="email">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                @lang('global.Address')
                                                            </label>
                                                            <div class="col-7">
                                                                <textarea class="form-control m-input" v-model="address" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-wizard__form-step m-wizard__form-step--current" v-if="page == 2">
                                        <div class="row">
                                            <div class="col-xl-11 offset-xl-1">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="m-form__heading">
                                                        <h2>
                                                            @lang('global.ProfileAndSettings')
                                                        </h2>
                                                    </div>
                                                    <div class="form-group m-form__group">

                                                        <h4 class="m--font-info">
                                                            <i class="la la-user"></i>
                                                            @lang('global.Profile')
                                                        </h4>

                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                @lang('global.IsCompany')
                                                            </label>
                                                            <div class="col-7">
                                                                <span class="m-switch m-switch--sm m-switch--icon">
                                                                    <label>
                                                                        <input type="checkbox" checked="checked" v-model="setting_is_company" @click="isCompany">
                                                                        <span></span>
                                                                    </label>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                @lang('global.LegalRepresentative')
                                                            </label>
                                                            <div class="col-7">
                                                                <input v-if="setting_is_company" type="text" class="form-control m-input" v-model="setting_agent">
                                                                <input v-else disabled="disabled" class="form-control m-input" v-model="setting_agent">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                @lang('global.Taxid')
                                                            </label>
                                                            <div class="col-7">
                                                                <input v-if="setting_is_company" type="text" class="form-control m-input" v-model="setting_agenttaxid">
                                                                <input v-else disabled="disabled" class="form-control m-input" v-model="setting_agenttaxid">
                                                            </div>
                                                        </div>

                                                        <div class="m-separator m-separator--dashed"></div>

                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                @lang('accounting.Regime')
                                                            </label>
                                                            <div v-if="setting_is_company" class="col-7">
                                                                <label class="m-radio m-radio--solid m-radio--warning">
                                                                    <input type="radio" name="account_group" checked="" value="" v-model="setting_regime">
                                                                    None
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio m-radio--solid m-radio--info">
                                                                    <input type="radio" name="account_group" value="1" v-model="setting_regime">
                                                                    Turismo
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio m-radio--solid m-radio--info">
                                                                    <input type="radio" name="account_group" value="2" v-model="setting_regime">
                                                                    Materia Prima
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio m-radio--solid m-radio--info">
                                                                    <input type="radio" name="account_group" value="3" v-model="setting_regime">
                                                                    Maquila
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio m-radio--solid m-radio--info">
                                                                    <input type="radio" name="account_group" value="4" v-model="setting_regime">
                                                                    Admision Temporania
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                            <div v-else class="col-7">
                                                                <label class="m-radio m-radio--solid m-radio--warning m-radio--disabled">
                                                                    <input type="radio" disabled name="account_group" checked="" value="" v-model="setting_regime">
                                                                    None
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio m-radio--solid m-radio--info m-radio--disabled">
                                                                    <input type="radio" disabled name="account_group" value="1" v-model="setting_regime">
                                                                    Turismo
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio m-radio--solid m-radio--info m-radio--disabled">
                                                                    <input type="radio" disabled name="account_group" value="2" v-model="setting_regime">
                                                                    Materia Prima
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio m-radio--solid m-radio--info m-radio--disabled">
                                                                    <input type="radio" disabled name="account_group" value="3" v-model="setting_regime">
                                                                    Maquila
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio m-radio--solid m-radio--info m-radio--disabled">
                                                                    <input type="radio" disabled name="account_group" value="4" v-model="setting_regime">
                                                                    Admision Temporania
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group">

                                                        <h4 class="m--font-info">
                                                            <i class="la la-gear"></i>
                                                            @lang('global.Settings')
                                                        </h4>

                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                @lang('global.Modules')
                                                            </label>
                                                            <div class="m-checkbox-list col-7">
                                                                <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-success" v-model="setting_fixedasset">
                                                                    <input type="checkbox" v-model="setting_fixedasset">
                                                                    @lang('commercial.FixedAssets')
                                                                    <span></span>
                                                                </label>
                                                                <label v-if="setting_is_company" class="m-checkbox m-checkbox--check-bold m-checkbox--state-success" v-model="setting_inventory">
                                                                    <input type="checkbox" v-model="setting_inventory">
                                                                    @lang('commercial.Inventory')
                                                                    <span></span>
                                                                </label>
                                                                <label v-else class="m-checkbox m-checkbox--check-bold m-checkbox--state-success m-checkbox--disabled" v-model="setting_inventory">
                                                                    <input disabled type="checkbox" v-model="setting_inventory">
                                                                    @lang('commercial.Inventory')
                                                                    <span></span>
                                                                </label>
                                                                <label v-if="setting_is_company" class="m-checkbox m-checkbox--check-bold m-checkbox--state-success" v-model="setting_production">
                                                                    <input type="checkbox" v-model="setting_production">
                                                                    @lang('commercial.Productions')
                                                                    <span></span>
                                                                </label>
                                                                <label v-else class="m-checkbox m-checkbox--check-bold m-checkbox--state-success m-checkbox--disabled" v-model="setting_production">
                                                                    <input disabled type="checkbox" v-model="setting_production">
                                                                    @lang('commercial.Productions')
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="m-separator m-separator--dashed m-separator--lg"></div> --}}

                                                        <div class="row">
                                                            <label class="col-4 col-form-label">
                                                                @lang('commercial.InternationalCommerce')
                                                            </label>
                                                            <div class="m-checkbox-list col-7">
                                                                <label v-if="setting_is_company" class="m-checkbox m-checkbox--check-bold m-checkbox--state-brand" v-model="setting_production">
                                                                    <input type="checkbox" v-model="setting_import">
                                                                    @lang('commercial.Imports')
                                                                    <span></span>
                                                                </label>
                                                                <label v-else class="m-checkbox m-checkbox--check-bold m-checkbox--state-brand m-checkbox--disabled" v-model="setting_production">
                                                                    <input disabled type="checkbox" v-model="setting_import">
                                                                    @lang('commercial.Imports')
                                                                    <span></span>
                                                                </label>
                                                                <label v-if="setting_is_company" class="m-checkbox m-checkbox--check-bold m-checkbox--state-brand" v-model="setting_production">
                                                                    <input type="checkbox" v-model="setting_export">
                                                                    @lang('commercial.Exports')
                                                                    <span></span>
                                                                </label>
                                                                <label v-else class="m-checkbox m-checkbox--check-bold m-checkbox--state-brand m-checkbox--disabled" v-model="setting_production">
                                                                    <input disabled type="checkbox" v-model="setting_export">
                                                                    @lang('commercial.Exports')
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-wizard__form-step m-wizard__form-step--current" v-if="page == 3">
                                        <div class="row">
                                            <div class="col-11 offset-xl-1">
                                                <div class="form-group m-form__group row">
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">
                                                            @lang('global.AccountType')
                                                        </h3>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <label class="m-option m-option--plain">
                                                                    <span class="m-option__control">
                                                                        <span class="m-radio m-radio--brand">
                                                                            <input type="radio" name="m_option_1" value="1" v-model="type">
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
                                                                            <input type="radio" name="m_option_1" value="2" v-model="type">
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
                                                                                <li class="m--font-info"> @lang('global.ViewData', ['module' => __('global.Commercial')]) </li>
                                                                                <li class="m--font-info"> @lang('global.ManageData', ['module' => __('global.Commercial')]) </li>
                                                                                <li class="m--font-info"> @lang('global.ViewData', ['module' => __('accounting.Accounting')]) </li>
                                                                                <li class="m--font-danger"> @lang('global.ManageData', ['module' => __('accounting.Accounting')]) </li>
                                                                                <li class="m--font-info"> @lang('global.Post', ['module' => __('global.Comment')]) </li>
                                                                                <li class="m--font-danger"> @lang('global.AuditorPlatform') <small>[@lang('SpecialReport_KPI')] </small></li>
                                                                            </ul>
                                                                        </span>
                                                                    </span>

                                                                </label>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <label class="m-option m-option--plain">
                                                                    <span class="m-option__control">
                                                                        <span class="m-radio m-radio--brand">
                                                                            <input type="radio" name="m_option_1" value="3" v-model="type">
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
                                </div>

                                <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
                                    <div class="m-form__actions m-form__actions">
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-4 m--align-left">
                                                <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
                                                    <span>
                                                        <i class="la la-arrow-left"></i>
                                                        &nbsp; &nbsp;
                                                        <span>
                                                            Back
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 m--align-right">
                                                <a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
                                                    <span>
                                                        <i class="la la-check"></i>
                                                        &nbsp;&nbsp;
                                                        <span>
                                                            Submit
                                                        </span>
                                                    </span>
                                                </a>
                                                <a v-on:click="nextPage($data)" class="btn btn-warning m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
                                                    <span>
                                                        <span>
                                                            Save &amp; Continue
                                                        </span>
                                                        &nbsp;&nbsp;
                                                        <i class="la la-arrow-right"></i>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Actions -->
                            </form>
                        </div>
                        <!--end: Form Wizard Form-->
                    </div>
                    <!--end: Form Wizard-->
                </div>
                <!--End::Main Portlet-->
            </div>
            <div class="col-xl-3">
                <div class="m-portlet">
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <h3 class="m-widget1__title">
                                @lang('global.Taxpayer')
                            </h3>

                            <div class="m-section__content">
                                <p>
                                    Once you create a taxpayer, if your team is the first to reference it, then you will become the default owner. In case another team previously owns it, then you will have to wait authorization.
                                </p>
                            </div>
                        </div>

                        <div class="m-separator m-separator--fit"></div>

                        <div class="m-widget6">
                            <div class="m-widget6__body">

                                <div class="m-widget6__item">
                                    <span v-if="name != ''" class="m-widget6__text">
                                        @{{ name }}
                                    </span>
                                    <span v-else class="m-widget6__text">
                                        Search or Create a Taxpayer
                                    </span>
                                    <span v-if="taxid != ''" class="m-widget6__text m--align-right m--font-boldest m--font-success">
                                        <i class="la la-check-circle"></i>
                                    </span>
                                    <span v-else class="m-widget6__text m--align-right m--font-boldest m--font-danger">
                                        <i class="la la-times-circle"></i>
                                    </span>
                                </div>

                                <div class="m-widget6__item">
                                    <span v-if="taxid != ''" class="m-widget6__text">
                                        @{{ taxid }}
                                    </span>
                                    <span v-else class="m-widget6__text">
                                        Search or Create a Taxpayer
                                    </span>
                                    <span v-if="taxid != ''" class="m-widget6__text m--align-right m--font-boldest m--font-success">
                                        <i class="la la-check-circle"></i>
                                    </span>
                                    <span v-else class="m-widget6__text m--align-right m--font-boldest m--font-danger">
                                        <i class="la la-times-circle"></i>
                                    </span>
                                </div>

                                <div class="m-widget6__item">
                                    <span v-if="owner_name != ''" class="m-widget6__text">
                                        @{{ owner_name }}
                                    </span>
                                    <span v-if="owner_name != ''" class="m-widget6__text">
                                        <div class="m-demo__preview m-demo__preview--badge">
                                            <span v-if="owner_type == '1'" class="m-badge m-badge--metal m-badge--wide m-badge--rounded">
                                                @lang('global.Accountant')
                                            </span>
                                            <span v-if="owner_type == '2'" class="m-badge m-badge--metal m-badge--wide m-badge--rounded">
                                                @lang('global.Personal')
                                            </span>
                                            <span v-if="owner_type == '3'" class="m-badge m-badge--metal m-badge--wide m-badge--rounded">
                                                @lang('global.Auditor')
                                            </span>
                                        </div>
                                    </span>
                                    <span v-else class="m-widget6__text">
                                        @{{ $parent.currentTeam.name }}
                                    </span>

                                    <span v-if="owner_name != ''" class="m-widget6__text m--align-right m--font-boldest m--font-warning">
                                        <i class="la la-warning"></i>
                                    </span>
                                    <span v-else class="m-widget6__text m--align-right m--font-boldest m--font-success">
                                        <i class="la la-check-circle"></i>
                                    </span>
                                </div>

                                <div class="m-widget6__item">
                                    <span class="m-widget6__text">
                                        @{{ $parent.currentTeam.name }}
                                    </span>
                                    <span class="m-widget6__text">
                                        <div class="m-demo__preview m-demo__preview--badge">
                                            <span v-if="type == '1'" class="m-badge m-badge--danger m-badge--wide m-badge--rounded">
                                                @lang('global.Accountant')
                                            </span>
                                            <span v-if="type == '2'" class="m-badge m-badge--brand m-badge--wide m-badge--rounded">
                                                @lang('global.Personal')
                                            </span>
                                            <span v-if="type == '3'" class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                                                @lang('global.Auditor')
                                            </span>
                                        </div>
                                    </span>

                                    <span v-if="type != ''" class="m-widget6__text m--align-right m--font-boldest m--font-success">
                                        <i class="la la-check-circle"></i>
                                    </span>

                                    <span v-else class="m-widget6__text m--align-right m--font-boldest m--font-danger">
                                        <i class="la la-times-circle"></i>
                                    </span>
                                </div>
                            </div>

                            <span v-if="owner_name != ''">
                                <i class="la la-warning m--font-warning"></i>
                                <p>
                                    It seems like another team has linked this taxpayer first. To access the accounting for this taxpayer, you will need to wait for authorization.
                                </p>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </taxpayer>

@endsection
