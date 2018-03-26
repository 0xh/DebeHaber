var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
Vue.component('sales-list',{

    props: ['taxpayer','cycle'],
    data(){
        return {
            columns: [

                {
                    title: 'SelectAll',
                    sortable: false,
                },
                {
                    title: 'Code',
                    field: 'code',
                    filterable: true,
                },
                {
                    title: 'Number',
                    field: 'number',
                    filterable: true,
                },
                {
                    title: 'Date',
                    field: 'date',
                    type: 'date',
                    inputFormat: 'YYYY-MM-DD',
                    outputFormat: 'MMM Do YY',
                },
                {
                    title: 'Action',
                },

            ],
            data: [

            ],
            total: 0,
            query: {}
        };
    },

    methods:
    {
        init()
        {
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_sales' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.$children[1].data = [];
                    app.$children[1].data = data;
                },
                error: function(xhr, status, error)
                {
                    console.log(status);
                }
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
