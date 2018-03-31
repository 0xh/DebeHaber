
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('account-payable-form',{
    props: ['taxpayer', 'cycle'],
    data() {
        return {
            id:0,
            ID:'',
            taxpayer_id:'',
            Supplier:'',
            SupplierTaxID:'',
            Currency:'',
            CurrencyID:'',
            PaymentCondition:'',
            Date:'',
            Expiry:'',
            Number:'',
            Paid:'',
            Value:'',
            chart_id:'',
            payment_value:'',
            comment:'',
            currencies:[],
            charts:[]
        }
    },


    methods: {


        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json,isnew)
        {

            var app = this;
            var api = null;
            this.taxpayer_id=this.taxpayer;
            $.ajax({
                url: '',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'post',
                data:json,
                dataType: 'json',
                async: false,
                success: function(data)
                {
                    if (data=='ok')
                    {
                        app.onReset(isnew);

                    }
                    else
                    {
                        alert('Something Went Wrong...')
                    }


                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },

        onReset: function(isnew)
        {
            var app=this;
            app.ID=0;
            app.Supplier = null;
            app.SupplierTaxID = null;
            app.Currency = null;
            app.CurrencyID = null;
            app.PaymentCondition = null;
            app.Date = null;
            app.Expiry = null;
            app.Number = null;
            app.Paid = null;
            app.Value = null;
            app.chart_id = null;
            app.payment_value = null;
            app.comment = null;
            if (isnew==false) {
                app.$parent.status=0;
            }


        },

        cancel()
        {
            var app=this;
            app.$parent.status=0;
        },
        getCurrencies: function(data)
        {
            var app=this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/get_currency' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.currencies=[];
                    for(let i = 0; i < data.length; i++)
                    {
                        app.currencies.push({name:data[i]['name'],id:data[i]['id']});
                    }

                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },

        getRate: function()
        {

            var app=this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/get_rateByCurrency/' + app.currency_id + '/' + app.date  ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {

                    if (app.rate=='' || app.rate==null) {
                        app.rate=data;
                    }


                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },
        onEdit: function(data)
        {
            console.log(data);
            var app = this;
            app.ID=data.ID;
            app.Supplier = data.Supplier;
            app.SupplierTaxID = data.SupplierTaxID;
            app.Currency = data.Currency;
            app.CurrencyID = data.CurrencyID;
            app.PaymentCondition = data.PaymentCondition;
            app.Date = data.Date;
            app.Expiry = data.Expiry;
            app.Number = data.Number;
            app.Paid = data.Paid;
            app.Value = data.Value;

        },

        getCharts: function(data)
        {
            var app=this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/accounting/chart/get_money-accounts',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.charts = [];
                    for(let i = 0; i < data.length; i++)
                    {
                        app.charts.push({name:data[i]['name'],id:data[i]['id']});
                    }

                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        }
    },

    mounted: function mounted()
    {
        this.getCurrencies();
        this.getCharts();
    }
});
