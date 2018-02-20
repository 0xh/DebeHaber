
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('taxpayer',{

    data() {
        return {
            id:0,
            country:'',
            code:'',
            name:'',
            alias:'',
            email:''



    }
},

methods: {


    //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
    //For updates code will be different and should use the ID's palced int he Json.
    onSave: function(json)
    {

        var app=this;
        var api=null;

        $.ajax({
            url: '/store_taxpayer',
            headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            type: 'post',
            data:json,
            dataType: 'json',
            async: false,
            success: function(data)
            {
                if (data=='ok') {
                document.location.href = '/home'
                }
                else {
                    alert('Something Went Wrong...')
                }


            },
            error: function(xhr, status, error)
            {
                console.log(xhr.responseText);
            }
        });
    },
    onEdit: function(data)
    {
        var app=this;
        app.id=data.id;
        app.country=data.type;
        app.code=data.customer_id;
        app.name=data.supplier_id;
        app.email=data.document_id;

    },
    init(){
        var app=this;
        $.ajax({
            url: '/get_taxpayers/' ,
            type: 'get',
            dataType: 'json',
            async: true,
            success: function(data)
            {
                app.id=data.id;
                app.country=data.type;
                app.code=data.customer_id;
                app.name=data.supplier_id;
                app.email=data.document_id;
            },
            error: function(xhr, status, error)
            {
                console.log(status);
            }
        });
    }
},

mounted: function mounted() {








}
});
