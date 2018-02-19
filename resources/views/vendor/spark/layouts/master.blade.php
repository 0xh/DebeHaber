<!DOCTYPE html>
<html lang="en" >
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

    <link href="/vendors/base/vendors.bundle.css" rel="stylesheet">
    <link href="/css/style.bundle.css" rel="stylesheet">
    <link href="{{ mix(Spark::usesRightToLeftTheme() ? 'css/app-rtl.css' : 'css/app.css') }}" rel="stylesheet">

    <script>
    window.Spark = <?php echo json_encode(array_merge(
        Spark::scriptVariables(), []
    )); ?>;
    </script>
</head>
<!-- end::Head -->
<!-- end::Body -->

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
                    @yield('contents')
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
                            {{ date("Y") }} &copy; DebeHaber by
                            <a href="https://www.cognitivo.in" class="m-link">
                                Cognitivo Paraguay SA
                            </a>
                        </span>
                    </div>
                    <div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
                        <ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
                            <li class="m-nav__item">
                                <a href="#"  class="m-nav__link">
                                    <span class="m-nav__link-text">
                                        Politicas de Privacidad
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="#" class="m-nav__link">
                                    <span class="m-nav__link-text">
                                        Terminos &amp; Condiciones
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="https://blog.debehaber.com" class="m-nav__link">
                                    <span class="m-nav__link-text">
                                        Blog
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="https://soporte.debehaber.com" class="m-nav__link">
                                    <span class="m-nav__link-text">
                                        Soporte
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
            <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Showcase" data-placement="left">
                <a href="">
                    <i class="la la-eye"></i>
                </a>
            </li>
            <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Pre-sale Chat" data-placement="left">
                <a href="" >
                    <i class="la la-comments-o"></i>
                </a>
            </li>
            <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Purchase" data-placement="left">
                <a href="https://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" target="_blank">
                    <i class="la la-cart-arrow-down"></i>
                </a>
            </li>
        @endif

        <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Tickets" data-placement="left">
            <a href="https://soporte.debehaber.com/ticket/" target="_blank">
                <i class="la la-envelope"></i>
            </a>
        </li>
        <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Support" data-placement="left">
            <a href="https://soporte.debehaber.com" target="_blank">
                <i class="la la-life-ring"></i>
            </a>
        </li>
    </ul>
    <!-- begin::Quick Nav -->
</div>
<script src="/vendors/base/vendors.bundle.js"></script>
<script src="/js/scripts.bundle.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
<!-- end::Body -->
</html>
