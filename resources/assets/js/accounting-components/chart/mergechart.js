
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';

Vue.use(VueSweetAlert);

Vue.component('mergechart',{

    props: ['taxpayer', 'cycle', 'chart2delete'],
    data() {
        return {
            id : 0,
            deleteFailed: false,
            toChartId : '',
        }
    },

    methods:
    {

        tryDelete: function(json)
        {
            var app = this;
            var api = null;

            //app.fromChartId = app.chartToDelete.id;
            //app.toChartId = app.$children[0].id;

            if (this.chart2delete.id > 0) {
                $.ajax({
                    //charts/merge/{id}
                    url : '/api/' + app.taxpayer + '/' + app.cycle + '/accounting/chart/merge-check/' +  this.chart2delete.id ,
                    headers : {'X-CSRF-TOKEN': CSRF_TOKEN},
                    type : 'post',
                    data : json,
                    dataType : 'json',
                    async : false,
                    success: function(data)
                    {
                        app.$swal('Said and Done! The chart has been deleted.');
                        app.onCancel();
                    },
                    error: function(xhr, status, error)
                    {
                        app.deleteFailed = true;
                    }
                });
            }

        },
        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        tryMerge: function(json)
        {
            var app = this;
            var api = null;
            console.log('asd');
            //app.fromChartId = app.selectid;
            //app.toChartId = app.$children[0].id;

            if (this.chart2delete.id > 0 && app.toChartId > 0) {
                $.ajax({
                    //charts/merge/{id}
                    url : '/api/' + app.taxpayer + '/' + app.cycle + '/accounting/chart/merge/' +  this.chart2delete.id + '/' + app.toChartId,
                    headers : {'X-CSRF-TOKEN': CSRF_TOKEN},
                    type : 'post',
                    data : json,
                    dataType : 'json',
                    async : false,
                    success: function(data)
                    {
                        app.$swal('Said and Done! All transactions merged to latest.');
                        app.onCancel();
                    },
                    error: function(xhr, status, error)
                    {
                        app.$swal('Delete & Merge failed. Please check with support.' + error);
                    }
                });
            }

        },

        onCancel: function()
        {
            this.$parent.close();
        }
    },

    mounted: function mounted()
    {

    }
});
