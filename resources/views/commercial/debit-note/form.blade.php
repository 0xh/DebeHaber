
<meta name="csrf-token" content="{{ csrf_token() }}">

<debit-note-form :trantype ="2" :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{request()->route('cycle')->id }}" inline-template>
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
                        Supplier
                    </label>

                    <div class="col-8">
                        <router-view name="SearchBox" :url="/get_taxpayer/"  :current_company="{{ request()->route('taxPayer')->id }}" ></router-view>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        Documento
                    </label>
                    <div class="col-8">
                        <div class="input-group">
                            <select v-model="document_id" required class="custom-select" v-on:change="changeDocument()">
                                <option v-for="document in documents" :value="document.id">@{{ document.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        Timbrado &amp; Venci.
                    </label>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-5">
                                <input class="form-control m-input" type="number" placeholder="Timbrado"  v-model="code">
                            </div>
                            <div class="col-7">
                                <input type="date" class="form-control m-input" v-model="code_expiry"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        Número de Factura
                    </label>
                    <div class="col-8">
                        <input class="form-control m-input" type="text" value="001-001-0000000" v-model="number">
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-6">
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-4 col-form-label">
                        Condición
                    </label>
                    <div class="col-8">
                        <div class="input-group">
                            <input id="payment_condition" type="text" class="form-control" v-model="payment_condition" placeholder=" 0 = Contado 1 0 mas = credito "/>

                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row" v-if="payment_condition == 0">
                    <label for="example-text-input" class="col-4 col-form-label ">
                        Cuenta de Dinero
                    </label>
                    <div class="col-8">
                        <div>
                            <select v-model="chart_account_id" required class="custom-select" id="account_id">
                                <option v-for="account in accounts" :value="account.id">@{{ account.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-6">
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

        {{-- Invoice Detail --}}
        <div class="m-portlet m-portlet--metal m-portlet--head-solid m-portlet--bordered">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-calendar"></i>
                        </span>
                        <h3 class="m-portlet__head-text m--font-primary">
                            Detalle de Factura
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="#" v-on:click="addDetail" class="btn btn-outline-primary btn-sm m-btn m-btn--icon">
                        <span>
                            <i class="la la-plus"></i>
                            <span>
                                Agregar Detalle
                            </span>
                        </span>
                    </a>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-2">
                        <span class="m--font-boldest">
                            Cuenta
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">IVA</span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">Valor</span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">Exenta</span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">Gravada</span>
                    </div>
                    <div class="col-1">
                        <span class="m--font-boldest">IVA</span>
                    </div>
                    <div class="col-1">
                        <span class="m--font-boldest"></span>
                    </div>
                </div>

                <hr>

                <div class="row" v-for="detail in details">
                    <div class="col-2">
                        <select required  v-model="detail.chart_id" class="custom-select">
                            <option v-for="item in charts" :value="item.id">@{{ item.name }}</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select required  v-model="detail.chart_vat_id" @change="onPriceChange(detail)" class="custom-select">
                            <option v-for="iva in ivas" :value="iva.id">@{{ iva.name }}</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control" v-model="detail.value" @change="onPriceChange(detail)"/>
                    </div>
                    <div class="col-2">
                        @{{ detail.exenta }}
                    </div>
                    <div class="col-2">
                        @{{ detail.gravada }}
                    </div>
                    <div class="col-1">
                        @{{ detail.iva }}
                    </div>
                    <div class="col-1">
                        <input type="hidden" :value="grandTotal"/>
                        <button v-on:click="deleteDetail(detail)" class="btn btn-outline-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="la la-remove"></i>
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-2">

                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">Totales</span>
                    </div>
                    <div class="col-2">

                        <span class="m--font-boldest">@{{ grandTotal }}</span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">@{{ grandExenta }}</span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">@{{ grandGravada }}</span>
                    </div>
                    <div class="col-1">
                        <span class="m--font-boldest">@{{ grandIva }}</span>
                    </div>
                    <div class="col-1">

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
</debit-note-form>
