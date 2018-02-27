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
                                    @lang('global.Dashboard',['team' => Auth::user()->currentTeam->name])
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
            </div>
        </div>
        <!-- END: Subheader -->

        @yield('content')
    </div>

@endsection
