<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <router-view name="Datatable"  :taxpayer="{{ request()->route('taxPayer')}}"  /> --}}

<sales-list :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}"  inline-template>
  <div>
    <button @click="add()">add new</button>
 <datatable v-bind="$data" />
</div>
</sales-list>
