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
                        <div class="m-portlet__padding-x">
                            <!-- Here you can put a message or alert -->
                        </div>

                        <div class="m-wizard__head m-portlet__padding-x">
                            <!--begin: Form Wizard Progress -->
                            <div class="m-wizard__progress">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: @{{ progBarPercent }};"></div>
                                </div>
                            </div>

                            <div class="m-wizard__nav">
                                <div class="m-wizard__steps">
                                    <div class="m-wizard__step m-wizard__step--current" data-wizard-target="#m_wizard_form_step_1">
                                        <a href="#" class="m-wizard__step-number">
                                            <span>
                                                <i class="la la-briefcase"></i>
                                            </span>
                                        </a>
                                        <div class="m-wizard__step-info">
                                            <div class="m-wizard__step-title">
                                                1. @lang('global.Taxpayer')
                                            </div>
                                            <div class="m-wizard__step-desc">
                                                All Taxpayer related information
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-wizard__step" data-wizard-target="#m_wizard_form_step_2">
                                        <a href="#" class="m-wizard__step-number">
                                            <span>
                                                <i class="la la-user"></i>
                                            </span>
                                        </a>
                                        <div class="m-wizard__step-info">
                                            <div class="m-wizard__step-title">
                                                2. @lang('global.ProfileSettings')
                                            </div>
                                            <div class="m-wizard__step-desc">
                                                All accounting information
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-wizard__step" data-wizard-target="#m_wizard_form_step_3">
                                        <a href="#" class="m-wizard__step-number">
                                            <span>
                                                <i class="la la-check"></i>
                                            </span>
                                        </a>
                                        <div class="m-wizard__step-info">
                                            <div class="m-wizard__step-title">
                                                3. @lang('global.Confirmation')
                                            </div>
                                            <div class="m-wizard__step-desc">
                                                Check data and save.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Nav -->
                        </div>

                        <div class="m-wizard__form">

                            <form class="m-form m-form--label-align-left- m-form--state-" id="m_form" novalidate="novalidate">
                                <!--begin: Form Body -->
                                <div class="m-portlet__body">
                                    <!--begin: Form Wizard Step 1-->
                                    <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                                        <div class="row">
                                            <div class="col-xl-10 offset-xl-2">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">
                                                            @lang('global.Taxpayer')
                                                        </h3>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                                            @lang('global.Taxid')
                                                        </label>
                                                        <div class="col-xl-9 col-lg-9">
                                                            <input type="text" name="name" class="form-control m-input" placeholder="" v-model="taxid">
                                                            <span class="m-form__help">
                                                                RUC or something similar
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                                            @lang('global.Name')
                                                        </label>
                                                        <div class="col-xl-9 col-lg-9">
                                                            <input type="email" name="email" class="form-control m-input" placeholder="" v-model="name">
                                                            <span class="m-form__help">
                                                                Taxpayer Name
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                                            @lang('global.Alias')
                                                        </label>
                                                        <div class="col-xl-9 col-lg-9">
                                                            <input type="text" class="form-control m-input" v-model="alias">

                                                            <span class="m-form__help">
                                                                Simple name to help remember the Taxpayer
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

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

                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <div class="m-form__section">
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">
                                                            @lang('global.ContactInformation')
                                                            <i data-toggle="m-tooltip" data-width="auto" class="m-form__heading-help-icon flaticon-info" title="" data-original-title="Some help text goes here"></i>
                                                        </h3>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                                            @lang('global.Email')
                                                        </label>
                                                        <div class="col-xl-9 col-lg-9">
                                                            <input type="text" class="form-control m-input" placeholder="" v-model="telephone">
                                                            <span class="m-form__help">

                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                                            @lang('global.Telephone')
                                                        </label>
                                                        <div class="col-xl-9 col-lg-9">
                                                            <input type="text" class="form-control m-input" placeholder="" v-model="email">
                                                            <span class="m-form__help">

                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                                            @lang('global.Address')
                                                        </label>
                                                        <div class="col-xl-9 col-lg-9">
                                                            <textarea class="form-control m-input" rows="3" v-model="address"></textarea>
                                                            <span class="m-form__help">
                                                                Address, City, and State if applicable
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group m-form__group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                                            @lang('global.Country')
                                                        </label>
                                                        <div class="col-xl-9 col-lg-9">
                                                            <select class="form-control">
                                                                {{-- {{ $countries->all()->pluck('name.common') }} --}}
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Step 1-->
                                    <!--begin: Form Wizard Step 2-->
                                    <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                                        <div class="row">
                                            <div class="col-xl-8 offset-xl-2">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">
                                                            Account Details
                                                        </h3>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">
                                                                * URL:
                                                            </label>
                                                            <input type="url" name="account_url" class="form-control m-input" placeholder="" value="http://sinortech.vertoffice.com">
                                                            <span class="m-form__help">
                                                                Please enter your preferred URL  to your dashboard
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-6 m-form__group-sub">
                                                            <label class="form-control-label">
                                                                * Username:
                                                            </label>
                                                            <input type="text" name="account_username" class="form-control m-input" placeholder="" value="nick.stone">
                                                            <span class="m-form__help">
                                                                Your username to login to your dashboard
                                                            </span>
                                                        </div>
                                                        <div class="col-lg-6 m-form__group-sub">
                                                            <label class="form-control-label">
                                                                * Password:
                                                            </label>
                                                            <input type="password" name="account_password" class="form-control m-input" placeholder="" value="qwerty">
                                                            <span class="m-form__help">
                                                                Please use letters and at least one number and symbol
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <div class="m-form__section">
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">
                                                            Client Settings
                                                        </h3>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-6 m-form__group-sub">
                                                            <label class="form-control-label">
                                                                * User Group:
                                                            </label>
                                                            <div class="m-radio-inline">
                                                                <label class="m-radio m-radio--solid m-radio--brand">
                                                                    <input type="radio" name="account_group" checked="" value="2">
                                                                    Sales Person
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-radio m-radio--solid m-radio--brand">
                                                                    <input type="radio" name="account_group" value="2">
                                                                    Customer
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                            <span class="m-form__help">
                                                                Please select user group
                                                            </span>
                                                        </div>
                                                        <div class="col-lg-6 m-form__group-sub">
                                                            <label class="form-control-label">
                                                                * Communications:
                                                            </label>
                                                            <div class="m-checkbox-inline">
                                                                <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                                    <input type="checkbox" name="account_communication[]" checked="" value="email">
                                                                    Email
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-checkbox m-checkbox--solid  m-checkbox--brand">
                                                                    <input type="checkbox" name="account_communication[]" value="sms">
                                                                    SMS
                                                                    <span></span>
                                                                </label>
                                                                <label class="m-checkbox m-checkbox--solid  m-checkbox--brand">
                                                                    <input type="checkbox" name="account_communication[]" value="phone">
                                                                    Phone
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                            <span class="m-form__help">
                                                                Please select user communication options
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Step 2-->
                                    <!--begin: Form Wizard Step 3-->
                                    <div class="m-wizard__form-step" id="m_wizard_form_step_3">
                                        <div class="row">
                                            <div class="col-xl-8 offset-xl-2">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">
                                                            Billing Information
                                                        </h3>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">
                                                                * Cardholder Name:
                                                            </label>
                                                            <input type="text" name="billing_card_name" class="form-control m-input" placeholder="" value="Nick Stone">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">
                                                                * Card Number:
                                                            </label>
                                                            <input type="text" name="billing_card_number" class="form-control m-input" placeholder="" value="372955886840581">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-4 m-form__group-sub">
                                                            <label class="form-control-label">
                                                                * Exp Month:
                                                            </label>
                                                            <select class="form-control m-input" name="billing_card_exp_month">
                                                                <option value="">
                                                                    Select
                                                                </option>
                                                                <option value="01">
                                                                    01
                                                                </option>
                                                                <option value="02">
                                                                    02
                                                                </option>
                                                                <option value="03">
                                                                    03
                                                                </option>
                                                                <option value="04" selected="">
                                                                    04
                                                                </option>
                                                                <option value="05">
                                                                    05
                                                                </option>
                                                                <option value="06">
                                                                    06
                                                                </option>
                                                                <option value="07">
                                                                    07
                                                                </option>
                                                                <option value="08">
                                                                    08
                                                                </option>
                                                                <option value="09">
                                                                    09
                                                                </option>
                                                                <option value="10">
                                                                    10
                                                                </option>
                                                                <option value="11">
                                                                    11
                                                                </option>
                                                                <option value="12">
                                                                    12
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-4 m-form__group-sub">
                                                            <label class="form-control-label">
                                                                * Exp Year:
                                                            </label>
                                                            <select class="form-control m-input" name="billing_card_exp_year">
                                                                <option value="">
                                                                    Select
                                                                </option>
                                                                <option value="2018">
                                                                    2018
                                                                </option>
                                                                <option value="2019">
                                                                    2019
                                                                </option>
                                                                <option value="2020">
                                                                    2020
                                                                </option>
                                                                <option value="2021" selected="">
                                                                    2021
                                                                </option>
                                                                <option value="2022">
                                                                    2022
                                                                </option>
                                                                <option value="2023">
                                                                    2023
                                                                </option>
                                                                <option value="2024">
                                                                    2024
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-4 m-form__group-sub">
                                                            <label class="form-control-label">
                                                                * CVV:
                                                            </label>
                                                            <input type="number" class="form-control m-input" name="billing_card_cvv" placeholder="" value="450">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <div class="m-form__section">
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">
                                                            Billing Address
                                                            <i data-toggle="m-tooltip" data-width="auto" class="m-form__heading-help-icon flaticon-info" title="" data-original-title="If different than the corresponding address"></i>
                                                        </h3>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">
                                                                * Address 1:
                                                            </label>
                                                            <input type="text" name="billing_address_1" class="form-control m-input" placeholder="" value="Headquarters 1120 N Street Sacramento 916-654-5266">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">
                                                                Address 2:
                                                            </label>
                                                            <input type="text" name="billing_address_2" class="form-control m-input" placeholder="" value="P.O. Box 942873 Sacramento, CA 94273-0001">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-5 m-form__group-sub">
                                                            <label class="form-control-label">
                                                                * City:
                                                            </label>
                                                            <input type="text" class="form-control m-input" name="billing_city" placeholder="" value="Polo Alto">
                                                        </div>
                                                        <div class="col-lg-5 m-form__group-sub">
                                                            <label class="form-control-label">
                                                                * State:
                                                            </label>
                                                            <input type="text" class="form-control m-input" name="billing_state" placeholder="" value="California">
                                                        </div>
                                                        <div class="col-lg-2 m-form__group-sub">
                                                            <label class="form-control-label">
                                                                * ZIP:
                                                            </label>
                                                            <input type="text" class="form-control m-input" name="billing_zip" placeholder="" value="34890">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <div class="m-form__section">
                                                    <div class="m-form__heading">
                                                        <h3 class="m-form__heading-title">
                                                            Delivery Type
                                                        </h3>
                                                    </div>
                                                    <div class="form-group m-form__group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label class="m-option">
                                                                    <span class="m-option__control">
                                                                        <span class="m-radio m-radio--state-brand">
                                                                            <input type="radio" name="billing_delivery" value="">
                                                                            <span></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="m-option__label">
                                                                        <span class="m-option__head">
                                                                            <span class="m-option__title">
                                                                                Standart Delevery
                                                                            </span>
                                                                            <span class="m-option__focus">
                                                                                Free
                                                                            </span>
                                                                        </span>
                                                                        <span class="m-option__body">
                                                                            Estimated 14-20 Day Shipping
                                                                            (&nbsp;Duties end taxes may be due
                                                                            upon delivery&nbsp;)
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="m-option">
                                                                    <span class="m-option__control">
                                                                        <span class="m-radio m-radio--state-brand">
                                                                            <input type="radio" name="billing_delivery" value="">
                                                                            <span></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="m-option__label">
                                                                        <span class="m-option__head">
                                                                            <span class="m-option__title">
                                                                                Fast Delevery
                                                                            </span>
                                                                            <span class="m-option__focus">
                                                                                $&nbsp;8.00
                                                                            </span>
                                                                        </span>
                                                                        <span class="m-option__body">
                                                                            Estimated 2-5 Day Shipping
                                                                            (&nbsp;Duties end taxes may be due
                                                                            upon delivery&nbsp;)
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="m-form__help">
                                                            <!--must use this helper element to display error message for the options-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Step 3-->
                                    <!--begin: Form Wizard Step 4-->
                                    <div class="m-wizard__form-step" id="m_wizard_form_step_4">
                                        <div class="row">
                                            <div class="col-xl-8 offset-xl-2">
                                                <!--begin::Section-->
                                                <div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">
                                                    <!--begin::Item-->
                                                    <div class="m-accordion__item active">
                                                        <div class="m-accordion__item-head" role="tab" id="m_accordion_1_item_1_head" data-toggle="collapse" href="#m_accordion_1_item_1_body" aria-expanded="  false">
                                                            <span class="m-accordion__item-icon">
                                                                <i class="fa flaticon-user-ok"></i>
                                                            </span>
                                                            <span class="m-accordion__item-title">
                                                                1. Client Information
                                                            </span>
                                                            <span class="m-accordion__item-mode"></span>
                                                        </div>
                                                        <div class="m-accordion__item-body collapse show" id="m_accordion_1_item_1_body" role="tabpanel" aria-labelledby="m_accordion_1_item_1_head" data-parent="#m_accordion_1">
                                                            <!--begin::Content-->
                                                            <div class="tab-content  m--padding-30">
                                                                <div class="m-form__section m-form__section--first">
                                                                    <div class="m-form__heading">
                                                                        <h4 class="m-form__heading-title">
                                                                            Account Details
                                                                        </h4>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            URL:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                sinortech.vertoffice.com
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Username:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                sinortech.admin
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Password:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                *********
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                                <div class="m-form__section">
                                                                    <div class="m-form__heading">
                                                                        <h4 class="m-form__heading-title">
                                                                            Client Settings
                                                                        </h4>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            User Group:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                Customer
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Communications:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                Phone, Email
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Item-->
                                                    <div class="m-accordion__item">
                                                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_2_head" data-toggle="collapse" href="#m_accordion_1_item_2_body" aria-expanded="    false">
                                                            <span class="m-accordion__item-icon">
                                                                <i class="fa  flaticon-placeholder"></i>
                                                            </span>
                                                            <span class="m-accordion__item-title">
                                                                2. Account Setup
                                                            </span>
                                                            <span class="m-accordion__item-mode"></span>
                                                        </div>
                                                        <div class="m-accordion__item-body collapse" id="m_accordion_1_item_2_body" role="tabpanel" aria-labelledby="m_accordion_1_item_2_head" data-parent="#m_accordion_1">
                                                            <!--begin::Content-->
                                                            <div class="tab-content  m--padding-30">
                                                                <div class="m-form__section m-form__section--first">
                                                                    <div class="m-form__heading">
                                                                        <h4 class="m-form__heading-title">
                                                                            Account Details
                                                                        </h4>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            URL:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                sinortech.vertoffice.com
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Username:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                sinortech.admin
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Password:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                *********
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                                <div class="m-form__section">
                                                                    <div class="m-form__heading">
                                                                        <h4 class="m-form__heading-title">
                                                                            Client Settings
                                                                        </h4>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            User Group:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                Customer
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Communications:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                Phone, Email
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Item-->
                                                    <div class="m-accordion__item">
                                                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_3_head" data-toggle="collapse" href="#m_accordion_1_item_3_body" aria-expanded="    false">
                                                            <span class="m-accordion__item-icon">
                                                                <i class="fa  flaticon-alert-2"></i>
                                                            </span>
                                                            <span class="m-accordion__item-title">
                                                                3. Billing Setup
                                                            </span>
                                                            <span class="m-accordion__item-mode"></span>
                                                        </div>
                                                        <div class="m-accordion__item-body collapse" id="m_accordion_1_item_3_body" role="tabpanel" aria-labelledby="m_accordion_1_item_3_head" data-parent="#m_accordion_1">
                                                            <div class="tab-content  m--padding-30">
                                                                <div class="m-form__section m-form__section--first">
                                                                    <div class="m-form__heading">
                                                                        <h4 class="m-form__heading-title">
                                                                            Billing Information
                                                                        </h4>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Cardholder Name:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                Nick Stone
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Card Number:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                *************4589
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Exp Month:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                10
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Exp Year:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                2018
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            CVV:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                ***
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                                <div class="m-form__section">
                                                                    <div class="m-form__heading">
                                                                        <h4 class="m-form__heading-title">
                                                                            Billing Address
                                                                        </h4>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Address Line 1:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                Headquarters 1120 N Street Sacramento 916-654-5266
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Address Line 2:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                P.O. Box 942873 Sacramento, CA 94273-0001
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            City:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                Polo Alto
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            State:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                California
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            ZIP:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                37505
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group m-form__group--sm row">
                                                                        <label class="col-xl-4 col-lg-4 col-form-label">
                                                                            Country:
                                                                        </label>
                                                                        <div class="col-xl-8 col-lg-8">
                                                                            <span class="m-form__control-static">
                                                                                USA
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Item-->
                                                </div>
                                                <!--end::Section-->
                                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                <div class="form-group m-form__group m-form__group--sm row">
                                                    <div class="col-xl-12">
                                                        <div class="m-checkbox-inline">
                                                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                                <input type="checkbox" name="accept" value="1">
                                                                Click here to indicate that you have read and agree to the terms presented in the Terms and Conditions agreement
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Form Wizard Step 4-->
                                </div>
                                <!--end: Form Body -->
                                <!--begin: Form Actions -->
                                <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
                                    <div class="m-form__actions m-form__actions">
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-4 m--align-left">
                                                <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
                                                    <span>
                                                        <i class="la la-arrow-left"></i>
                                                        &nbsp;&nbsp;
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
                                                <a href="#" class="btn btn-warning m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
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
                            <h2 class="m-section__heading">
                                Benifits Of Joining
                            </h2>
                            <div class="m-section__content">
                                <p>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                </p>
                                <p>
                                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                    It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                </p>
                            </div>
                        </div>
                        <div class="m-separator m-separator--fit"></div>
                        <div class="m-widget1 m-widget1--paddingless">
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            Member Profit
                                        </h3>
                                        <span class="m-widget1__desc">
                                            Awerage Weekly Profit
                                        </span>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                            +$17,800
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            Orders
                                        </h3>
                                        <span class="m-widget1__desc">
                                            Weekly Customer Orders
                                        </span>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-danger">
                                            +1,800
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">
                                            Issue Reports
                                        </h3>
                                        <span class="m-widget1__desc">
                                            System bugs and issues
                                        </span>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-success">
                                            -27,49%
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--end: Form Wizard Step 4-->
                        </div>
                        <!--end: Form Body -->
                    </div>
                </div>
            </div>
        </div>

















        {{--

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
</form> --}}
</taxpayer>

@endsection
