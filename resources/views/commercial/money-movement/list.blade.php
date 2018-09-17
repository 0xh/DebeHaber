<div>
  <b-table :data="list" hoverable :loading="isLoading">
    <template slot-scope="props">
      <b-table-column field="date" label="@lang('global.Date')" numeric sortable>
        @{{ new Date(props.row.Date).toLocaleDateString() }}
      </b-table-column>

      <b-table-column field="chart.name" label="@lang('commercial.Account')" sortable>
        @{{ props.row.chart.name }}
      </b-table-column>

      <b-table-column field="number" label="@lang('commercial.InvoiceNumber')" sortable>
        @{{ props.row.transaction!=null?props.row.transaction.number:"" }}
      </b-table-column>

      <b-table-column field="debit" label="@lang('accounting.Debit')" numeric sortable>
        @{{ new Number(props.row.Debit).toLocaleString() }}
      </b-table-column>

      <b-table-column field="credit" label="@lang('accounting.Credit')" numeric sortable>
        @{{ new Number(props.row.Credit).toLocaleString() }}
      </b-table-column>

      <b-table-column field="Currency">
        <span v-if="props.row.debit > 0" class="m-badge m-badge--danger m-badge--wide m-badge--rounded">
          @{{ props.row.currency.code }}
        </span>
        <span v-else class="m-badge m-badge--success m-badge--wide m-badge--rounded">
          @{{ props.row.currency.code }}
        </span>
      </b-table-column>

      <b-table-column custom-key="actions" numeric>
        <a v-if="props.row.transaction_id == ''" href="#" v-on:click="onEdit(props.row.id)" class="btn btn-outline-primary btn-sm m-btn m-btn--icon">
          <i class="la la-pencil"></i>
        </a>
      </b-table-column>
      <b-table-column custom-key="actions" numeric>

        <a href="#" v-on:click="onDelete(props.row)" class="btn btn-outline-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
          <i class="fa fa-trash"></i>
        </a>

      </b-table-column>
    </template>
  </b-table>
  <b-pagination :total="meta.total" :current.sync="meta.current_page" :simple="false" :per-page="meta.per_page" @change="pageChange"> </b-pagination>
</div>
