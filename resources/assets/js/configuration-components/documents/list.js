
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('document',{
  props: ['taxpayer'],
  data() {
    return {
      id:0,
      type:'',
      prefix:'',
      mask:0,
      start_range:'',
      current_range:'',
      end_range:'',
      code:'',
      code_expiry:'',
      list: [
        //     id:0,
        //     type:'',
        //     prefix:'',
        //     mask:0,
        //     start_range:'',
        //     current_range:'',
        //     end_range:'',
        //     code:'',
        //     code_expiry:''

      ]


    }
  },

  methods: {

    //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
    //For updates code will be different and should use the ID's palced int he Json.
    onSave: function(json)
    {
      var app = this;
      var api = null;


      $.ajax({
        url: '',
        headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
        type: 'post',
        data: json,
        dataType: 'json',
        async: false,
        success: function(data)
        {
          console.log(data);
          if (data == 'ok')
          {
            app.id = 0;

            app.type = data.type;
            app.prefix = data.prefix;
            app.mask = data.mask;
            app.start_range = data.start_range;
            app.current_range = data.current_range;
            app.end_range = data.end_range;
            app.code = data.code;
            app.code_expiry = data.code_expiry;
            app.init();
          }
          else
          {
            alert('Something Went Wrong...')
          }
        },
        error: function(xhr, status, error)
        {
          alert('Something went wrong, check logs...' + error);
          console.log(xhr.responseText);
        }
      });
    },
    onEdit: function(data)
    {
      var app = this;
      app.id = data.id;
      app.type = data.type;
      app.prefix = data.prefix;
      app.mask = data.mask;
      app.start_range = data.start_range;
      app.current_range = data.current_range;
      app.end_range = data.end_range;
      app.code = data.code;
      app.code_expiry = data.code_expiry;

    },
    init(){
      var app = this;
      $.ajax({
        url: '/api/'  + this.taxpayer + '/get_allDocuments' ,
        headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
        type: 'get',
        dataType: 'json',
        async: true,
        success: function(data)
        {
          console.log(data);
          app.list = [];
          for(let i = 0; i < data.length; i++)
          {
            app.list.push({id : data[i]['id'],
            type : data[i]['type'],
            prefix : data[i]['prefix'],
            mask : data[i]['mask'],
            start_range : data[i]['start_range'],
            current_range : data[i]['current_range'],
            end_range : data[i]['end_range'],
            code : data[i]['code'],
            code_expiry : data[i]['code_expiry']});
          }
        },
        error: function(xhr, status, error)
        {
          console.log(status);
        }
      });
    }
  },

  mounted: function mounted()
  {
    this.init();
  }
});
