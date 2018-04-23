@extends('spark::layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="m-portlet m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ $taxPayer->name }} <small></small>
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand  m-tabs-line--right m-tabs-line-danger" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#info" role="tab">
                            <i class="flaticon-share"></i>
                            Information
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#settings" role="tab">
                            <i class="flaticon-share"></i>
                            Settings
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#currencies" role="tab">
                            <i class="flaticon-share"></i>
                            Currencies
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="info">

                    <div class="m-form__section m-form__section--first">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title">Taxpayer Information</h3>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label">Name</label>
                            <div class="col-lg-6">
                                <input type="email" class="form-control m-input" placeholder="Enter full name">
                                <span class="m-form__help">Please enter your full name</span>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label">Alias</label>
                            <div class="col-lg-6">
                                <input type="email" class="form-control m-input" placeholder="Enter email">
                                <span class="m-form__help">We'll never share your email with anyone else</span>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label">Tax ID</label>
                            <div class="col-lg-6">
                                <input type="email" class="form-control m-input" placeholder="Enter email">
                                <span class="m-form__help">We'll never share your email with anyone else</span>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label">Email</label>
                            <div class="col-lg-6">
                                <input type="email" class="form-control m-input" placeholder="Enter email">
                                <span class="m-form__help">We'll never share your email with anyone else</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label">Telephone</label>
                            <div class="col-lg-6">
                                <input type="email" class="form-control m-input" placeholder="Enter email">
                                <span class="m-form__help">We'll never share your email with anyone else</span>
                            </div>
                        </div>
                    </div>

                    <div class="m-form__section m-form__section--first">
                        <div class="m-form__heading">
                            <h3 class="m-form__heading-title">Accounting Information</h3>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label">Agent</label>
                            <div class="col-lg-6">
                                <input type="email" class="form-control m-input" placeholder="Enter email">
                                <span class="m-form__help">We'll never share your email with anyone else</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label">Agent TaxID</label>
                            <div class="col-lg-6">
                                <input type="email" class="form-control m-input" placeholder="Enter email">
                                <span class="m-form__help">We'll never share your email with anyone else</span>
                            </div>
                        </div>
                        <div class="m-form__group form-group row">
                            <label class="col-lg-2 col-form-label">Communication:</label>
                            <div class="col-lg-6">
                                <div class="m-checkbox-list">
                                    <label class="m-checkbox">
                                        <input type="checkbox"> Email
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input type="checkbox"> SMS
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input type="checkbox"> Phone
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane " id="settings">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
                </div>
                <div class="tab-pane " id="currencies">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
                </div>
            </div>
        </div>
    </div>
@endsection
