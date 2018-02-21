<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
        <li class="m-menu__item  m-menu__item--active  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="click" aria-haspopup="true">
            <a  href="#" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon la la-briefcase"></i>
                <span class="m-menu__link-text">
                    {{ request()->route('taxPayer') }}
                </span>
                <i class="m-menu__hor-arrow la la-angle-down"></i>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu m-menu__submenu--fixed-xl m-menu__submenu--center" >
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
                                    <a  href="{{ route('sales.index', [request()->route('taxPayer'),request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-paper-plane"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.SalesBook')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-money"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.AccountsRecievable')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-mail-reply"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.CreditNote')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-ship"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.Exports')
                                        </span>
                                    </a>
                                </li>

                                <h3 class="m-menu__heading m-menu__toggle">
                                    <span class="m-menu__link-text">
                                        @lang('global.Reports')
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </h3>

                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-graphic-1"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.SalesVAT')
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
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-shopping-cart"></i>

                                        <span class="m-menu__link-text">
                                            @lang('commercial.PurchaseBook')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-money"></i>

                                        <span class="m-menu__link-text">
                                            @lang('commercial.AccountsPayable')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-mail-reply"></i>

                                        <span class="m-menu__link-text">
                                            @lang('commercial.DebitNote')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-ship"></i>

                                        <span class="m-menu__link-text">
                                            @lang('commercial.Imports')
                                        </span>
                                    </a>
                                </li>

                                <h3 class="m-menu__heading m-menu__toggle">
                                    <span class="m-menu__link-text">
                                        @lang('global.Reports')
                                    </span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </h3>

                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon flaticon-graphic-1"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.PurchaseVAT')
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
                                    <a href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-cubes"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.Inventory')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item " data-redirect="true" aria-haspopup="true">
                                    <a href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-money"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.MoneyTransfers')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-industry"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.Production')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-key"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.FixedAssets')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-file-o"></i>
                                        <span class="m-menu__link-text">
                                            @lang('commercial.Documents')
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" data-menu-submenu-toggle="click" data-redirect="true" aria-haspopup="true">
            <a  href="#" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon la la-calculator"></i>
                <span class="m-menu__link-text">
                    @lang('accounting.Accounting')
                </span>
                <i class="m-menu__hor-arrow la la-angle-down"></i>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:600px">
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
                                    <a  href="inner.html" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-list"></i>
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

                                <hr style="border: 1px whitesmoke dashed">

                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="{{ route('charts.index', [request()->route('taxPayer'),request()->route('cycle')]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-icon la la-sitemap"></i>
                                        <span class="m-menu__link-text">
                                            @lang('accounting.ChartofAccounts')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="{{ route('cycles.index', request()->route('taxPayer')) }}" class="m-menu__link ">
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
                                    <a  href="inner.html" class="m-menu__link ">
                                        {{-- <i class="m-menu__link-icon flaticon-graphic-1"></i> --}}
                                        <span class="m-menu__link-text">
                                            @lang('accounting.JournalEntires')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        {{-- <i class="m-menu__link-icon flaticon-graphic-1"></i> --}}
                                        <span class="m-menu__link-text">
                                            @lang('accounting.GroupJournalEntries')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        {{-- <i class="m-menu__link-icon flaticon-graphic-1"></i> --}}
                                        <span class="m-menu__link-text">
                                            @lang('accounting.BalanceSheet')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        {{-- <i class="m-menu__link-icon flaticon-graphic-1"></i> --}}
                                        <span class="m-menu__link-text">
                                            @lang('accounting.BalanceSheet(Comparative)')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        {{-- <i class="m-menu__link-icon flaticon-graphic-1"></i> --}}
                                        <span class="m-menu__link-text">
                                            @lang('accounting.IncomeStatement')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        {{-- <i class="m-menu__link-icon flaticon-graphic-1"></i> --}}
                                        <span class="m-menu__link-text">
                                            @lang('accounting.StatementofCashflows')
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item "  data-redirect="true" aria-haspopup="true">
                                    <a  href="inner.html" class="m-menu__link ">
                                        {{-- <i class="m-menu__link-icon flaticon-graphic-1"></i> --}}
                                        <span class="m-menu__link-text">
                                            @lang('accounting.StatementofRetainedEarnings')
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="m-menu__item  m-menu__item--submenu">
            <a  href="#" class="m-menu__link m-menu__toggle">
                {{-- <span class="m-menu__item-here"></span> --}}
                <i class="m-menu__link-icon la la-line-chart"></i>
                <span class="m-menu__link-text">
                    @lang('global.Reports')
                </span>
            </a>
        </li>
    </ul>
</div>
