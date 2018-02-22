@extends('spark::layouts.form')

@section('title', 'Chart')

@section('form')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="my_datatable" id="m_datatable">
  
</div>
  <router-view name="Datatable">



  </router-view>


@endsection
@section('script')
  <script>
  var options = {
      data: {
          type: 'remote',
          source: {
              read: {
                  url: 'http://localhost:8000/api/get_sales/3',
                  method: 'GET',
                  // custom headers
                  //  headers: { 'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                  // params: {
                  //     // custom query params
                  //     query: {
                  //         generalSearch: '',
                  //         EmployeeID: 1,
                  //         someParam: 'someValue',
                  //         token: 'token-value'
                  //     }
                  // },
                  map: function(raw) {
                      // sample data mapping
                      var dataSet = raw;

                      if (typeof raw.data !== 'undefined') {
                          dataSet = raw.data;
                      }
                      return dataSet;
                  },
              }
          },
          pageSize: 10,
          saveState: {
              cookie: true,
              webstorage: true
          },

          serverPaging: false,
          serverFiltering: false,
          serverSorting: false
      },

      layout: {
          theme: 'default',
          class: 'm-datatable--brand',
          scroll: false,
          height: null,
          footer: false,
          header: true,

          smoothScroll: {
              scrollbarShown: true
          },

          spinner: {
              overlayColor: '#000000',
              opacity: 0,
              type: 'loader',
              state: 'brand',
              message: true
          },

          icons: {
              sort: {asc: 'la la-arrow-up', desc: 'la la-arrow-down'},
              pagination: {
                  next: 'la la-angle-right',
                  prev: 'la la-angle-left',
                  first: 'la la-angle-double-left',
                  last: 'la la-angle-double-right',
                  more: 'la la-ellipsis-h'
              },
              rowDetail: {expand: 'fa fa-caret-down', collapse: 'fa fa-caret-right'}
          }
      },

      sortable: false,

      pagination: true,

      search: {
          // enable trigger search by keyup enter
          onEnter: false,
          // input text for search
          input: $('#generalSearch'),
          // search delay in milliseconds
          delay: 400,
      },

      detail: {
          title: 'Load sub table',
          content: function (e) {
              // e.data
              // e.detailCell
          }
      },

      rows: {
          callback: function() {},
          // auto hide columns, if rows overflow. work on non locked columns
          autoHide: false,
      },

      // columns definition
      columns: [{
          field: "RecordID",
          title: "#",
          locked: {left: 'xl'},
          sortable: false,
          width: 40,
          selector: {class: 'm-checkbox--solid m-checkbox--brand'}
      }, {
          field: "id",
          title: "id",
          sortable: 'asc',
          filterable: false,
          width: 150,
          responsive: {visible: 'lg'},
          locked: {left: 'xl'},
          template: '{{'id'}} - {{'code'}}'
      }, {
          field: "code",
          title: "code",
          width: 150,
          overflow: 'visible',
          template: function (row) {
              return row.id + ' - ' + row.name;
          }
      }]
  }

  var datatable = $('.my_datatable').mDatatable(options);
  console.log(datatable);]
  </script>
@endsection
