<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <router-view name="Datatable"  :taxpayer="{{ request()->route('taxPayer')}}"  /> --}}

<sales-list :taxpayer="{{ request()->route('taxPayer')->id}}"  inline-template>
  <div>

 <datatable v-bind="$data" />
</div>
</sales-list>
