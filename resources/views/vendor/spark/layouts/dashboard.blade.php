@extends('spark::layouts.master')

@section('layout')

    <div class="m-content">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">
                        @yield('title')
                    </h3>
                    @if(request()->route('cycle') != null)
                        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                            <li class="m-nav__item m-nav__item--home">
                                <a href="{{ route('hello') }}" class="m-nav__link m-nav__link--icon m--font-primary">
                                    <i class="la la-home"></i>
                                    @{{ currentTeam.name }} @lang('global.Dashboard')
                                </a>
                            </li>
                            <li class="m-nav__separator">
                                /
                            </li>
                            <li class="m-nav__item">
                                <a href="{{ route('taxpayer.dashboard', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-nav__link">
                                    <span class="m-nav__link-text m--font-brand">
                                        {{ request()->route('taxPayer')->name }}
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__separator">
                                /
                            </li>
                            <li class="m-nav__item">
                                <a href="#" class="m-nav__link">
                                    <span class="m-nav__link-text m--font-focus">
                                        {{ request()->route('cycle')->year }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>
                <div>
                    @if(request()->route('cycle') != null)
                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                            <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                                <i> {{ request()->route('cycle')->year }} </i>
                            </a>
                            <div class="m-dropdown__wrapper">
                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                <div class="m-dropdown__inner">
                                    <div class="m-dropdown__body">
                                        <div class="m-dropdown__content">
                                            <ul class="m-nav">
                                                <li class="m-nav__section m-nav__section--first m--hide">
                                                    <span class="m-nav__section-text">
                                                        Quick Actions
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- END: Subheader -->

        @yield('content')
    </div>

@endsection
