
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';

Vue.use(VueSweetAlert);

Vue.component('adjustment',{

    props: ['taxpayer','cycle'],
    data() {
        return {
            Journals:[]


        }
    },

    methods:
    {
        getJournal: function(json)
        {
            var app=this;
            axios.get('/api/' + app.taxpayer + '/' + app.cycle + '/accounting/journal')
            .then(({ data }) =>
            {
                app.Journals=data;
            });
        }


    },

    mounted: function mounted()
    {
        this.getJournal();
    }
});
