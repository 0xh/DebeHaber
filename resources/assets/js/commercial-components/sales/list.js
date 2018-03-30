var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

import InfiniteLoading from 'vue-infinite-loading';
import axios from 'axios';

Vue.component('sales-list',
{
    props: ['taxpayer','cycle'],
    data()
    {
        return {
            list: [],
            selectedList :[],
            total: 0,
            skip: 0,
            pageSize: 100,
            search: '',
        };
    },

    computed: {
        filteredList() {
            return this.list; //.filter(x => {
                //return x.Number.toLowerCase().includes(this.search.toLowerCase())
            //})
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
            axios.get('/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_sales/' + app.skip + '',
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
        onselectedList: function(list)
        {
            var app = this;
            for (let i = 0; i < app.list.length; i++)
            {

                if (app.list[i]['IsSelected']==true)
                {
                    app.selectedList.push(app.list[i]);
                }
            }
            console.log(JSON.stringify(this.selectedList));
            axios({
                method: 'post',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                url: '/taxpayer/'+ this.taxpayer + '/' + this.cycle + '/generateJournals/',
                responseType: 'text',
                data:this.selectedList

            }).then(function (response)
            {
                console.log(response.data);

            })
            .catch(function (error)
            {
                console.log( error.response.data);
            });



        },


        onEdit: function(data)
        {
            var app = this;
            app.$parent.status = 1;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_salesByID/' + data,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.$parent.$children[0].onEdit(data[0]);
                },
                error: function(xhr, status, error)
                {
                    console.log(status);
                }
            });
        },

        toggleSelectAll()
        {
            this.allSelected = !this.allSelected;
            this.data.forEach(row => {
                if (this.allSelected)
                {
                    data.selected = true;
                }
                else
                {
                    data.selected = false;
                }
            })
        }
    }
});
