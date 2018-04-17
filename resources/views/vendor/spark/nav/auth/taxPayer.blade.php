<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
        <li class="m-menu__item @if (\Request::is('*/commercial/*')) m-menu__item--active @endif m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">
            <a href="#" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon la la-briefcase"></i>
                <span class="m-menu__link-text">
                    {{ request()->route('taxPayer')->alias }}
                </span>
                <i class="m-menu__hor-arrow la la-angle-down"></i>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>

            @php
            $startDate = new Carbon\Carbon('first day of last month');
            $endDate = new Carbon\Carbon('last day of last month');
            @endphp

            <div class="m-menu__submenu m-menu__submenu--fixed m-menu__submenu--left" style="width:900px">
                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                <div class="m-menu__subnav">
                    <ul class="m-menu__content">
                        <li class="m-menu__item">
                            <h3 class="m-menu__heading m-menu__toggle">
                                <span class="m-menu__link-text">
                                    @lang('commercial.Sales')
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </h3>
                            <ul class="m-menu__inner">
                                <li class="m-menu__item " data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('sales.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-paper-plane"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.SalesBook')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('account-receivables.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-money"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.AccountsReceivable')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('credit-notes.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-mail-reply"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.CreditNotes')
                                        </span>
                                    </a>
                                </li>

                                @if (request()->route('taxPayer')->is_company)
                                    <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                        <a href="{{ route('impex-exports.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-ship"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.Exports')
                                            </span>
                                        </a>
                                    </li>
                                @endif

                                <h3 class="m-menu__heading m-menu__toggle">
                                    <span class="m-menu__link-text">
                                        @lang('global.Reports')
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </h3>

                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('reports.sales', [request()->route('taxPayer'), request()->route('cycle'), $startDate, $endDate]) }}" target="_blank" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-graphic-1"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.SalesBook')
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="m-menu__item">
                            <h3 class="m-menu__heading m-menu__toggle">
                                <span class="m-menu__link-text">
                                    @lang('commercial.Purchases')
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </h3>
                            <ul class="m-menu__inner">
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('purchases.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-shopping-cart"></i>

                                        <span class="m-menu__link-text">
                                            @lang('commercial.PurchaseBook')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('account-payables.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-money"></i>

                                        <span class="m-menu__link-text">
                                            @lang('commercial.AccountsPayable')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('debit-notes.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-mail-forward"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.DebitNotes')
                                        </span>
                                    </a>
                                </li>
                                @if (request()->route('taxPayer')->is_company)
                                    <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                        <a href="{{ route('impex-imports.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-ship"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.Imports')
                                            </span>
                                        </a>
                                    </li>
                                @endif
                                <h3 class="m-menu__heading m-menu__toggle">
                                    <span class="m-menu__link-text">
                                        @lang('global.Reports')
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </h3>

                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('reports.purchases', [request()->route('taxPayer'), request()->route('cycle'), $startDate, $endDate]) }}" target="_blank" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-graphic-1"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.PurchaseBook')
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="m-menu__item">
                            <h3 class="m-menu__heading m-menu__toggle">
                                <span class="m-menu__link-text">
                                    @lang('commercial.General')
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </h3>
                            <ul class="m-menu__inner">
                                <li class="m-menu__item " data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('inventories.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-gear"></i>
                                        <span class="m-menu__link-text">
                                            @lang('global.ProfileAndSettings')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item " data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('money-transfers.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-money"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.MoneyTransfers')
                                        </span>
                                    </a>
                                </li>

                                @if (request()->route('taxPayer')->is_company == 1)
                                    {{-- If Taxpayer is not Company, do not show Inventory, Production, and Fixed Assets--}}

                                    <li class="m-menu__item " data-redirect="true" aria-haspopup="true">
                                        <a href="{{ route('inventories.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-cubes"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.Inventory')
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                        <a href="{{ route('productions.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-industry"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.Production')
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                        <a href="{{ route('fixed-assets.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-key"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.FixedAssets')
                                            </span>
                                        </a>
                                    </li>
                                @endif

                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('documents.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-file-o"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.Documents')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="{{ route('CurrencyRate.index') }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-file-o"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.Rate')
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="m-menu__item @if (\Request::is('*/accounting/*')) m-menu__item--active @endif m-menu__item--submenu m-menu__item--rel" data-menu-submenu-toggle="click" aria-haspopup="true">
            <a  href="#" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon la la-calculator"></i>
                <span class="m-menu__link-text">
                    @lang('accounting.Accounting')
                </span>
                <i class="m-menu__hor-arrow la la-angle-down"></i>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:700px">
                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                <div class="m-menu__subnav">
                    <ul class="m-menu__content">
                        <li class="m-menu__item">
                            <h3 class="m-menu__heading m-menu__toggle">
                                <span class="m-menu__link-text">
                                    @lang('accounting.Accounting')
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </h3>
                            <ul class="m-menu__inner">
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="{{ route('journals.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-book"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.Journal')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-paste"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.JournalTemplate')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-gamepad"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.JournalSimulation')
                                        </span>
                                    </a>
                                </li>

                                <h3 class="m-menu__heading m-menu__toggle">
                                    <span class="m-menu__link-text">
                                        @lang('general.Configuration')
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </h3>

                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="{{ route('charts.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-sitemap"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.ChartofAccounts')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="{{ route('cycles.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-calendar"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.AccountingCycle')
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="m-menu__item">
                            <h3 class="m-menu__heading m-menu__toggle">
                                <span class="m-menu__link-text">
                                    @lang('global.Reports')
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </h3>
                            <ul class="m-menu__inner">
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-graphic-1"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.SubLedger')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-graphic-1"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.Ledger')
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
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="m-menu__item @if (\Request::is('*/reports/')) m-menu__item--active @endif"  data-redirect="true" aria-haspopup="true">
            <a href="{{ route('reports.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                <i class="m-menu__link-icon la la-pie-chart"></i>
                <span class="m-menu__link-text">
                    @lang('global.Reports')
                </span>
            </a>
        </li>
    </ul>
</div>
