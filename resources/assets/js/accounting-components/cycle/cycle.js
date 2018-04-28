
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('cycle',
{
    props: ['taxpayer', 'cycle', 'cycles', 'versions','charts','budgetchart','budgets'],
    data() {
        return {
            id: 0,
            chart_version_id: '',
            year: '',
            start_date: '',
            end_date: '',
            list: [],
            chartversions: [],
            chartlist:[],
            budgetlist:[]
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
                    app.$parent.showCycle=0;
                    app.init();
                }
                else
                {
                    console.log(response);
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

        onJournalSave: function(json)
        {
            var app = this;
            var api = null;

            axios({
                method: 'post',
                url: '/api/' + app.taxpayer + '/' + app.cycle + '/accounting/journalstore',
                responseType: 'json',
                data: app.chartlist

            }).then(function (response)
            {

                if (response.data == 'ok')
                {

                    app.$parent.showCycle = 0;
                }
                else
                {

                    alert('Something went Wrong...')
                }
            })
            .catch(function (error)
            {
                console.log(error.response);
            });

        },
        onCycleBudgetSave: function(json)
        {
            var app = this;

            axios({
                method: 'post',
                url: '/api/' + app.taxpayer + '/' + app.cycle + '/accounting/cyclebudgetstore',
                responseType: 'json',
                data: app.budgetlist

            }).then(function (response)
            {

                if (response.data == 'ok')
                {
                    for (var i = 0; i < app.budgetlist.length; i++) {

                        app.budgetlist[i].credit=0;
                        app.budgetlist[i].debit=0;
                    }
                    app.$parent.showCycle = 0;
                }
                else
                {
                    console.log(response);
                    alert('Something went Wrong...')
                }
            })
            .catch(function (error)
            {
                console.log(error.response);
            });

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
            app.$parent.showCycle = 1;

            for (var i = 0; i < app.budgetchart.length; i++) {
                for (var j = 0; j < app.budgets.length; j++) {
                    if (app.budgetchart[i].id==app.budgets[j].chart_id)
                    {
                        app.budgetchart[i].debit=app.budgets[j].debit;
                        app.budgetchart[i].credit=app.budgets[j].credit;
                    }
                }
            }

            axios.get('/api/' + app.taxpayer + '/' + app.cycle + '/accounting/journal/ByCycleID/' +  data.id)
            .then(({ data }) =>
            {
                console.log(data.length);
                if (data.length >0 ) {
                    app.chartlist=[];
                }
                else {
                    app.chartlist = app.charts;
                }

                for (var i = 0; i < data.length; i++) {
                    app.chartlist.push({ chart_id:data[i].chart_id
                        ,id:data[i].id
                        , code:data[i].code
                        , name:data[i].name
                        , debit:data[i].debit
                        , credit:data[i].credit
                        , is_accountable:data[i].is_accountable
                    })
                }
            });

        },

        init()
        {
            var app = this;
            app.taxpayer_id = app.$parent.taxpayer;
            app.list = app.cycles;
            app.chartlist = app.charts;
            app.budgetlist = app.budgetchart;
            app.chartversions = app.versions;



        }
    },

    mounted: function mounted()
    {
        var app = this;
        app.init();

    }
});
