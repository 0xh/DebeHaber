<meta name="csrf-token" content="{{ csrf_token() }}">
<b-table :data="list" hoverable :loading="isLoading">
    <template slot-scope="props">
        <b-table-column field="Customer" label="@lang('commercial.Customer')">

              @{{ props.row.Customer }}

        </b-table-column>

        <b-table-column field="Number" label="@lang('commercial.InvoiceNumber')">
            @{{ props.row.Number }}


        </b-table-column>
        <b-table-column field="Date" label="@lang('commercial.InvoiceNumber')">
            @{{ props.row.Date  }}
        </b-table-column>
        <b-table-column field="Expiry" label="@lang('commercial.InvoiceNumber')">
            @{{ props.row.Expiry  }}
        </b-table-column>
        <b-table-column field="Value" label="@lang('commercial.InvoiceNumber')">
            @{{ props.row.Value  }}
        </b-table-column>
        <b-table-column field="Balance" label="@lang('commercial.InvoiceNumber')">
            @{{ props.row.Balance  }}
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

<b-pagination :total="meta.total" :current.sync="meta.current_page" :simple="false" :per-page="meta.per_page" @change="pageChange"> </b-pagination>
