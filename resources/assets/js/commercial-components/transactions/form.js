import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';
import axios from 'axios';
import MaskedInput from 'vue-masked-input';

Vue.component('transaction-form',
{
    components: {
        MaskedInput
    },

    props: ['trantype'],
    data() {
        return {

            id: 0,
            taxpayer_id:'',
            Value:'',
            type:'',
            Supplier:'',
            Customer:'',
            SupplierTaxID:'',
            CustomerTaxID:'',
            customer_id: '',
            supplier_id: '',
            document_id: '',
            currency_id: '',
            chart_account_id:'',
            rate: 1,
            payment_condition: '',
            date: '',
            number: '',
            code: '',
            code_expiry: '',
            comment: '',
            ref_id: '',
            details: [
                // id
                // transaction_id
                // chart_id
                // chart_vat_id
                // value
                // vat
                // taxExempt
                // taxable
            ],
            documents:[],
            currencies:[],
            charts:[],
            vats:[],
            accounts:[]
        }
    },

    computed:
    {
        condition: function()
        {
            if (this.payment_condition > 0)
            { return 'Crédito'; }
            return 'Contado';
        },

        grandTotal: function()
        {
            var app = this;
            var total = new Number(0);
            for (let i = 0; i < app.details.length; i++)
            {
                total += parseFloat(new Number(app.details[i].value)).toFixed(2);
            }

            return total;
        },

        grandTaxExempt: function()
        {

            var app = this;
            var totalTaxExempt = new Number(0);

            for (let i = 0; i < app.details.length; i++)
            {
                if (app.details[i].taxExempt != null) {
                    totalTaxExempt +=  parseFloat(new Number(app.details[i].taxExempt)).toFixed(2);
                }
            }
            return totalTaxExempt;
        },

        grandTaxable: function()
        {
            var app = this;
            var totaltaxable = 0;
            for (let i = 0; i < app.details.length; i++)
            {
                totaltaxable += parseFloat(app.details[i].taxable).toFixed(2);
            }
            return totaltaxable;
        },

        grandVAT: function()
        {
            var app = this;
            var total = 0;
            for (let i = 0; i < app.details.length; i++)
            {
                total += parseFloat(app.details[i].vat).toFixed(2);
            }

            return total;
        }
    },

    methods:
    {
        addDetail: function()
        {
            this.details.push({ id:0, value:0, chart_vat_id:1, chart_id:0, vat:0, taxExempt:0, taxable:0 })
        },

        //Removes Detail. Make sure it removes the correct detail, and not in randome.
        deleteDetail: function(detail)
        {
            let index = this.details.indexOf(detail)
            this.details.splice(index, 1)
        },

        onEdit: function(data)
        {

            console.log(data);
            var app = this;

            app.id = data.id;
            app.type = data.type;
            app.Customer = data.customer;
            app.Supplier = data.supplier;
            app.SupplierTaxID = data.SupplierTaxID;
            app.CustomerTaxID = data.CustomerTaxID;
            app.Value = data.Value;
            app.customer_id = data.customer_id;
            app.chart_account_id = data.chart_account_id;
            app.supplier_id = data.supplier_id;
            app.document_id = data.document_id;
            app.currency_id = data.currency_id;
            app.currency_code = data.currency_code;
            app.rate = data.rate;
            app.payment_condition = data.payment_condition;
            app.date = data.date;
            app.number = data.number;
            app.code = data.code;
            app.code_expiry = data.code_expiry;
            app.comment = data.comment;
            app.ref_id = data.ref_id;
            app.details = data.details;

            for (var i = 0; i < app.details.length; i++)
            {

                app.onPriceChange(app.details[i]);
            }

            if (app.type == 4 || app.type == 5)
            {
                app.$children[0].selectText = data.customer;
                app.$children[0].id = data.customer_id ;
            }
            else
            {
                app.$children[0].selectText = data.supplier;
                app.$children[0].id = data.supplier_id ;
            }

            app.$parent.$parent.showList = false;
        },

        onReset: function(isnew)
        {
            var app = this;

            app.id = 0;
            app.type = null;
            app.Customer = null;
            app.Supplier = null;
            app.SupplierTaxID = null;
            app.CustomerTaxID = null;
            app.Value = null;
            app.currency_code = null;
            app.date = null;
            app.chart_account_id = null;
            app.customer_id = null;
            app.supplier_id = null;
            app.document_id = null;
            app.currency_id = null;
            app.rate = null;
            app.payment_condition = null;

            app.number = null;
            app.code = null;
            app.code_expiry = null;
            app.comment = null;
            app.ref_id = null;
            app.details = [];

            if (isnew == false)
            {
                app.$parent.$parent.showList = true;
            }
        },

        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json,isnew)
        {
            var app = this;
            var api = null;
            //app.type = app.trantype;

            if (this.$children[0] != null) {
                if (app.type == 4 || app.type == 5)
                {
                    app.customer_id = this.$children[0].id;
                }
                else
                {
                    app.supplier_id = this.$children[0].id;
                }
            }

            axios({
                method: 'post',
                url: '',
                responseType: 'json',
                data: json
            }).then(function (response)
            {
                if (response.status = 200 )
                {
                    app.onReset(isnew);
                }
                else
                {
                    alert('Something Went Wrong...')
                }
            })
            .catch(function (error)
            {
                console.log(error.response);
            });
        },

        changeDocument: function()
        {
            var app = this;
            axios.get('/api/' + app.$parent.taxpayer + '/get_documentByID/' + app.document_id + '')
            .then(({ data }) =>
            {
                app.number = data.current_range + 1;
                app.code = data.code;
                app.code_expiry = data.code_expiry;
            });
        },

        getRate: function()
        {
            var app = this;
            var url = '';

            url = '/api/' + app.$parent.taxpayer + '/get_rates/' + app.currency_id + '/' + app.date;
            if (app.transType == 4 || app.transType == 5)
            {
                axios.get(url).then(({ data }) => { app.rate = data.buy_rate; });
            }
            else
            {
                axios.get(url).then(({ data }) => { app.rate = data.sell_rate; });
            }
        },

        onPriceChange: function(detail)
        {
            var app = this;

            for (let i = 0; i < app.vats.length; i++)
            {
                if (detail.chart_vat_id == app.vats[i].id)
                {
                    //check if tax exempt
                    if (app.vats[i].coefficient == '0.0000')
                    {
                        detail.taxExempt = parseFloat(detail.value).toFixed(2);
                        detail.taxable = 0;
                    }
                    else
                    {
                        detail.taxExempt = 0;
                        detail.taxable = parseFloat(new Number(detail.value) / (1 + new Number(app.vats[i].coefficient))).toFixed(2);
                    }

                    //calculate vat
                    detail.vat = parseFloat(new Number(detail.value) - (new Number(detail.taxable))).toFixed(2);
                }
            }
        },

        getAccounts: function(data)
        {
            var app = this;
            axios
            .get('/api/' + app.$parent.taxpayer + '/' + app.$parent.cycle + '/accounting/chart/get-money_accounts')
            .then(({ data }) =>
            {
                app.accounts = [];
                for(let i = 0; i < data.length; i++)
                {
                    app.accounts.push({ name:data[i]['name'], id:data[i]['id'] });
                }
            });
        },

        getDocuments: function(data)
        {
            var app = this;
            axios.get('/api/' + app.$parent.taxpayer + '/get_documents/' + app.transType)
            .then(({ data }) =>
            {
                app.documents = [];
                for(let i = 0; i < data.length; i++)
                {
                    app.documents.push({ name:data[i]['code'], id:data[i]['id'] });
                }
            });

        },

        getCurrencies: function()
        {
            var app = this;

            axios.get('/api/' + app.$parent.taxpayer + '/get_currency' )
            .then(({ data }) =>
            {
                app.currencies = [];

                for(let i = 0; i < data.length; i++)
                {
                    app.currencies.push({ name:data[i]['name'], id:data[i]['id'], isoCode:data[i]['code']});
                    // if (data[i]['code'] == this.taxpayerCurrency)
                    // {
                    //     app.currency_id = data[i]['id'];
                    // }
                }
            });

        },

        //Get Cost Centers
        getCharts: function(data)
        {
            var app = this;
            axios.get('/api/' + app.$parent.taxpayer + '/' + app.$parent.cycle + '/' +  app.$parent.baseurl + '/get-charts/')
            .then(({ data }) =>
            {
                app.charts = [];
                for(let i = 0; i < data.length; i++)
                {
                    app.charts.push({ name:data[i]['name'], id:data[i]['id'] });
                }
            });
        },

        //VAT
        getTaxes: function()
        {
            var app = this;
            axios.get('/api/' + app.$parent.taxpayer + '/' + app.$parent.cycle + '/' +  app.$parent.baseurl + '/get-vats/')
            .then(({ data }) =>
            {
                app.vats = [];
                for(let i = 0; i < data.length; i++)
                {
                    app.vats.push({
                        name:data[i]['name'],
                        id:data[i]['id'],
                        coefficient:data[i]['coefficient']
                    });
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
        this.type=this.trantype;
        //this.init();
        this.getCharts();
        this.getTaxes();
        this.getAccounts();
        this.getDocuments();
        this.getCurrencies();
    }
});
