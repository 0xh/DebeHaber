<meta name="csrf-token" content="{{ csrf_token() }}">
    <div>
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

        <div class="row m--margin-bottom-5" v-for="invoice in list">
            <div class="col-1">
                <p> @{{ invoice.Date }} </p>
            </div>
            <div class="col-5">
                <p> <span class="m--font-bold">@{{ invoice.Customer }}</span> | <em>@{{ invoice.CustomerTaxID }}</em> </p>
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
                <div class="m-btn-group btn-group-sm m-btn-group--pill btn-group" role="group" aria-label="...">
                    <a class="m-btn btn btn-secondary"><i class="la la-check m--font-success"></i></a>
                    <a @click="onEdit(invoice.ID)" class="m-btn btn btn-secondary"><i class="la la-pencil m--font-brand"></i></a>
                    <a @click="onDelete(invoice)" class="m-btn btn btn-secondary"><i class="la la-trash m--font-danger"></i></a>
                    <a @click="onAnull(invoice)" class="m-btn btn btn-secondary"><i class="la la-close m--font-danger"></i></a>
                </div>
            </div>
        </div>
        @include('layouts/infinity-loading')
    </div>
