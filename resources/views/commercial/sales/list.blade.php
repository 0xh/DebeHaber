<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <router-view name="Datatable"  :taxpayer="{{ request()->route('taxPayer')}}"  /> --}}

  <sales-list :taxpayer="{{ request()->route('taxPayer')->id}}"  inline-template>
    <div>
      <vue-good-table
      :columns="columns"
      :rows="rows"
      :paginate="true"
      >
      <template slot="table-column" slot-scope="props">
        <span v-if="props.column.label =='SelectAll'">
          <label class="checkbox">
            <input
            type="checkbox"
            @click="toggleSelectAll()">
          </label>
        </span>
        <span v-else>
          @{{props.column.label}}
        </span>
      </template>
      <template slot="table-row-after" slot-scope="props">
        <button @click="onEdit(rows[props.row.originalIndex])">Edit</button>
      </template>
      <template slot="table-row-before" slot-scope="props">
        <td>
          <label class="checkbox">
            <input type="checkbox" v-model="rows[props.row.originalIndex].selected">
          </label>
        </td>
      </template>
    </vue-good-table>
  </div>
  </sales-list>
