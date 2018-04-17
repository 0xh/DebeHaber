@extends('spark::layouts.dashboard')

@section('title', __('global.Reports'))

@section('nav')

@endsection

@section('content')
    <reports inline-template>
        <div class="m-portlet m-portlet--tabs">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            @lang('global.DateRange')
                            <el-date-picker v-model="dateRange"
                            type="daterange"
                            align="right"
                            unlink-panels
                            range-separator="|"
                            start-placeholder="@lang('global.StartDate')"
                            end-placeholder="@lang('global.EndDate')"
                            format = "dd/MM/yyyy"
                            value-format = "yyyy-MM-dd"
                            :picker-options="pickerOptions2"></el-date-picker>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--right m-tabs-line--brand" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#commercial" role="tab" aria-selected="false">
                                <i class="la la-briefcase"></i>
                                @lang('global.Commercial')
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#accounting" role="tab" aria-selected="false">
                                <i class="la la-calculator"></i>
                                @lang('accounting.Accounting')
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#audit" role="tab" aria-selected="true">
                                <i class="la la-search"></i>
                                @lang('global.Audits')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" id="commercial" role="tabpanel">
                        <div class="row">
                            <div class="col-6">
                                <h3> @lang('commercial.Sales') </h3>
                                <p class="lead"> Basic reports giving you information regarding your sales. </p>

                                <div class="m-widget4">
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/sales.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sales/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.SalesBook')
                                                </a>
                                                <br>
                                                <small>Basic list of sales invoices</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/sales.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sales-byVATs/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.SalesByVAT')
                                                </a>
                                                <br>
                                                <small>List of invoices grouped by sales tax</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/sales.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sales-byCustomers/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.SalesByCustomer')
                                                </a>
                                                <br>
                                                <small>List of invoices grouped by customers</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
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
                                                <a target="_blank" :href="'reports/sales-vat/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.CreditNotes')
                                                </a>
                                                <br>
                                                <small>List of credit returns made</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
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
                                                <a target="_blank" :href="'reports/sales-vat/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.AccountsReceivable')
                                                </a>
                                                <br>
                                                <small>List of accounts receivables</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/sales.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" href="#">@lang('commercial.VATDebit')</a>
                                                <br>
                                                <small>List of VAT Debit (sales invoice plus debit notes)</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
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
                                            <img src="/img/icons/purchase.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.PurchaseBook')
                                                </a>
                                                <br>
                                                <small>Simple list of purchase invoices</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/purchase.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases-byVAT/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.PurchaseByVAT')
                                                </a>
                                                <br>
                                                <small>List of purchase invoices grouped by sales tax</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/purchase.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases-bySupplier/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.PurchaseBySuppliers')
                                                </a>
                                                <br>
                                                <small>List of purchase invoices grouped by suppliers</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/purchase.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases-byChart/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.PurchaseByChart')
                                                </a>
                                                <br>
                                                <small>List of purchase invoices grouped by suppliers</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
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
                                                <a href="#">@lang('commercial.DebitNotes')</a>
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
                                            <img src="/img/icons/purchase.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a href="#">@lang('commercial.SalesVAT')</a>
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

                        <div v-if="{{ request()->route('taxPayer')->country }} == PRY" class="row">
                            <div class="col-6">
                                <h3> Paraguay </h3>
                                <p class="lead"> Special reports from your country </p>

                                <div class="m-widget4">
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/cloud.jpg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a :href="'reports/hechauka/generate_files/'+dateRange[0]+'/'+dateRange[1]">Hechauka</a>
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
                                            <img src="/img/icons/cloud.jpg" alt="">
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

                    {{-- Accounting Reports --}}
                    <div class="tab-pane" id="accounting" role="tabpanel">
                        <div class="row">
                            <div class="col-6">
                                <h3> @lang('accounting.Journal') </h3>
                                <p class="lead">  </p>

                                <div class="m-widget4">
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/journals.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sales/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.SubLedger')
                                                </a>
                                                <br>
                                                {{-- <small>List of Journal Related Reports</small> --}}
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/journals.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sales-byVATs/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.Ledger')
                                                </a>
                                                <br>
                                                {{-- <small>List of invoices grouped by sales tax</small> --}}
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/report.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sales-byCustomers/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.LedgerOf', ['attribute' => __('commercial.SalesTax')])
                                                </a>
                                                <br>
                                                <small></small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/report.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sales-byCustomers/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.LedgerOf', ['attribute' => __('enum.BankAccount')])
                                                </a>
                                                <br>
                                                <small></small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/report.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sales-byCustomers/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.LedgerOf', ['attribute' => __('commercial.AccountsReceivable')])
                                                </a>
                                                <br>
                                                <small></small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/report.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sales-byCustomers/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.LedgerOf', ['attribute' => __('commercial.AccountsPayable')])
                                                </a>
                                                <br>
                                                <small></small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <h3> @lang('accounting.BalanceSheet') </h3>
                                {{-- <p class="lead"> Basic reports giving you information regarding your purchases. </p> --}}

                                <div class="m-widget4">
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/balance.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.BalanceSheet')
                                                </a>
                                                <br>
                                                {{-- <small>Simple list of purchase invoices</small> --}}
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/balance.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.BalanceSheetCompBy', ['attribute' => __('global.Month')])
                                                </a>
                                                <br>
                                                {{-- <small>Simple list of purchase invoices</small> --}}
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/balance.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.BalanceSheetCompBy', ['attribute' => __('global.Year')])
                                                </a>
                                                <br>
                                                {{-- <small>Simple list of purchase invoices</small> --}}
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
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
                                <h3> @lang('general.General') </h3>
                                <p class="lead"></p>

                                <div class="m-widget4">
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--icon">
                                            <img src="/img/icons/chart-of-accounts.svg" alt="">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/chart-ofAccounts/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.ChartofAccounts')
                                                </a>
                                                <br>
                                                <small>List of Journal Related Reports</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" href="#" class="m-widget4__icon">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="audit" role="tabpanel">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
                    </div>
                </div>
            </div>
        </div>
    </reports>
@endsection
