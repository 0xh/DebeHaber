
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('chart',{

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
            ref_id:''
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
            app.chart_version_id=data.chart_version_id;
            app.country=data.country;
            app.is_accountable=data.is_accountable;
            app.code=data.code;
            app.name=data.name;
            app.level=data.level;
            app.type=data.type;
            app.sub_type=data.sub_type;
        },
        init(){
            var app=this;
            $.ajax({
                url: '/get_chart/' ,
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.list=[];
                    for(let i = 0; i < data.length; i++)
                    {
                        app.list.push({name:data[i]['name'],id:data[i]['id']});
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
