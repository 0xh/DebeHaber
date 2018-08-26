
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('inventory-form',{
    props: ['taxpayer','cycle','charts'],
    data() {
        return {
            id:0,
            start_date:'',
            end_date:'',
            chart_id:'',
            inventory_value:'',
            sales_value:'',
            cost_value:'',
            margin:'',
            selectcharttype:[],
            chartincome : '',
            charttypes:[],
        }
    },

    methods:
    {
        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json)
        {
            var app = this;

            $.ajax({
                url: '',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'post',
                data:json,
                dataType: 'json',
                async: false,
                success: function(data)
                {
                    app.onReset();
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },
        getChartTypes: function(json)
        {
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/inventories/get_InventoryChartType/',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'post',
                data:json,
                dataType: 'json',
                async: false,
                success: function(data)
                {
                    app.charttypes = [];
                    for(let i = 0; i < data.length; i++)
                    {
                        app.charttypes.push({ name:data[i]['name'], id:data[i]['id'] });
                    }
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });

        },
        calculateCost:function ()
        {
            var app=this;
            app.cost_value=(app.sales_value * (1-app.margin));
        },
        onCalculate: function(json)
        {
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/inventories/calc-revenue/',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'post',
                data:json,
                dataType: 'json',
                async: false,
                success: function(data)
                {
                    // TODO: Abhi Please check this i m not sure abouto calculate this calcution
                    app.sales_value=data[0].sales_cost;
                    app.cost_value=data[0].cost_value;
                    app.margin=(app.sales_value-app.cost_value)/app.sales_value;
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });

        },

        onReset: function()
        {
            var app = this;
            app.id=0,
            app.code='',
            app.number='',
            app.date=''

            app.$parent.$parent.showList = 1;
        },

        cancel()
        {
            var app = this;
            app.$parent.$parent.showList = 1;
        }

    },

    mounted: function mounted()
    {
        this.getChartTypes();
    }
});
