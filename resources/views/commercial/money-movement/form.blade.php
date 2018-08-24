
<meta name="csrf-token" content="{{ csrf_token() }}">

<money-transfer-form :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{request()->route('cycle')->id }}" inline-template>
    <div>

        <div class="row">

            <div class="col-12">
                <b-field label="@lang('global.Type')">
                    <b-radio-button v-model="type" native-value="0" type="is-danger">
                        <b-icon icon="arrow-up"></b-icon>
                        <span>@lang('commercial.Withdrawal')</span>
                    </b-radio-button>
                    <b-radio-button v-model="type" native-value="1" type="is-success">
                        <b-icon icon="arrow-down"></b-icon>
                        <span>@lang('commercial.Deposit')</span>
                    </b-radio-button>
                    <b-radio-button v-model="type" native-value="2" type="is-warning">
                        <b-icon icon="exchange-alt"></b-icon>
                        <span>@lang('commercial.Transfer')</span>
                    </b-radio-button>
                </b-field>
            </div>
        </div>

        <div class="row">
            {{-- Debit --}}
            <div v-if="type==1 || type==2" class="m-portlet m-portlet--bordered m-portlet--bordered-semi m-portlet--rounded col-md-6 col-sm-12">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                @lang('accounting.Debit')
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <b-field label="Account to Debit" horizontal>
                        <b-select>
                            <option>Mr.</option>
                            <option>Ms.</option>
                        </b-select>
                    </b-field>
                    <b-field label="Account to Debit" horizontal>
                        <b-field>
                            <b-input placeholder="Number" v-bind="debit" type="number" min="0"></b-input>
                        </b-field>
                    </b-field>
                    <b-field label="Account to Debit" horizontal>
                        <b-field>
                            <b-input placeholder="Number" v-bind="debit" type="number" min="0"></b-input>
                        </b-field>
                    </b-field>
                </div>
            </div>

            <div v-if="type==0 || type==2" class="m-portlet m-portlet--bordered m-portlet--bordered-semi m-portlet--rounded col-md-6 col-sm-12">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                @lang('accounting.Debit')
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <b-field label="Account to Debit" horizontal>
                        <b-select>
                            <option>Mr.</option>
                            <option>Ms.</option>
                        </b-select>
                    </b-field>
                    <b-field label="Account to Debit" horizontal>
                        <b-field>
                            <b-input placeholder="Number" v-bind="debit" type="number" min="0"></b-input>
                        </b-field>
                    </b-field>
                </div>
            </div>

            {{-- <div class="col-6">
                <h3 class="title is-3">@lang('accounting.Debit')</h3>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        From Accounts
                    </label>

                    <div class="col-8">
                        <select required  v-model="from_chart_id" class="custom-select">
                            <option v-for="item in charts" :value="item.id">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        To Accounts
                    </label>

                    <div class="col-8">
                        <select required  v-model="to_chart_id" class="custom-select">
                            <option v-for="item in charts" :value="item.id">@{{ item.name }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-6" v-if="type==1 || type==2">
                <h3 class="title is-3">@lang('accounting.Debit')</h3>
                <div class="form-group m-form__group row" v-if="type==0 || type==2">
                    <b-field label="@lang('global.Type')" horizontal>

                    </b-field>
                    <label for="example-text-input" class="col-4 col-form-label">
                        debit
                    </label>
                    <div class="col-8">
                        <div class="input-group">
                            <input  type="number" class="form-control" v-model="debit" />
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row" v-if="type==1 || type==2">
                    <label for="example-text-input" class="col-4 col-form-label">
                        credit
                    </label>
                    <div class="col-8">
                        <div class="input-group">
                            <input  type="number" class="form-control" v-model="credit" />
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        Moneda
                    </label>
                    <div class="col-8">
                        <div class="input-group">
                            <select required v-model="currency_id" class="custom-select" v-on:change="getRate()">
                                <option v-for="currency in currencies" :value="currency.id">@{{ currency.name }}</option>
                            </select>
                            <input type="text" class="form-control" v-model="rate" />
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <div class="row">
            <button v-on:click="onSave($data,false,'/current/{{request()->route('company') }}/sales')" class="btn btn-primary">
                @lang('global.Save')
            </button>
            <button v-on:click="onSave($data,true,'')" class="btn btn-primary">
                @lang('global.Save&New')
            </button>
            <button v-on:click="cancel()" class="btn btn-default">
                @lang('global.Cancel')
            </button>
        </div>
    </div>
</account-receivable-form>
