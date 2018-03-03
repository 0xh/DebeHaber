@extends('spark::layouts.form')

@section('title',  __('accounting.ChartofAccounts'))

@section('form')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <chart :taxpayer="{{ request()->route('taxPayer')->id }}" :cycle="{{ request()->route('cycle')->id }}" inline-template>
        <div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.BelongsTo')
                        </label>
                        <div class="col-8">
                            <router-view name="SearchBoxAccount" url="/accounting/chart/get_parent-accounts/" :cycle="{{ request()->route('cycle')->id }}"  :current_company="{{ request()->route('taxPayer')->id }}" >

                            </router-view>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('accounting.ChartVersion')
                        </label>
                        <div class="col-8">
                            {{ request()->route('taxPayer')->country . ' ' . request()->route('cycle')->chartVersion->name }}
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
                            @lang('global.Type')
                        </label>
                        <div class="col-8">
                            <select v-model="type" required class="custom-select" >
                                @foreach (App\Enums\ChartTypeEnum::labels() as $value => $label)
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.SubType')
                        </label>
                        <div class="col-8">
                            <template v-if="type === '1' || type=== 1">
                                <select v-model="sub_type" required class="custom-select" >
                                    @foreach (App\Enums\ChartAssetTypeEnum::labels() as $value => $label)
                                        <option value="{{ $value }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </template>
                            <template v-else-if="type === '2' || type=== 2">
                                <select v-model="sub_type" required class="custom-select" >
                                    @foreach (App\Enums\ChartLiabilityTypeEnum::labels() as $value => $label)
                                        <option value="{{ $value }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </template>
                            <template v-else-if="type === '3' || type=== 3">
                                <select v-model="sub_type" required class="custom-select" >
                                    @foreach (App\Enums\ChartEquityTypeEnum::labels() as $value => $label)
                                        <option value="{{ $value }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </template>
                            <template v-else-if="type === '4' || type=== 4">
                                <select v-model="sub_type" required class="custom-select" >
                                    @foreach (App\Enums\ChartRevenueTypeEnum::labels() as $value => $label)
                                        <option value="{{ $value }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </template>
                            <template v-else>
                                <select v-model="sub_type" required class="custom-select" >
                                    @foreach (App\Enums\ChartExpenseTypeEnum::labels() as $value => $label)
                                        <option value="{{ $value }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </template>

                        </div>
                    </div>
                </div>
                <div class="col-6" v-if="type === '1' || type=== '2'">

                    <div class="form-group m-form__group row" v-if="sub_type === '12' || sub_type=== '3'">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.coefficient')
                        </label>
                        <div class="col-8">
                            <input type="text" class="form-control" v-model="coefficient" />
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('accounting.IsAccountable')
                        </label>
                        <div class="col-8">
                            <input type="checkbox" class="form-control" v-model="is_accountable" />
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
                            @lang('global.Code')
                        </span>
                    </div>
                    <div class="col-6">
                        <span class="m--font-boldest">
                            @lang('accounting.Accounts')
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('accounting.IsAccountable')
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
                        @{{ data.code }}
                    </div>
                    <div class="col-6">
                        @{{ data.name }}
                    </div>
                    <div class="col-2">
                        @{{ data.is_accountable }}
                    </div>
                    <div class="col-2">
                        <button v-on:click="onEdit(data)" class="btn btn-outline-pencil m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="la la-pencil"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </chart>

@endsection
