<meta name="csrf-token" content="{{ csrf_token() }}">

<div>
    {{-- @details-open="(row, index) => $toast.open(`Expanded ${row.comment}`)" --}}
    <b-table :data="list" hoverable detailed detail-key="id">
        <template slot-scope="props">
            <b-table-column field="id" label="ID">
                @{{ props.row.uuid }} | @{{ props.row.date }}
            </b-table-column>

            <b-table-column field="number" label="Number">
                @{{ props.row.number }}
            </b-table-column>

            <b-table-column field="comment" label="Comment">
                @{{ props.row.comment }}
            </b-table-column>

            <b-table-column custom-key="actions">
                <button v-on:click="onEdit(props.row.uuid)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" data-original-title="Delete">
                    <i class="la la-pencil m--font-brand"></i>
                </button>
                <button v-on:click="onDelete(props.row)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" data-original-title="Delete">
                    <i class="fa fa-trash"></i>
                </button>
            </b-table-column>
        </template>

        <template slot="detail" slot-scope="props">
            <div class="media-content">
                <div class="content">
                    <div class="row" v-for="detail in props.row.details">
                        <div class="col-8">
                            <p v-if="detail.chart !=null"> @{{ detail.chart.code }} | <span class="m--font-bold">@{{ detail.chart.name }}</span> </p>
                        </div>
                        <div class="col-2 m--align-right">
                            <p v-if="detail.credit > 0" class="m--font-bold "> @{{ new Number(detail.credit).toLocaleString() }} </p>
                            <p v-else class="m--font-metal"> - </p>
                        </div>
                        <div class="col-2 m--align-right">
                            <p v-if="detail.debit > 0" class="m--font-bold "> @{{ new Number(detail.debit).toLocaleString() }} </p>
                            <p v-else class="m--font-metal"> - </p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </b-table>
    <b-pagination :total="meta.total" :current.sync="meta.current_page" :simple="false" :per-page="meta.per_page" @change="pageChange"> </b-pagination>
</div>
