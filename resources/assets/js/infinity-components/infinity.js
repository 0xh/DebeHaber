var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';
import InfiniteLoading from 'vue-infinite-loading';
import axios from 'axios';

Vue.component('infinity',
{
    props: ['taxpayer', 'cycle', 'baseurl'],
    data() {
        return {
            list: [],
            selectedList :[],
            total: 0,
            skip: 0,
            pageSize: 100,
            search: '',

        }
    },

    computed:
    {
        filteredList()
        {
            return this.list;
        },


        Today: function Today() {
            return new Date();
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
                url: '/api/' + app.taxpayer + '/' + app.cycle + '/' +  app.baseurl + '/by-id/' + data,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                  console.log('/api/' + app.taxpayer + '/' + app.cycle + '/' +  app.baseurl + '/by-id/' + data);
                    app.$children[0].onEdit(data[0]);

                },
                error: function(xhr, status, error)
                {
                    console.log(status);
                }
            });
        },
        onDeleteChart: function(data)
          {
              console.log('ad');
              window.location="http://localhost:8000/taxpayer/769164/16/accounting/merge-charts-index/" + data.id + "/" + data.name
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

        cancel()
        {
            var app = this;
            app.$parent.showList = true;
        }
    },
    mounted: function mounted()
    {

    }
});
