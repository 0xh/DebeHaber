

<div>
    <b-table :data="list" hoverable :loading="isLoading">
        <template slot-scope="props">
            <b-table-column field="Date" label="@lang('global.Date')">
                <small>
                    @{{ new Date(props.row.Date).toLocaleDateString() }}
                </small>
            </b-table-column>

            <b-table-column field="Customer" label="@lang('commercial.Supplier')">
                @{{ props.row.Supplier }}

                <small class="m--font-metal">
                    @{{ props.row.SupplierTaxID }}
                </small>
            </b-table-column>

            <b-table-column field="Number" label="@lang('commercial.InvoiceNumber')">
                @{{ props.row.Number }}
                <small v-if="props.row.PaymentCondition > 0" class="m--font-bold m--font-info"> Credit </small>
                <small v-else class="m--font-bold m--font-success"> Cash</small>
            </b-table-column>

            <b-table-column field="Value" label="@lang('global.Total')" numeric>
                @{{ new Number(props.row.Value).toLocaleString() }}
                <small class="m--font-brand">
                    @{{ props.row.Currency }}
                </small>
            </b-table-column>

            <b-table-column custom-key="actions">

                <button v-on:click="onEdit(props.row.ID)" type="button" class="btn btn-outline-info btn-sm m-btn m-btn--icon">
                    <span>
                        <i class="fa fa-pencil"></i>
                        <span>@lang('global.Edit')</span>
                    </span>
                </button>

                <button v-on:click="onDelete(props.row)" type="button" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa fa-trash"></i>
                </button>

            </b-table-column>
        </template>
          @include('layouts/infinity-loading')
    </b-table>

    <b-pagination :total="meta.total" :current.sync="meta.current_page" :simple="false" :per-page="meta.per_page" @change="pageChange"> </b-pagination>
</div>
