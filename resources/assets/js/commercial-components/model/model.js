var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';
import InfiniteLoading from 'vue-infinite-loading';
import axios from 'axios';

Vue.component('model',
{
    props: ['taxpayer', 'cycle', 'url','editurl','deleteurl'],
    data() {
        return {
            list: [],
            selectedList :[],
            total: 0,
            skip: 0,
            pageSize: 100,
            search: '',
            status : 0
        }
    },

    computed: {

        filteredList() {

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
            axios.get('/api/' + this.taxpayer + '/' + this.cycle + '/' + this.url + '/' + app.skip + '',
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

        created() {

        },
        onEdit: function(data)
        {

            var app = this;
            app.status = 1;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle +  this.editurl + data,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    // console.log(data);
                    //console.log(app.$children[0].$parent);
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
            var app=this;
            $.ajax({
                url: '/taxpayer/' + this.taxpayer + '/' + this.cycle + '/' + this.deleteurl + '/' + data.ID,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'delete',
                dataType: 'json',
                async: true,
                success: function(responsedata)
                {
                  for (var i = 0; i < app.list.length; i++) {
                      if (data.ID==app.list[i].ID)
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
    }
});
