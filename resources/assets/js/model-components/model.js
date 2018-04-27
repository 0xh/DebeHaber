var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('model',
{
    props: ['taxpayer','cycle'],
    data() {
        return {
            showList : true,
            cycle_id:0,
            cycles:[],
            showCycle:0

        }
    },

    methods:
    {
        onCreate()
        {
            var app = this;
            app.showList = false;
            app.showCycle=1;
        },
        onCycleop()
        {
            var app = this;
            app.showCycle=3;
            console.log(app.showCycle);
        },
        onCyclecl()
        {
            var app = this;
            app.showCycle=4;
        },
        onCyclebudget()
        {
            var app = this;
            app.showCycle=2;
        },
        cyclechange()
        {

            var app=this;
            window.location.href = '/taxpayer/' + app.taxpayer + '/'+ app.cycle_id +'/stats/';


        },
        init: function (data)
        {
            var app=this;
            axios.get('/api/' + app.taxpayer + '/get_cycle')
            .then(({ data }) =>
            {
                console.log(data);
                app.cycles=data;

            });
        }
    },
    mounted: function mounted()
    {
        var app=this;
        app.init();
        app.cycle_id=app.cycle;
        console.log(app.cycle_id);
    }
});
