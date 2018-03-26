<meta name="csrf-token" content="{{ csrf_token() }}">

<sales-list :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}" inline-template>
    <div>
        <div>
            <router-view name="create" :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}"></router-view>
        </div>
        <div>
            <p v-for="item in list">
                Line:
                <span v-text="item"></span>
            </p>
            <infinite-loading @infinite="infiniteHandler"></infinite-loading>
        </div>
    </div>
</sales-list>


{{-- <router-view name="List" :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}" inline-template>
<div>
<datatable v-bind="$data">

<button class="btn btn-default" @click="alertSelectedUids" :disabled="!selection.length">
<i class="fa fa-task"></i>
Alert selected uid(s)
</button>
</datatable>
</div>
</router-view> --}}
