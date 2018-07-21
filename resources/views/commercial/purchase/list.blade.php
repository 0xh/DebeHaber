<meta name="csrf-token" content="{{ csrf_token() }}">

<div>

    <b-table :data="list" hoverable>
        <template slot-scope="props">
            <b-table-column field="Date" label="Date">
                @{{ new Date(props.row.Date).toLocaleDateString() }}
            </b-table-column>

            <b-table-column field="Customer" label="Supplier">
                @{{ props.row.Supplier }} |   @{{ props.row.SupplierTaxID }}
            </b-table-column>

            <b-table-column field="Number" label="InvoiceNumber">
                @{{ props.row.Number }}
                <span v-if="props.row.PaymentCondition > 0" class="m--font-bold m--font-info"> Credit </span>
                <span v-else class="m--font-bold m--font-success"> Cash</span>
            </b-table-column>

            <b-table-column field="customer_email" label="Total" numeric>
                @{{ new Number(props.row.Value).toLocaleString() }}  @{{ props.row.Currency }}
            </b-table-column>

            <b-table-column custom-key="actions">

                <button v-on:click="onEdit(props.row.ID)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" data-original-title="Delete">
                    <i class="la la-pencil m--font-brand"></i>
                </button>
                <button v-on:click="onDelete(props.row)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" data-original-title="Delete">
                    <i class="fa fa-trash"></i>
                </button>
                <button v-on:click="onAnull(props.row)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" data-original-title="Delete">
                    <i class="fa fa-trash"></i>
                </button>
            </b-table-column>
        </template>
    </b-table>
    <b-pagination :total="meta.total" :current.sync="meta.current_page" :simple="false" :per-page="meta.per_page" @change="pageChange"> </b-pagination>
    {{-- <div class="row">
    <div class="col-1 m--font-boldest">
    <p class="m--font-boldest m--font-transform-u">@lang('global.Date')</p>
</div>
<div class="col-4">
<p class="m--font-boldest m--font-transform-u">@lang('commercial.Customer')</p>
</div>
<div class="col-3">
<p class="m--font-boldest m--font-transform-u">@lang('commercial.InvoiceNumber')</p>
</div>
<div class="col-2">
<p class="m--align-right m--font-boldest m--font-transform-u">@lang('global.Total')</p>
</div>
<div class="col-2">
<p class="m--align-center m--font-boldest m--font-transform-u">@lang('global.Actions')</p>
</div>
</div>

<div class="row m--margin-bottom-5" v-for="invoice in list">
<div class="col-1">
<p> @{{ new Date(invoice.Date).toLocaleDateString() }} </p>
</div>
<div class="col-4">
<p> <span class="m--font-bold">@{{ invoice.Customer }}</span> | <em>@{{ invoice.CustomerTaxID }}</em> </p>
</div>
<div class="col-3">
<p>
@{{ invoice.Number }} |
<span v-if="invoice.PaymentCondition > 0" class="m--font-bold m--font-info"> Credit </span>
<span v-else class="m--font-bold m--font-success"> Cash</span>
</p>
</div>
<div class="col-2">
<p class="m--font-bold m--align-right">
@{{ new Number(invoice.Value).toLocaleString() }} <span class="m--font-primary">@{{ invoice.Currency }}</span>
</p>
</div>
<div class="col-2">
<div class="m-btn-group btn-group-sm m-btn-group--pill btn-group" role="group" aria-label="...">
<a class="m-btn btn btn-secondary"><i class="la la-check m--font-success"></i></a>
<a @click="onEdit(invoice.ID)" class="m-btn btn btn-secondary"><i class="la la-pencil m--font-brand"></i></a>
<a @click="onDelete(invoice)" class="m-btn btn btn-secondary"><i class="la la-trash m--font-danger"></i></a>
<a @click="onAnull(invoice)" class="m-btn btn btn-secondary"><i class="la la-close m--font-danger"></i></a>
</div>
</div>
</div> --}}

</div>
