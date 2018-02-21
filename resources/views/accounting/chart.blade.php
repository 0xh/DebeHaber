@extends('spark::layouts.one-column')

@section('title', 'Chart')

@section('form')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <chart  inline-template>
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
                            @lang('global.code')
                        </label>
                        <div class="col-8">
                            <input type="text" class="form-control" v-model="code" />
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.code')
                        </label>
                        <div class="col-8">
                            <input type="text" class="form-control" v-model="name" />
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.name')
                        </label>
                        <div class="col-8">
                            <input type="text" class="form-control" v-model="name" />
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.StartDate')
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

            <hr>

            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-2">
                        <span class="m--font-boldest">
                            Name
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            year
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            Start Date
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            End Date
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            Action
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
        </div>
    </chart>

@endsection
