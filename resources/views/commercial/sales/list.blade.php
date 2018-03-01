<meta name="csrf-token" content="{{ csrf_token() }}">

<sales-list :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}"  inline-template>
    <div>
        <div>
            <router-view name="create"  :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}" />
            </div>
            <div>
                <router-view name="List" :taxpayer="{{ request()->route('taxPayer')->id}}" :cycle="{{ request()->route('cycle')->id }}" inline-template>
                  <div>
                    <p><code>query: @{{ query }}</code></p>
                    <datatable v-bind="$data">
                      <button class="btn btn-default" @click="alertSelectedUids" :disabled="!selection.length">
                        <i class="fa fa-commenting-o"></i>
                        Alert selected uid(s)
                      </button>
                    </datatable>
                  </div>
                </router-view>
            </div>
        </div>
    </sales-list>
