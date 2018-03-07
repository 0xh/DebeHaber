var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('list',{

    props: ['taxpayer','cycle','row'],
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
            { title: 'UID', field: 'uid', label: 'User ID', sortable: true, visible: 'true' },
            { title: 'Email', field: 'email', visible: false, thComp: 'FilterTh', tdComp: 'Email' },
            { title: 'Username', field: 'name', thComp: 'FilterTh', tdStyle: { fontStyle: 'italic' } },
            { title: 'Country', field: 'country', thComp: 'FilterTh', thStyle: { fontWeight: 'normal' } },
            { title: 'IP', field: 'ip', visible: false, tdComp: 'IP' },
            { title: 'Age', field: 'age', sortable: true, thClass: 'text-info', tdClass: 'text-success' },
            { title: 'Create time', field: 'createTime', sortable: true, colClass: 'w-240', thComp: 'CreatetimeTh', tdComp: 'CreatetimeTd' },
            { title: 'Color', field: 'color', explain: 'Favorite color', visible: false, tdComp: 'Color' },
            { title: 'Language', field: 'lang', visible: false, thComp: 'FilterTh' },
            { title: 'PL', field: 'programLang', explain: 'Programming Language', visible: false, thComp: 'FilterTh' },
            { title: 'Operation', tdComp: 'Opt', visible: 'true' }
          ]
          const groupsDef = {
            Normal: ['Email', 'Username', 'Country', 'IP'],
            Sortable: ['UID', 'Age', 'Create time'],
            Extra: ['Operation', 'Color', 'Language', 'PL']
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
        add()
        {
            var app=this;
            app.$parent.status=1;
            console.log(app.$parent.$children[0]);
            //app.$parent.$children[0].onReset();



        },

        init(){
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_credit_note' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {

                  app.$children[1].data = [];
                  app.$children[1].data=data;
                    // for(let i = 0; i < data.length; i++)
                    // {
                    //     app.rows.push({
                    //         selected: false,
                    //         id : data[i]['id'],
                    //         type : data[i]['type'],
                    //         customer_id : data[i]['customer_id'],
                    //         supplier_id : data[i]['supplier_id'],
                    //         document_id : data[i]['document_id'],
                    //         currency_id : data[i]['currency_id'],
                    //         rate : data[i]['rate'],
                    //         payment_condition : data[i]['payment_condition'],
                    //         chart_account_id : data[i]['chart_account_id'],
                    //         date : data[i]['date'],
                    //         number : data[i]['number'],
                    //         code : data[i]['code'],
                    //         code_expiry :data[i]['code_expiry'],
                    //         comment :data[i]['comment'],
                    //         ref_id :data[i]['ref_id'],
                    //         details : data[i]['details']
                    //     });
                    // }
                },
                error: function(xhr, status, error)
                {
                    console.log(status);
                }
            });
        },
        onEdit: function(data)
        {

            var app = this;
            app.$parent.status=1;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_credit_noteByID/' + data,
                  headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {


                    app.$parent.$children[0].onEdit(data[0]);


                },
                error: function(xhr, status, error)
                {
                    console.log(status);
                }
            });

        },
        toggleSelectAll() {
            this.allSelected = !this.allSelected;
            this.rows.forEach(row => {
                if(this.allSelected){
                    row.selected = true;
                }else{
                    row.selected = false;
                }
            })
        }
    },

    mounted: function mounted()
    {
        var app=this;
        this.init();

    }
});
