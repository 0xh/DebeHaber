
<button class="m-aside-header-menu-mobile-close m-aside-header-menu-mobile-close--skin-dark" id="m_aside_header_menu_mobile_close_btn">
    <i class="la la-close"></i>
</button>

<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark">
    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
        <li class="m-menu__item @if (\Request::is('*/commercial/*')) m-menu__item--active @endif m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" aria-haspopup="true">
            <a href="#" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>

                @php
                $isCompany = request()->route('taxPayer')->setting->is_company;
                $icon = $isCompany ? 'briefcase' : 'user';
                $color = $isCompany ? 'success' : 'info';
                @endphp

                <i class="m-menu__link-icon la la-{{ $icon }} m--font-{{ $color }}"></i>
                <span class="m-menu__link-text menu-name m--font-{{ $color }}">
                    {{ request()->route('taxPayer')->alias }}
                </span>

                <i class="m-menu__hor-arrow m--font-{{ $color }} la la-angle-down"></i>
                <i class="m-menu__ver-arrow m--font-{{ $color }} la la-angle-right"></i>
            </a>

            @php
            $startDate = new Carbon\Carbon('first day of last month');
            $endDate = new Carbon\Carbon('last day of last month');
            @endphp

            <div class="m-menu__submenu m-menu__submenu--fixed m-menu__submenu--left"  style="width:900px" >
                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                <div class="m-menu__subnav">
                    <ul class="m-menu__content">
                        <li class="m-menu__item">
                            <p class="lead m-menu__heading m-menu__toggle">
                                <span class="m-menu__link-text">
                                    @lang('commercial.Incomes')
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </p>
                            <ul class="m-menu__inner">
                                @if ($isCompany)
                                    <li class="m-menu__item">
                                        <a href="{{ route('sales.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-paper-plane"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.SalesBook')
                                            </span>
                                        </a>
                                    </li>
                                    @if (request()->route('taxPayer')->setting->does_export)
                                        <li class="m-menu__item">
                                            <a href="{{ route('impex-exports.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                                <i class="m-menu__link-icon la la-ship"></i>
                                                <span class="m-menu__link-text">
                                                    @lang('commercial.Exports')
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    <li class="m-menu__item">
                                        <a href="{{ route('account-receivables.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-money"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.AccountsReceivable')
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item">
                                        <a href="{{ route('credit-notes.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-mail-reply"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.CreditNotes')
                                            </span>
                                        </a>
                                    </li>
                                @else
                                    <li class="m-menu__item">
                                        <a href="{{ route('sales.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-paper-plane"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.Income')
                                            </span>
                                        </a>
                                    </li>
                                @endif

                                <p class="lead m-menu__heading m-menu__toggle">
                                    <span class="m-menu__link-text">
                                        @lang('global.Reports')
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </p>

                                <li class="m-menu__item">
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
                            <p class="lead m-menu__heading m-menu__toggle">
                                <span class="m-menu__link-text">
                                    @lang('commercial.Expenses')
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </p>
                            <ul class="m-menu__inner">
                                @if ($isCompany)
                                    <li class="m-menu__item">
                                        <a href="{{ route('purchases.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-shopping-cart"></i>

                                            <span class="m-menu__link-text">
                                                @lang('commercial.PurchaseBook')
                                            </span>
                                        </a>
                                    </li>

                                    @if (request()->route('taxPayer')->setting->does_import)
                                        <li class="m-menu__item">
                                            <a href="{{ route('impex-imports.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                                <i class="m-menu__link-icon la la-ship"></i>
                                                <span class="m-menu__link-text">
                                                    @lang('commercial.Imports')
                                                </span>
                                            </a>
                                        </li>
                                    @endif

                                    <li class="m-menu__item">
                                        <a href="{{ route('account-payables.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-money"></i>

                                            <span class="m-menu__link-text">
                                                @lang('commercial.AccountsPayable')
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item">
                                        <a href="{{ route('debit-notes.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-mail-forward"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.DebitNotes')
                                            </span>
                                        </a>
                                    </li>
                                @else
                                    <li class="m-menu__item">
                                        <a href="{{ route('purchases.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-shopping-cart"></i>

                                            <span class="m-menu__link-text">
                                                @lang('commercial.Expense')
                                            </span>
                                        </a>
                                    </li>
                                @endif

                                <p class="lead m-menu__heading m-menu__toggle">
                                    <span class="m-menu__link-text">
                                        @lang('global.Reports')
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </p>

                                <li class="m-menu__item">
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
                            <p class="lead m-menu__heading m-menu__toggle">
                                <span class="m-menu__link-text">
                                    @lang('commercial.General')
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </p>
                            <ul class="m-menu__inner">
                                <li class="m-menu__item">
                                    <a href="{{ route('taxpayer.show', [request()->route('taxPayer')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-gear"></i>
                                        <span class="m-menu__link-text">
                                            @lang('global.ProfileAndSettings')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item">
                                    <a href="{{ route('money_movements.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-money"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.MoneyMovements')
                                        </span>
                                    </a>
                                </li>

                                @if (request()->route('taxPayer')->setting->show_inventory)
                                    <li class="m-menu__item">
                                        <a href="{{ route('inventories.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-cubes"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.Inventory')
                                            </span>
                                        </a>
                                    </li>
                                @endif

                                @if (request()->route('taxPayer')->setting->show_production)
                                    <li class="m-menu__item">
                                        <a href="{{ route('productions.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-industry"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.Productions')
                                            </span>
                                        </a>
                                    </li>
                                @endif

                                @if (request()->route('taxPayer')->setting->show_fixedasset)
                                    <li class="m-menu__item">
                                        <a href="{{ route('fixed-assets.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon la la-key"></i>
                                            <span class="m-menu__link-text">
                                                @lang('commercial.FixedAssets')
                                            </span>
                                        </a>
                                    </li>
                                @endif

                                <li class="m-menu__item">
                                    <a href="{{ route('documents.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-file-o"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.Document')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item">
                                    <a href="{{ route('CurrencyRate.index',[request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-globe"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.ExchangeRates')
                                        </span>
                                    </a>
                                </li>

                                <li class="m-menu__item">
                                    <a href="{{ route('home') }}" class="m-menu__link">
                                        <i class="m-menu__link-icon la la-refresh m--font-danger"></i>
                                        <span class="m-menu__link-text m--font-danger">
                                            @lang('commercial.Change Taxpayer')
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="m-menu__item @if (\Request::is('*/accounting/*')) m-menu__item--active @endif m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" aria-haspopup="true">
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
                            <p class="lead m-menu__heading m-menu__toggle">
                                <span class="m-menu__link-text">
                                    @lang('global.Transactions')
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </p>
                            <ul class="m-menu__inner">
                                <li class="m-menu__item">
                                    <a  href="{{ route('journals.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-book"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.Journal')
                                        </span>
                                    </a>
                                </li>

                                <p class="lead m-menu__heading m-menu__toggle">
                                    <span class="m-menu__link-text">
                                        @lang('global.Configuration')
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </p>

                                <li class="m-menu__item">
                                    <a  href="{{ route('charts.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-sitemap"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.ChartofAccounts')
                                        </span>
                                    </a>
                                </li>

                                <li class="m-menu__item">
                                    <a  href="{{ route('cycles.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-calendar"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.AccountingCycle')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item">
                                    <a href="{{ route('budget.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-map"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.AnnualBudget')
                                        </span>
                                    </a>
                                </li>

                                <p class="lead m-menu__heading m-menu__toggle">
                                    <span class="m-menu__link-text">
                                        @lang('global.Reports')
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </p>
                                <li class="m-menu__item">
                                    <a href="{{ route('reports.subLedger', [request()->route('taxPayer'), request()->route('cycle'), $startDate, $endDate]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-graphic-1"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.SubLedger')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item">
                                    <a href="{{ route('reports.ledger', [request()->route('taxPayer'), request()->route('cycle'), $startDate, $endDate]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-graphic-1"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.Ledger')
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="m-menu__item">
                            <p class="lead m-menu__heading m-menu__toggle">
                                <span class="m-menu__link-text">
                                    @lang('accounting.Accounting')
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </p>
                            <ul class="m-menu__inner">
                                <li class="m-menu__item">
                                    <a href="{{ route('opening-balance.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-flag-o"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.OpeningBalance')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item">
                                    <a href="{{ route('balance-sheet.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-balance-scale"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.BalanceSheet')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item">
                                    <a href="{{ route('income-statement.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-leaf"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.IncomeStatement')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item">
                                    <a href="{{ route('cash-flows.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-line-chart"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.StatementCashFlows')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item">
                                    <a href="{{ route('retained-earnings.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-key"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.StatementRetainedEarnings')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item">
                                    <a href="{{ route('closing-balance.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-flag-checkered"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.ClosingBalance')
                                        </span>
                                    </a>
                                </li>

                                <p class="lead m-menu__heading m-menu__toggle">
                                    <span class="m-menu__link-text">
                                        @lang('global.Reports')
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </p>
                                <ul class="m-menu__inner">
                                    <li class="m-menu__item">
                                        <a  href="{{ route('reports.balanceSheet', [request()->route('taxPayer'), request()->route('cycle'), $startDate, $endDate]) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-graphic-1"></i>
                                            <span class="m-menu__link-text">
                                                @lang('accounting.BalanceSheet')
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item">
                                        <a class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-graphic-1"></i>
                                            <span class="m-menu__link-text">
                                                @lang('accounting.IncomeStatement')
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="m-menu__item @if (\Request::is('*/reports/')) m-menu__item--active @endif">
            <a href="{{ route('reports.index', [request()->route('taxPayer'), request()->route('cycle')]) }}" class="m-menu__link ">
                <i class="m-menu__link-icon la la-pie-chart"></i>
                <span class="m-menu__link-text">
                    @lang('global.Reports')
                </span>
            </a>
        </li>
    </ul>
</div>
