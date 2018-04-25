import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';
import axios from 'axios';
import MaskedInput from 'vue-masked-input';

Vue.component('transaction-form',
{
  components: {
    MaskedInput
  },

  props: ['trantype','charts','vats','accounts'],
  data() {
    return {

      id: 0,
      taxpayer_id:'',
      payment_value:'',
      Value:'',
      type: this.transType,
      Supplier:'',
      Customer:'',
      Paid :'',
      SupplierTaxID:'',
      CustomerTaxID:'',
      customer_id: '',
      supplier_id: '',
      document_id: '',
      currency_id: '',
      rate:1,
      payment_condition: '',
      chart_account_id: '',
      date: '',
      number: '',
      code: '',
      code_expiry: '',
      comment: '',
      ref_id: '',
      details: [
        // id
        // transaction_id
        // chart_id
        // chart_vat_id
        // value
        // vat
        // taxExempt
        // taxable
      ],
      documents:[],
      //    accounts:[],
      currencies:[],
      //  charts:[],
      //vats:[]
    }
  },

  computed:
  {
    condition: function()
    {
      if (this.payment_condition > 0)
      { return 'Crédito'; }
      return 'Contado';
    },

    grandTotal: function()
    {
      var app = this;
      var total = 0.0;
      for (let i = 0; i < app.details.length; i++)
      {
        total += parseFloat(app.details[i].value).toFixed(2) ;
      }

      return parseFloat(total).toFixed(2);
    },

    grandTaxExempt: function()
    {
      var total = 0.0;
      for (let i = 0; i < this.details.length; i++)
      {
        total += parseFloat(this.details[i].taxExempt).toFixed(2);
      }

      return parseFloat(total).toFixed(2);
    },

    grandTaxable: function()
    {
      var app = this;
      var total = 0.0;

      for (let i = 0; i < app.details.length; i++)
      {
        total += parseFloat(app.details[i].taxable).toFixed(2);
      }

      return parseFloat(total).toFixed(2);
    },

    grandVAT: function()
    {
      var total = 0.0;
      for (let i = 0; i < this.details.length; i++)
      {
        total += parseFloat(this.details[i].vat).toFixed(2);
      }

      return parseFloat(total).toFixed(2);
    }
  },

  methods:
  {
    addDetail: function()
    {
      this.details.push({ id:0, value:0, chart_vat_id:1, chart_id:0, vat:0, taxExempt:0, taxable:0 })
    },

    //Removes Detail. Make sure it removes the correct detail, and not in randome.
    deleteDetail: function(detail)
    {
      let index = this.details.indexOf(detail)
      this.details.splice(index, 1)
    },
    onEdit: function(data)
    {
      console.log(data)
      var app = this;
      app.id = data.ID;
      app.type = data.type;
      app.Customer = data.customer;
      app.Supplier = data.supplier;
      app.Paid = data.Paid;
      app.SupplierTaxID=data.SupplierTaxID;
      app.CustomerTaxID=data.CustomerTaxID;
      app.Value = data.Value;
      app.customer_id = data.customer_id;
      app.supplier_id = data.supplier_id;
      app.document_id = data.document_id;
      app.currency_id = data.currency_id;
      app.currency_code = data.currency_code;
      app.rate = data.rate;
      app.payment_condition = data.payment_condition;
      app.chart_account_id = data.chart_account_id;
      app.date = data.date;
      app.number = data.number;
      app.code = data.code;
      app.code_expiry = data.code_expiry;
      app.comment = data.comment;
      app.ref_id = data.ref_id;
      app.details = data.details;

      if (app.trantype == 4 ||app.trantype == 5) {
        app.$children[0].selectText = data.customer;
        app.$children[0].id=data.customer_id ;
      }
      else {
        app.$children[0].selectText = data.supplier;
        app.$children[0].id=data.supplier_id ;
      }

      app.$parent.$parent.showList = false;

    },

    onReset: function(isnew)
    {
      var app = this;

      app.id = 0;
      app.type = null;
      app.Customer = null;
      app.Supplier = null;
      app.Paid =null;
      app.SupplierTaxID=null;
      app.CustomerTaxID=null;
      app.Value = null;
      app.currency_code = null;
      app.date = null;
      app.customer_id = null;
      app.supplier_id = null;
      app.document_id = null;
      app.currency_id = null;
      app.rate = null;
      app.payment_condition = null;
      app.chart_account_id = null;
      app.number = null;
      app.code = null;
      app.code_expiry = null;
      app.comment = null;
      app.ref_id = null;
      app.details = [];

      if (isnew == false)
      {
        app.$parent.$parent.showList = false;
      }
    },

    //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
    //For updates code will be different and should use the ID's palced int he Json.
    onSave: function(json,isnew)
    {
      var app = this;
      var api = null;
      app.type =  app.trantype;

      if (this.$children[0]!=null) {
        if (app.trantype == 4 || app.trantype == 5) {
          app.customer_id = this.$children[0].id;
        }
        else {

          app.supplier_id = this.$children[0].id;

        }
      }

      console.log(json);
      axios({
        method: 'post',
        url: '',
        responseType: 'json',
        data: json

      }).then(function (response)
      {


        if (response.status=200 )
        {
          app.onReset(isnew);
        }
        else
        {
          alert('Something Went Wrong...')
        }
      })
      .catch(function (error)
      {
        console.log(error);
        console.log(error.response);
      });
      // $.ajax({
      //     url: '',
      //     headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
      //     type: 'post',
      //     data:json,
      //     dataType: 'json',
      //     async: false,
      //     success: function(data)
      //     {
      //
      //     },
      //     error: function(xhr, status, error)
      //     {
      //         console.log(xhr.responseText);
      //     }
      // });
    },

    changeDocument: function()
    {
      var app = this;
      axios.get('/api/' + app.$parent.taxpayer + '/get_documentByID/' + app.document_id + '')
      .then(({ data }) =>
      {
        app.number = data.current_range + 1;
        app.code = data.code;
        app.code_expiry = data.code_expiry;
      });
    },

    getRate: function()
    {
      var app = this;
      var url = '';

      if (app.transType == 4 || app.transType == 5)
      {
        url = '/api/' + app.$parent.taxpayer + '/get_buyRateByCurrency/' + app.currency_id + '/' + app.date;
      }
      else
      {
        url = '/api/' + app.$parent.taxpayer + '/get_sellRateByCurrency/' + app.currency_id + '/' + app.date;
      }

      axios.get(url).then(({ data }) => { app.rate = data; });
    },

    onPriceChange: function(detail)
    {
      var app = this;

      for (let i = 0; i < app.vats.length; i++)
      {
        if (detail.chart_vat_id == app.vats[i].id)
        {
          if (parseFloat(app.vats[i].coefficient) > 0)
          {
            if (app.vats[i].coefficient == '0.00')
            {
              detail.taxExempt = parseFloat(parseFloat(detail.value).toFixed(2) / (1 + parseFloat(app.vats[i].coefficient))).toFixed(2);
            }
            else
            {
              detail.taxable = parseFloat(parseFloat(detail.value).toFixed(2) / (1 + parseFloat(app.vats[i].coefficient))).toFixed(2);
            }
          }

          detail.vat = parseFloat(parseFloat(detail.value).toFixed(2) - (  detail.taxable == 0 ?   detail.taxExempt :   detail.taxable)).toFixed(2);
        }
      }
    },

    getAccounts: function(data)
    {
      var app = this;
      axios.get('/api/' + app.$parent.taxpayer + '/' + app.$parent.cycle + '/accounting/chart/get-money_accounts' ,
    )
    .then(({ data }) =>
    {
      app.accounts = [];
      for(let i = 0; i < data.length; i++)
      {
        app.accounts.push({name:data[i]['name'],id:data[i]['id']});
      }
    });

  },
  getDocuments: function(data)
  {
    var app = this;

    axios.get('/api/' + app.$parent.taxpayer + '/get_documents/' + app.transType ,
  )
  .then(({ data }) =>
  {
    app.documents = [];
    for(let i = 0; i < data.length; i++)
    {
      app.documents.push({ name:data[i]['code'], id:data[i]['id'] });
    }
  });

},
getCurrencies: function(data)
{
  var app = this;
  axios.get('/api/' + app.$parent.taxpayer + '/get_currency' ,
)
.then(({ data }) =>
{
  app.currencies = [];
  for(let i = 0; i < data.length; i++)
  {
    app.currencies.push({ name:data[i]['name'], id:data[i]['id'], isoCode:data[i]['code']});
    if (data[i]['code'] == this.taxpayerCurrency)
    {
      app.currency_id = data[i]['id'];
    }
  }
});

},
//Get Cost Centers
getCharts: function(data)
{
  var app = this;
  axios.get('/api/' + app.$parent.taxpayer + '/' + app.$parent.cycle + '/' +  app.$parent.baseurl + '/get-charts/',
)
.then(({ data }) =>
{
  app.charts = [];
  for(let i = 0; i < data.length; i++)
  {
    app.charts.push({ name:data[i]['name'], id:data[i]['id'] });
  }

});

},
//VAT
getTaxes: function()
{

  var app = this;
  axios.get('/api/' + app.$parent.taxpayer + '/' + app.$parent.cycle + '/' +  app.$parent.baseurl + '/get-vats/',
)
.then(({ data }) =>
{
  app.vats = [];

  for(let i = 0; i < data.length; i++)
  {
    app.vats.push({
      name:data[i]['name'],
      id:data[i]['id'],
      coefficient:data[i]['coefficient']
    });
  }
});
},

init: function (data)
{
  var app = this;
  app.taxpayer_id = app.$parent.taxpayer;
}
},

mounted: function mounted()
{
  this.init();
  this.getDocuments();
  this.getCurrencies();
  //this.getCharts();
  //    this.getTaxes();
  //    this.getAccounts();
}
});
