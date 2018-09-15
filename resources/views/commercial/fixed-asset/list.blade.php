
<div>
    <b-table :data="list" hoverable :loading="isLoading">
        <template slot-scope="props">
            <b-table-column field="purchase_date" label="@lang('commercial.PurchaseDate')" numeric sortable>
                <small>
                    @{{ new Date(props.row.purchase_date).toLocaleDateString() }}
                </small>
            </b-table-column>

            <b-table-column field="chart" label="@lang('accounting.ChartofAccounts')" sortable>
                @{{ props.row.chart.id }}

                <small class="m--font-metal">
                    @{{ props.row.chart.code }}
                </small>
            </b-table-column>

            <b-table-column field="name" width="512" label="@lang('commercial.FixedAssets')" sortable>
                @{{ props.row.name }}
            </b-table-column>

            <b-table-column field="quantity" label="@lang('global.Quantity')" numeric sortable>
                @{{ new Number(props.row.quantity).toLocaleString() }}
            </b-table-column>

            <b-table-column field="purchase_value" label="@lang('commercial.PurchaseValue')" numeric sortable>
                @{{ new Number(props.row.purchase_value).toLocaleString() }}
            </b-table-column>

            <b-table-column custom-key="actions" numeric>
                <a v-on:click="onEdit(props.row.id)" class="m--font-metal" href="#">
                    <i class="fa fa-pencil-alt"></i>
                </a>
            </b-table-column>
        </template>
    </b-table>

    <b-pagination :total="meta.total" order="is-centered" :rounded="true" :current.sync="meta.current_page" :simple="false" :per-page="meta.per_page" @change="pageChange"> </b-pagination>
</div>
