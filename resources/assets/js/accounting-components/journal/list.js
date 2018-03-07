var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
Vue.component('journals-list',{

    props: ['taxpayer','cycle'],
    data(){
        return {
            columns: [

                {
                    title: 'SelectAll',
                    sortable: false,
                },
                {
                    title: 'Comment',
                    field: 'comment',
                    filterable: true,
                },
                {
                    title: 'Number',
                    field: 'number',
                    filterable: true,
                },
                {
                    title: 'Debit',
                    field: 'debit',
                    filterable: true,
                },
                {
                    title: 'Credit',
                    field: 'credit',
                    filterable: true,
                },
                {
                    title: 'Date',
                    field: 'date',
                    type: 'date',
                    inputFormat: 'YYYY-MM-DD',
                    outputFormat: 'MMM Do YY',
                },
                {
                    title: 'Action',
                },

            ],
            data: [

            ],
            total: 0,
            query: {}
        };
    },

    methods: {


        init(){
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/accounting/journal/get' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {

                    app.$children[0].data = [];
                    app.$children[0].data=data;


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
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_salesByID/' + data,
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
            this.data.forEach(row => {
                if(this.allSelected){
                    data.selected = true;
                }else{
                    data.selected = false;
                }
            })
        }
    }
});
