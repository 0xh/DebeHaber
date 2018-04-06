@extends('spark::layouts.master')

@section('stats')
    <div class="col-md-12 col-lg-6 col-xl-3">
        <div class="m-nav-grid m-nav-grid--skin-light">
            <div class="m-nav-grid__row">
                <a href="{{ route('journals.generate', [request()->route('taxPayer'), request()->route('cycle'), \Carbon\Carbon::now()->subMonth(3)->startOfDay(), \Carbon\Carbon::now()->endOfDay()]) }}" class="m-nav-grid__item padding-40-5">
                    <img src="/img/icons/generate.svg" alt="" width="64">
                    <span class="m-nav-grid__text">
                        Generar Asientos
                        <br>
                        <small>Click Aqui</small>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6 col-xl-3">
        <div class="m-widget24">
            <div class="m-widget24__item">
                @if ($totalSales > 0)
                    <h4 class="m-widget24__title">
                        <img src="/img/icons/ventas.svg" alt="" width="32"> @lang('commercial.SalesBook')
                    </h4>

                    <br>

                    <span class="m-widget24__desc">
                    </span>

                    <span class="m-widget24__stats m--font-success">
                        {{ number_format($totalSales, 0, '.', ',') }}
                    </span>

                    <div class="m--space-10"></div>

                    <div class="progress m-progress--sm">
                    </div>
                    <span class="m-widget24__change">
                    </span>
                    <span class="m-widget24__number">
                    </span>
                @else
                    <div class="m-nav-grid m-nav-grid--skin-light">
                        <div class="m-nav-grid__row background-sales">
                            <a href="{{ route('sales.index', [request()->route('taxPayer'), request()->route('cycle')])}}">
                                <img src="/img/icons/ventas.svg" alt="" width="64">
                                <span class="m-nav-grid__text">
                                    <p class="lead">
                                        Faltan cargar Ventas
                                    </p>
                                    Empiece Aqui
                                </span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6 col-xl-3">
        <!--begin::New Feedbacks-->
        <div class="m-widget24">
            <div class="m-widget24__item">
                @if ($totalPurchases > 0)
                    <h4 class="m-widget24__title">
                        <img src="/img/icons/compras.svg" alt="" width="32"> @lang('commercial.PurchaseBook')
                    </h4>
                    <br>
                    <span class="m-widget24__desc">
                    </span>
                    <span class="m-widget24__stats m--font-info">
                        {{ number_format($totalPurchases, 0, '.', ',') }}
                    </span>
                    <div class="m--space-10"></div>
                    <div class="progress m-progress--sm"></div>
                    <span class="m-widget24__change"></span>
                    <span class="m-widget24__number"></span>
                @else
                    <div class="m-nav-grid m-nav-grid--skin-light">
                        <div class="m-nav-grid__row background-sales">
                            <a href="{{route('purchases.index', [request()->route('taxPayer'), request()->route('cycle')])}}">
                                <img src="/img/icons/compras.svg" alt="" width="64">
                                <span class="m-nav-grid__text">
                                    <p class="lead">
                                        Faltan cargar Compras
                                    </p>
                                    Empiece Aqui
                                </span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!--end::New Feedbacks-->
    </div>
    <div class="col-md-12 col-lg-6 col-xl-3">
        <div class="container">
            <ul class="m-nav">
                <li class="m-nav__section">
                    <span class="m-nav__section-text">
                    </span>
                </li>
                <li class="m-nav__item">
                    <i class="m-nav__link-icon la la-paper-plane-o"></i>
                    <span class="m-nav__link-text">@lang('commercial.PurchaseBook')</span>
                </li>
                <li class="m-nav__item">
                    <i class="m-nav__link-icon la la-shopping-cart"></i>
                    <span class="m-nav__link-text">Libro IVA Compras</span>
                </li>
                <li class="m-nav__item">
                    <i class="m-nav__link-icon la la-book"></i>
                    <span class="m-nav__link-text">Libro Mayor</span>
                </li>
                <li class="m-nav__item">
                    <i class="m-nav__link-icon la la-cloud-download"></i>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('layout')
    <div class="m-content">
        @yield('content')
    </div>
@endsection
