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

                    <div class="form-group m-form__group row has-danger">
                        <label class="col-lg-2 col-form-label">
                            @lang('commercial.Account'):
                        </label>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <div class="input-group-preappend">
                                    <input type="text" class="input-group-text" v-model="code" placeholder="@lang('global.Code')" aria-describedby="basic-addon2">
                                </div>
                                <input type="text" class="form-control m-input"  v-model="name" placeholder="@lang('global.Name')" aria-describedby="basic-addon2">
                            </div>
                            <span class="m-form__help">Create an account code (number) and give it a name for easy identification</span>
                        </div>
                    </div>

                    <div class="m-form__seperator m-form__seperator--dashed"></div>

                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">
                            @lang('global.Type'):
                        </label>
                        <div class="col-10">
                            <div class="row">
                                @foreach (App\Enums\ChartTypeEnum::labels() as $value => $label)
                                    @if ($value == 1)
                                        @include('accounting.types.asset')
                                    @elseif ($value == 2)
                                        @include('accounting.types.liability')
                                    @elseif ($value == 3)
                                        @include('accounting.types.equity')
                                    @elseif ($value == 4)
                                        @include('accounting.types.revenue')
                                    @elseif ($value == 5)
                                        @include('accounting.types.expense')
                                    @endif
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
                                        @include('accounting.sub-types.assets')
                                    @endforeach
                                </template>
                                <template v-else-if="type === '2' || type=== 2">
                                    @foreach (App\Enums\ChartLiabilityTypeEnum::labels() as $value => $label)
                                        @include('accounting.sub-types.liabilities')
                                    @endforeach
                                </template>
                                <template v-else-if="type === '3' || type=== 3">
                                    @foreach (App\Enums\ChartEquityTypeEnum::labels() as $value => $label)
                                        @include('accounting.sub-types.equities')
                                    @endforeach
                                </template>
                                <template v-else-if="type === '4' || type=== 4">
                                    @foreach (App\Enums\ChartRevenueTypeEnum::labels() as $value => $label)
                                        @include('accounting.sub-types.revenues')
                                    @endforeach
                                </template>
                                <template v-else-if="type === '5' || type=== 5">
                                    @foreach (App\Enums\ChartExpenseTypeEnum::labels() as $value => $label)
                                        @include('accounting.sub-types.expenses')
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
                    <div class="col-1">

                    </div>
                    <div class="col-6">
                        <span class="m--font-boldest">
                            @lang('accounting.Accounts')
                        </span>
                    </div>
                    <div class="col-2">
                        {{-- No Title --}}
                    </div>

                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('global.Action')
                        </span>
                    </div>
                </div>

                <hr>

                <div class="row" v-for="data in list">
                    <div class="col-1">

                    </div>
                    <div class="col-1">
                        <span v-if="data.type == 1" class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                            <b>@{{ data.code }}</b>
                        </span>
                        <span v-else-if="data.type == 2" class="m-badge m-badge--brand m-badge--wide m-badge--rounded">
                            <b>@{{ data.code }}</b>
                        </span>
                        <span v-else-if="data.type == 3" class="m-badge m-badge--warning m-badge--wide m-badge--rounded">
                            <b>@{{ data.code }}</b>
                        </span>
                        <span v-else-if="data.type == 4" class="m-badge m-badge--success m-badge--wide m-badge--rounded">
                            <b>@{{ data.code }}</b>
                        </span>
                        <span v-else-if="data.type == 5" class="m-badge m-badge--danger m-badge--wide m-badge--rounded">
                            <b>@{{ data.code }}</b>
                        </span>
                    </div>
                    <div class="col-6">
                        <span v-if="data.is_accountable">
                            @{{ data.name }}
                        </span>
                        <span v-else>
                            <b>@{{ data.name }}</b>
                        </span>
                    </div>
                    <div class="col-4">
                        <div class="m-btn-group m-btn-group--pill btn-group m--margin-5" role="group" aria-label="First group">

                            <button v-if="data.taxpayer_id == null" type="button" class="m-btn btn btn-metal">
                                @lang('accounting.Generic')
                            </button>

                            <button v-else type="button" class="m-btn btn btn-success">
                                <i class="la la-pencil"></i>
                            </button>

                            <div v-else>
                                <button type="button" class="m-btn btn btn-warning">
                                    <i class="la la-trash-o"></i>
                                </button>
                                <button type="button" class="m-btn btn btn-info">
                                    <i class="la la-scissors"></i>
                                </button>
                            </div>

                            <button v-if="data.is_accountable" type="button" class="m-btn btn btn-primary">
                                @lang('accounting.IsAccountable')
                            </button>
                        </div>
                        {{-- <div v-if="data.taxpayer_id != null">
                        <button v-on:click="onEdit(data)" class="btn btn-outline-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                        <i class="la la-pencil"></i>
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
</div>
</chart>
@endsection
