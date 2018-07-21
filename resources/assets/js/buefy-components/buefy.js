var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
Vue.component('buefy',
{
    props: ['taxpayer', 'cycle', 'baseurl'],
    data() {
        return {
            list: [],
            meta: [{total:0}],
            isLoading: true
        };
    },

    methods: {
        onLoad(page)
        {
            axios
            .get('/api/' + this.taxpayer + '/' + this.cycle + '/' + this.baseurl)
            .then(response => {
                this.isLoading = false;

                this.list = response.data.data;
                this.meta = response.data.meta;
            }).catch(error => {
                this.isLoading = false;
            });
        },
        pageChange (page) {
            var app = this;
            app.onLoad(page);
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
                    app.$children[0].onEdit(data[0]);
                },
                error: function(xhr, status, error)
                {
                    console.log(status);
                }
            });
        },
        onDeleteAccount: function(data)
        {
            this.fromid = data.id;
            this.fromname = data.name;
            this.isActive = true;
        },
        onDelete: function(data)
        {
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
                    data.Value = 0;
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },
    },

    mounted: function mounted()
    {
        var app = this;
        app.onLoad();
    }
});
