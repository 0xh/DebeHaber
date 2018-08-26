@extends('spark::layouts.form')

@section('title',  __('commercial.Document'))

@section('form')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <document :taxpayer="{{ request()->route('taxPayer')->id }}"  inline-template>
        <diV>
            <div>
                <div class="row">

                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('accounting.prefix')
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="prefix" />
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('global.mask')
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="mask" />
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('global.current_range')
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="current_range" />
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('global.start_range')
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="start_range" />
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('global.end_range')
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="end_range" />
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
                                @lang('global.code Expiry')
                            </label>
                            <div class="col-8">
                                <input type="Date" class="form-control" v-model="code_expiry" />
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-4 col-form-label">
                                @lang('global.Type')
                            </label>
                            <div class="col-8">
                                <select v-model="type" required class="custom-select">
                                    @php
                                    $enum = 'App\Enums\Countries\\' . request()->route('taxPayer')->country  . '\DocumentTypeEnum';
                                    @endphp
                                    @foreach ($enum::labels() as $value => $label)
                                        <option value="{{ $value }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


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
                            @lang('global.Prefix')
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('accounting.Mask')
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('accounting.Start Range')
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('accounting.End Range')
                        </span>
                    </div>
                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('accounting.Current Range')
                        </span>
                    </div>


                    <div class="col-2">
                        <span class="m--font-boldest">
                            @lang('global.Action')
                        </span>
                    </div>
                </div>

                <hr>

                <div class="row" v-for="data in list">
                    <div class="col-2">
                        @{{ data.prefix }}
                    </div>
                    <div class="col-2">
                        @{{ data.mask }}
                    </div>
                    <div class="col-2">
                        @{{ data.start_range }}
                    </div>
                    <div class="col-2">
                        @{{ data.end_range }}
                    </div>
                    <div class="col-2">
                        @{{ data.current_range }}
                    </div>
                    <div class="col-2">
                        <button v-on:click="onEdit(data)" class="btn btn-outline-pencil m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="la la-pencil"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </document>

@endsection
