



<div>
    <div class="row">
        <div class="col-8">
            <button v-on:click="onCycleBudgetSave($data)" class="btn btn-primary">
                @lang('global.Save')
            </button>
        </div>
        <div class="col-2">
            <span class="m--font-boldest">
                @lang('accounting.Code')
            </span>
        </div>
        <div class="col-2">
            <span class="m--font-boldest">
                @lang('global.Account')
            </span>
        </div>
        <div class="col-2">
            <span class="m--font-boldest">
                @lang('global.Debit')
            </span>
        </div>
        <div class="col-2">
            <span class="m--font-boldest">
                @lang('global.Credit')
            </span>
        </div>
    </div>
    <hr>
    <div class="row m--margin-5" v-for="data in budgetlist">
        <div class="col-2 m--align-left">
            @{{ data.code }}
        </div>
        <div class="col-2">
            @{{ data.name }}
        </div>
        <div v-if="data.is_accountable" class="col-2">
            <input type="number" v-model="data.debit" name="">
        </div>
        <div v-if="data.is_accountable" class="col-2">
            <input type="number" v-model="data.credit" name="">
        </div>
    </div>
</div>
