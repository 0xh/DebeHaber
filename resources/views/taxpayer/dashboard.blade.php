@extends('spark::layouts.dashboard')

@section('title', __('global.Dashboard',['team' => request()->route('taxPayer')->alias]))

{{-- @section('stats')

<div class="row m-row--no-padding">
<div class="col-md-12 col-lg-6 col-xl-6">
<div class="m-widget24">
<div class="m-widget24__item">
@if ($totalSales > 0)
<h4 class="m-widget24__title">
<img src="/img/icons/sales.svg" alt="" width="32"> @lang('commercial.SalesBook')
</h4>

<br>

<span class="m-widget24__desc">
Some widget5__desc
</span>

<span class="m-widget24__stats m--font-success">
{{ number_format($totalSales, 0, '.', ',') }}
</span>

@else
<div class="m-nav-grid m-nav-grid--skin-light">
<div class="m-nav-grid__row">
<a href="{{route('sales.index', [request()->route('taxPayer'), request()->route('cycle')])}}" class="m-nav-grid__item padding-40-5">
<img src="/img/icons/sales.svg" alt="" width="64">
<span class="m-nav-grid__text">
Faltan cargar Ventas
<br>
<small>Empiece Aqui</small>
</span>
</a>
</div>
</div>
@endif
</div>
</div>
</div>
<div class="col-md-12 col-lg-6 col-xl-6">
<!--begin::New Feedbacks-->
<div class="m-widget24">
<div class="m-widget24__item">
@if ($totalPurchases > 0)
<h4 class="m-widget24__title">
<img src="/img/icons/purchase.svg" alt="" width="32"> @lang('commercial.PurchaseBook')
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
<div class="m-nav-grid__row">
<a href="{{route('purchases.index', [request()->route('taxPayer'), request()->route('cycle')])}}" class="m-nav-grid__item padding-40-5">
<img src="/img/icons/purchase.svg" alt="" width="64">
<span class="m-nav-grid__text">
Faltan cargar Compras
<br>
<small>Empiece Aqui</small>
</span>
</a>
</div>
</div>
@endif
</div>
</div>
<!--end::New Feedbacks-->
</div>
<div class="col-md-12 col-lg-6 col-xl-6">
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
</a>
</li>
</ul>
</div>
</div>

@endsection --}}

@section('content')
    <div class="row">

        <div class="col-md-12 col-lg-4">
            <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height">
                <div class="m-portlet__body">
                    <!--begin::Widget5-->
                    <div class="m-widget4">
                        <div class="m-widget4__chart m-portlet-fit--sides" style="height:160px;">
                            {{-- <img src="/img/bg/expense.jpg" height="160px" alt=""> --}}
                            <canvas id="m_chart_trends_stats" class="chartjs-render-monitor" style="background-image: url('/img/bg/expense.jpg'); display: block; width: 400px; height: 160px;"></canvas>
                        </div>

                        <div class="m-widget4__ext">

                        </div>

                        <div class="m-widget4__item">
                            <div class="m-widget4__info">
                                <span class="m-widget4__title">
                                    <a href="{{route('purchases.index', [request()->route('taxPayer'), request()->route('cycle')])}}">
                                        @lang('commercial.PurchaseBook')
                                    </a>
                                </span>
                                <br>
                                <span class="m-widget4__sub">
                                    A Programming Language
                                </span>
                            </div>
                            <span class="m-widget4__ext">
                                <span class="m-widget4__number
                                @if($totalPurchases == 0)
                                    m--font-danger
                                @else
                                    m--font-success
                                @endif">
                                    {{ number_format($totalPurchases, 0, '.', ',') }}
                                </span>
                            </span>
                        </div>

                        <div class="m-widget4__item">
                            <div class="m-widget4__img m-widget4__img--logo">
                                <img src="assets/app/media/img/client-logos/logo1.png" alt="">
                            </div>
                            <div class="m-widget4__info">
                                <span class="m-widget4__title">
                                    FlyThemes
                                </span><br>
                                <span class="m-widget4__sub">
                                    A Let's Fly Fast Again Language
                                </span>
                            </div>
                            <span class="m-widget4__ext">
                                <span class="m-widget4__number m--font-danger">+$300</span>
                            </span>
                        </div>
                        <div class="m-widget4__item">
                            <div class="m-widget4__img m-widget4__img--logo">
                                <img src="assets/app/media/img/client-logos/logo2.png" alt="">
                            </div>
                            <div class="m-widget4__info">
                                <span class="m-widget4__title">
                                    AirApp
                                </span><br>
                                <span class="m-widget4__sub">
                                    Awesome App For Project Management
                                </span>
                            </div>
                            <span class="m-widget4__ext">
                                <span class="m-widget4__number m--font-danger">+$6700</span>
                            </span>
                        </div>
                    </div>
                    <!--end::Widget 5-->
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-6">
            <h4 class="m-widget24__title">

            </h4>
        </div>
        <div class="col-md-12 col-lg-6">
            <h4 class="m-widget24__title">
                <img src="/img/icons/purchase.svg" alt="" width="32"> @lang('commercial.PurchaseBook')
            </h4>
        </div>
    </div>
@endsection
