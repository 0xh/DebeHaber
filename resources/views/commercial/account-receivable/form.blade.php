
<meta name="csrf-token" content="{{ csrf_token() }}">

<account-receivable-form :trantype ="2" :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{request()->route('cycle')->id }}"  inline-template>
    <div>

        <div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            Fecha de Fact.
                        </label>
                        <div class="col-8">
                            <input type="date" class="form-control" v-model="date" />
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-4 col-form-label">
                            Accounts
                        </label>

                        <div class="col-8">
                            <select required  v-model="chart_id" class="custom-select">
                                <option v-for="item in charts" :value="item.id">@{{ item.name }}</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-6">
                    <div class="form-group m-form__group row">
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
