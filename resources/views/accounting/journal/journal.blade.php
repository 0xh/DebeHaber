<meta name="csrf-token" content="{{ csrf_token() }}">
<router-view name="Journal"  inline-template>
  <div>
    @{{query}}
    <datatable v-bind="$data">
      <button class="btn btn-default" @click="alertSelectedUids" :disabled="!selection.length">
        <i class="fa fa-commenting-o"></i>
        Alert selected uid(s)
      </button>
    </datatable>
  </div>
</router-view>
