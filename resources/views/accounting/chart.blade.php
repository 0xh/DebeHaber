@extends('spark::layouts.form')

@section('title', 'Chart')

@section('form')
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <chart :taxpayer="{{ request()->route('taxPayer')}}"  inline-template>
    <div>
      <div class="row">
        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              @lang('accounting.ChartVersion')
            </label>
            <div class="col-8">
              <select v-model="chart_version_id" required class="custom-select" >
                <option v-for="chartversion in chartversions" :value="chartversion.id">@{{ chartversion.name }}</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              @lang('global.code')
            </label>
            <div class="col-8">
              <input type="text" class="form-control" v-model="code" />
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              @lang('global.name')
            </label>
            <div class="col-8">
              <input type="text" class="form-control" v-model="name" />
            </div>
          </div>
        </div>

        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              @lang('global.type')
            </label>
            <div class="col-8">
              <select v-model="type" required class="custom-select" >
                <option value="Asset">@lang('accounting.Asset')</option>
                <option value="2">@lang('accounting.Liabilities')</option>
                <option value="3">@lang('accounting.Capital')</option>
                <option value="4">@lang('accounting.Income')</option>
                <option value="5">@lang('accounting.Expense')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              @lang('global.subtype')
            </label>
            <div class="col-8">
              <select v-model="sub_type" required class="custom-select" >
                <option value="1">@lang('accounting.Cash and Bank Accounts')</option>
                <option value="2">@lang('accounting.Accounts Receivable')</option>
                <option value="3">@lang('accounting.Undeposited Funds')</option>
                <option value="4">@lang('accounting.Inventory')</option>
                <option value="5">@lang('accounting.Fixed Assets Groups')</option>
                <option value="6">@lang('accounting.Prepaid Insurance')</option>
                <option value="7">@lang('accounting.Sales Tax Credit')</option>
                <option value="8">@lang('accounting.Accrued Liablities')</option>
                <option value="9">@lang('accounting.Accounts Payable')</option>
                <option value="10">@lang('accounting.Payroll liabilities')</option>
                <option value="11">@lang('accounting.Notes Payable')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              @lang('accounting.accountable')
            </label>
            <div class="col-8">
              <input type="checkbox" class="form-control" v-model="is_accountable" />
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group m-form__group row">

            <div class="col-8">
              <button v-on:click="onSave($data)" class="btn btn-primary">
                @lang('global.Save')
              </button>
            </div>
          </div>
        </div>
      </div>

      <hr>

      <div class="m-portlet__body">
        <div class="row">
          <div class="col-2">
            <span class="m--font-boldest">
                  @lang('global.code')
            </span>
          </div>
          <div class="col-2">
            <span class="m--font-boldest">
              @lang('global.name')
            </span>
          </div>
          <div class="col-2">
            <span class="m--font-boldest">
                  @lang('global.version')
            </span>
          </div>
          <div class="col-2">
            <span class="m--font-boldest">
              @lang('accounting.accountable')
            </span>
          </div>

          <div class="col-2">
            <span class="m--font-boldest">
              Action
            </span>
          </div>
        </div>
        <hr>
        <div class="row" v-for="data in list">
          <div class="col-2">
            @{{ data.code }}
          </div>
          <div class="col-2">
            @{{ data.name }}
          </div>
          <div class="col-2">
            @{{ data.chart_version_name }}
          </div>
          <div class="col-2">
            @{{ data.is_accountable }}
          </div>

          <div class="col-1">

            <button v-on:click="onEdit(data)" class="btn btn-outline-pencil m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
              <i class="la la-pencil"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </chart>

@endsection