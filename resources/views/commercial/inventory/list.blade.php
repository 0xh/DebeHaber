<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <router-view name="Datatable"  :taxpayer="{{ request()->route('taxPayer')}}"  /> --}}
<div>
  <div class="row">
    <div class="col-1 m--font-boldest">
      <p class="m--font-boldest m--font-transform-u">@lang('global.StartDate')</p>
    </div>
    <div class="col-5">
      <p class="m--font-boldest m--font-transform-u">@lang('commercial.EndDate')</p>
    </div>
    <div class="col-2">
      <p class="m--font-boldest m--font-transform-u">@lang('commercial.Inventory')</p>
    </div>
    <div class="col-2">
      <p class="m--font-boldest m--font-transform-u">@lang('commercial.Sales')</p>
    </div>
    <div class="col-2">
      <p class="m--font-boldest m--font-transform-u">@lang('commercial.Cost')</p>
    </div>

    <div class="col-1">
      <p class="m--align-center m--font-boldest m--font-transform-u">@lang('global.Actions')</p>
    </div>
  </div>

  <div class="row m--margin-bottom-5" v-for="invoice in list">
    <div class="col-1">
      <p> @{{ invoice.start_date }} </p>
    </div>
    <div class="col-5">
      <p> @{{ invoice.end_date }} </p>
    </div>
    <div class="col-2">
      <p>
      @{{ invoice.inventory_value }}
      </p>
    </div>
    <div class="col-2">
      <p>
      @{{ invoice.sales_value }}
      </p>
    </div>
    <div class="col-2">
      <p>
      @{{ invoice.cost_value }}
      </p>
    </div>

    <div class="col-1">
      <div class="m-btn-group btn-group-sm m-btn-group--pill btn-group" role="group" aria-label="...">
        <a class="m-btn btn btn-secondary"><i class="la la-check m--font-success"></i></a>
        <a @click="onEdit(invoice.id)" class="m-btn btn btn-secondary"><i class="la la-pencil m--font-brand"></i></a>
        <a @click="onDelete(invoice)" class="m-btn btn btn-secondary"><i class="la la-trash m--font-danger"></i></a>
      </div>
    </div>
  </div>
  @include('layouts/infinity-loading')
</div>
