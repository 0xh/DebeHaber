
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('cycle',
{
    props: ['taxpayer', 'cycle', 'cycles', 'versions','charts', 'budgetchart', 'budgets', 'opening_balance'],
    data() {
        return {
            id: 0,
            chart_version_id: '',
            year: '',
            start_date: '',
            end_date: '',
            list: [],
            chartversions: [],
            chartlist: [],
            budgetlist: [],
            openingbalance: []
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
                app.id = 0;
                app.chart_version_id = null;
                app.year = null ;
                app.start_date = null;
                app.end_date = null;
                app.$parent.showCycle=0;
                app.init();
            })
            .catch(function (error)
            {
                console.log(error);
            });
        },

        onJournalSave: function(json)
        {
            var app = this;
            var api = null;

            axios({
                method: 'post',
                url: '/api/' + app.taxpayer + '/' + app.cycle + '/accounting/opening_balance',
                responseType: 'json',
                data: app.openingbalance
            }).then(function (response)
            {
                app.$parent.showCycle = 0;
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
                for (var i = 0; i < app.budgetlist.length; i++)
                {
                    app.budgetlist[i].credit = 0;
                    app.budgetlist[i].debit = 0;
                }
                app.$parent.showCycle = 0;
            })
            .catch(function (error)
            {
                console.log(error.response);
                alert('Something went Wrong...')
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
                    if (app.budgetchart[i].id == app.budgets[j].chart_id)
                    {
                        app.budgetchart[i].debit = app.budgets[j].debit;
                        app.budgetchart[i].credit = app.budgets[j].credit;
                    }
                }
            }

            axios.get('/api/' + app.taxpayer + '/' + app.cycle + '/accounting/journal/ByCycleID/' +  data.id)
            .then(({ data }) =>
            {
                if (data.length > 0 ) {
                    app.chartlist = [];
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
            app.openingbalance = app.opening_balance;
        }
    },

    mounted: function mounted()
    {
        var app = this;
        app.init();
    }
});
