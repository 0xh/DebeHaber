
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('taxpayer',{

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
            $.ajax({
                url: '/get_taxpayers/' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    this.id = data.id;
                    this.taxid = data.taxid;
                    this.country = data.type;
                    this.code = data.customer_id;
                    this.name = data.supplier_id;
                    this.email = data.document_id;
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
