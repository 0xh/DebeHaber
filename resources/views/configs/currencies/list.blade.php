@extends('spark::layouts.form')

@section('title',  __('accounting.Documents'))

@section('form')
    <currency taxpayer="{{ request()->route('taxPayer')->id}}" cycle="{{ request()->route('cycle')->id }}" inline-template>
        <diV>
            <div class="row">
                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.Currency')
                        </label>
                        <div class="col-8">
                            <select v-model="currency_id" required class="custom-select" >
                                <option v-for="currency in currencies" :value="currency.id">@{{ currency.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.rate')
                        </label>
                        <div class="col-8">
                            <input type="text" class="form-control" v-model="rate" />
                        </div>
                    </div>
                </div>


                <div class="form-group m-form__group row">
                    <div class="col-8">
                        <button v-on:click="onSave($data)" class="btn btn-primary">
                            @lang('global.Save')
                        </button>
                    </div>
                </div>
            </div>

            <hr>

            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('global.Currency')
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('global.Date')
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('accounting.BuyRate')
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('accounting.SellRate')
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
                        @{{ data.name }}
                    </div>
                    <div class="col-2">
                        @{{ new Date(data.date).toLocaleDateString() }}
                    </div>
                    <div class="col-2">
                        @{{ new Number(data.buy_rate).toLocaleString() }}
                    </div>
                    <div class="col-2">
                        @{{ new Number(data.sell_rate).toLocaleString() }}
                    </div>

                    <div class="col-2">
                        <button v-on:click="onEdit(data)" class="btn btn-outline-pencil m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="la la-pencil"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </document>
@endsection
