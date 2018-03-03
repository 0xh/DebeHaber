
<script>
import Vue from 'vue'
import mockData from './datatable/_mockData'
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
          { title: 'ID', field: 'id', label: 'ID', sortable: true, visible: 'true' },
          { title: 'Code', field: 'code', visible: false, thComp: 'FilterTh', tdComp: 'Email' },
          { title: 'Number', field: 'number', thComp: 'FilterTh', tdStyle: { fontStyle: 'italic' } },
          { title: 'Date', field: 'date',type: 'date',inputFormat: 'YYYY-MM-DD',outputFormat: 'MMM Do YY'},

          { title: 'Operation', tdComp: 'Opt', visible: 'true' }
        ]
        const groupsDef = {
          Normal: ['Code', 'Number', 'Date'],
          Sortable: ['Code', 'Number', 'Date'],
          Extra: ['Operation']
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
      tabledata:[],

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
      alert(this.selection.map(({ id }) => id))
    },
    onEdit: function(data)
    {

      var app = this;
      app.$parent.$parent.status=1;
      $.ajax({
        url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_salesByID/' + data,
        type: 'get',
        dataType: 'json',
        async: true,
        success: function(data)
        {


          app.$parent.$parent.$children[0].onEdit(data[0]);


        },
        error: function(xhr, status, error)
        {
          console.log(status);
        }
      });

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
