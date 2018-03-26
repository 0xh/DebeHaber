<meta name="csrf-token" content="{{ csrf_token() }}">

<sales-list :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}" inline-template>
    <div>
        <div>
        </div>
        <div class="m_datatable m-datatable m-datatable--default m-datatable--loaded">
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-4">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span><i class="la la-search"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <a href="#" class="btn btn-brand m-btn m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-cart-plus"></i>
                                <span>
                                    <router-view name="create" :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}" ></router-view>
                                </span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                        <input type="checkbox" value="1">
                        <span></span>
                    </label>
                    @lang('global.Date')
                </div>
                <div class="col-4">
                    @lang('commercial.Customer')
                </div>
                <div class="col-2">
                    @lang('commercial.InvoiceNumber')
                </div>
                <div class="col-1">

                </div>
                <div class="col-2">
                    @lang('global.Total')
                </div>
                <div class="col-1">
                    @lang('global.Actions')
                </div>
            </div>
            <div class="row" v-for="invoice in list">
                <div class="col-2">
                    {{-- <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                        <input type="checkbox" value="1">
                        <span></span>
                    </label> --}}
                    <p>@{{ invoice.Date }}</p>
                </div>
                <div class="col-4">
                    <p>@{{ invoice.Customer }}</p>
                </div>
                <div class="col-2">
                    <p>@{{ invoice.Number }}</p>
                </div>
                <div class="col-1">
                    <span v-if="invoice.PaymentCondition > 0"> Credit </span>
                    <span v-else > Credit </span>
                </div>
                <div class="col-2">
                    @{{ invoice.Value }} <small class="m--font-primary">@{{ invoice.Currency }}</small>
                </div>
                <div class="col-1">

                </div>
            </div>

            <infinite-loading @infinite="infiniteHandler">
                <span slot="no-more">
                    No more data
                </span>
            </infinite-loading>

            {{-- <div v-for="chunks in list">
            <div class="row" v-for="invoice in chunks">
            <div class="col-1">
            <span></span>
        </div>
        <div class="col-4">
        <span class="m--font-bolder">@{{ invoice.Customer }}</span>
    </div>
    <div class="col-2">
    <span>@{{ invoice.Number }}</span>
</div>
<div class="col-1">
<span v-if="invoice.PaymentCondition > 0">Credito</span>
<span v-else>Contado</span>
</div>
<div class="col-2">
<span>@{{ invoice.Currency }} @
<small>@{{ invoice.Rate }}</small>
</span>
</div>

<div class="col-2">

</div>

</div>
</div> --}}

</div>
</div>
</sales-list>
