
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';

Vue.use(VueSweetAlert);

Vue.component('chart',{

  props: ['taxpayer','cycle'],
  data() {
    return {
      id : 0,
      parent_id : '',
      partner_id:'',
      chart_version_id : '',
      country : '',
      is_accountable : '',
      code : '',
      name : '',
      level :  '',
      type : '',
      sub_type : '',
      coefficient : 0,
      asset_years : 0,
      canChange : true,
      list: [
        // id:0
        // chart_version_id
        // chart_version_name
        // country
        // is_accountable
        // code
        // name
        // level
        // type
        // sub_type
      ],
      chartversions : [],
      accounts : []
    }
  },

  methods:
  {
    onClickChild (value) {
      console.log("value") // someValue
    },
    //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
    //For updates code will be different and should use the ID's palced int he Json.
    onSave: function(json)
    {
      var app = this;
      var api = null;

      app.parent_id = app.$children[0].id;
      //app.partner_id = app.$children[1].id;

      if (app.code == '')
      {
        app.$swal('Please Check fields?', 'code', 'warning');
        return;
      }
      if (app.name == '')
      {
        app.$swal('Please fill name...');
        return;
      }
      if (app.type == 0)
      {
        app.$swal('Please Select Type...');
        return;
      }
      if (app.is_accountable && app.sub_type == 0)
      {
        app.$swal('Please Select Sub Type...');
        return;
      }
      $.ajax({
        url : '',
        headers : {'X-CSRF-TOKEN': CSRF_TOKEN},
        type : 'post',
        data : json,
        dataType : 'json',
        async : false,
        success: function(data)
        {
          app.id = 0;
          app.parent_id = null;
          app.chart_version_id = null;
          app.country = null;
          app.is_accountable = null;
          app.code = null;
          app.name = null;
          app.level = null;
          app.type = null;
          app.sub_type = null;
          app.coefficient = null;
          app.asset_years = null;
          app.$parent.$parent.showList = 1;
        },
        error: function(xhr, status, error)
        {
          app.$swal('Something went wrong, check logs...' + error);
          console.log(xhr.responseText);
        }
      });
    },

    onEdit: function(data)
    {

      var app = this;
      app.id = data.id;
      app.parent_id = data.parent_id;
      app.chart_version_id = data.chart_version_id;
      app.country = data.country;
      app.is_accountable = data.is_accountable;
      app.code = data.code;
      app.name = data.name;
      app.level = data.level;
      app.type = data.type;
      app.sub_type = data.sub_type;
      app.coefficient = data.coefficient;
      app.asset_years =  data.asset_years;
      app.$children[0].selectText=data.name;
    }
  },

  mounted: function mounted()
  {
    //    this.init();
  }
});
