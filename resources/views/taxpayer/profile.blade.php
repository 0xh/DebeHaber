@extends('spark::layouts.app')

@section('title', __('global.Create', ['model' => __('global.Taxpayer')]))

@section('content')
    <taxpayer-integration :taxpayer="{{ $taxPayer }}" inline-template>
        <div class="row">
            <div class="col-xl-3">
                <div class="m-portlet">
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <h3 class="m-widget1__title">
                                @lang('global.Taxpayer')
                            </h3>
                        </div>

                        <div class="m-separator m-separator--fit"></div>

                        <div class="m-widget6">
                            <div class="m-widget6__body">
                                <div class="m-widget6__item">
                                    <span class="m-widget6__text">
                                        @{{ alias }}
                                    </span>
                                    <span class="m-widget6__text m--align-right m--font-boldest m--font-success">
                                        <i class="la la-check-circle"></i>
                                    </span>
                                </div>

                                <div class="m-widget6__item">
                                    <span class="m-widget6__text">
                                        @{{ taxid }}
                                    </span>
                                    <span class="m-widget6__text m--align-right m--font-boldest m--font-success">
                                        <i class="la la-check-circle"></i>
                                    </span>
                                </div>

                                <div class="m-widget6__item">
                                    <h6>@lang('global.Teams')</h6>

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

                                <div v-if="owner_name != ''" class="m-widget6__item">

                                    <span  class="m-widget6__text">
                                        @{{ owner_name }}
                                    </span>
                                    <span class="m-widget6__text">
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

                                    <span class="m-widget6__text m--align-right m--font-boldest m--font-warning">
                                        <i class="la la-warning"></i>
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
            <div class="col-xl-9">
                <!--Begin::Main Portlet-->
                <div class="m-portlet">
                    <b-tabs size="is-large" >
                        <b-tab-item label="Taxpayer">
                            <div class="m-portlet__body">
                                <div class="row">
                                    <div class="col-xl-11 offset-xl-1">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="form-group m-form__group">

                                                <div class="m-form__heading">
                                                    <h2>
                                                        <i class="la la-briefcase"></i>
                                                        @lang('global.Taxpayer')
                                                    </h2>
                                                </div>

                                                <div class="row">
                                                    <label class="col-4 col-form-label">
                                                        <a id="taxpayer"></a>
                                                        @lang('global.Taxid')
                                                    </label>
                                                    <div class="col-7">
                                                        <b-field>
                                                            <b-input v-model="taxid" disabled></b-input>
                                                        </b-field>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <label class="col-4 col-form-label">
                                                        @lang('global.NameOf', ['model' => __('global.Taxpayer')])
                                                    </label>
                                                    <div class="col-7">
                                                        <b-field>
                                                            <b-input v-model="name" disabled></b-input>
                                                        </b-field>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <label class="col-4 col-form-label">
                                                        @lang('global.Alias')
                                                    </label>
                                                    <div class="col-7">
                                                        <b-field>
                                                            <b-input v-model="alias" maxlength="32"></b-input>
                                                        </b-field>
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
                                                        <b-field>
                                                            <b-input v-model="telephone" maxlength="64"></b-input>
                                                        </b-field>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-4 col-form-label">
                                                        @lang('global.Email')
                                                    </label>
                                                    <div class="col-7">
                                                        <b-field>
                                                            <b-input type="email" maxlength="64" v-model="email"></b-input>
                                                        </b-field>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-4 col-form-label">
                                                        @lang('global.Address')
                                                    </label>
                                                    <div class="col-7">
                                                        <b-field>
                                                            <b-input type="textarea" minlength="10" maxlength="191" v-model="address"></b-input>
                                                        </b-field>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </b-tab-item>

                        <b-tab-item label="Settings">
                            <div class="m-portlet__body">
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
                                                        <label v-if="setting_is_company" class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                                                            <input type="checkbox" v-model="setting_fixedasset">
                                                            @lang('commercial.FixedAssets')
                                                            <span></span>
                                                        </label>
                                                        <label v-else class="m-checkbox m-checkbox--check-bold m-checkbox--state-success m-checkbox--disabled">
                                                            <input disabled type="checkbox" v-model="setting_fixedasset">
                                                            @lang('commercial.FixedAssets')
                                                            <span></span>
                                                        </label>
                                                        <label v-if="setting_is_company" class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                                                            <input type="checkbox" v-model="setting_inventory">
                                                            @lang('commercial.Inventory')
                                                            <span></span>
                                                        </label>
                                                        <label v-else class="m-checkbox m-checkbox--check-bold m-checkbox--state-success m-checkbox--disabled">
                                                            <input disabled type="checkbox" v-model="setting_inventory">
                                                            @lang('commercial.Inventory')
                                                            <span></span>
                                                        </label>
                                                        <label v-if="setting_is_company" class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                                                            <input type="checkbox" v-model="setting_production">
                                                            @lang('commercial.Productions')
                                                            <span></span>
                                                        </label>
                                                        <label v-else class="m-checkbox m-checkbox--check-bold m-checkbox--state-success m-checkbox--disabled">
                                                            <input disabled type="checkbox" v-model="setting_production">
                                                            @lang('commercial.Productions')
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <label class="col-4 col-form-label">
                                                        @lang('commercial.InternationalCommerce')
                                                    </label>
                                                    <div class="m-checkbox-list col-7">
                                                        <label v-if="setting_is_company" class="m-checkbox m-checkbox--check-bold m-checkbox--state-brand">
                                                            <input type="checkbox" v-model="setting_import">
                                                            @lang('commercial.Imports')
                                                            <span></span>
                                                        </label>
                                                        <label v-else class="m-checkbox m-checkbox--check-bold m-checkbox--state-brand m-checkbox--disabled">
                                                            <input disabled type="checkbox" v-model="setting_import">
                                                            @lang('commercial.Imports')
                                                            <span></span>
                                                        </label>
                                                        <label v-if="setting_is_company" class="m-checkbox m-checkbox--check-bold m-checkbox--state-brand">
                                                            <input type="checkbox" v-model="setting_export">
                                                            @lang('commercial.Exports')
                                                            <span></span>
                                                        </label>
                                                        <label v-else class="m-checkbox m-checkbox--check-bold m-checkbox--state-brand m-checkbox--disabled">
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
                        </b-tab-item>
                    </b-tabs>
                </div>
                <button v-on:click="onSave($data,false)" class="btn btn-primary">
                    Save
                </button>
                <!--End::Main Portlet-->
            </div>

        </div>
    </taxpayer-integration>
@endsection
