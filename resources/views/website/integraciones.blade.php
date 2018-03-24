
@extends('layouts.website')

@section('content')

    <section class="section features reasons bg-6 alpha-6">
        <div class="container">
            <div class="section-heading text-center">
                <h1>Integración de otros Sistemas de Gestión con el DebeHaber</h1>
                <br>
                <p class="lead">
                    La integración de sistemas es la posibilidad que posee una aplicación de poder juntar datos de diferentes fuentes
                  permitiendo así al usuario tener un vista unificada de los mismos.
                El Sistema de Contabilidad DebeHaber trabaja con APIS abiertas, es decir cualquier sistema de Gestión puede ser integrada facilmente.</p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container-wide">
            <div class="row align-items-center text-center text-lg-left">
                <div class="col-10 col-lg-4 mx-auto order-md-2">
                    <h2>Reducción de tiempo en la carga de Datos.</h2>

                    <p class="lead">La integración de datos permite agilizar los tiempos de carga.</p>
                    <p>
                        Una de las razones para integrar sus datos es automatizar la carga de datos, es decir usted solo deberá hacer click en un botón y todos los Datos de compras, ventas, etc.
                      serán automáticamente cargados al sistema contable DebeHaber.</p>

                    <a href=""  target="_blank" class="btn btn-rounded">Leer más</a>
                </div>

                <div class="col-12 col-lg-6 pl-0 order-md-1">
                    <img src="assets/front-end/img/secure-ssl.png" alt="" class="img-responsive shadow" data-aos="fade-right">
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container-wide">
            <div class="row align-items-center text-center text-lg-left">
                <div class="col-10 col-lg-4 mx-auto">
                    <h2>Prevención de errores de carga.</h2>
                    <p class="lead">Los datos son cargados por el sistema, evitando el error humano.</p>

                    <p>
                        La integración automática asegura que los datos cargados al sistema sean confiables, evitando de esta manera
                        que el usuario comenta errores de carga.
                    </p>
                    <a href=""  target="_blank" class="btn btn-rounded">Leer más</a>
                </div>

                <div class="col-12 col-lg-6 pr-0">
                    <img src="assets/front-end/img/screens/libro-compras.png" alt="Libro Compras" class="img-responsive shadow" data-aos="fade-left">
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container-wide">
            <div class="row align-items-center text-center text-lg-left">
                <div class="col-10 col-lg-4 mx-auto order-md-2">
                    <h2>Compatibilidad con otros Sistemas de Gestión</h2>

                    <p class="lead">
                        Cualquier sistema de gestión puede ser integrado fácilmente con el DebeHaber.
                    </p>

                    <p>
                      Nuestras APIS están muy bien documentadas de manera a facilitarle al programador la integración con su sistema de gestión.
                      Para saber como funcionan nuestras APIS puede ingrear al link.
                    </p>
                    <a href="apis"  target="_blank" class="btn btn-rounded">APIS DebeHaber</a>

                </div>

                <div class="col-12 col-lg-6 pl-0 order-md-1">
                    <img src="assets/front-end/img/secure-ssl.png" alt="" class="img-responsive shadow" data-aos="fade-right">
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container-wide">
            <div class="row align-items-center text-center text-lg-left">
              <div class="col-10 col-lg-4 mx-auto">
                  <h2>Autenticación OAuth para intercambio de Datos.</h2>

                  <p>OAuth es un protocolo abierto, que permite autorización segura de una API de modo estándar y simple para aplicaciones de escritorio, móviles y web.</p>

                  <p>El DebeHaber utiliza el protocoo OAuth para todas las sincronizaciones de datos contables que el DebeHaber realice con otros sistemas de Gestión, a fin de garantizar la integridad de los datos que son subidos al sistema contable.</p>

                  <a href="https://aplicacionesysistemas.com/que-es-oauth/"  target="_blank" class="btn btn-rounded">Leer más</a>
              </div>

                <div class="col-12 col-lg-6 pr-0">
                    <img src="assets/front-end/img/screens/dash-2.jpg" alt="" class="img-responsive shadow" data-aos="fade-left">
                </div>
            </div>
        </div>
    </section>
    @endsection
