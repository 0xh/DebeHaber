<meta name="csrf-token" content="{{ csrf_token() }}">
<div>
  <div class="row">
    <div class="col-1 m--font-boldest">
      <p class="m--font-boldest m--font-transform-u">@lang('global.ChartName')</p>
    </div>
    <div class="col-5">
      <p class="m--font-boldest m--font-transform-u">@lang('commercial.Serial')</p>
    </div>
    <div class="col-2">
      <p class="m--font-boldest m--font-transform-u">@lang('commercial.Name')</p>
    </div>
    <div class="col-2">
      <p class="m--align-right m--font-boldest m--font-transform-u">@lang('global.PurchaseDate')</p>
    </div>
    <div class="col-1">
      <p class="m--align-center m--font-boldest m--font-transform-u">@lang('global.PurchaseValue')</p>
    </div>
  </div>

  <div class="row m--margin-bottom-5" v-for="asset in list">
    <div class="col-1">
      <p> @{{ asset.chart }} </p>
    </div>
    <div class="col-5">
      <p> @{{ asset.serial}} </p>
    </div>
    <div class="col-2">
      <p>
         @{{ asset.name}}

      </p>
    </div>
    <div class="col-2">
      <p class="m--font-bold m--align-right">
    @{{ asset.purchase_date}}
      </p>
    </div>
    <div class="col-2">
      <p class="m--font-bold m--align-right">
    @{{ asset.purchase_value}}
      </p>
    </div>
    <div class="col-1">
      <div class="m-btn-group btn-group-sm m-btn-group--pill btn-group" role="group" aria-label="...">
        <a class="m-btn btn btn-secondary"><i class="la la-check m--font-success"></i></a>
        <a @click="onEdit(asset.id)" class="m-btn btn btn-secondary"><i class="la la-pencil m--font-brand"></i></a>


      </div>
    </div>
  </div>
  @include('layouts/infinity-loading')
</div>
