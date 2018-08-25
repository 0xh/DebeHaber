<div class="col-4">
    <label class="m-option m-option m-option--plain">
        <span class="m-option__control">
            <span class="m-radio m-radio--danger m-radio--check-bold">
                <input type="radio" v-model="type" value="{{ $value }}">
                <span></span>
            </span>
        </span>
        <span class="m-option__label">
            <span class="m-option__head">
                <span class="m-option__title">
                    <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">
                        {{ $label }}
                    </span>
                </span>
            </span>
            <span class="m-option__body m--font-metal">
                @lang('accounting.descExpense')
            </span>
        </span>
    </label>
</div>
