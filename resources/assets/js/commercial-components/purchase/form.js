
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('purchases-form',{
  props: ['taxpayer','trantype','cycle'],
  data() {
    return {
      id:0,
      type:this.trantype,
      customer_id:'',
      supplier_id:'',
      document_id:'',
      currency_id:'',
      rate: '',
      payment_condition:'',
      chart_account_id:'',
      date:'',
      number:'',
      code:'',
      code_expiry:'',
      comment:'',
      ref_id:'',
      details: [
        //     {
        //     id:0,
        //     transaction_id:'',
        //     chart_id:'',
        //     chart_vat_id:0,
        //     value:''
        //     vat:0,
        //     totalvat:0,
        //     withoutvat:0,

        // }
      ],
      documents:[],
      accounts:[],
      currencies:[],
      charts:[],
      ivas:[]
    }
  },
  computed: {
    condition: function()
    {
      if (this.payment_condition > 0)
      { return 'Crédito'; }
      return 'Contado';
    },

    grandTotal: function()
    {
      var total = 0.0;

      for(let i = 0; i < this.details.length; i++)
      {
        total +=  parseFloat(this.details[i].value).toFixed(2) ;
      }

      return parseFloat(total).toFixed(2);
    },

    grandExenta: function()
    {
      var total = 0.0;
      for(let i = 0; i < this.details.length; i++)
      {
        total += parseFloat(this.details[i].withoutvat).toFixed(2);
      }

      return parseFloat(total).toFixed(2);
    },

    grandGravada: function()
    {
      var app=this;
      var total = 0.0;

      for(let i = 0; i < app.details.length; i++)
      {

        total += parseFloat(app.details[i].vat).toFixed(2);
      }

      return parseFloat(total).toFixed(2);
    },

    grandIva: function()
    {
      var total = 0.0;
      for(let i = 0; i < this.details.length; i++)
      {
        total += parseFloat(this.details[i].totalvat).toFixed(2);
      }

      return parseFloat(total).toFixed(2);
    }
  },

  methods: {
    addDetail: function()
    {
      this.details.push({ id:0, value:0, chart_vat_id:1, chart_id:0,vat:0,totalvat:0,withoutvat:0 })
    },

    //Removes Detail. Make sure it removes the correct detail, and not in randome.
    deleteDetail: function(detail)
    {
      let index = this.details.indexOf(detail)
      this.details.splice(index, 1)
    },

    //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
    //For updates code will be different and should use the ID's palced int he Json.
    onSave: function(json)
    {

      var app = this;
      var api = null;
      app.type = app.trantype;

      this.supplier_id = this.$children[0].id;

    $.ajax({
      url: '',
      headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
      type: 'post',
      data:json,
      dataType: 'json',
      async: false,
      success: function(data)
      {
        if (data=='ok')
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
  onEdit: function(data)
  {
    var app = this;
    app.id = data.id;
    app.type = data.type;
    app.customer_id = data.customer_id;
    app.supplier_id = data.supplier_id;
    app.document_id = data.document_id;
    app.currency_id = data.currency_id;
    app.rate = data.rate;
    app.payment_condition = data.payment_condition;
    app.chart_account_id = data.chart_account_id;
    app.date = data.date;
    app.number = data.number;
    app.code = data.code;
    app.code_expiry = data.code_expiry;
    app.comment = data.comment;
    app.ref_id = data.ref_id;
    app.details=data.details;
    app.$children[0].selectText=data.supplier;
    app.$children[0].id=data.supplier_id;

  },
  onReset: function()
  {
    var app=this;
    app.id = 0;
    app.type = null;
    app.customer_id = null;
    app.supplier_id = null;
    app.document_id = null;
    app.currency_id = null;
    app.rate = null;
    app.payment_condition = null;
    app.chart_account_id = null;
    app.date = null;
    app.number = null;
    app.code = null;
    app.code_expiry = null;
    app.comment = null;
    app.ref_id = null;
    app.details = [];
    app.$parent.status=0;
  },
  getDocuments: function(data)
  {
    var app=this;
    $.ajax({
      url: '/api/' + this.taxpayer + '/get_document/2/' ,
      headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
      type: 'get',
      dataType: 'json',
      async: true,
      success: function(data)
      {
        app.documents=[];
        for(let i = 0; i < data.length; i++)
        {
          app.documents.push({name:data[i]['code'],id:data[i]['id']});
        }

      },
      error: function(xhr, status, error)
      {
        console.log(xhr.responseText);
      }
    });
  },
  changeDocument: function()
  {

    var app = this;

    $.ajax({
      url: '/api/' + this.taxpayer + '/get_documentByID/' + app.document_id   ,
      headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
      type: 'get',
      dataType: 'json',
      async: true,
      success: function(data)
      {

        app.number=data.current_range + 1;
        app.code=data.code;
        app.code_expiry=data.code_expiry;
      },
      error: function(xhr, status, error)
      {
        console.log(xhr.responseText);
      }
    });
  },
  cancel()
  {
    var app=this;
    app.$parent.status=0;
  },
  getCurrencies: function(data)
  {
    var app=this;
    $.ajax({
      url: '/api/' + this.taxpayer + '/get_currency' ,
      headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
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
  },
  getRate: function()
  {

    var app=this;
    $.ajax({
      url: '/api/' + this.taxpayer + '/get_rateByCurrency/' + app.currency_id + '/' + app.date  ,
      headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
      type: 'get',
      dataType: 'json',
      async: true,
      success: function(data)
      {

        if (app.rate=='' || app.rate==null) {
          app.rate=data;
        }


      },
      error: function(xhr, status, error)
      {
        console.log(xhr.responseText);
      }
    });
  },
  getCharts: function(data)
  {
    var app=this;
    $.ajax({
      url: '/api/' + this.taxpayer + '/' + this.cycle + '/accounting/chart/get_item-purchases' ,
      headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
      type: 'get',
      dataType: 'json',
      async: true,
      success: function(data)
      {
        app.charts = [];
        for(let i = 0; i < data.length; i++)
        {
          app.charts.push({name:data[i]['name'],id:data[i]['id']});
        }

      },
      error: function(xhr, status, error)
      {
        console.log(xhr.responseText);
      }
    });
  },
  getTaxs: function(data)
  {
    var app=this;
    $.ajax({
      url: '/api/' + this.taxpayer + '/' + this.cycle + '/accounting/chart/get_vat-credit' ,
      headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
      type: 'get',
      dataType: 'json',
      async: true,
      success: function(data)
      {
        console.log(data);
        app.ivas = [];
        for(let i = 0; i < data.length; i++)
        {
          app.ivas.push({name:data[i]['name'],id:data[i]['id']});
        }

      },
      error: function(xhr, status, error)
      {
        console.log(xhr.responseText);
      }
    });
  },
  onPriceChange: function(detail)
  {
    var app=this;


    for (let i = 0; i < app.ivas.length; i++)
    {

      if (detail.chart_vat_id == app.ivas[i].id)
      {

        if (parseFloat(app.ivas[i].coefficient) > 0)
        {

          if (app.ivas[i].coefficient == '0.00')
          {
            detail.exenta = parseFloat(parseFloat(detail.value).toFixed(2) / (1 + parseFloat(app.ivas[i].coefficient))).toFixed(2);
          }
          else
          {

            detail.gravada = parseFloat(parseFloat(detail.value).toFixed(2) / (1 + parseFloat(app.ivas[i].coefficient))).toFixed(2);
          }


        }
        detail.iva = parseFloat(parseFloat(detail.value).toFixed(2) - (  detail.gravada == 0 ?   detail.exenta :   detail.gravada)).toFixed(2);
      }
    }
  },
  getAccounts: function(data)
  {
    var app = this;
    $.ajax({
      url: '/api/' + this.taxpayer + '/' + this.cycle + '/accounting/chart/get_money-accounts' ,
      headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
      type: 'get',
      dataType: 'json',
      async: true,
      success: function(data)
      {
        app.accounts = [];
        for(let i = 0; i < data.length; i++)
        {
          app.accounts.push({name:data[i]['name'],id:data[i]['id']});
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
  //this.init()
  this.getDocuments();
  this.getCurrencies();
  this.getCharts();
  this.getTaxs();
  this.getAccounts();
}
});
