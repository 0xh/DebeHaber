
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('cycle',
{
    props: ['taxpayer', 'cycle', 'cycles', 'versions'],
    data() {
        return {
            id: 0,
            chart_version_id: '',
            year: '',
            start_date: '',
            end_date: '',
            list: [],
            chartversions: [],
        }
    },

    methods:
    {
        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json)
        {
            var app = this;
            var api = null;

            axios({
                method: 'post',
                url: '/taxpayer/' + app.taxpayer + '/' + app.cycle + '/cycles/store',
                responseType: 'json',
                data: json

            }).then(function (response)
            {
            
                if (response.data == 'ok')
                {
                    app.id = 0;
                    app.chart_version_id = null;
                    app.year = null ;
                    app.start_date = null;
                    app.end_date = null;
                    app.init();
                }
                else
                {
                    alert('Something went Wrong...')
                }
            })
            .catch(function (error)
            {
                console.log(error);
            });
            // $.ajax({
            //     url: '',
            //     headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            //     type: 'post',
            //     data:json,
            //     dataType: 'json',
            //     async: false,
            //     success: function(data)
            //     {
            //
            //         if (data == 'ok') {
            //             app.id = 0;
            //             app.chart_version_id = null;
            //             app.year = null ;
            //             app.start_date = null;
            //             app.end_date = null;
            //             app.init();
            //         }
            //         else {
            //             alert('Something Went Wrong...')
            //         }
            //
            //
            //     },
            //     error: function(xhr, status, error)
            //     {
            //         console.log(xhr.responseText);
            //     }
            // });
        },
        onEdit: function(data)
        {
            var app = this;

            app.id = data.id;
            app.chart_version_id = data.chart_version_id;
            app.chart_version_name = data.chart_version_name;
            app.year = data.year;
            app.start_date = data.start_date;
            app.end_date = data.end_date;
        },

        init()
        {
            var app = this;
            app.taxpayer_id = app.$parent.taxpayer;
            app.list = app.cycles;
            app.chartversions = app.versions;
            // $.ajax({
            //     url: '/api/' + this.taxpayer + '/get_cycle/' ,
            //     headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            //     type: 'get',
            //     dataType: 'json',
            //     async: true,
            //     success: function(data)
            //     {
            //         app.list = [];
            //         for(let i = 0; i < data.length; i++)
            //         {
            //             var start_date = moment(data[i]['start_date']).format('YYYY-MM-DD');
            //             var end_date = moment(data[i]['end_date']).format('YYYY-MM-DD');
            //             app.list.push({chart_version_id:data[i]['chart_version_id'],id:data[i]['id']
            //             ,chart_version_name:data[i]['chart_version_name'],year:data[i]['year']
            //             ,start_date:start_date,end_date:end_date});
            //         }
            //
            //     },
            //     error: function(xhr, status, error)
            //     {
            //         console.log(status);
            //     }
            // });
        }
    },

    mounted: function mounted()
    {
        var app = this;
        app.init();
    //     $.ajax({
    //         url: '/api/' + this.taxpayer +'/get_chartversion/' ,
    //         headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
    //         type: 'get',
    //         dataType: 'json',
    //         async: true,
    //         success: function(data)
    //         {
    //             app.chartversions = [];
    //             for(let i = 0; i < data.length; i++)
    //             {
    //                 app.chartversions.push({name:data[i]['name'],id:data[i]['id']});
    //             }
    //         },
    //         error: function(xhr, status, error)
    //         {
    //             console.log(status);
    //         }
    //     });
    }
});
