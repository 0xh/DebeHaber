
<meta name="csrf-token" content="{{ csrf_token() }}">

<money-transfer-form :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{request()->route('cycle')->id }}" inline-template>
    <div>

        <div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            Type.
                        </label>
                        <div class="col-2">
                            <input type="radio" name="type" value="0"  v-model="type" checked />Withdraw
                        </div>
                        <div class="col-2">
                            <input type="radio" name="type" value="1"  v-model="type" />Credit
                        </div>
                        <div class="col-2">
                            <input type="radio" name="type" value="2"  v-model="type" />Transfer
                        </div>
                    </div>
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
                    <div class="form-group m-form__group row" v-if="type==2">
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
                <div class="col-6">
                    <div class="form-group m-form__group row" v-if="type==0 || type==2">
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
                </div>


            </div>









            <button v-on:click="onSave($data,false,'/current/{{request()->route('company') }}/sales')" class="btn btn-primary">
                Guardar
            </button>
            <button v-on:click="onSave($data,true,'')" class="btn btn-primary">
                Guardar & New
            </button>
            <button v-on:click="cancel()" class="btn btn-default">
                Cancelar
            </button>
        </div>
    </div>
</account-receivable-form>
