
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';

Vue.use(VueSweetAlert);

Vue.component('mergechart',{

    props: ['taxpayer','cycle','selectid','selectname'],
    data() {
        return {
            id : 0,
            fromChartId : '',
            toChartId : '',
            boolIncludeFutureReference : '',
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

            app.fromChartId = app.selectid;
            app.toChartId = app.$children[0].id;

            if (this.fromChartId>0 && this.toChartId>0) {
                $.ajax({
                    //charts/merge/{id}
                    url : '/api/' + app.taxpayer + '/' + app.cycle + '/accounting/chart/merge/' +  app.fromChartId + '/' + app.toChartId,
                    headers : {'X-CSRF-TOKEN': CSRF_TOKEN},
                    type : 'post',
                    data : json,
                    dataType : 'json',
                    async : false,
                    success: function(data)
                    {
                        //console.log(data);
                        if (data == 200)
                        {
                            app.$swal('Chart Merged...');
                        }
                        else
                        {
                            app.$swal('Something went wrong, check logs...' + error);
                        }
                    },
                    error: function(xhr, status, error)
                    {
                        app.$swal('Something went wrong, check logs...' + error);
                        console.log(xhr.responseText);
                    }
                });
            }

        },
        cancel: function()
        {
this.$parent.close();

        }
    },

    mounted: function mounted()
    {

    }
});
