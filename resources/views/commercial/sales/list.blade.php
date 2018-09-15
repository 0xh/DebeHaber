<div>
    <b-table :data="list" hoverable :loading="isLoading">
        <template slot-scope="props">
            <b-table-column field="Date" label="@lang('global.Date')" sortable>
                <small>
                    @{{ new Date(props.row.Date).toLocaleDateString() }}
                </small>
            </b-table-column>

            <b-table-column field="Customer" label="@lang('commercial.Customer')" sortable>
                @{{ props.row.Customer }}

                <small class="m--font-metal">
                    @{{ props.row.CustomerTaxID }}
                </small>
            </b-table-column>

            <b-table-column field="Number" label="@lang('commercial.InvoiceNumber')" sortable>
                @{{ props.row.Number }}
                <small v-if="props.row.PaymentCondition > 0" class="m--font-bold m--font-info"> Credit </small>
                <small v-else class="m--font-bold m--font-success"> Cash</small>
            </b-table-column>

            <b-table-column field="Value" label="@lang('global.Total')" numeric sortable>
                @{{ new Number(props.row.Value).toLocaleString() }}
                <span class="m-badge m-badge--metal m-badge--wide m-badge--rounded">
                    @{{ props.row.Currency }}
                </span>
            </b-table-column>

            <b-table-column custom-key="actions" numeric>

                <a href="#" v-on:click="onEdit(props.row.ID)" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="la la-pencil"></i>
                </a>

                <a href="#" v-on:click="onAnull(props.row)" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="la la-close"></i>
                </a>

                <a href="#" v-on:click="onDelete(props.row)" class="btn btn-outline-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="fa fa-trash"></i>
                </a>

            </b-table-column>
        </template>
    </b-table>

    <b-pagination :total="meta.total" order="is-centered" :rounded="true" :current.sync="meta.current_page" :simple="false" :per-page="meta.per_page" @change="pageChange"> </b-pagination>
</div>
