@extends('spark::layouts.dashboard')

@section('title', __('global.Reports'))

@section('nav')

@endsection

@section('content')

    <div class="m-portlet m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        @lang('global.Select Date Range')
                        <input type="date" name="" value="">
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="false">
                            <i class="la la-briefcase"></i>
                            @lang('commercial.Commercial')
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="false">
                            <i class="la la-calculator"></i>
                            @lang('accounting.Accounting')
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_1_tab_content" role="tab" aria-selected="true">
                            <i class="la la-search"></i>
                            @lang('global.Audits')
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                    <div class="row">
                        <div class="col-6">

                            <h3> @lang('commercial.Sales') </h3>
                            <p class="lead"> Basic reports giving you information regarding your sales. </p>

                            <div class="m-widget4">
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/ventas.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('commercial.SalesBook')</a>
                                            <br>
                                            <small>Basic list of sales invoices</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/ventas.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('report.SalesByVAT')</a>
                                            <br>
                                            <small>List of invoices grouped by sales tax</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/ventas.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('report.SalesVATByCustomer')</a>
                                            <br>
                                            <small>List of invoices grouped by customers</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/credit-note.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('commercial.CreditNote')</a>
                                            <br>
                                            <small>List of credit returns made</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/account-receivable.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('commercial.AccountsReceivable')</a>
                                            <br>
                                            <small>List of accounts receivables</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/ventas.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('report.VATDebit')</a>
                                            <br>
                                            <small>List of VAT Debit (sales invoice plus debit notes)</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">

                            <h3> @lang('commercial.Purchases') </h3>
                            <p class="lead"> Basic reports giving you information regarding your purchases. </p>

                            <div class="m-widget4">
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/compras.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('commercial.PurchaseBook')</a>
                                            <br>
                                            <small>Simple list of purchase invoices</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/compras.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('report.SalesByVAT')</a>
                                            <br>
                                            <small>List of purchase invoices grouped by sales tax</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/compras.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('report.SalesBySuppliers')</a>
                                            <br>
                                            <small>List of purchase invoices grouped by suppliers</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/credit-note.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('commercial.DebitNote')</a>
                                            <br>
                                            <small>List of Debit Notes</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/account-payable.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('commercial.AccountsPayable')</a>
                                            <br>
                                            <small>List of accounts payable to suppliers</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/compras.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">@lang('report.SalesVAT')</a>
                                            <br>
                                            <small>List of VAT Debit (purchase invoice plus credit notes)</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-6">
                            <h3> Paraguay </h3>
                            <p class="lead"> Special reports from your country </p>

                            <div class="m-widget4">
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/clouds.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">Hechauka</a>
                                            <br>
                                            <small>Download your files</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">
                                        <img src="/img/icons/clouds.svg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            <a href="#">Aranduka</a>
                                            <br>
                                            <small>Download your files</small>
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                    It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
                <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
                </div>
            </div>
        </div>
    </div>

    {{-- <ul class="m-menu__inner">
    <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
    <a href="inner.html" class="m-menu__link ">
    <i class="m-menu__link-icon flaticon-graphic-1"></i>
    <span class="m-menu__link-text">
    @lang('accounting.JournalEntires')
</span>
</a>
</li>
<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
<a href="inner.html" class="m-menu__link ">
<i class="m-menu__link-icon flaticon-graphic-1"></i>
<span class="m-menu__link-text">
@lang('accounting.GroupJournalEntries')
</span>
</a>
</li>
<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
<a  href="inner.html" class="m-menu__link ">
<i class="m-menu__link-icon flaticon-graphic-1"></i>
<span class="m-menu__link-text">
@lang('accounting.BalanceSheet')
</span>
</a>
</li>
<li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
<a  href="inner.html" class="m-menu__link ">
<i class="m-menu__link-icon flaticon-graphic-1"></i>
<span class="m-menu__link-text">
@lang('accounting.BalanceSheet(Comparative)')
</span>
</a>
</li>
<li class="m-menu__item"  data-redirect="true" aria-haspopup="true">
<a  href="inner.html" class="m-menu__link ">
<i class="m-menu__link-icon flaticon-graphic-1"></i>
<span class="m-menu__link-text">
@lang('accounting.IncomeStatement')
</span>
</a>
</li>
<li class="m-menu__item" data-redirect="true" aria-haspopup="true">
<a href="inner.html" class="m-menu__link ">
<i class="m-menu__link-icon flaticon-graphic-1"></i>
<span class="m-menu__link-text">
@lang('accounting.StatementofCashflows')
</span>
</a>
</li>
<li class="m-menu__item"  data-redirect="true" aria-haspopup="true">
<a href="inner.html" class="m-menu__link ">
<i class="m-menu__link-icon flaticon-graphic-1"></i>
<span class="m-menu__link-text">
@lang('accounting.StatementofRetainedEarnings')
</span>
</a>
</li>
</ul> --}}
@endsection
