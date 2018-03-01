
<script>
import Vue from 'vue'

import components from './datatable/comps/'

export default {
  components,
  name: 'FriendsTable', // `name` is required as a recursive component
  props: ['row','cycle','taxpayer'], // from the parent FriendsTable (if exists)
  data () {
    const amINestedComp = !!this.row

    return {
      supportBackup: true,
      supportNested: true,
      tblClass: 'table-bordered',
      tblStyle: 'color: #666',
      pageSizeOptions: [5, 10, 15, 20],
      columns: (() => {
        const cols = [
          {
              title: 'Code',
              field: 'code',
              filterable: true,
          },
          {
              title: 'Number',
              field: 'number',
              filterable: true,
          },
          {
              title: 'Date',
              field: 'date',
              type: 'date',
              inputFormat: 'YYYY-MM-DD',
              outputFormat: 'MMM Do YY',
          },
          { title: 'Operation', tdComp: 'Opt', visible: 'true' }
        ]
        const groupsDef = {
          Normal: ['Code', 'Number', 'Date'],
          Sortable: ['Code', 'Number', 'Date']

        }
        return cols.map(col => {
          Object.keys(groupsDef).forEach(groupName => {
            if (groupsDef[groupName].includes(col.title)) {
              col.group = groupName
            }
          })
          return col
        })
      })(),
      data: [],
      total: 0,
      selection: [],
      summary: {},

      // `query` will be initialized to `{ limit: 10, offset: 0, sort: '', order: '' }` by default
      // other query conditions should be either declared explicitly in the following or set with `Vue.set / $vm.$set` manually later
      // otherwise, the new added properties would not be reactive
      query: amINestedComp ? { uid: this.row.friends } : {},

      // any other staff that you want to pass to dynamic components (thComp / tdComp / nested components)
      xprops: {
        eventbus: new Vue()
      }
    }
  },
  methods: {

    alertSelectedUids () {
      alert(this.selection.map(({ uid }) => uid))
    }
  },
  mounted: function mounted()
  {
    var app=this;
    $.ajax({
        url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_sales' ,
        type: 'get',
        dataType: 'json',
        async: true,
        success: function(data)
        {

            app.data = [];
            app.data=data;

        },
        error: function(xhr, status, error)
        {
            console.log(status);
        }
    });

  }
}
</script>
<style>
.w-240 {
  width: 240px;
}
</style>
