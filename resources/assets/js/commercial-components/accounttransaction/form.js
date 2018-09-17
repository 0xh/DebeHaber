import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';
import axios from 'axios';
import MaskedInput from 'vue-masked-input';

Vue.component('account-form',
{
    components: {
        MaskedInput
    },

    props: ['trantype','charts','vats','accounts'],
    data() {
        return {

            id: 0,
            taxpayer_id:'',
            comment: '',
            payment_value:'',
            Value:'',
            Supplier:'',
            Customer:'',
            Paid :'',
            Balance: 0,
            SupplierTaxID:'',
            CustomerTaxID:'',
            customer_id: '',
            supplier_id: '',
            currency_id: '',
            rate: 1,
            chart_account_id: '',
            date: '',
            number: '',
            code_expiry: '',
            // accounts:[],
            currencies:[],
            //  charts:[],
            //  vats:[]
        }
    },


    methods:
    {

        onEdit: function(data)
        {
            console.log(data)
            var app = this;
            app.id = data.id;
            app.Customer = data.Customer;
            app.Supplier = data.Supplier;
            app.Paid = data.Paid;
            app.Value = data.Value;
            app.Balance = data.Balance;
            app.SupplierTaxID = data.SupplierTaxID;
            app.CustomerTaxID = data.CustomerTaxID;
            app.customer_id = data.customer_id;
            app.supplier_id = data.supplier_id;
            app.currency_id = data.currency_id;
            app.rate = data.rate;
            app.chart_account_id = data.chart_account_id;
            app.date = data.date;
            app.number = data.number;
            app.comment = data.comment;
            app.code_expiry = data.code_expiry;
            app.$parent.$parent.showList = false;
        },

        onReset: function(isnew)
        {
            var app = this;

            app.id = 0;
            app.Customer = null;
            app.Supplier = null;
            app.Paid =null;
            app.SupplierTaxID=null;
            app.CustomerTaxID=null;
            app.Value=null;
            app.Balance = 0;
            app.date = null;
            app.customer_id = null;
            app.supplier_id = null;
            app.currency_id = null;
            app.rate = null;
            app.chart_account_id = null;
            app.number = null;
            app.comment = null;
            app.code_expiry = null;

            if (isnew == false)
            {
                app.$parent.$parent.showList = true;
                app.$parent.onLoad(1);
            }
        },

        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json,isnew)
        {
            var app = this;
            var api = null;


            if (parseFloat(app.payment_value)>parseFloat(app.Balance))
            {
                alert('Payment Exceed..');
                return;
            }

            console.log(json);
            axios({
                method: 'post',
                url: '',
                responseType: 'json',
                data: json

            }).then(function (response)
            {
                if (response.status = 200 )
                {
                    alert('success...')
                    app.onReset(isnew);
                }
                else
                {
                    alert('Something Went Wrong...')
                }
            })
            .catch(function (error)
            {
                console.log(error);
                console.log(error.response);
            });
        },


        getRate: function()
        {
            var app = this;
            var url = '';

            if (app.transType == 4 || app.transType == 5)
            {
                url = '/api/' + app.$parent.taxpayer + '/get_buyRateByCurrency/' + app.currency_id + '/' + app.date;
            }
            else
            {
                url = '/api/' + app.$parent.taxpayer + '/get_sellRateByCurrency/' + app.currency_id + '/' + app.date;
            }

            axios.get(url).then(({ data }) => { app.rate = data; });
        },





        getCurrencies: function(data)
        {
            var app = this;
            axios.get('/api/' + app.$parent.taxpayer + '/get_currency' ,
        )
        .then(({ data }) =>
        {
            app.currencies = [];
            for(let i = 0; i < data.length; i++)
            {
                app.currencies.push({ name:data[i]['name'], id:data[i]['id'], isoCode:data[i]['code']});
                if (data[i]['code'] == this.taxpayerCurrency)
                {
                    app.currency_id = data[i]['id'];
                }
            }
        });

    },
    //Get Cost Centers
    getCharts: function(data)
    {
        var app = this;
        axios.get('/api/' + app.$parent.taxpayer + '/' + app.$parent.cycle + '/' +  app.$parent.baseurl + '/get-charts/',
    )
    .then(({ data }) =>
    {
        app.charts = [];
        for(let i = 0; i < data.length; i++)
        {
            app.charts.push({ name:data[i]['name'], id:data[i]['id'] });
        }

    });

},


init: function (data)
{
    var app = this;
    app.taxpayer_id = app.$parent.taxpayer;
}
},

mounted: function mounted()
{
    this.init();
    this.getCurrencies();
}
});
