
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('dashboard-team',{
    props: ['user'],
    data() {
        return {
            list:[
                // id: '',
                // country: '',
                // name: '',
                // type: '',
                // alias: '',
                // taxID: '',
                // is_favorite: ''
            ]
            //Requires User to be Sent.
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
                    for(let i = 0; i < data.length; i++)
                    {
                        app.list.push({id:data[i]['id'],country:data[i]['country'],
                        name:data[i]['name'],type:data[i]['type'],alias:data[i]['alias'],
                        taxID:data[i]['taxID'],is_favorite:data[i]['is_favorite']});
                }
                
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
