
@extends('spark::layouts.form')

@section('title',  __('accounting.ChartofAccounts'))

@section('stats')

@endsection

@section('form')

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <mergechart :taxpayer="{{ request()->route('taxPayer')->id }}" :cycle="{{ request()->route('cycle')->id }}" :id="{{ request()->route('id') }}" :name="'{{ request()->route('name') }}'" inline-template>
      <div>

          <!--begin::Form-->
          <div class="m-form m-form--fit m-form--label-align-right m-form--group-seperator">
              <div class="m-portlet__body">
                  <div class="form-group m-form__group row">
                      <label class="col-lg-2 col-form-label">
                          @lang('global.FromAccount'):
                      </label>
                      <div class="col-lg-6">
                          <router-view name="SearchBoxAccount" url="/accounting/chart/get-accountable_charts/" :cycle="{{ request()->route('cycle')->id }}" :current_company="{{ request()->route('taxPayer')->id }}" >

                          </router-view>
                      </div>
                  </div>
                  <div class="form-group m-form__group row">
                      <label class="col-lg-2 col-form-label">
                          @lang('global.ToAccount'):
                      </label>
                      <div class="col-lg-6">
                          <router-view name="SearchBoxAccount" url="/accounting/chart/get-accountable_charts/" :cycle="{{ request()->route('cycle')->id }}" :current_company="{{ request()->route('taxPayer')->id }}" >

                          </router-view>
                      </div>
                  </div>

              </div>
          </div>

          <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
              <div class="m-form__actions m-form__actions--solid">
                  <div class="row">
                      <div class="col-lg-2"></div>
                      <div class="col-lg-6">
                          <button v-on:click="onSave($data)" class="btn btn-primary">
                              @lang('global.Save')
                          </button>
                          <button v-on:click="cancel()" class="btn btn-secondary">Cancel</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>

  </mergechart>

@endsection
