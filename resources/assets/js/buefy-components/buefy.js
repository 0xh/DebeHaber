var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('buefy',
{
    props: ['taxpayer', 'cycle', 'baseurl'],
    data() {
        return {
            list: [],
            item: [],
            meta: [{total:0}],
            isLoading: true,
            isActive : false,
            data :[]
        };
    },

    methods: {
        onLoad(page)
        {
          console.log(page);
            axios
            .get('/api/' + this.taxpayer + '/' + this.cycle + '/' + this.baseurl + '?page=' + page)
            .then(response => {

                this.isLoading = false;
                this.list = response.data.data;
                this.meta = response.data.meta;
                this.data = response.data;
            }).catch(error => {
                this.isLoading = false;
            });
        },
        pageChange (page)
        {
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
                    console.log(data);
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
                url: '/' + this.taxpayer + '/' + this.cycle + '/' + this.baseurl + '/' + data.ID,
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
        onDeleteAccount: function(data)
        {
            var app = this;
            app.item = data;
            app.isActive = true;
        },
        saveOpeningClosingBalance : function(json)
        {
            var app=this;
            axios({
                method: 'post',
                url: '',
                responseType: 'json',
                data: json
            }).then(function (response)
            {

                if (response.status = 200 )
                {

                    

                    app.onLoad(0);
                    alert("Save Success...")
                }
                else
                {
                    alert('Something Went Wrong...')
                }
            })
            .catch(function (error)
            {
              console.log(error);
                console.log(error.response);
            });
        }
    },

    mounted: function mounted()
    {
        var app = this;
        app.onLoad(1);
    }
});
