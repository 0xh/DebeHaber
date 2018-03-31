var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

import InfiniteLoading from 'vue-infinite-loading';
import axios from 'axios';

Vue.component('account-payable-list',{
    props: ['taxpayer','cycle'],
    data(){
        return {
            list: [],
            total: 0,
            skip: 0,
            pageSize: 100,
            search: '',
        };
    },

    computed: {
        filteredList() {
            return this.list;
            // return this.list.filter(x => {
            //     return x.Number.toLowerCase().includes(this.search.toLowerCase())
            // })
        },
        Today(){
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
            axios.get('/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_account_payables/' + app.skip + '',
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

        add()
        {
            var app = this;
            app.$parent.status = 1;
        },

        onEdit: function(data)
        {
          console.log(data);
            var app = this;
            app.$parent.status = 1;
            $.ajax({
                url: '/api/'+ this.taxpayer + '/' + this.cycle + '/commercial/get_account_payableByID/' + data,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    console.log(data);
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
            this.rows.forEach(row => {
                if(this.allSelected){
                    row.selected = true;
                } else {
                    row.selected = false;
                }
            })
        }
    }
});
