
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';

Vue.use(VueSweetAlert);

Vue.component('fixedasset',{

    props: ['taxpayer','cycle','charts'],
    data() {
        return {
            id : 0,
            chart_id : '',
            currency_id : '',
            rate : '',
            serial : '',
            name : '',
            purchase_date :  '',
            purchase_value : '',
            current_value : '',
            quantity : '',
            sales_date : null,
            list: [
                // id:0
                // chart_id
                // chart_name
                // serial
                // name
                // purchase_date
                // purchase_value
                // current_value
                // quantity
                // sales_date
            ],
            currencies:[],
        }
    },

    methods:
    {
        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json)
        {
            var app = this;
            var api = null;
            if (app.chart_id == '' || app.chart_id <= 0) {
                app.chart_id=app.$children[0].id;
            }

            $.ajax({
                url : '',
                headers : {'X-CSRF-TOKEN': CSRF_TOKEN},
                type : 'post',
                data : json,
                dataType : 'json',
                async : false,
                success: function(data)
                {
                    console.log(data);
                    if (data == 'Ok')
                    {
                        app.id = 0;
                        app.chart_id = null,
                        app.currency_id = null,
                        app.rate = null,
                        app.serial = null,
                        app.name = null,
                        app.purchase_date = null,
                        app.purchase_value = null,
                        app.current_value = null,
                        app.quantity = null,
                        app.sales_date = null,
                        app.$parent.$parent.showList = 1;
                        //app.init();
                    }
                    else
                    {
                        alert('Something Went Wrong...')
                    }
                },
                error: function(xhr, status, error)
                {
                    app.$swal('Something went wrong, check logs...' + status);
                    console.log(xhr.responseText);
                }
            });
        },

        onEdit: function(data)
        {
            console.log(data);
            var app = this;
            app.id = data.id;
            app.chart_id = data.chart_id,
            app.currency_id = data.currency_id,
            app.rate = data.rate,
            app.serial = data.serial,
            app.name = data.name ,
            app.purchase_date = data.purchase_date,
            app.purchase_value = data.purchase_value,
            app.current_value = data.current_value,
            app.quantity = data.quantity,
            app.sales_date = data.sales_date,
            app.$children[0].selectText=data.chart.name;
        },
        onDelete: function(data)
        {

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

},

mounted: function mounted()
{


    this.getCurrencies();

}


});
