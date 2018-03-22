
@extends('spark::layouts.app')

@section('title', 'Informes | DebeHaber')

@section('pageTitle', 'Informes')

@section('pageDescription', 'Aqui podra generar todo los informes acorde las exigencias de la sub-secretaria de tributación.')

@section('head_visible', none)

@section('content')
    <reports inline-template>
        <div>
            <div class="form-group m-form__group row">
                <div class="block" align="center">
                    <el-date-picker
                    v-model="dateRange"
                    type="daterange"
                    align="right"
                    unlink-panels
                    range-separator="To"
                    start-placeholder="Start date"
                    end-placeholder="End date"
                    format = "dd/MM/yyyy"
                    value-format = "yyyy-MM-dd"
                    :picker-options="pickerOptions2">
                </el-date-picker>
            </div>
        </div>

        <br>
        <br>

        <div class="row">
            <div class="col-6">
                <h4><i class="la la-shopping-cart"></i> Libro IVA Compras</h4>
                <a :href="'purchase-vat/'+dateRange[0]+'/'+dateRange[1]">
                    Libro IVA Compras
                </a>
                <br>
                <a :href="'purchase-vat-byCenter/'+dateRange[0]+'/'+dateRange[1]">
                    Libro IVA Compras por Centro de Negocio
                </a>
                <br>
                <a :href="'purchase-vat-bySupplier/'+dateRange[0]+'/'+dateRange[1]">
                    Libro IVA Compras por Proveedor
                </a>
                <br>
                <a :href="'purchase-vat-byBranch/'+dateRange[0]+'/'+dateRange[1]">
                    Libro IVA Compras por Sucursal
                </a>
            </div>
            <div class="col-6">
                <h4><i class="la la-rocket"></i>  Libro IVA Ventas</h4>
                <a :href="'sales-vat/'+dateRange[0]+'/'+dateRange[1]">
                    Libro IVA Ventas
                </a>
                <br>
                <a :href="'sales-vat-byCenter/'+dateRange[0]+'/'+dateRange[1]">
                    Libro IVA Ventas por Centro de Negocio
                </a>
                <br>
                <a :href="'sales-vat-byCustomer/'+dateRange[0]+'/'+dateRange[1]">
                    Libro IVA Ventas por Cliente
                </a>
                <br>
                <a :href="'sales-vat-byBranch/'+dateRange[0]+'/'+dateRange[1]">
                    Libro IVA Ventas por Sucursal
                </a>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-6">
                <h4><i class="la la-book"></i> Libros</h4>

                <a :href="'journal/'+dateRange[0]+'/'+dateRange[1]">
                    Libro Diario
                </a>
                <br>
                <a :href="'journal-ByEntry/'+dateRange[0]+'/'+dateRange[1]">
                    Libro Diario por Asientos
                </a>
                <br>
                <a :href="'journal-ByDate/'+dateRange[0]+'/'+dateRange[1]">
                    Libro Diario por Fecha
                </a>
                <br>

                <a :href="'journal-ByChart/'+dateRange[0]+'/'+dateRange[1]">
                    Libro Mayor
                </a>
            </div>
            <div class="col-6">
                <h4><i class="la la-cloud-download"></i> Hechauka</h4>
                <a id="hechauka_compras" :href="'hechauka/generate_files/'+dateRange[0]+'/'+dateRange[1]">
                    Compras y Ventas
                    <span class="m-badge m-badge--warning m-badge--wide">
                        PRO
                    </span>
                </a>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-6">
                <h4><i class="la la-th-list"></i> Balances</h4>
                <a :href="'balance-sheet/'+dateRange[0]+'/'+dateRange[1]">
                    Balance General
                </a>
                <br>
                <a :href="'balance-comparative/'+dateRange[0]+'/'+dateRange[1]">
                    Balance General Comparativo
                </a>
                <br>
                <a :href="'balance-sums-balances/'+dateRange[0]+'/'+dateRange[1]">
                    Balance de Sumas &amp; Saldos
                </a>
            </div>
            <div class="col-6">
                <h4>
                    <i class="la la-suitcase"></i>
                    Financieros
                    <span class="m-badge m-badge--danger m-badge--wide">
                        Version Beta
                    </span>
                </h4>

                <br>

                <a :href="'fx-rates/'+dateRange[0]+'/'+dateRange[1]">
                    Monedas &amp; Cotizaciones
                </a>
            </div>
        </div>
    </div>
</reports>
@endsection
