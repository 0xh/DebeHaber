<div class="col-4">
    <label class="m-option m-option m-option--plain">
        <span class="m-option__control">
            <span class="m-radio m-radio--info m-radio--check-bold">
                <input type="radio" v-model="type" value="{{ $value }}">
                <span></span>
            </span>
        </span>
        <span class="m-option__label">
            <span class="m-option__head">
                <span class="m-option__title">
                    <span class="m--font-bolder">

                        <span class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                            {{ $label }}
                        </span>

                    </span>
                </span>
            </span>
            <span class="m-option__body m--font-metal">
                @lang('enum.descAsset')
            </span>
        </span>
    </label>
</div>
