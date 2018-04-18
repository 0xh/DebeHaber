@extends('spark::layouts.dashboard')

@section('title', __('global.Dashboard',['team' => request()->route('taxPayer')->alias]))

@section('stats')
    <div class="row m-row--no-padding m-row--col-separator-xl">
        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="m-nav-grid m-nav-grid--skin-light">
                <div class="m-nav-grid__row">
                    <a href="{{ route('journals.generate', [request()->route('taxPayer'), request()->route('cycle'),
                        request()->route('cycle')->start_date,
                        request()->route('cycle')->end_date]) }}" class="m-nav-grid__item padding-40-5">
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
                            <img src="/img/icons/sales.svg" alt="" width="32"> @lang('commercial.SalesBook')
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
        <div class="col-md-12 col-lg-6 col-xl-3">
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
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-6">
            <!--begin:: Widgets/Inbound Bandwidth-->
            <div class="m-portlet m-portlet--bordered-semi m-portlet--half-height m-portlet--fit " style="min-height: 300px">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Inbound Bandwidth
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin::Widget5-->
                    <div class="m-widget20">
                        <div class="m-widget20__number m--font-success">670</div>
                        <div class="m-widget20__chart" style="height:160px;"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                        </div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                            <canvas id="m_chart_bandwidth" width="772" height="320" class="chartjs-render-monitor" style="display: block; height: 160px; width: 386px;"></canvas>
                        </div>
                    </div>
                    <!--end::Widget 5-->
                </div>
            </div>

            <div class="m--space-30"></div>

            <div class="m-portlet m-portlet--bordered-semi m-portlet--half-height m-portlet--fit " style="min-height: 300px">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Outbound Bandwidth
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin::Widget5-->
                    <div class="m-widget20">
                        <div class="m-widget20__number m--font-warning">340</div>
                        <div class="m-widget20__chart" style="height:160px;"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                        <canvas id="m_chart_bandwidth2" width="772" height="320" class="chartjs-render-monitor" style="display: block; height: 160px; width: 386px;"></canvas>
                    </div>
                </div>
                <!--end::Widget 5-->
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <!--begin:: Widgets/Top Products-->
        <div class="m-portlet m-portlet--full-height m-portlet--fit ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Configuracion de Cuentas
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin::Widget5-->
                <div class="m-widget4 m-widget4--chart-bottom" style="min-height: 480px">
                    {{-- @php
                    $totalExpense = App\Models\CostCenter::myExpenses()->count();
                    $totalAccounts = App\Models\Account::Account(request()->route('company')->id)->count();
                    $totalIncome = App\Models\CostCenter::myIncome()->count();
                    $totalInventory = App\Models\CostCenter::myInventory()->count();
                    $totalFixedAssets = App\Models\CostCenter::myAssetGroups()->count();
                @endphp --}}

                <div class="m-widget4__item">
                    <img src="/img/icons/account.svg" width="60">
                    <div class="m-widget4__info">
                        <span class="m-widget4__title">
                            {{-- <a href="{{ route('accounts.index', request()->route('company')) }}"> --}}
                            Cuentas de Dinero <i class="la la-chevron-circle-right"></i>
                            {{-- </a> --}}
                            <small class="text-info"><i>Cant. de Registros: {{ $chartMoneyAccounts }}</i></small>
                        </span><br>
                        <span class="m-widget4__sub">
                            Cuenta de Banco o tipo Caja, que pueden almacenar fondos. Integrado con Compras, Ventas, y Pagos.
                        </span>
                    </div>
                </div>
                <div class="m-widget4__item">
                    <img src="/img/icons/purchase.svg" width="60">

                    <div class="m-widget4__info">
                        <span class="m-widget4__title">
                            {{-- <a href="{{ route('expense.index', request()->route('company')) }}"> --}}
                            Cuentas de Gastos <i class="la la-chevron-circle-right"></i>
                        </a>
                        <small class="text-info"><i>Cant. de Registros: {{ $chartExpenses }}</i></small>
                    </span>
                    <br>
                    <span class="m-widget4__sub">
                        Gastos en general tipo Fijos o Administrativos. Integrado con Facturas de Compras.
                    </span>
                </div>
            </div>
            <div class="m-widget4__item">
                <img src="/img/icons/income.svg" width="60">

                <div class="m-widget4__info">
                    <span class="m-widget4__title">
                        {{-- <a href="{{ route('income.index', request()->route('company')) }}"> --}}
                        Cuentas de Ingresos <i class="la la-chevron-circle-right"></i>
                    </a>
                    <small class="text-{{ $chartIncomes == 0 ? 'danger' : 'info' }}"><i>Cant. de Registros: {{ $chartIncomes }}</i></small>
                </span>
                <br>
                <span class="m-widget4__sub">
                    Cuentas que generan Ingresos como Servicios o Ganancias. Integrado con Facturas de Ventas.
                </span>
            </div>
        </div>
        <div class="m-widget4__item">
            <img src="/img/icons/inventory.svg" width="60">

            <div class="m-widget4__info">
                <span class="m-widget4__title">
                    {{-- <a href="{{ route('inventory.index', request()->route('company')) }}"> --}}
                    Cuentas de Inventario <i class="la la-chevron-circle-right"></i>
                </a>
                <small class="text-{{ $chartInventories == 0 ? 'danger' : 'info' }}"><i>Cant. de Registros: {{ $chartInventories }}</i></small>
            </span>
            <br>
            <span class="m-widget4__sub">
                Cuentas que suman el valor del inventario. Principalmente utilizado en Compras y descontado manualmente.
            </span>
        </div>
    </div>
    <div class="m-widget4__item">
        <img src="/img/icons/fixed-asset.svg" width="60">

        <div class="m-widget4__info">
            <span class="m-widget4__title">
                {{-- <a href="{{ route('asset-group.index', request()->route('company')) }}"> --}}
                Cuentas de Activos Fijos <i class="la la-chevron-circle-right"></i>
            </a>
            <small class="text-{{ $chartFixedAssets == 0 ? 'danger' : 'info' }}"><i>Cant. de Registros: {{ $chartFixedAssets }}</i></small>
        </span>
        <br>
        <span class="m-widget4__sub">
            Valor de Activos que se deprecian con el tiempo. Integrado con Compras y Ventas.
        </span>
    </div>
