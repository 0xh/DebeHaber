var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
Vue.component('purchases-list',{

  props: ['taxpayer','cycle'],
  data(){
    return {
      columns: [
        {
          label: 'SelectAll',
          sortable: false,
        },
        {
          label: 'Code',
          field: 'code',
          filterable: true,
        },
        {
          label: 'Number',
          field: 'number',
          filterable: true,
        },
        {
          label: 'Date',
          field: 'date',
          type: 'date',
          inputFormat: 'YYYY-MM-DD',
          outputFormat: 'MMM Do YY',
        },
        {
          label: 'Action',
        },

      ],
      rows: [

      ],
    };
  },

  methods: {
    add()
    {
      var app=this;
      app.$parent.status=1;
      console.log(app.$parent.$children[0]);
      //app.$parent.$children[0].onReset();



    },

    init(){
      var app = this;
      $.ajax({
        url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_purchases' ,
          headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
        type: 'get',
        dataType: 'json',
        async: true,
        success: function(data)
        {

          app.$children[1].data = [];
          app.$children[1].data=data;
          // for(let i = 0; i < data.length; i++)
          // {
          //     app.rows.push({
          //         selected: false,
          //         id : data[i]['id'],
          //         type : data[i]['type'],
          //         customer_id : data[i]['customer_id'],
          //         supplier_id : data[i]['supplier_id'],
          //         document_id : data[i]['document_id'],
          //         currency_id : data[i]['currency_id'],
          //         rate : data[i]['rate'],
          //         payment_condition : data[i]['payment_condition'],
          //         chart_account_id : data[i]['chart_account_id'],
          //         date : data[i]['date'],
          //         number : data[i]['number'],
          //         code : data[i]['code'],
          //         code_expiry :data[i]['code_expiry'],
          //         comment :data[i]['comment'],
          //         ref_id :data[i]['ref_id'],
          //         details : data[i]['details']
          //     });
          // }
        },
        error: function(xhr, status, error)
        {
          console.log(status);
        }
      });
    },
    onEdit: function(data)
    {

      var app = this;
      app.$parent.status=1;
      $.ajax({
        url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_purchasesByID/' + data ,
          headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
        type: 'get',
        dataType: 'json',
        async: true,
        success: function(data)
        {


          app.$parent.$children[0].onEdit(data[0]);


        },
        error: function(xhr, status, error)
        {
          console.log(status);
        }
      });

    },
    toggleSelectAll() {
      this.allSelected = !this.allSelected;
      this.rows.forEach(row => {
        if(this.allSelected){
          row.selected = true;
        }else{
          row.selected = false;
        }
      })
    }
  },

  mounted: function mounted()
  {
    var app=this;
    this.init();

  }
});
