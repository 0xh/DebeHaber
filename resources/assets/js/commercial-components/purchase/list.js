var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
Vue.component('purchases-list',{

    props: ['taxpayer','cycle'],
    data(){
        return {
            columns: [
                {
                    label: 'SelectAll',
                    sortable: false,
                },
                {
                    label: 'Code',
                    field: 'code',
                    filterable: true,
                },
                {
                    label: 'Number',
                    field: 'number',
                    filterable: true,
                },
                {
                    label: 'Date',
                    field: 'date',
                    type: 'date',
                    inputFormat: 'YYYY-MM-DD',
                    outputFormat: 'MMM Do YY',
                },
                {
                    label: 'Action',
                },

            ],
            rows: [

            ],
        };
    },

    methods:
    {
        add()
        {
            var app = this;
            app.$parent.status = 1;
            console.log(app.$parent.$children[0]);
        },

        init(){
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_purchases' ,
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
        onEdit: function(id)
        {

            var app = this;
            app.$parent.status=1;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_purchasesByID/' + id ,
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
            this.allSelected =! this.allSelected;
            this.rows.forEach(row => {
                if(this.allSelected)
                {
                    row.selected = true;
                }
                else
                {
                    row.selected = false;
                }
            })
        }
    },

    mounted: function mounted()
    {
        var app = this;
        this.init();
    }
});
