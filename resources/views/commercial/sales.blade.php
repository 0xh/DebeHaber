@extends('spark::layouts.form')

@section('title', 'Chart')

@section('form')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="my_datatable" id="m_datatable">

</div>
  <router-view name="Datatable">



  </router-view>
  <transaction :trantype ="3" :taxpayer="{{ request()->route('taxPayer')}}"  inline-template>
    <div>
      <div class="row">
        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              Fecha de Fact.
            </label>
            <div class="col-8">
              <input type="date" class="form-control" v-model="date" />
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              Cliente
            </label>

            <div class="col-8">
              <router-view name="SearchBox" :url="/get_taxpayer/"  :current_company="{{ request()->route('taxPayer') }}" ></router-view>
            </div>
          </div>
        </div>

        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              Documento
            </label>
            <div class="col-8">
              <div class="input-group">
                <select v-model="document_id" required class="custom-select" >
                  <option v-for="document in documents" :value="document.id">@{{ document.name }}</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              Timbrado &amp; Venci.
            </label>
            <div class="col-8">
              <div class="row">
                <div class="col-5">
                  <input class="form-control m-input" type="number" placeholder="Timbrado"  v-model="code">
                </div>
                <div class="col-7">
                  <input type="date" class="form-control m-input" v-model="code_expiry"/>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              Número de Factura
            </label>
            <div class="col-8">
              <input class="form-control m-input" type="text" value="001-001-0000000" v-model="number">
            </div>
          </div>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              Condición
            </label>
            <div class="col-8">
              <div class="input-group">
                <input id="payment_condition" type="text" class="form-control" v-model="payment_condition" placeholder=" 0 = Contado 1 0 mas = credito "/>

              </div>
            </div>
          </div>
          <div class="form-group m-form__group row" v-if="payment_condition == 0">
            <label for="example-text-input" class="col-4 col-form-label ">
              Cuenta de Dinero
            </label>
            <div class="col-8">
              <div>
                <select v-model="chart_account_id" required class="custom-select" id="account_id">
                  <option v-for="account in accounts" :value="account.id">@{{ account.name }}</option>
                </select>
              </div>
            </div>
          </div>

        </div>
        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              Moneda
            </label>
            <div class="col-8">
              <div class="input-group">
                <select required v-model="currency_id" class="custom-select">
                  <option v-for="currency in currencies" :value="currency.id">@{{ currency.name }}</option>
                </select>
                <input type="text" class="form-control" v-model="rate" />
              </div>
            </div>
          </div>


        </div>
      </div>

      {{-- Invoice Detail --}}
      <div class="m-portlet m-portlet--metal m-portlet--head-solid m-portlet--bordered">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <span class="m-portlet__head-icon">
                <i class="flaticon-calendar"></i>
              </span>
              <h3 class="m-portlet__head-text m--font-primary">
                Detalle de Factura
              </h3>
            </div>
          </div>
          <div class="m-portlet__head-tools">
            <a href="#" v-on:click="addDetail" class="btn btn-outline-primary btn-sm m-btn m-btn--icon">
              <span>
                <i class="la la-plus"></i>
                <span>
                  Agregar Detalle
                </span>
              </span>
            </a>
          </div>
        </div>
        <div class="m-portlet__body">
          <div class="row">
            <div class="col-2">
              <span class="m--font-boldest">
                Cuenta
              </span>
            </div>
            <div class="col-2">
              <span class="m--font-boldest">IVA</span>
            </div>
            <div class="col-2">
              <span class="m--font-boldest">Valor</span>
            </div>
            <div class="col-2">
              <span class="m--font-boldest">Exenta</span>
            </div>
            <div class="col-2">
              <span class="m--font-boldest">Gravada</span>
            </div>
            <div class="col-1">
              <span class="m--font-boldest">IVA</span>
            </div>
            <div class="col-1">
              <span class="m--font-boldest"></span>
            </div>
          </div>

          <hr>

          <div class="row" v-for="detail in details">
            <div class="col-2">
              <select required  v-model="detail.chart_id" class="custom-select">
                <option v-for="item in charts" :value="item.id">@{{ item.name }}</option>
              </select>
            </div>
            <div class="col-2">
              <select required  v-model="detail.chart_vat_id" @change="onPriceChange(detail)" class="custom-select">
                <option v-for="iva in ivas" :value="iva.id">@{{ iva.name }}</option>
              </select>
            </div>
            <div class="col-2">
              <input type="text" class="form-control" v-model="detail.value" @change="onPriceChange(detail)"/>
            </div>
            <div class="col-2">
              @{{ detail.exenta }}
            </div>
            <div class="col-2">
              @{{ detail.gravada }}
            </div>
            <div class="col-1">
              @{{ detail.iva }}
            </div>
            <div class="col-1">
              <input type="hidden" :value="grandTotal"/>
              <button v-on:click="deleteDetail(detail)" class="btn btn-outline-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                <i class="la la-remove"></i>
              </button>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-2">

            </div>
            <div class="col-2">
              <span class="m--font-boldest">Totales</span>
            </div>
            <div class="col-2">

              <span class="m--font-boldest">@{{ grandTotal }}</span>
            </div>
            <div class="col-2">
              <span class="m--font-boldest">@{{ grandExenta }}</span>
            </div>
            <div class="col-2">
              <span class="m--font-boldest">@{{ grandGravada }}</span>
            </div>
            <div class="col-1">
              <span class="m--font-boldest">@{{ grandIva }}</span>
            </div>
            <div class="col-1">

            </div>
          </div>
        </div>
      </div>

      <button v-on:click="onSave($data,false,'/current/{{request()->route('company') }}/sales')" class="btn btn-primary">
        Guardar
      </button>
      <button v-on:click="onSave($data,true,'')" class="btn btn-primary">
        Guardar & New
      </button>
      <button v-on:click="onSave($data)" class="btn btn-default">
        Cancelar
      </button>
    </div>
  </transaction>


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
