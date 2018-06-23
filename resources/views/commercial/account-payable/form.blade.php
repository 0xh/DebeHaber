
<meta name="csrf-token" content="{{ csrf_token() }}">

<account-form :trantype ="2" :charts=" {{ $charts }}" inline-template>
    <div>
        <div class="">
            <p class="lead m--font-boldest m--font-transform-u">@lang('commercial.Purchase')</p>
            <div class="row">
                <div class="col-4">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('commercial.Supplier')
                        </label>
                        <div class="col-8">
                            @{{ Supplier }}
                            {{-- <input type="date" class="form-control" v-model="date" /> --}}
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.InvoiceDate')
                        </label>
                        <div class="col-8">
                            @{{ new Date(date).toLocaleDateString() }}
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.Due')
                        </label>
                        <div class="col-8">
                            <p>
                                @{{ new Number(Value).toLocaleString() }} <span class="m--font-primary">@{{ Currency }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('commercial.InvoiceNumber')
                        </label>
                        <div class="col-8">
                            <p>@{{ number }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.Deadline')
                        </label>
                        <div class="col-8">
                            <p>@{{ new Date(code_expiry).toLocaleDateString() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            @lang('global.Balance')
                        </label>
                        <div class="col-8">
                            @{{ new Number(Balance).toLocaleString() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <h3>@lang('commercial.MakePayment')</h3>
        <div class="row">
            <div class="col-4">
                <label for="example-text-input" class="col-4 col-form-label">
                    @lang('commercial.Account')
                </label>
            </div>
            <div class="col-8">
                <select required  v-model="chart_account_id" class="custom-select">
                    <option v-for="item in charts" :value="item.id">@{{ item.name }}</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <label for="example-text-input" class="col-4 col-form-label">
                    @lang('global.Value')
                </label>
            </div>
            <div class="col-8">
                <input type="number" name="" v-model="payment_value">
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group m-form__group">
                    <label for="example-text-input" class="col-4 col-form-label">
                        @lang('commercial.Currency')
                    </label>
                </div>
            </div>
            <div class="col-8">
                <div class="input-group">
                    <select required v-model="currency_id" class="custom-select" v-on:change="getRate()">
                        <option v-for="currency in currencies" :value="currency.id">@{{ currency.name }}</option>
                    </select>
                    <input type="number" class="form-control" v-model="rate" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <label for="example-text-input" class="col-4 col-form-label">
                    @lang('global.Comment')
                </label>
            </div>
            <div class="col-8">
                <input type="text" name="" value="" v-model="comment">
            </div>
        </div>

        <button v-on:click="onSave($data,false,'/current/{{request()->route('company') }}/sales')" class="btn btn-primary">
            @lang('Save')
        </button>
        <button v-on:click="cancel()" class="btn btn-default">
            @lang('Cancel')
        </button>
    </div>
</transaction-form>
