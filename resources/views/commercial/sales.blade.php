@extends('spark::layouts.form')

@section('title', 'Chart')

@section('form')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <router-view name="Datatable">

      <div class="my_datatable" id="m_datatable">
        <table id="example" class="display" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Start date</th>
                  <th>Salary</th>
              </tr>
          </thead>
          <tfoot>
              <tr>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Start date</th>
                  <th>Salary</th>
              </tr>
          </tfoot>
      </table></div>

  </router-view>


@endsection
