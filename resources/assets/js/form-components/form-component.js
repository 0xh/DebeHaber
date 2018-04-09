var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';
import InfiniteLoading from 'vue-infinite-loading';
import axios from 'axios';

Vue.component('form-view',
{
    props: ['taxpayer', 'cycle', 'baseurl', 'taxpayercurrency'],
    data() {
        return {
            list: [],
            selectedList :[],
            total: 0,
            skip: 0,
            pageSize: 100,
            search: '',

            documents:[],
            accounts:[],
            currencies:[],
            charts:[],
            vats:[]
        }
    },

    computed:
    {
        filteredList()
        {
            return this.list;
        }
    },

    components:
    {
        InfiniteLoading,
    },

    methods:
    {
        infiniteHandler($state)
        {
            var app = this;
            axios.get('/api/' + this.taxpayer + '/' + this.cycle + '/' + this.baseurl + '/' + app.skip + '',
            {
                params:
                {
                    page: app.list.length / 100 + 1,
                },
            })
            .then(({ data }) =>
            {
                if (data.length > 0)
                {
                    for (let i = 0; i < data.length; i++)
                    {
                        app.list.push(data[i]);
                    }

                    app.skip += app.pageSize;
                    $state.loaded();
                }
                else
                {
                    $state.complete();
                }
            });
        },

        onEdit: function(data)
        {
            var app = this;
            app.$parent.showList = false;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/' +  this.baseurl + '/by-id/' + data,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.$children[0].onEdit(data[0]);
                },
                error: function(xhr, status, error)
                {
                    console.log(status);
                }
            });
        },

        onDelete: function(data)
        {
            //SweetAlert message and confirmation.
            var app = this;
            $.ajax({
                url: '/taxpayer/' + this.taxpayer + '/' + this.cycle + '/' + this.baseurl + '/' + data.ID,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'delete',
                dataType: 'json',
                async: true,
                success: function(responsedata)
                {
                    for (var i = 0; i < app.list.length; i++) {
                        if (data.ID == app.list[i].ID)
                        {
                            app.list.splice(i,1);
                        }
                    }
                    //console.log(data);
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },
        onAnull: function(data)
        {
            //SweetAlert message and confirmation.
            var app = this;
            $.ajax({
                url: '/taxpayer/' + this.taxpayer + '/' + this.cycle + '/' +  this.baseurl + '/anull/' + data.ID,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(responsedata)
                {
                    data.Value=0;
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },
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
                        app.documents.push({name:data[i]['code'],id:data[i]['id']});
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
