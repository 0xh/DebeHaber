var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
Vue.component('account-payable-list',{

    props: ['taxpayer'],
    data(){
        return {
            columns: [
              {
                  label: 'SelectAll',
                  sortable: false,
              },
              {
                  label: ' Chart',
                  field: 'chart',
                  filterable: true,
              },
              {
                  label: 'Amount',
                  field: 'debit',
                  filterable: true,
              },
              {
                  label: 'Date',
                  field: 'date',
                  type: 'date',
                  inputFormat: 'YYYY-MM-DD',
                  outputFormat: 'MMM Do YY',
              },
              {
                  label: 'Action',
              },


            ],
            rows: [

            ],
        };
    },

    methods: {
        add()
        {
            var app=this;
            app.$parent.status=1;

            //app.$parent.$children[0].onReset();



        },

        init(){
            var app = this;
            $.ajax({
                url: '/api/get_account_payable/' + app.taxpayer,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {

                    app.rows = [];
                    app.rows=data;
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
                url: '/api/get_account_payableByID/' + app.taxpayer + '/' + data.id,
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
