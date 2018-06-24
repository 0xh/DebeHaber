<meta name="csrf-token" content="{{ csrf_token() }}">

<div>
    <div class="row">
        <div class="col-8">
            <p class="m--font-boldest m--font-transform-u">@lang('accounting.ChartofAccounts')</p>
        </div>
        <div class="col-2">
            <p class="m--align-right m--font-boldest m--font-transform-u">@lang('accounting.Credit')</p>
        </div>
        <div class="col-2">
            <p class="m--align-right m--font-boldest m--font-transform-u">@lang('accounting.Debit')</p>
        </div>
    </div>

    <div class="m--margin-bottom-5" v-for="journal in list">
        <div class="row">
            <div class="col-2">
                <p> @{{ journal.id }} | @{{ journal.date }} </p>
            </div>

            <div class="col-1">
                <p> @{{ journal.number }} </p>
            </div>

            <div class="col-7">
                <p class="m--font-bolder"> @{{ journal.comment }} </p>
            </div>

            <div class="col-2">
                <div class="m-btn-group btn-group-sm m-btn-group--pill btn-group" role="group" aria-label="...">
                    <a class="m-btn btn btn-secondary"><i class="la la-check m--font-success"></i></a>
                    <a @click="onEdit(journal.id)" class="m-btn btn btn-secondary"><i class="la la-pencil m--font-brand"></i></a>
                    <a @click="onDelete(journal)" class="m-btn btn btn-secondary"><i class="la la-trash m--font-danger"></i></a>
                </div>
            </div>
        </div>
        <div class="row" v-for="detail in journal.details">
            <div class="col-8">
                <p> @{{ detail.chart.code }} | <span class="m--font-bold">@{{ detail.chart.name }}</span> </p>
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

    <infinite-loading force-use-infinite-wrapper="true" @infinite="infiniteHandler">
        <span slot="no-more">
            No more data
        </span>
    </infinite-loading>
</div>
