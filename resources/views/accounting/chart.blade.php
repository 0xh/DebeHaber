{{-- <div class="col-10">
<div class="form-group m-form__group row">
<label for="example-text-input" class="col-4 col-form-label">
@lang('accounting.ChartVersion')
</label>
<div class="col-8">
{{ request()->route('taxPayer')->country . ' ' . request()->route('cycle')->chartVersion->name }}
</div>
</div>
</div> --}}

@extends('spark::layouts.form')

@section('title',  __('accounting.ChartofAccounts'))

@section('form')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <chart :taxpayer="{{ request()->route('taxPayer')->id }}" :cycle="{{ request()->route('cycle')->id }}" inline-template>
        <div>
            {{-- <div class="m-portlet"> --}}
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Border Seperator Form Groups
                        </h3>
                    </div>
                </div>
            </div>

            <div class="m-form__seperator m-form__seperator--dashed"></div>

            <!--begin::Form-->
            <div class="m-form m-form--fit m-form--label-align-right m-form--group-seperator">
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">
                            @lang('global.BelongsTo'):
                        </label>
                        <div class="col-lg-6">
                            <router-view name="SearchBoxAccount" url="/accounting/chart/get_parent-accounts/" :cycle="{{ request()->route('cycle')->id }}" :current_company="{{ request()->route('taxPayer')->id }}" >

                            </router-view>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">
                            @lang('accounting.ChartofAccounts'):
                        </label>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <div class="input-group-preappend">
                                    <input type="text" class="input-group-text" v-model="code" placeholder="@lang('global.Code')" aria-describedby="basic-addon2">
                                </div>
                                <input type="text" class="form-control m-input" v-model="name" placeholder="@lang('global.Name')" aria-describedby="basic-addon2">
                            </div>
                            <span class="m-form__help">Create an account code (number) and give it a name for easy identification</span>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">
                            @lang('global.Type'):
                        </label>
                        <div class="col-10">
                            <div class="row">
                                @foreach (App\Enums\ChartTypeEnum::labels() as $value => $label)
                                    <div class="col-4">
                                        <label class="m-option m-option m-option--plain">
                                            <span class="m-option__control">
                                                <span class="m-radio m-radio--brand m-radio--check-bold">
                                                    <input type="radio" v-model="type" value="{{ $value }}" :disabled="canChange == false">
                                                    <span></span>
                                                </span>
                                            </span>
                                            <span class="m-option__label">
                                                <span class="m-option__head">
                                                    <span class="m-option__title">
                                                        <span class="m--font-bolder">{{ $label }}</span>
                                                    </span>
                                                </span>
                                                <span class="m-option__body m--font-metal">
                                                    @if ($value == 1)
                                                        Assets are awsome. You should have more of these.
                                                    @else
                                                        Liabilities are bad. Try having less of those.
                                                    @endif
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">
                            @lang('accounting.IsAccountable'):
                        </label>
                        <div class="col-10">
                            <span class="m-switch m-switch--outline m-switch--icon m-switch--brand">
                                <label>
                                    <input type="checkbox" v-model="is_accountable" name="">
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>

                    <div v-if="is_accountable" class="m-form__group m-form__group--last form-group row">
                        <label class="col-lg-2 col-form-label">
                            @lang('global.SubType'):
                        </label>
                        <div class="col-10">
                            <div class="row">
                                <template v-if="type === '1' || type=== 1">
                                    @foreach (App\Enums\ChartAssetTypeEnum::labels() as $value => $label)
                                        @include('accounting.types.assets')
                                    @endforeach
                                </template>
                                <template v-else-if="type === '2' || type=== 2">
                                    @foreach (App\Enums\ChartLiabilityTypeEnum::labels() as $value => $label)
                                        @include('accounting.types.liabilities')
                                    @endforeach
                                </template>
                                <template v-else-if="type === '3' || type=== 3">
                                    @foreach (App\Enums\ChartEquityTypeEnum::labels() as $value => $label)
                                        @include('accounting.types.equities')
                                    @endforeach
                                </template>
                                <template v-else-if="type === '4' || type=== 4">
                                    @foreach (App\Enums\ChartRevenueTypeEnum::labels() as $value => $label)
                                        @include('accounting.types.revenues')
                                    @endforeach
                                </template>
                                <template v-else-if="type === '5' || type=== 5">
                                    @foreach (App\Enums\ChartExpenseTypeEnum::labels() as $value => $label)
                                        @include('accounting.types.expenses')
                                    @endforeach
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions--solid">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-6">
                            <button v-on:click="onSave($data)" class="btn btn-primary">
                                @lang('global.Save')
                            </button>
                            <button v-on:click="cancel()" class="btn btn-secondary">Cancel</button>
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
