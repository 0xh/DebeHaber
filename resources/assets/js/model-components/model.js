var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('model',
{
    props: ['trantype'],
    data() {
        return {
            showList : true,
        }
    },

    methods:
    {
        onCreate()
        {
            var app = this;
            app.showList = false;
        },
    }
});
