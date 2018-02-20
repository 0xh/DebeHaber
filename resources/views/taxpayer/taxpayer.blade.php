@extends('spark::layouts.one-column')

@section('title', 'Chart Version')

@section('form')

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <taxpayer inline-template>
    <div>
      <div class="row">
        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              Code
            </label>
            <div class="col-8">
              <input type="text" class="form-control" v-model="code" />
            </div>
          </div>
        </div>
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
            <label for="example-text-input" class="col-4 col-form-label">
              Alias
            </label>
            <div class="col-8">
              <input type="text" class="form-control" v-model="alias" />
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-4 col-form-label">
              email
            </label>
            <div class="col-8">
              <input type="text" class="form-control" v-model="email" />
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

    </div>



  </chartversion>

@endsection
