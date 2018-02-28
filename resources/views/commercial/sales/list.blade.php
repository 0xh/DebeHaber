<meta name="csrf-token" content="{{ csrf_token() }}">

<sales-list :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}"  inline-template>
    <div>
        <a href="#" v-on:click="add()" class="btn btn-outline-primary btn-sm m-btn m-btn--icon">
            <span>
                <i class="la la-plus"></i>
                <span>
                    @lang('global.New')
                </span>
            </span>
        </a>

        <datatable v-bind="$data" />
    </div>
</sales-list>
