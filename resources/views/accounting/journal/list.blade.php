<meta name="csrf-token" content="{{ csrf_token() }}">

<div>
    {{-- @details-open="(row, index) => $toast.open(`Expanded ${row.comment}`)" --}}
    <b-table :data="list" hoverable detailed detail-key="id">
        <template slot-scope="props">
            <b-table-column field="id" label="@lang('global.Date')">
                @{{ new Date(props.row.date).toLocaleDateString() }}
            </b-table-column>

            <b-table-column field="number" label="@lang('global.Number')">
                @{{ props.row.number }}
            </b-table-column>

            <b-table-column field="comment" label="@lang('global.Comment')">
                @{{ props.row.comment }}
            </b-table-column>

            <b-table-column field="comment" numeric label="@lang('accounting.Credit')">
                @{{ new Number(props.row.details.reduce((a,b) => a + Number(b.credit), 0)).toLocaleString() }}
            </b-table-column>
            <b-table-column field="comment" numeric label="@lang('accounting.Debit')">
                @{{ new Number(props.row.details.reduce((a,b) => a + Number(b.debit), 0)).toLocaleString() }}
            </b-table-column>

            <b-table-column custom-key="actions">

                <button v-on:click="onEdit(props.row.uuid)" type="button" class="btn btn-sm btn-info js-tooltip-enabled" data-toggle="tooltip" data-original-title="Edit">
                    <i class="fa fa-pen"></i>
                </button>

                <button v-on:click="onDelete(props.row)" type="button" class="btn btn-sm btn-danger js-tooltip-enabled" data-toggle="tooltip" data-original-title="Delete">
                    <i class="fa fa-trash"></i>
                </button>

            </b-table-column>
        </template>

        <template slot="detail" slot-scope="props">
            <div>
                <div class="row">
                    <div class="col-8">
                        <b>Account</b>
                    </div>
                    <div class="col-2 m--align-right">
                        <b>@lang('accounting.Credit')</b>
                    </div>
                    <div class="col-2 m--align-right">
                        <b>@lang('accounting.Debit')</b>
                    </div>
                </div>
                <div class="row" v-for="detail in props.row.details">
                    <div class="col-2 m--align-right">
                        <span v-if="detail.chart.type == 1" class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                            <b>@{{ detail.chart.code }}</b>
                        </span>
                        <span v-else-if="detail.chart.type == 2" class="m-badge m-badge--brand m-badge--wide m-badge--rounded">
                            <b>@{{ detail.chart.code }}</b>
                        </span>
                        <span v-else-if="detail.chart.type == 3" class="m-badge m-badge--warning m-badge--wide m-badge--rounded">
                            <b>@{{ detail.chart.code }}</b>
                        </span>
                        <span v-else-if="detail.chart.type == 4" class="m-badge m-badge--success m-badge--wide m-badge--rounded">
                            <b>@{{ detail.chart.code }}</b>
                        </span>
                        <span v-else-if="detail.chart.type == 5" class="m-badge m-badge--danger m-badge--wide m-badge--rounded">
                            <b>@{{ detail.chart.code }}</b>
                        </span>
                    </div>
                    <div class="col-6">
                        <p v-if="detail.chart !=null"> <span class="m--font-bold">@{{ detail.chart.name }}</span> </p>
                    </div>
                    <div class="col-2 m--align-right">
                        <p v-if="detail.credit > 0" class="m--font-bold "> @{{ new Number(detail.credit).toLocaleString() }} </p>
                        <p v-else class="m--font-metal"> 0 </p>
                    </div>
                    <div class="col-2 m--align-right">
                        <p v-if="detail.debit > 0" class="m--font-bold "> @{{ new Number(detail.debit).toLocaleString() }} </p>
                        <p v-else class="m--font-metal"> 0 </p>
                    </div>
                </div>
            </div>
        </template>
    </b-table>
    <b-pagination :total="meta.total" :current.sync="meta.current_page" :simple="false" :per-page="meta.per_page" @change="pageChange"> </b-pagination>
</div>
