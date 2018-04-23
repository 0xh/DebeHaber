
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('inventory-form',{
    props: ['taxpayer','trantype','charts'],
    data() {
        return {
            id:0,
            taxpayer_id:'',
            chart_id:'',
            date:'',
            current_value:''
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
            app.type = app.trantype;
            if (this.type == 1)
            {
                this.customer_id = this.$children[0].id;
            }
            else
            {
                this.supplier_id = this.$children[0].id;
            }
            $.ajax({
                url: '',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'post',
                data:json,
                dataType: 'json',
                async: false,
                success: function(data)
                {
                    if (data == 'ok')
                    {
                        app.onReset();
                    }
                    else
                    {
                        alert('Something Went Wrong...')
                    }
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
            app.id = 0;
            app.taxpayer_id = null;
            app.chart_id = null;
            app.date = null;
            app.current_value = null;
            app.$parent.status = 0;
        },

        cancel()
        {
            var app = this;
            app.$parent.status = 0;
        }

    },

    mounted: function mounted()
    {

    }
});
