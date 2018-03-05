
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('currency',{
  props: ['taxpayer'],
  data() {
    return {
      id:0,
      currency_id:'',
      rate:'',
      list: [
        //     id:0,
        //     currency_id:'',
        //     rate:''
      ],
      currencies:[]


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
        url: '/CurrencyRate',
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

            app.currency_id = data.currency_id;
            app.rate = data.rate;
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
      app.currency_id = data.currency_id;
      app.rate = data.rate;


    },
    init(){
      var app = this;
      $.ajax({
        url: '/api/get_Allrate' ,
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
            currency_id : data[i]['currency_id'],
            name:data[i]['name'],
            rate : data[i]['rate']});
          }
        },
        error: function(xhr, status, error)
        {
          console.log(status);
        }
      });
    },
    getCurrencies: function(data)
    {
      var app=this;
      $.ajax({
        url: '/api/' + this.taxpayer + '/get_currency' ,
        type: 'get',
        dataType: 'json',
        async: true,
        success: function(data)
        {
          app.currencies=[];
          for(let i = 0; i < data.length; i++)
          {
            app.currencies.push({name:data[i]['name'],id:data[i]['id']});
          }

        },
        error: function(xhr, status, error)
        {
          console.log(xhr.responseText);
        }
      });
    }
  },

  mounted: function mounted()
  {
    this.init();
    this.getCurrencies();
  }
});
