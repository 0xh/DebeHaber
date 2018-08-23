var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('model',
{
    props: ['taxpayer','cycle'],
    data() {
        return {
            showList : true,
            cycle_id : 0,
            cycles : [],
            showCycle : 0
        }
    },

    methods:
    {
        onCreate()
        {
            var app = this;
            app.showList = false;
        },

        onCancel()
        {
            var app = this;
            app.showList = true;
        },

        onCreateCyclce()
        {
            var app = this;
            app.showCycle = 1;
        },

        onCycleBudget()
        {
            var app = this;
            app.showCycle = 2;
        },

        onOpeningBalance()
        {
            var app = this;
            app.showCycle = 3;
        },

        onClosingBalance()
        {
            var app = this;
            app.showCycle = 4;
        },

        cyclechange()
        {
            var app = this;
            window.location.href = '/taxpayer/' + app.taxpayer + '/'+ app.cycle_id +'/stats/';
        },

        init: function (data)
        {
            var app = this;
            axios.get('/api/' + app.taxpayer + '/get_cycle')
            .then(({ data }) =>
            {
                app.cycles = data;
            });
        }
    },

    mounted: function mounted()
    {
        var app = this;
        app.init();
        app.cycle_id = app.cycle;
    }
});
