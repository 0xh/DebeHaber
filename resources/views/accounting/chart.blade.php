{{-- <div class="col-10">
<div class="form-group m-form__group row">
<label for="example-text-input" class="col-4 col-form-label">
@lang('accounting.ChartVersion')
</label>
<div class="col-8">
{{ request()->route('taxPayer')->country . ' ' . request()->route('cycle')->chartVersion->name }}
</div>
</div>
</div> --}}

@extends('spark::layouts.form')

@section('title',  __('accounting.ChartofAccounts'))

@section('form')

    <model :taxpayer="{{ request()->route('taxPayer')->id}}"
      :cycle="{{ request()->route('cycle')->id }}"
      url="accounting/chart/get_charts" editurl="/commercial/get_salesByID/" deleteurl="commercial/sales"
      inline-template>
      <div>
          <div v-if="status === 1">
              @include('accounting/chart/form')
          </div>
          <div v-else>
             @include('accounting/chart/list')
          </div>
      </div>
  </model>
@endsection
