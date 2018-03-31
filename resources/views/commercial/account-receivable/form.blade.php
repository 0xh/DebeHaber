
<meta name="csrf-token" content="{{ csrf_token() }}">

<account-receivable-form :trantype ="2" :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{request()->route('cycle')->id }}"  inline-template>
    <div>
        <div>
            <div class="row">
                <div class="col-12">
                    <h3>@lang('commercial.Sales')</h3>
                </div>

                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('commercial.Customer')
                        </label>
                        <div class="col-8">
                            <input type="date" class="form-control" v-model="date" />
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('commercial.InvoiceNumber')
                        </label>
                        <div class="col-8">
                            @{{ invoice.Value }}
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('commercial.Value')
                        </label>
                        <div class="col-8">
                            <p>
                                @{{ invoice.Value }}
                                <span class="m--font-primary">
                                    @{{ invoice.CurrencyCode }}
                                </span>
                            </p>
                            {{-- <input type="date" class="form-control" v-model="date" /> --}}
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.InvoiceDate')
                        </label>
                        <div class="col-8">
                            <p>@{{ invoice.Date }}</p>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.Deadline')
                        </label>
                        <div class="col-8">
                            <p>@{{ invoice.ExpiryDate }}</p>
                        </div>
                    </div>
                    {{-- <div class="form-group m-form__group row">
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
                    </div> --}}
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-4">
                    <label for="example-text-input" class="col-4 col-form-label">
                        @lang('global.Deadline')
                    </label>
                </div>
                <div class="col-8">
                    
                </div>
            </div>

            <button v-on:click="onSave($data,false,'/current/{{request()->route('company') }}/sales')" class="btn btn-primary">
                @lang('Save')
            </button>
            <button v-on:click="cancel()" class="btn btn-default">
                @lang('Cancel')
            </button>
        </div>
    </div>
</account-receivable-form>
