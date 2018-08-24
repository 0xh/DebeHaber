<meta name="csrf-token" content="{{ csrf_token() }}">
<b-table :data="list" hoverable :loading="isLoading">
    <template slot-scope="props">
        <b-table-column label="@lang('commercial.Chart')">
            @{{ props.row.chart.name }}
        </b-table-column>

        <b-table-column  label="@lang('commercial.InvoiceNumber')">
            @{{ props.row.transaction.number }}
        </b-table-column>

        <b-table-column field="debit" numeric label="@lang('global.Debit')">
            @{{ new Number(props.row.debit).toLocaleString() }}
        </b-table-column>
        <b-table-column field="credit" numeric label="@lang('global.Credit')">
            @{{ new Number(props.row.credit).toLocaleString() }}
        </b-table-column>

        <b-table-column custom-key="actions" numeric>
            <a href="#" v-on:click="onEdit(props.row.id)" class="btn btn-outline-primary btn-sm m-btn m-btn--icon">
                <i class="la la-pencil"></i>
            </a>
        </b-table-column>
    </template>
</b-table>
