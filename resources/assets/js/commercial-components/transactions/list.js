var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';
import axios from 'axios';
import list from 'list';

Vue.component('transaction-list',
{
    props: ['taxpayer', 'cycle', 'baseurl', 'taxpayercurrency'],
    data() {
        return {

            documents:[],
            accounts:[],
            currencies:[],
            charts:[],
            vats:[]
        }
    },


    methods:
    {

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
        getDocuments: function(data)
        {
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/get_documents/',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.documents = [];
                    for(let i = 0; i < data.length; i++)
                    {
                        app.documents.push({ name:data[i]['code'], id:data[i]['id'] });
                    }
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
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
                        app.currencies.push({ name:data[i]['name'], id:data[i]['id'], isoCode:data[i]['code']});
                        if (data[i]['code'] == this.taxpayerCurrency)
                        {
                            app.currency_id = data[i]['id'];
                        }
                    }
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
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/' +  this.baseurl + '/get-charts/',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.charts = [];
                    for(let i = 0; i < data.length; i++)
                    {
                        app.charts.push({ name:data[i]['name'], id:data[i]['id'] });
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
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/' +  this.baseurl + '/get-vats/',
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
        cancel()
        {
            var app = this;
            app.$parent.showList = true;
        }
    },
    mounted: function mounted()
    {
        this.getDocuments();
        this.getCurrencies();
        this.getCharts();
        this.getTaxes();
        this.getAccounts();
    }
});
