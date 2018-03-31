var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

import MaskedInput from 'vue-masked-input';

Vue.component('sales-form', {
    components: {
        MaskedInput
    },

    props: ['taxpayer','trantype','cycle'],
    data() {
        return {
            id:0,
            type:this.trantype,
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
            details: [
                //     {
                //     id:0,
                //     transaction_id:0,
                //     chart_id:'',
                //     chart_vat_id:0,
                //     value:0,
                //     vat:0,
                //     taxExempt:0,
                //     taxable:0,
                //
                // }
            ],
            documents:[],
            accounts:[],
            currencies:[],
            charts:[],
            vats:[]
        }
    },

    computed: {
        condition: function()
        {
            if (this.payment_condition > 0)
            { return 'Crédito'; }
            return 'Contado';
        },

        grandTotal: function()
        {
            var app = this;
            var total = 0.0;
            for (let i = 0; i < app.details.length; i++)
            {

                total += parseFloat(app.details[i].value).toFixed(2) ;
            }

            return parseFloat(total).toFixed(2);
        },

        grandTaxExempt: function()
        {
            var total = 0.0;
            for(let i = 0; i < this.details.length; i++)
            {
                total += parseFloat(this.details[i].taxExempt).toFixed(2);
            }

            return parseFloat(total).toFixed(2);
        },

        grandTaxable: function()
        {
            var app = this;
            var total = 0.0;

            for (let i = 0; i < app.details.length; i++)
            {
                total += parseFloat(app.details[i].taxable).toFixed(2);
            }

            return parseFloat(total).toFixed(2);
        },

        grandVAT: function()
        {
            var total = 0.0;
            for (let i = 0; i < this.details.length; i++)
            {
                total += parseFloat(this.details[i].vat).toFixed(2);
            }

            return parseFloat(total).toFixed(2);
        }
    },

    methods: {
        addDetail: function()
        {
            this.details.push({ id:0, value:0, chart_vat_id:1, chart_id:0,vat:0,taxExempt:0,taxable:0 })
        },

        //Removes Detail. Make sure it removes the correct detail, and not in randome.
        deleteDetail: function(detail)
        {
            let index = this.details.indexOf(detail)
            this.details.splice(index, 1)
        },

        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json,isnew)
        {
            var app = this;
            var api = null;
            app.type = app.trantype;

            this.customer_id = this.$children[0].id;

            $.ajax({
                url: '',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'post',
                data:json,
                dataType: 'json',
                async: false,
                success: function(data)
                {
                    if (data == 'ok')
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
        onEdit: function(data)
        {
            var app = this;
            app.id = data.id;
            app.type = data.type;
            app.customer_id = data.customer_id;
            app.supplier_id = data.supplier_id;
            app.document_id = data.document_id;
            app.currency_id = data.currency_id;
            app.rate = data.rate;
            app.payment_condition = data.payment_condition;
            app.chart_account_id = data.chart_account_id;
            app.date = data.date;
            app.number = data.number;
            app.code = data.code;
            app.code_expiry = data.code_expiry;
            app.comment = data.comment;
            app.ref_id = data.ref_id;
            app.details = data.details;
            app.$children[0].selectText = data.customer;
            app.$children[0].id = data.customer_id;
        },
        onReset: function(isnew)
        {
            var app=this;
            app.id = 0;
            app.type = null;
            app.customer_id = null;
            app.supplier_id = null;
            app.document_id = null;
            app.currency_id = null;
            app.rate = null;
            app.payment_condition = null;
            app.chart_account_id = null;
            app.number = null;
            app.code = null;
            app.code_expiry = null;
            app.comment = null;
            app.ref_id = null;
            app.details = [];
            if (isnew==false) {
                app.$parent.status = 0;
            }

        },

        getDocuments: function(data)
        {
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/get_documents/1/',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.documents = [];
                    for(let i = 0; i < data.length; i++)
                    {
                        app.documents.push({name:data[i]['code'],id:data[i]['id']});
                    }

                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },

        changeDocument: function()
        {
            var app = this;

            $.ajax({
                url: '/api/' + this.taxpayer + '/get_documentByID/' + app.document_id   ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.number = data.current_range + 1;
                    app.code = data.code;
                    app.code_expiry = data.code_expiry;
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },

        cancel()
        {
            var app = this;
            app.$parent.status = 0;
        },

        getCurrencies: function(data)
        {
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/get_currency' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.currencies = [];
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
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/get_buyRateByCurrency/' + app.currency_id + '/' + app.date  ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.rate = data;
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },

        //Get Cost Centers
        getCharts: function(data)
        {
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/accounting/chart/get_item-sales' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.charts = [];
                    for(let i = 0; i < data.length; i++)
                    {
                        app.charts.push({ name : data[i]['name'], id : data[i]['id'] });
                    }

                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },

        //VAT
        getTaxes: function(data)
        {
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/accounting/chart/get_vat-debit' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
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

                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },

        onPriceChange: function(detail)
        {
            var app = this;

            for (let i = 0; i < app.vats.length; i++)
            {
                if (detail.chart_vat_id == app.vats[i].id)
                {
                    if (parseFloat(app.vats[i].coefficient) > 0)
                    {
                        if (app.vats[i].coefficient == '0.00')
                        {
                            detail.taxExempt = parseFloat(parseFloat(detail.value).toFixed(2) / (1 + parseFloat(app.vats[i].coefficient))).toFixed(2);
                        }
                        else
                        {
                            detail.taxable = parseFloat(parseFloat(detail.value).toFixed(2) / (1 + parseFloat(app.vats[i].coefficient))).toFixed(2);
                        }
                    }

                    detail.vat = parseFloat(parseFloat(detail.value).toFixed(2) - (  detail.taxable == 0 ?   detail.taxExempt :   detail.taxable)).toFixed(2);
                }
            }
        },
        //Get Money Accounts
        getAccounts: function(data)
        {
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/accounting/chart/get_money-accounts' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.accounts = [];
                    for(let i = 0; i < data.length; i++)
                    {
                        app.accounts.push({name:data[i]['name'],id:data[i]['id']});
                    }
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },

        init: function (data){
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_lastDate' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {

                    if (app.date==null) {

                        app.date = data;

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
        this.init();
        this.getDocuments();
        this.getCurrencies();
        this.getCharts();
        this.getTaxes();
        this.getAccounts();
    }
});
