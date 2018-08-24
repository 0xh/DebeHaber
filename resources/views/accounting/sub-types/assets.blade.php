<div class="col-4">
    <label class="m-option m-option m-option--plain">
        <span class="m-option__control">
            <span class="m-radio m-radio--info m-radio--check-bold">
                <input type="radio" v-model="sub_type" value="{{ $value }}">
                <span></span>
            </span>
        </span>
        <span class="m-option__label">
            <span class="m-option__head">
                <span class="m-option__title">
                    <span class="m--font-bolder">{{ $label }}</span>
                </span>
            </span>
            <span class="m-option__body m--font-metal">
                @if ($value == 1)
                    @lang('accounting.descBankAccount')
                @elseif ($value == 3)
                    @lang('accounting.descPettyCash')
                @endif
            </span>
        </span>
    </label>
</div>
