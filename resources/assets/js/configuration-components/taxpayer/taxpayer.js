
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('taxpayer',{
    props: ['taxpayer'],
    data() {
        return {
            id: 0,
            country: '',
            taxid: '',
            code: '',
            name: '',
            alias: '',
            address: '',
            telephone: '',
            email: '',
            show_inventory:0,
            show_production:0,
            show_fixedasset:0,
            show_column:1,
            agent_name :'',
            agent_taxid :'',
            type:[],

            img: ''
        }
    },

    methods: {
        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json)
        {
            var api = null;

            $.ajax({
                url: '/taxpayer',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},

                type: 'post',
                data:json,
                dataType: 'json',
                async: false,
                success: function(data)
                {
                    if (data == 'ok')
                    {
                        document.location.href = '../home/'
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
        onUpdate: function(json)
        {

            var app = this;

            $.ajax({
                url: '/taxpayer/' + app.id,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},

                type: 'put',
                data:json,
                dataType: 'json',
                async: false,
                success: function(data)
                {

                    alert('Sucess')

                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },
        onEdit: function(data)
        {
            this.id = data.id;
            this.taxid=data.taxid;
            this.country = data.type;
            this.code = data.customer_id;
            this.name = data.supplier_id;
            this.email = data.document_id;
        },
        init(){
            var app=this;

            app.id = app.taxpayer[0].id;
            app.taxid = app.taxpayer[0].taxid;
            app.country = app.taxpayer[0].country;
            app.code = app.taxpayer[0].code;
            app.name = app.taxpayer[0].name;
            app.email = app.taxpayer[0].email;
            app.alias = app.taxpayer[0].alias;
            app.address = app.taxpayer[0].address;
            app.telephone = app.taxpayer[0].telephone;
            app.agent_name = app.taxpayer[0].telephone;
            app.agent_taxid = app.taxpayer[0].telephone;


        }
    },

    mounted: function mounted() {
        if (this.taxpayer!=null) {
            this.init();
        }
    }
});
