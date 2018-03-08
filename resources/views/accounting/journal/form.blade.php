<meta name="csrf-token" content="{{ csrf_token() }}">

<journal-form :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{request()->route('cycle')->id }}"  inline-template>
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
                        @lang('commercial.Number')
                    </label>
                    <div class="col-8">
                        <input class="form-control m-input" type="text" value="001-001-0000000" v-model="number">
                    </div>
                </div>
            </div>

        </div>

        <hr>
        <div class="col-6">
            <div class="form-group m-form__group row">
                <label for="example-text-input" class="col-4 col-form-label">
                    Comment
                </label>
                <div class="col-8">
                    <input class="form-control m-input" type="text"  v-model="comment">
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
                            @lang('commercial.Detail')
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="#" v-on:click="addDetail" class="btn btn-outline-primary btn-sm m-btn m-btn--icon">
                        <span>
                            <i class="la la-plus"></i>
                            <span>
                                @lang('global.New')
                            </span>
                        </span>
                    </a>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-2">
                        <span class="m--font-boldest">@lang('commercial.Account')</span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">@lang('commercial.Debit')</span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">@lang('commercial.Credit')</span>
                    </div>

                    <div class="col-1">
                        <span class="m--font-boldest"></span>
                    </div>
                </div>

                <hr>

                <div class="row" v-for="detail in details">
                    <div class="col-2">
                        <select required  v-model="detail.chart_id" class="custom-select">
                            <option v-for="item in accounts" :value="item.id">@{{ item.name }}</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control" v-model="detail.debit" />
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control" v-model="detail.credit" />
                    </div>

                    <div class="col-1">

                        <button v-on:click="deleteDetail(detail)" class="btn btn-outline-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="la la-remove"></i>
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-2">
                        <span class="m--font-boldest">@lang('global.Total')</span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">@{{ grandDebitTotal }}</span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">@{{ grandCreditTotal }}</span>

                    </div>

                </div>
            </div>
        </div>

        <button v-on:click="onSave($data,false)" class="btn btn-primary">
            @lang('global.Save')
        </button>
        <button v-on:click="onSave($data,true)" class="btn btn-primary">
            @lang('global.Save-and-New')
        </button>
        <button v-on:click="cancel()" v-shortkey.once="['esc']" @shortkey="cancel()" class="btn btn-default">
            @lang('global.Cancel')
        </button>
    </div>
</sales-form>
