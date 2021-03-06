<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        @yield('title') | DebeHaber
    </title>
    <meta name="description" content="Gestione su Contabilidad online gratis!">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="/vendors/base/vendors.bundle.css" rel="stylesheet">
    <link href="/css/style.bundle.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
    @yield('styles')

    @if (config('app.debug'))
        <style>
        body { background-color: LightSteelBlue !important}
        </style>
    @endif

    <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#f5f5f5">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#f5f5f5">

    <script> window.Spark = <?php echo json_encode(array_merge(Spark::scriptVariables(), [])); ?>; </script>
</head>
<!-- end::Head -->

<body class="m-header--fixed m-header--fixed-mobile">
    <div id="spark-app" v-cloak>
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- BEGIN: Header -->
            @if (Auth::check())
                @include('spark::nav.list')
            @else
                @include('spark::nav.guest')
            @endif
        </div>

        <!-- begin::Body -->
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body">
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-container m-container--responsive m-container--xxl m-container--full-height">
                <div class="m-grid__item m-grid__item--fluid m-wrapper">

                    @hasSection('settings')
                        @yield('settings')
                    @else
                        @if(request()->route('cycle') != null)
                            @php
                            $cycleid = request()->route('cycle')->id ;
                            $taxpayerid = request()->route('taxPayer')->id ;
                            @endphp
                        @else
                            @php
                            $cycleid = 0 ;
                            $taxpayerid = 0;
                            @endphp
                        @endif

                        <model cycle="{{ $cycleid }}" taxpayer="{{ $taxpayerid }}" inline-template>
                            <div>
                                <div class="m-subheader row">
                                    <div class="d-flex col-9">
                                        <div class="mr-auto">
                                            <h4 class="m--block-inline title is-4"> @yield('title') </h4>
                                        </div>

                                        @if(request()->route('cycle') != null)
                                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline m--align-right">
                                                <li class="m-nav__item m-nav__item--home">
                                                    <a href="{{ route('home') }}" class="m-nav__link m-nav__link--icon m--font-info">
                                                        <i class="la la-home"></i>
                                                        @lang('global.Dashboard',['team' => Auth::user()->currentTeam->name])
                                                    </a>
                                                </li>
                                                <li class="m-nav__separator">
                                                    /
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="{{ route('taxpayer.dashboard', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-nav__link">
                                                        <span class="m-nav__link-text m--font-info">
                                                            {{ request()->route('taxPayer')->name }}
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__separator">
                                                    /
                                                </li>
                                                <li class="m-nav__item">
                                                    <b-dropdown hoverable>
                                                        <button class="button is-info" slot="trigger">
                                                            <span>{{request()->route('cycle')->year}}</span>
                                                            <b-icon icon="angle-down"></b-icon>
                                                        </button>

                                                        <b-dropdown-item v-for="cycle in cycles" @click="changeCycle(cycle.id)">
                                                            @{{ cycle.year }}
                                                        </b-dropdown-item>
                                                    </b-dropdown>
                                                </li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>

                                @hasSection('stats')
                                    <div class="m-portlet">
                                        <div class="m-portlet__body  m-portlet__body--no-padding">
                                            @yield('stats')
                                        </div>
                                    </div>
                                @endif

                                @yield('layout')
                            </div>
                        </model>
                    @endif

                    @if (Auth::check())
                        @include('spark::modals.notifications')
                        @include('spark::modals.session-expired')
                    @endif
                </div>
            </div>
        </div>
        <!-- end:: Body -->

        <!-- begin::Footer -->
        <footer class="m-grid__item  m-footer ">
            <div class="m-container m-container--responsive m-container--xxl m-container--full-height">
                <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                    <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                        <span class="m-footer__copyright">
                            {{ date("Y") }} &copy; @lang('global.DebeHaberBy')
                            <a href="https://www.cognitivo.in" class="m-link">
                                Cognitivo, Inc.
                            </a>
                        </span>
                    </div>
                    <div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
                        <ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
                            <li class="m-nav__item">
                                <a href="#" target="_blank" class="m-nav__link">
                                    <span class="m-nav__link-text">
                                        @lang('global.PrivacyPolicy')
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="#" target="_blank" class="m-nav__link">
                                    <span class="m-nav__link-text">
                                        @lang('global.TermsConditions')
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="https://developer.debehaber.com" target="_blank" class="m-nav__link">
                                    <span class="m-nav__link-text">
                                        @lang('global.DeveloperPlatform')
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="https://blog.debehaber.com" target="_blank" class="m-nav__link">
                                    <span class="m-nav__link-text m--font-info">
                                        Blog
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="https://support.debehaber.com" target="_blank" class="m-nav__link">
                                    <span class="m-nav__link-text m--font-danger">
                                        @lang('global.Support')
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end::Footer -->

        <!-- begin::Scroll Top -->
        <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
            <i class="la la-arrow-up"></i>
        </div>
        <!-- end::Scroll Top -->
        <ul class="m-nav-sticky">
            @if (request()->route('taxPayer'))
                <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="@lang('commercial.SalesBook')" data-placement="left">
                    <a href="{{ route('sales.index', [request()->route('taxPayer'), request()->route('cycle')]) }}">
                        <i class="la la-paper-plane"></i>
                    </a>
                </li>
                <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="@lang('commercial.PurchaseBook')" data-placement="left">
                    <a href="{{ route('purchases.index', [request()->route('taxPayer'), request()->route('cycle')]) }}">
                        <i class="la la-shopping-cart"></i>
                    </a>
                </li>

                <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="@lang('accounting.Journal')" data-placement="left">
                    <a href="{{ route('journals.index', [request()->route('taxPayer'), request()->route('cycle')]) }}">
                        <i class="la la-list"></i>
                    </a>
                </li>

                <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="@lang('global.Reports')" data-placement="left">
                    <a href="{{ route('reports.index', [request()->route('taxPayer'), request()->route('cycle')]) }}">
                        <i class="la la-pie-chart"></i>
                    </a>
                </li>
            @endif
            <hr>
            <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Tickets" data-placement="left">
                <a href="https://support.debehaber.com/ticket/" target="_blank">
                    <i class="la la-envelope m--font-primary"></i>
                </a>
            </li>
            <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="@lang('global.Support')" data-placement="left">
                <a href="https://support.debehaber.com" target="_blank">
                    <i class="la la-life-ring m--font-primary"></i>
                </a>
            </li>
        </ul>
        <!-- begin::Quick Nav -->
    </div>

    @yield('scripts')
    <script src="/vendors/base/vendors.bundle.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="/js/scripts.bundle.js"></script>
</body>
<!-- end::Body -->
</html>
