
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('dashboard-team',{
    props: ['user'],
    data() {
        return {
            id: '',
            country: '',
            name: '',
            type: '',
            alias: '',
            taxID: '',
            is_favorite: '' //Requires User to be Sent.
        }
    },

    methods: {

        init(){
            var app = this;
            $.ajax({
                url: '/api/my-taxpayers/1/1',
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.id = data.id;
                    app.country = data.country;
                    app.name = data.name;
                     app.type = data.type;
                    app.alias = data.alias;
                    app.taxID = data.taxID;
                    app.is_favorite = data.is_favorite;
                },
                error: function(xhr, status, error)
                {
                    console.log(status);
                }
            });
        },

        //Add taxpayer to current user's favorites
        addFavorites(){

        }
    },



    mounted: function mounted()
    {
        this.init();
    }
});
