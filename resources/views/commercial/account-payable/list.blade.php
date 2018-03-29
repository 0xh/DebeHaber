<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <router-view name="Datatable"  :taxpayer="{{ request()->route('taxPayer')}}"  /> --}}

<account-payable-list :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{request()->route('cycle')->id }}"  inline-template>
    <div>
        <button @click="add()">@lang('global.Add')</button>

        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
            <div class="row align-items-center">
                <div class="col-xl-8 order-2 order-xl-1">
                    <div class="form-group m-form__group row align-items-center">
                        <div class="col-md-4">
                            <div class="m-input-icon m-input-icon--left">
                                <input type="text" class="form-control m-input" placeholder="Search..." v-model="search">
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
            <div class="col-1 m--font-boldest">
                <p class="m--font-boldest m--font-transform-u">@lang('global.Date')</p>
            </div>
            <div class="col-5">
                <p class="m--font-boldest m--font-transform-u">@lang('commercial.Customer')</p>
            </div>
            <div class="col-2">
                <p class="m--font-boldest m--font-transform-u">@lang('commercial.InvoiceNumber')</p>
            </div>
            <div class="col-2">
                <p class="m--align-right m--font-boldest m--font-transform-u">@lang('global.Total')</p>
            </div>
            <div class="col-1">
                <p class="m--align-center m--font-boldest m--font-transform-u">@lang('global.Actions')</p>
            </div>
        </div>

        <div class="row m--margin-bottom-5" v-for="invoice in filteredList">
            <div class="col-1">
                <p> @{{ invoice.Date }} </p>
            </div>
            <div class="col-5">
                <p> <span class="m--font-bold">@{{ invoice.Customer }}</span> |  <em>@{{ invoice.CustomerTaxID }}</em> </p>
            </div>
            <div class="col-2">
                <p>
                    @{{ invoice.Number }} |
                    <span v-if="invoice.PaymentCondition > 0" class="m--font-bold m--font-info"> Credit </span>
                    <span v-else class="m--font-bold m--font-success"> Cash</span>
                </p>
            </div>
            <div class="col-2">
                <p class="m--font-bold m--align-right">
                    @{{ invoice.Value }} <span class="m--font-primary">@{{ invoice.Currency }}</span>
                </p>
            </div>
            <div class="col-1">
                <div class="m-btn-group m-btn-group--pill btn-group mr-2" role="group" aria-label="...">
                    <a class="m-btn btn btn-secondary"><i class="la la-check m--font-success"></i></a>
                    <a @click="onEdit(invoice.ID)" class="m-btn btn btn-secondary"><i class="la la-pencil m--font-brand"></i></a>
                    <a class="m-btn btn btn-secondary"><i class="la la-trash m--font-danger"></i></a>
                </div>
            </div>
        </div>

        <infinite-loading @infinite="infiniteHandler">
            <span slot="no-more">
                No more data
            </span>
        </infinite-loading>
    </div>
</sales-list>
