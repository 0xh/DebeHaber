@extends('spark::layouts.one-column')

@section('title', __('accounting.ChartVersion'))

@section('content')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <chartversion inline-template>
    <div>
      <div class="row">
        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              Name
            </label>
            <div class="col-8">
              <input type="text" class="form-control" v-model="name" />
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group m-form__group row">

            <div class="col-8">
              <button v-on:click="onSave($data)" class="btn btn-primary">
                Guardar & New
              </button>
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>
      <br>
      <div class="m-portlet__body">
        <div class="row">
          <div class="col-2">
            <span class="m--font-boldest">
              Name
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
            @{{ data.name }}
          </div>
          <div class="col-1">

            <button v-on:click="onEdit(data)" class="btn btn-outline-pencil m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
              <i class="la la-pencil"></i>
            </button>
          </div>
        </div>
      </div>
    </div>



  </chartversion>

@endsection
