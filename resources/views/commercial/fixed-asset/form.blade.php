
<meta name="csrf-token" content="{{ csrf_token() }}">

<fixedasset :taxpayer="{{ request()->route('taxPayer')->id }}" :cycle="{{ request()->route('cycle')->id }}"  :charts="{{ $charts }}" inline-template>
    <div>

        <!--begin::Form-->
        <div class="m-form m-form--fit m-form--label-align-right m-form--group-seperator">
            <div class="m-portlet__body">

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        @lang('commercial.Account')
                    </label>
                    <div class="col-8">
                        <router-view name="SearchBoxAccount" url="/accounting/chart/get-fixed-assets/" :cycle="{{ request()->route('cycle')->id }}" :current_company="{{ request()->route('taxPayer')->id }}"></router-view>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        @lang('global.Name')
                    </label>
                    <div class="col-8">
                        <div class="input-group">
                            <div class="input-group-preappend">
                                <input type="text" class="input-group-text" v-model="serial" placeholder="@lang('commercial.Serial')" aria-describedby="basic-addon2">
                            </div>
                            <input type="text" class="form-control m-input"  v-model="name" placeholder="@lang('global.Name')" aria-describedby="basic-addon2">
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        @lang('commercial.PurchaseDate')
                    </label>
                    <div class="col-8">
                        <input type="date" class="form-control" v-model="purchase_date" />
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        @lang('commercial.Currency')
                    </label>
                    <div class="col-8">
                        <div class="input-group">
                            <div class="input-group-preappend">
                                <select required v-model="currency_id" class="custom-select" v-on:change="getRate()">
                                    <option v-for="currency in currencies" v-bind:value="currency.id">
                                        @{{ currency.name }} | <b>@{{ currency.isoCode }}</b>
                                    </option>
                                </select>
                            </div>
                            <input type="text" class="form-control" v-model="rate" placeholder="@lang('commercial.Rate')"/>
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        @lang('commercial.PurchaseValue')
                    </label>
                    <div class="col-8">
                        <input type="text" class="form-control" v-model="purchase_value" />
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        @lang('commercial.CurrentValue')
                    </label>
                    <div class="col-8">
                        <input type="text" class="form-control" v-model="current_value" />
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        @lang('global.Quantity')
                    </label>
                    <div class="col-8">
                        <input type="text" class="form-control" v-model="quantity" />
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
                        <button v-on:click="onCancel()" class="btn btn-secondary">@lang('global.Cancel')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</chart>
