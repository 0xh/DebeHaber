<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        @yield('title') | DebeHaber
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
    WebFont.load({
        google: {"families":["Open+Sans:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>
    <!--end::Web font -->

    <link href="/vendors/base/vendors.bundle.min.css" rel="stylesheet">
    <link href="/css/style.bundle.min.css" rel="stylesheet">

    @yield('styles')

    <script>
    window.Spark = <?php echo json_encode(array_merge(
        Spark::scriptVariables(), []
    )); ?>;
    </script>
</head>
<!-- end::Head -->

<body class="m--skin- m-content--skin-light m-header--fixed m-header--fixed-mobile">
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

                    {{-- <model inline-template> --}}
                    <div>
                        @hasSection('stats')
                            <div class="m-portlet">
                                <div class="m-portlet__body  m-portlet__body--no-padding">
                                    @yield('stats')
                                </div>
                            </div>
                        @endif

                        @yield('layout')
                    </div>
                    {{-- </model> --}}

                    @if (Auth::check())
                        @include('spark::modals.notifications')
                        {{-- @include('spark::modals.support') --}}
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
                                Cognitivo Paraguay SA
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
    </div>
    <!-- end:: Page -->

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

<script src="/vendors/base/vendors.bundle.min.js"></script>
<script src="/js/scripts.bundle.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
@yield('script')
</body>
<!-- end::Body -->
</html>
