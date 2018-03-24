
@extends('layouts.website')

@section('content')


    <!-- < PRICING > ..........
    .............................................. -->
    <section class="section pricing">

        <div class="container">

            <div class="row">
                <div class="col-sm-4">
                    <h4>Planes y precios <span class="bold block">accesibles</span></h4>
                    <p>Porque cada empresa es diferente, tenemos diferentes planes que se adaptan a sus necesidades.</p>

                    <hr class="my-5">
                    <p class="handwritten font-md">Necesita algo más?</p>
                    <p>Si esta buscando una funcionalidad más específica, puede escribirnos y con gusto responderemos.</p>
                    <button class="btn btn-outline-4 btn-rounded p-3 ml-0">Escríbenos</button>
                </div>

                <div class="col-sm-4">
                    <div class="pricing-plan">
                        <!-- <i class="icon fa-user"></i> -->
                        <center><h2>Plan <span class="bold">Básico</span></h2></center>
                        <h2><center><span class="bold">Gratis</span></center></h2>
                        <center><p>Para contadores independientes</p></center>

                        <div class="pricing-details text-center">
                            <span class="pricing-value">
                                <span class="price">Gs. 0</span>
                            </span>

                            <div class="slider-price">


                                <input type="text"
                                data-toggle="slider"
                                data-slider-min="1"
                                data-slider-max="2"
                                data-slider-step="1"
                                data-slider-value="0"
                                data-slider-tooltip="hide"/>
                            </div>

                            <ul class="list list-unstyled list-features">
                                <li>Hasta 1 Empresa.</li>
                                <li>Hasta 1 Usuario.</li>
                                <li>Libros de Compras y Ventas</li>
                                <li>Libro Mayor</li>
                                <li>Balance</li>
                                <li class="strike">Importación</li>
                                <li class="strike">Producción</li>
                            </ul>

                            <a href="#" class="btn btn-rounded btn-outline-3 py-3 px-5">Registrar Cuenta</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="pricing-plan best-value">
                        <!-- <i class="icon fa-building accent"></i> -->
                        <h2 class="accent">Plan <span class="bold">Premium</span></h2>
                        <p class="bold italic bg-3 color-1">Para Estudios Contables</p>

                        <div class="pricing-details text-center">
                            <span class="pricing-value">
                                <span class="price">5</span>
                            </span>

                            <div class="slider-price">
                                <p class="small"><span class="bold value"></span> Cantidad de usuarios</p>

                                <input type="text"
                                data-toggle="slider"
                                data-slider-min="1"
                                data-slider-max="100"
                                data-slider-step="1"
                                data-slider-value="1"
                                data-slider-tooltip="hide"/>
                            </div>

                            <ul class="list list-unstyled list-features">
                                <li>Hasta 5 Empresas.</li>
                                <li>Hasta 10 Usuarios.</li>
                                <li>Libros de Compras y Ventas</li>
                                <li>Libro Mayor</li>
                                <li>Balance</li>
                                <li>Importación</li>
                                <li>Producción</li>
                            </ul>

                            <a href="#" class="btn btn-rounded btn-accent py-3 px-5">Registrar Cuenta</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- < PRICING > ..........
    .............................................. -->
    <section class="pricing">
        <div class="container">
            <div class="section-heading text-center">
                <h2>Regístrese y utilice DebeHaber Gratis!!</h2>
            </div>

            <div class="border">
                <div class="row py-5">
                    <div class="col-sm-5 m-auto">
                        <h4>Beneficios del DebeHaber</h4>

                        <ul class="list list-unstyled list-features">
                            <li><i class="font-regular icon lnr-magic-wand"></i>Comparta los datos con su Contador.</li>
                            <li><i class="font-regular icon lnr-database"></i>Contabilidad Automatizada.</li>
                            <li><i class="font-regular icon lnr-heart"></i>Acceda a sus datos desde cualquier dispositivo.</li>
                            <li><i class="font-regular icon lnr-layers"></i>Fácil e intuitivo</li>
                            <li><i class="font-regular icon lnr-history"></i>Seguridad.</li>
                        </ul>
                    </div>

                    <div class="col-sm-5 m-auto text-center">
                        <h4>Empiece a utilizar DebeHaber Gratis.</h4>

                        <p class="">
                            <span class="price font-xl">0 Gs.</span>
                        </p>

                        <!-- <a class="btn btn-lg btn-success">Get started NOW</a> -->
                        <a href="#" class="btn btn-rounded btn-accent py-3 px-5">Regístrese Ahora!</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
