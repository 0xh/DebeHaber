@extends('spark::layouts.dashboard')

@section('title', __('global.Reports'))

@section('nav')

@endsection

@section('content')
    <reports inline-template>
        <div class="m-portlet m-portlet--tabs">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--info m-tabs-line--2x m-tabs-line--right" role="tablist">
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
                        <li class="nav-item m-tabs__item disabled">
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
                    {{-- Commercial Reports --}}
                    <div class="tab-pane active" id="commercial" role="tabpanel">
                        <div class="row">
                            <div class="col-6">
                                <h3> @lang('commercial.Sales') </h3>

                                <p class="lead"> Basic reports giving you information regarding your sales. </p>

                                <div class="m-widget4">
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/sales.svg" width="24" height="24" alt>
                                            <span class="m-widget4__text">

                                                <a target="_blank" :href="'reports/sales/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.SalesBook')
                                                </a>
                                                <br>
                                                <small>Basic list of sales invoices</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/sales/'+dateRange[0]+'/'+dateRange[1]+'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/sales.svg" width="24" height="24" alt="">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sales-byVATs/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.SalesByVAT')
                                                </a>
                                                <br>
                                                <small>List of invoices grouped by sales tax</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/sales-byVATs/'+dateRange[0]+'/'+dateRange[1]+'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/sales.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sales-byCustomers/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.SalesByCustomer')
                                                </a>
                                                <br>
                                                <small>List of invoices grouped by customers</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/sales-byCustomers/'+dateRange[0]+'/'+dateRange[1]+'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/credit-note.svg" width="24" height="24" alt="">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/credit_notes/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.CreditNotes')
                                                </a>
                                                <br>
                                                <small>List of credit returns made</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/credit_notes/'+dateRange[0]+'/'+dateRange[1]+'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/account-receivable.svg" width="24" height="24" alt="">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/account-receivable/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.AccountsReceivable')
                                                </a>
                                                <br>
                                                <small>List of accounts receivables</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/account-receivable/'+dateRange[0]+'/'+dateRange[1]+'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
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
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/purchase.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.PurchaseBook')
                                                </a>
                                                <br>
                                                <small>Simple list of purchase invoices</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/purchases/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/purchase.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases-byVAT/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.PurchaseByVAT')
                                                </a>
                                                <br>
                                                <small>List of purchase invoices grouped by sales tax</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/purchases-byVAT/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/purchase.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases-bySupplier/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.PurchaseBySuppliers')
                                                </a>
                                                <br>
                                                <small>List of purchase invoices grouped by suppliers</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/purchases-bySupplier/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/purchase.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases-byChart/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.PurchaseByChart')
                                                </a>
                                                <br>
                                                <small>List of purchase invoices grouped by suppliers</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/purchases-byChart/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/credit-note.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/debit_notes/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.DebitNotes')
                                                </a>
                                                <br>
                                                <small>List of Debit Notes</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/debit_notes/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/account-payable.svg" width="24" height="24" alt="">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/account-payable/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.AccountsPayable')
                                                </a>
                                                <br>
                                                <small>List of accounts payable to suppliers</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/account-payable/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
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
                                    @if (request()->route('taxPayer')->setting->is_company)
                                        <div class="m-widget4__item">
                                            <div class="m-widget4__info">
                                                <img src="/img/icons/generate.svg" width="24" height="24" alt="">
                                                <span class="m-widget4__text">
                                                    <a :href="'reports/hechauka/generate_files/'+dateRange[0]+'/'+dateRange[1]">
                                                        Hechauka
                                                    </a>
                                                    <br>
                                                    <small>Download your files</small>
                                                </span>
                                            </div>
                                            <div class="m-widget4__ext">
                                                <a :href="'reports/hechauka/generate_files/'+dateRange[0]+'/'+dateRange[1]" class="m-widget4__icon">
                                                    <i class="la la-file-zip-o m--font-warning"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="m-widget4__item">
                                            <div class="m-widget4__info">
                                                <img src="/img/icons/generate.svg" width="24" height="24" alt="">

                                                <span class="m-widget4__text">
                                                    <a href="#">Aranduka</a>
                                                    <br>
                                                    <small>Download your files</small>
                                                </span>
                                            </div>
                                            <div class="m-widget4__ext">
                                                <a href="#" class="m-widget4__icon">
                                                    <i class="la la-file-zip-o m--font-warning"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
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
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/journals.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sub_ledger/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.SubLedger')
                                                </a>
                                                <br>
                                                {{-- <small>List of Journal Related Reports</small> --}}
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" :href="'reports/sub_ledger/'+dateRange[0]+'/'+dateRange[1]" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/journals.svg" width="24" height="24" alt="">
                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/ledger/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.Ledger')
                                                </a>
                                                <br>
                                                {{-- <small>List of invoices grouped by sales tax</small> --}}
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" :href="'reports/ledger/'+dateRange[0]+'/'+dateRange[1]" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/journals.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/ledger-byMonth/'+ this.$parent.cycles[0].start_date +'/'+ this.$parent.cycles[0].end_date">
                                                    @lang('accounting.LedgerOf', ['attribute' => __('global.Month')])
                                                </a>
                                                <br>
                                                <small></small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" :href="'reports/ledger-byMonth/'+dateRange[0]+'/'+dateRange[1]" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/journals.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/ledger-byMoneyAccounts/'+ this.$parent.cycles[0].start_date +'/'+dateRange[1]">
                                                    @lang('accounting.LedgerOf', ['attribute' => __('enum.CashAccount')])
                                                </a>
                                                <br>
                                                <small></small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" :href="'reports/ledger-byMoneyAccounts/'+dateRange[0]+'/'+dateRange[1]" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/journals.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/ledger-byReceivables/'+ this.$parent.cycles[0].start_date +'/'+dateRange[1]">
                                                    @lang('accounting.LedgerOf', ['attribute' => __('commercial.AccountsReceivable')])
                                                </a>
                                                <br>
                                                <small></small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" :href="'reports/ledger-byReceivables/'+dateRange[0]+'/'+dateRange[1]" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/journals.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/ledger-byPayables/'+ this.$parent.cycles[0].start_date +'/'+dateRange[1]">
                                                    @lang('accounting.LedgerOf', ['attribute' => __('commercial.AccountsPayable')])
                                                </a>
                                                <br>
                                                <small></small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" :href="'reports/ledger-byPayables/'+dateRange[0]+'/'+dateRange[1]" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/journals.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/ledger-byExpenses/'+ this.$parent.cycles[0].start_date +'/'+dateRange[1]">
                                                    @lang('accounting.LedgerOf', ['attribute' => __('commercial.Expenses')])
                                                </a>
                                                <br>
                                                <small></small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" :href="'reports/ledger-byExpenses/'+dateRange[0]+'/'+dateRange[1]" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
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
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/balance.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/balance-sheet/' + this.$parent.cycles[0].start_date +'/'+ this.$parent.cycles[0].end_date">
                                                    @lang('accounting.BalanceSheet')
                                                </a>
                                                <br>
                                                {{-- <small>Simple list of purchase invoices</small> --}}
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" :href="'reports/balance-sheet/'+dateRange[0]+'/'+dateRange[1]" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/balance.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/balance-sheetComparative/'+ this.$parent.cycles[0].start_date +'/'+ this.$parent.cycles[0].end_date">
                                                    @lang('accounting.BalanceSheetCompBy', ['attribute' => __('global.Month')])
                                                </a>
                                                <br>
                                                {{-- <small>Simple list of purchase invoices</small> --}}
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" :href="'reports/balance-sheetComparative/'+dateRange[0]+'/'+dateRange[1]" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/balance.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/balance-sheetComparativeYearly/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.BalanceSheetCompBy', ['attribute' => __('global.Year')])
                                                </a>
                                                <br>
                                                {{-- <small>Simple list of purchase invoices</small> --}}
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a target="_blank" :href="'reports/balance-sheetComparativeYearly/'+dateRange[0]+'/'+dateRange[1]" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
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
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/chart-of-accounts.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/chart-ofAccounts/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.ChartofAccounts')
                                                </a>
                                                <br>
                                                <small>List of Journal Related Reports</small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/chart-ofAccounts/'+dateRange[0]+'/'+dateRange[1]+'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
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
