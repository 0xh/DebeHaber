
<div class="m-form__heading">
    <h3 class="m-form__heading-title">Opening Balance</h3>
</div>

<div>
    <button v-on:click="onJournalSave(opening_balance)" class="btn btn-primary">
        @lang('global.Save')
    </button>

    <div class="row">
        <div class="col-2">
            <span class="m--font-boldest">
                @lang('global.Code')
            </span>
        </div>
        <div class="col-6">
            <span class="m--font-boldest">
                @lang('commercial.Account')
            </span>
        </div>
        <div class="col-2">
            <span class="m--font-boldest">
                @lang('accounting.Debit')
            </span>
        </div>
        <div class="col-2">
            <span class="m--font-boldest">
                @lang('accounting.Credit')
            </span>
        </div>
    </div>

    <hr>

    <div class="row m--margin-bottom-10" v-for="balance in opening_balance">
        <div class="col-1">
            @{{ balance.id }}
        </div>
        <div class="col-2 m--align-left">
            <span v-if="balance.type == 1" class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                <b>@{{ balance.code }}</b>
            </span>
            <span v-else-if="balance.type == 2" class="m-badge m-badge--brand m-badge--wide m-badge--rounded">
                <b>@{{ balance.code }}</b>
            </span>
            <span v-else-if="balance.type == 3" class="m-badge m-badge--warning m-badge--wide m-badge--rounded">
                <b>@{{ balance.code }}</b>
            </span>
            <span v-else-if="balance.type == 4" class="m-badge m-badge--success m-badge--wide m-badge--rounded">
                <b>@{{ balance.code }}</b>
            </span>
            <span v-else-if="balance.type == 5" class="m-badge m-badge--danger m-badge--wide m-badge--rounded">
                <b>@{{ balance.code }}</b>
            </span>
            <span v-else class="m-badge m-badge--metal m-badge--wide m-badge--rounded">
                <b>@{{ balance.code }}</b>
            </span>
        </div>
        <div class="col-5">
            @{{ balance.name }}
        </div>
        <div v-if="balance.is_accountable" class="col-2">
            <b-input placeholder="@lang('accounting.Debit')" v-model="balance.debit" type="number" min="0"></b-input>
        </div>
        <div v-if="balance.is_accountable" class="col-2">
            <b-input placeholder="@lang('accounting.Credit')" v-model="balance.credit" type="number" min="0"></b-input>
        </div>
    </div>

    <button v-on:click="onJournalSave(opening_balance)" class="btn btn-primary">
        @lang('global.Save')
    </button>
</div>
