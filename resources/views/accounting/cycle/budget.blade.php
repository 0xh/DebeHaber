<div class="m-form__heading">
    <h3 class="m-form__heading-title">Budget Information</h3>
</div>
<div>
    <div>
        <button v-on:click="onCycleBudgetSave($data)" class="btn btn-primary">
            @lang('global.Save')
        </button>
        <div class="row">
            <div class="col-2">
                <span class="m--font-boldest">
                    @lang('global.Code')
                </span>
            </div>
            <div class="col-4">
                <span class="m--font-boldest">
                    @lang('accounting.ChartofAccounts')
                </span>
            </div>
            <div class="col-3">
                <span class="m--font-boldest">
                    @lang('accounting.Debit')
                </span>
            </div>
            <div class="col-3">
                <span class="m--font-boldest">
                    @lang('accounting.Credit')
                </span>
            </div>
        </div>
        <hr>
        <div class="row m--margin-bottom-10" v-for="data in budgetchart">
            <div class="col-2 m--align-right">
                @{{ data.code }}
            </div>
            <div class="col-4">
                @{{ data.name }}
            </div>
            <div v-if="data.is_accountable" class="col-3">
                <input type="number" v-model="data.debit">
            </div>
            <div v-if="data.is_accountable" class="col-3">
                <input type="number" v-model="data.credit">
            </div>
        </div>
    </div>
</div>
