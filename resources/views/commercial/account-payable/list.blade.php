<meta name="csrf-token" content="{{ csrf_token() }}">

    <div>
        <div class="row">
            <div class="col-3">
                <p class="m--font-boldest m--font-transform-u">@lang('commercial.Supplier')</p>
            </div>
            <div class="col-2">
                <p class="m--font-boldest m--font-transform-u">@lang('commercial.InvoiceNumber')</p>
            </div>
            <div class="col-1 m--font-boldest">
                <p class="m--font-boldest m--font-transform-u">@lang('global.Deadline')</p>
            </div>
            <div class="col-2 m--font-boldest">
                <p class="m--align-right m--font-boldest m--font-transform-u">@lang('global.Balance')</p>
            </div>
            <div class="col-2 m--font-boldest">
                <p class="m--align-right m--font-boldest m--font-transform-u">@lang('commercial.Paid')</p>
            </div>
            <div class="col-2">
                <p class="m--align-center m--font-boldest m--font-transform-u">@lang('global.Actions')</p>
            </div>
        </div>

        <div class="row m--margin-bottom-5" v-for="invoice in list">
            <div class="col-3">
                <p> <span class="m--font-bold">@{{ invoice.Supplier }}</span> |  <em>@{{ invoice.SupplierTaxID }}</em> </p>
            </div>

            <div class="col-2">
                <p>
                    @{{ invoice.number }}
                    {{-- | <small v-if="invoice.PaymentCondition > 0" class="m--font-bold m--font-brand"> @{{ invoice.Date }} </small> --}}
                </p>
            </div>

            <div class="col-1">
                <p v-if="invoice.Expiry < Today" class="m--font-bold m--font-danger">
                    @{{ invoice.code_expiry }}
                </p>
                <p v-else class="m--font-bold">
                    @{{ invoice.code_expiry }}
                </p>
            </div>

            <div class="col-2">
                <p class="m--font-bold m--align-right">
                    @{{ invoice.Balance }} <span class="m--font-primary">@{{ invoice.currency_code }}</span>
                </p>
            </div>

            <div class="col-2">
                <p class="m--font-bold m--align-right">
                    @{{ invoice.Paid }} <span class="m--font-primary">@{{ invoice.currency_code }}</span>
                </p>
            </div>
            <div class="col-2">
                <div class="m-btn-group btn-group-sm m-btn-group--pill btn-group" role="group" aria-label="...">
                    <a class="m-btn btn btn-secondary">
                        <i class="la la-check m--font-success"></i>
                    </a>
                    <a @click="onEdit(invoice.id)" class="m-btn btn btn-secondary"><i class="la la-money m--font-brand"></i> @lang('commercial.MakePayment')</a>
                </div>
            </div>
        </div>

        @include('layouts/infinity-loading')

    </div>
