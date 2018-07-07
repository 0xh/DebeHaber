<meta name="csrf-token" content="{{ csrf_token() }}">
<div>
    <div class="row">
        <div class="col-1">

        </div>
        <div class="col-6">
            <span class="m--font-boldest">
                @lang('accounting.Accounts')
            </span>
        </div>
        <div class="col-2">
            {{-- No Title --}}
        </div>

        <div class="col-2">
            <span class="m--font-boldest">
                @lang('global.Action')
            </span>
        </div>
    </div>

    <div class="row m--margin-5" v-for="data in list">
        <div class="col-2 m--align-left">
            <span v-if="data.type == 1" class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                <b>@{{ data.code }}</b>
            </span>
            <span v-else-if="data.type == 2" class="m-badge m-badge--brand m-badge--wide m-badge--rounded">
                <b>@{{ data.code }}</b>
            </span>
            <span v-else-if="data.type == 3" class="m-badge m-badge--warning m-badge--wide m-badge--rounded">
                <b>@{{ data.code }}</b>
            </span>
            <span v-else-if="data.type == 4" class="m-badge m-badge--success m-badge--wide m-badge--rounded">
                <b>@{{ data.code }}</b>
            </span>
            <span v-else-if="data.type == 5" class="m-badge m-badge--danger m-badge--wide m-badge--rounded">
                <b>@{{ data.code }}</b>
            </span>
        </div>

        <div class="col-5">
            <span v-if="data.is_accountable" class="m--font-bolder">
                @{{ data.name }}
            </span>
            <span v-else class="m--font-bolder m--font-metal m--font-transform-u">
                @{{ data.name }}
            </span>
        </div>
        <div class="col-2">
            <p>
                <span v-if="data.is_accountable" class="m--font-info">
                    @lang('accounting.IsAccountable')
                </span>
            </p>
        </div>
        <div class="col-3">
            <div v-if="data.taxpayer_id != null" class="m-btn-group btn-group-sm m-btn-group--pill btn-group" role="group" aria-label="...">
                <button @click="onView(data)" class="m-btn btn btn-success"><i class="la la-eye"></i></button>
                <button @click="onEdit(data.id)" class="m-btn btn btn-primary"><i class="la la-pencil"></i></button>
                <button @click="onDeleteChart(data)" class="m-btn btn btn-secondary"><i class="la la-trash m--font-danger"></i></button>
                {{-- <a @click="onMigrate(data)" class="m-btn btn btn-secondary"><i class="la la-forward m--font-warning"></i></a> --}}
            </div>
            <div v-else class="m-btn-group btn-group-sm m-btn-group--pill btn-group" role="group" aria-label="...">
                <button disabled class="m-btn btn btn-metal"></button>
                <button disabled class="m-btn btn btn-secondary">Classification Account</button>
            </div>
        </div>
    </div>

    <infinite-loading force-use-infinite-wrapper="true" @infinite="infiniteHandler">
        <span slot="no-more">
            No more data
        </span>
    </infinite-loading>
</div>
