<template>
  <div>
    <vue-good-table
    :columns="columns"
    :rows="rows"
    :paginate="true"
    >
    <template slot="table-column" slot-scope="props">
      <span v-if="props.column.label =='SelectAll'">
        <label class="checkbox">
          <input
          type="checkbox"
          @click="toggleSelectAll()">
        </label>
      </span>
      <span v-else>
        {{props.column.label}}
      </span>
    </template>
    <template slot="table-row-before" slot-scope="props">
      <td>
        <label class="checkbox">
          <input type="checkbox" v-model="rows[props.row.originalIndex].selected">
        </label>
      </td>
    </template>
  </vue-good-table>
</div>
</template>

<script>

export default {

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

      ],
      rows: [

      ],
    };
  },

  methods: {
    init(){
      var app = this;
      $.ajax({
        url: '/api/get_sales/3',
        type: 'get',
        dataType: 'json',
        async: true,
        success: function(data)
        {
          app.list = [];
          for(let i = 0; i < data.length; i++)
          {
            app.rows.push({selected: false,id : data[i]['id'],
            date : data[i]['date'],
            number : data[i]['number'],
            code : data[i]['code']});
          }
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
    this.init()

  }
};
</script>
