<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <router-view name="Datatable"  :taxpayer="{{ request()->route('taxPayer')}}"  /> --}}

<credit-note-list :taxpayer="{{ request()->route('taxPayer')->id}}"  inline-template>
    <div>
      <button @click="add()">add new</button>
        <vue-good-table
        :columns="columns"
        :rows="rows"
        :paginate="true"
        :globalSearch="true"
        styleClass="m-datatable__table">

        {{-- SelectAll --}}
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

        {{-- Action Buttons --}}
        <template slot="table-row-after" slot-scope="props">
            <button @click="onEdit(rows[props.row.originalIndex])">Edit</button>
        </template>

        {{-- Checkbox --}}
        <template slot="table-row-before" slot-scope="props">
            <td>
                <label class="checkbox">
                    <input type="checkbox" v-model="rows[props.row.originalIndex].selected">
                </label>
            </td>
        </template>

        <tr class="m-datatable__row">
        </tr>

    </vue-good-table>
</div>
</purchases-list>