</div>
</div>
<!--end::Widget 5-->
</div>
</div>
</div>
</div>
<div class="row">
    <div class="col-xl-6">
        <!--begin:: Widgets/Support Cases-->
        <div class="m-portlet  m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Support Cases
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                            <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
                                <i class="la la-ellipsis-h m--font-brand"></i>
                            </a>
                            <div class="m-dropdown__wrapper">
                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                <div class="m-dropdown__inner">
                                    <div class="m-dropdown__body">
                                        <div class="m-dropdown__content">
                                            <ul class="m-nav">
                                                <li class="m-nav__section m-nav__section--first">
                                                    <span class="m-nav__section-text">Quick Actions</span>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                        <span class="m-nav__link-text">Activity</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                        <span class="m-nav__link-text">Messages</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-info"></i>
                                                        <span class="m-nav__link-text">FAQ</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                        <span class="m-nav__link-text">Support</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__separator m-nav__separator--fit">
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Cancel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-widget16">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="m-widget16__head">
                                <div class="m-widget16__item">
                                    <span class="m-widget16__sceduled">
                                        Type
                                    </span>
                                    <span class="m-widget16__amount m--align-right">
                                        Amount
                                    </span>
                                </div>
                            </div>
                            <div class="m-widget16__body">
                                <!--begin::widget item-->
                                <div class="m-widget16__item">
                                    <span class="m-widget16__date">
                                        EPS
                                    </span>
                                    <span class="m-widget16__price m--align-right m--font-brand">
                                        +78,05%
                                    </span>
                                </div>
                                <!--end::widget item-->
                                <!--begin::widget item-->
                                <div class="m-widget16__item">
                                    <span class="m-widget16__date">
                                        PDO
                                    </span>
                                    <span class="m-widget16__price m--align-right m--font-accent">
                                        21,700
                                    </span>
                                </div>
                                <!--end::widget item-->
                                <!--begin::widget item-->
                                <div class="m-widget16__item">
                                    <span class="m-widget16__date">
                                        OPL Status
                                    </span>
                                    <span class="m-widget16__price m--align-right m--font-danger">
                                        Negative
                                    </span>
                                </div>
                                <!--end::widget item-->
                                <!--begin::widget item-->
                                <div class="m-widget16__item">
                                    <span class="m-widget16__date">
                                        Priority
                                    </span>
                                    <span class="m-widget16__price m--align-right m--font-brand">
                                        +500,200
                                    </span>
                                </div>
                                <!--end::widget item-->
                                <!--begin::widget item-->
                                <div class="m-widget16__item">
                                    <span class="m-widget16__date">
                                        Net Prifit
                                    </span>
                                    <span class="m-widget16__price m--align-right m--font-brand">
                                        $18,540,60
                                    </span>
                                </div>
                                <!--end::widget item-->
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="m-widget16__stats">
                                <div class="m-widget16__visual">
                                    <div id="m_chart_support_tickets" style="height: 180px">

                                    </div>
                                </div>
                                <div class="m-widget16__legends">
                                    <div class="m-widget16__legend">
                                        <span class="m-widget16__legend-bullet m--bg-info"></span>
                                        <span class="m-widget16__legend-text">20% Margins</span>
                                    </div>
                                    <div class="m-widget16__legend">
                                        <span class="m-widget16__legend-bullet m--bg-accent"></span>
                                        <span class="m-widget16__legend-text">80% Profit</span>
                                    </div>
                                    <div class="m-widget16__legend">
                                        <span class="m-widget16__legend-bullet m--bg-danger"></span>
                                        <span class="m-widget16__legend-text">10% Lost</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end:: Widgets/Support Stats-->	</div>
        <div class="col-xl-6">
            <!--begin:: Widgets/Finance Stats-->
            <div class="m-portlet  m-portlet--full-height ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Finance Stats
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                                <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
                                    <i class="la la-ellipsis-h m--font-brand"></i>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav">
                                                    <li class="m-nav__section m-nav__section--first">
                                                        <span class="m-nav__section-text">Quick Actions</span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-share"></i>
                                                            <span class="m-nav__link-text">Activity</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                            <span class="m-nav__link-text">Messages</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-info"></i>
                                                            <span class="m-nav__link-text">FAQ</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                            <span class="m-nav__link-text">Support</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__separator m-nav__separator--fit">
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Cancel</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget1 m-widget1--paddingless">
                        <div class="m-widget1__item">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">IPO Margin</h3>
                                    <span class="m-widget1__desc">Awerage IPO Margin</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-accent">+24%</span>
                                </div>
                            </div>
                        </div>
                        <div class="m-widget1__item">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Payments</h3>
                                    <span class="m-widget1__desc">Yearly Expenses</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-info">+$560,800</span>
                                </div>
                            </div>
                        </div>
                        <div class="m-widget1__item">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Logistics</h3>
                                    <span class="m-widget1__desc">Overall Regional Logistics</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-warning">-10%</span>
                                </div>
                            </div>
                        </div>
                        <div class="m-widget1__item">
                            <div class="row m-row--no-padding align-items-center">
                                <div class="col">
                                    <h3 class="m-widget1__title">Expenses</h3>
                                    <span class="m-widget1__desc">Balance</span>
                                </div>
                                <div class="col m--align-right">
                                    <span class="m-widget1__number m--font-danger">$345,000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end:: Widgets/Finance Stats-->
        </div>
    </div>

@endsection
