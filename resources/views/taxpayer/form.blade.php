@extends('spark::layouts.app')

@section('title', __('global.Create', ['model' => __('global.Taxpayer')]))

@section('content')
    <taxpayer inline-template>
        <div>
            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                @lang('global.Create', ['model' => __('global.Taxpayer')]) <small></small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div>

                        <div class="row">
                            <div class="col-10">
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-4 col-form-label">
                                        @lang('global.Taxid')
                                    </label>
                                    <div class="col-4">
                                        <input type="text" class="form-control" v-model="taxid" />
                                    </div>
                                    <div class="col-1">
                                        -
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" v-model="code" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10">
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-4 col-form-label">
                                        @lang('global.Taxpayer')
                                    </label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" v-model="name" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-4 col-form-label">
                                        @lang('global.Alias')
                                    </label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" v-model="alias" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-4 col-form-label">
                                    @lang('global.Productions')
                                </label>
                                <span class="m-switch m-switch--sm m-switch--icon">
                                    <label>
                                        <input type="checkbox" checked="checked" name="">
                                        <span></span>
                                    </label>
                                </span>
                            </div>

                            <div class="col-6">
                                <div class="form-group m-form__group row">
                                    <div class="col-8">
                                        <button v-on:click="onSave($data)" class="btn btn-brand">
                                            @lang('global.Save')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                @lang('global.ProfileAndSettings') <small></small>
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
                                    <div class="col-lg-6">
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
                                                        Accountant
                                                    </span>
                                                </span>
                                                <span class="m-option__body">
                                                    Accountant Account.
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
    </taxpayer>

@endsection
