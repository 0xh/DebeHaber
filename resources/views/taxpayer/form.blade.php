@extends('spark::layouts.app')

@section('title', 'Chart Version')

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="content">
        <taxpayer inline-template>
            <div>
                <div class="row">

                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('global.Taxid')
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="taxid" />
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('global.Code')
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="code" />
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('global.Name')
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="name" />
                            </div>
                        </div>
                    </div>

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
                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('global.ShowInventory')
                            </label>
                            <div class="col-1">
                                <input type="checkbox" class="form-control" v-model="show_inventory" />
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('global.ShowProduction')
                            </label>
                            <div class="col-1">
                                <input type="checkbox" class="form-control" v-model="show_production" />
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('global.ShowFixedAsset')
                            </label>
                            <div class="col-1">
                                <input type="checkbox" class="form-control" v-model="show_fixedasset" />
                            </div>
                        </div>
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
        </taxpayer>
    </div>

@endsection
