
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('transaction',{

    data() {
        return {
            id:0,
            type:'',
            customer_id:'',
            supplier_id:'',
            document_id:'',
            currency_id:'',
            rate: '',
            payment_condition:'',
            chart_account_id:'',
            date:'',
            number:'',
            code:'',
            code_expiry:'',
            comment:'',
            ref_id:'',
            list: [
              //     {
              //     id:0,
              //     transaction_id:'',
              //     chart_id:'',
              //     chart_vat_id:0,
              //     value:''

              // }
            ],

        }
    },

    methods: {


        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json)
        {
            var app=this;
            var api=null;

            $.ajax({
                url: '/store_transaction/',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'post',
                data:json,
                dataType: 'json',
                async: false,
                success: function(data)
                {
                    if (data=='ok') {
                        app.id=0;
                        app.type=null;
                        app.customer_id=null;
                        app.supplier_id=null;
                        app.document_id=null;
                        app.currency_id=null;
                        app.rate=null;
                        app.payment_condition=null;
                        app.chart_account_id=null;
                        app.date=null;
                        app.number=null;
                        app.code=null;
                        app.code_expiry=null;
                        app.comment=null;
                        app.ref_id=null;
                        app.details=[];
                        app.init();
                    }
                    else {
                        alert('Something Went Wrong...')
                    }


                },
                error: function(xhr, status, error)
                {
                    console.log(error);
                }
            });
        },
        onEdit: function(data)
        {
            var app=this;
            app.id=data.id;
            app.type=data.type;
            app.customer_id=data.customer_id;
            app.supplier_id=data.supplier_id;
            app.document_id=data.document_id;
            app.currency_id=data.currency_id;
            app.rate=data.rate;
            app.payment_condition=data.payment_condition;
            app.chart_account_id=data.chart_account_id;
            app.date=data.date;
            app.number=data.number;
            app.code=data.code;
            app.code_expiry=data.code_expiry;
            app.comment=data.comment;
            app.ref_id=data.ref_id;
        },
        init(){
            var app=this;
            $.ajax({
                url: '/get_transactions/' ,
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.id=data.id;
                    app.type=data.type;
                    app.customer_id=data.customer_id;
                    app.supplier_id=data.supplier_id;
                    app.document_id=data.document_id;
                    app.currency_id=data.currency_id;
                    app.rate=data.rate;
                    app.payment_condition=data.payment_condition;
                    app.chart_account_id=data.chart_account_id;
                    app.date=data.date;
                    app.number=data.number;
                    app.code=data.code;
                    app.code_expiry=data.code_expiry;
                    app.comment=data.comment;
                    app.ref_id=data.ref_id;

                    app.list=[];
                    for(let i = 0; i < data.length; i++)
                    {

                        app.list.push({transaction_id:data[i]['name'],chart_id:data[i]['id'],
                                        chart_vat_id:data[i]['chart_vat_id'],value: data[i]['value']   });
                    }

                },
                error: function(xhr, status, error)
                {
                    console.log(status);
                }
            });
        }
    },

    mounted: function mounted() {

        this.init()






    }
});
