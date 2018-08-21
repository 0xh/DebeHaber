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

                                <p class="lead"> @lang('commercial.Sales') </p>

                                <div class="m-widget4">
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/sales.svg" width="24" height="24" alt>
                                            <span class="m-widget4__text">

                                                <a target="_blank" :href="'reports/sales/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.SalesBook')
                                                </a>
                                                <small> <i>Download your files</i> </small>
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
                                                </a> <small> <i>Download your files</i> </small>
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
                                                </a><small> <i>Download your files</i> </small>
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
                                                </a><small> <i>Download your files</i> </small>
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
                                                </a><small> <i>Download your files</i> </small>
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

                                <p class="lead"> @lang('commercial.Purchases') </p>

                                <div class="m-widget4">
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/purchase.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/purchases/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('commercial.PurchaseBook')
                                                </a><small> <i>Download your files</i> </small>
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
                                                </a><small> <i>Download your files</i> </small>
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
                                                </a><small> <i>Download your files</i> </small>
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
                                                </a><small> <i>Download your files</i> </small>
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
                                                </a><small> <i>Download your files</i> </small>
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
                                                </a><small> <i>Download your files</i> </small>
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

                                <p class="lead"> <img src="/img/flags/{{ request()->route('taxPayer')->country }}.png" width="32" alt="{{ request()->route('taxPayer')->country }}">
                                    Paraguay
                                </p>

                                <div class="m-widget4">
                                    @if (request()->route('taxPayer')->setting->is_company)
                                        <div class="m-widget4__item">
                                            <div class="m-widget4__info">
                                                <img src="/img/icons/generate.svg" width="24" height="24" alt="">
                                                <span class="m-widget4__text">
                                                    <a :href="'reports/hechauka/generate_files/'+dateRange[0]+'/'+dateRange[1]">Hechauka</a> <small> <i>Download your files</i> </small>
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
                                                    <a href="#">Aranduka</a> <small> <i>Download your files</i> </small>
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
                                <p class="lead"> @lang('accounting.Journal') </p>

                                <div class="m-widget4">

                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/journals.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/sub_ledger/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.SubLedger')
                                                </a><small> <i>Download your files</i> </small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/sub_ledger/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
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
                                                </a><small> <i>Download your files</i> </small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/ledger/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
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
                                                </a><small> <i>Download your files</i> </small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/ledger-byMonth/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
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
                                                </a><small> <i>Download your files</i> </small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/ledger-byMoneyAccounts/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
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
                                                </a><small> <i>Download your files</i> </small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/ledger-byReceivables/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
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
                                                </a><small> <i>Download your files</i> </small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/ledger-byPayables/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
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
                                                </a><small> <i>Download your files</i> </small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/ledger-byExpenses/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
                                                <i class="la la-file-excel-o m--font-success"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-6">
                                <p class="lead"> @lang('accounting.BalanceSheet') </p>

                                <div class="m-widget4">
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/balance.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/balance-sheet/' + this.$parent.cycles[0].start_date +'/'+ this.$parent.cycles[0].end_date">
                                                    @lang('accounting.BalanceSheet')
                                                </a><small> <i>Download your files</i> </small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/balance-sheet/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
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
                                                </a><small> <i>Download your files</i> </small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/balance-sheetComparative/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
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
                                                </a><small> <i>Download your files</i> </small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/balance-sheetComparativeYearly/'+dateRange[0]+'/'+dateRange[1] +'/e'" class="m-widget4__icon">
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
                                <p class="lead"> @lang('global.General') </p>

                                <div class="m-widget4">
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__info">
                                            <img src="/img/icons/chart-of-accounts.svg" width="24" height="24" alt="">

                                            <span class="m-widget4__text">
                                                <a target="_blank" :href="'reports/chart-ofAccounts/'+dateRange[0]+'/'+dateRange[1]">
                                                    @lang('accounting.ChartofAccounts')
                                                </a><small> <i>Download your files</i> </small>
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a :href="'reports/chart-ofAccounts/'+dateRange[0]+'/'+dateRange[1]+'/p'" class="m-widget4__icon">
                                                <i class="la la-file-pdf-o m--font-danger"></i>
                                            </a>
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
                    </div>
                    <div class="tab-pane" id="audit" role="tabpanel">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
                    </div>
                </div>
            </div>
        </div>
    </reports>
@endsection
