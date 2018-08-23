
@extends('spark::layouts.form')

@section('title',  __('commercial.MoneyMovements'))
@section('stats')
  <div v-if="showList" class="row m-row--no-padding m-row--col-separator-xl">
    <div class="col-md-12 col-lg-6 col-xl-3">
      <div class="m-nav-grid m-nav-grid--skin-light">
        <div class="m-nav-grid__row">
          <div class="m-nav-grid__item">
            <span class="m-nav-grid__text">
              <button @click="onCreate()" class="btn btn-outline-primary m-btn m-btn--icon m-btn--outline-2x">
                <span>
                  <i class="la la-plus"></i>
                  <span>
                    @lang('global.Create', ['model' => __('commercial.Transfer')])
                  </span>
                </span>
              </button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-lg-6 col-xl-3">
      <div class="m-widget24">
        <div class="m-widget24__item">

        </div>
      </div>
    </div>
    <div class="col-md-12 col-lg-6 col-xl-3">
      <!--begin::New Feedbacks-->
      <div class="m-widget24">
        <div class="m-widget24__item">

        </div>
      </div>
      <!--end::New Feedbacks-->
    </div>
    <div class="col-md-12 col-lg-6 col-xl-3">
      <div class="container">
        <ul class="m-nav">

        </ul>
      </div>
    </div>
  </div>
@endsection
@section('form')
  <buefy taxpayer="{{ request()->route('taxPayer')->id}}" cycle="{{ request()->route('cycle')->id }}" baseurl="commercial/money_movements" inline-template>
    <div>
      <div v-if="$parent.showList">
        @include('commercial/money-movement/list')
      </div>
      <div v-else>
        @include('commercial/money-movement/form')
      </div>

    </div>
  </buefy>
@endsection
