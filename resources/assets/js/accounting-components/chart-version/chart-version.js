
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('chart-version',{

  data() {
    return {
      id:0,
      name:'',
      taxpayer_id: '',
      list: [
        //     {
        //     id:0,
        //     name:'',
        //     taxpayer_id:0,
        //     taxpayer:''

        // }
      ],

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
        url: '',
        headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
        type: 'post',
        data:json,
        dataType: 'json',
        async: false,
        success: function(data)
        {
          if (data=='ok') {
            app.id=0;
            app.name=null;
            app.init();
          }
          else {
            alert('Something Went Wrong...')
          }


        },
        error: function(xhr, status, error)
        {
          console.log(error);
        }
      });
    },
    onEdit: function(data)
    {
      var app=this;
      app.name=data.name;
      app.id=data.id;
    },
    init(){
      var app=this;
      $.ajax({
        url: '/get_chartversion/' ,
        headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
        type: 'get',
        dataType: 'json',
        async: true,
        success: function(data)
        {
          app.list=[];
          for(let i = 0; i < data.length; i++)
          {
            app.list.push({name:data[i]['name'],id:data[i]['id']});
          }

        },
        error: function(xhr, status, error)
        {
          console.log(status);
        }
      });
    }
  },

  mounted: function mounted() {

    this.init()

  }
});
