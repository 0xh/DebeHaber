
<div class="m-form__heading">
    <h3 class="m-form__heading-title">Opening Balance</h3>
</div>

<div>
    <button v-on:click="onJournalSave($data)" class="btn btn-primary">
        @lang('global.Save')
    </button>

    <div class="row">
        <div class="col-2">
            <span class="m--font-boldest">
                @lang('accounting.Code')
            </span>
        </div>
        <div class="col-4">
            <span class="m--font-boldest">
                @lang('global.Account')
            </span>
        </div>
        <div class="col-3">
            <span class="m--font-boldest">
                @lang('global.Debit')
            </span>
        </div>
        <div class="col-3">
            <span class="m--font-boldest">
                @lang('global.Credit')
            </span>
        </div>
    </div>

    <hr>

    <div class="row m--margin-bottom-10" v-for="data in chartlist">
        <div class="col-2 m--align-left">
            @{{ data.code }}
        </div>
        <div class="col-4">
            @{{ data.name }}
        </div>
        <div v-if="data.is_accountable" class="col-3">
            <input type="number" v-model="data.debit" name="">
        </div>
        <div v-if="data.is_accountable" class="col-3">
            <input type="number" v-model="data.credit" name="">
        </div>
    </div>

    <button v-on:click="onJournalSave($data)" class="btn btn-primary">
        @lang('global.Save')
    </button>
</div>
