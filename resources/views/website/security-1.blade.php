
@extends('layouts.website')

@section('content')

    <section class="section features reasons bg-6 alpha-6">
        <div class="container">
            <div class="section-heading text-center">
                <h1 class="title is-1">Su Contabilidad esta Seguro</h1>
                <br>
                <p class="lead">
                    DebeHaber es un software contable que utiliza algunas de las politicas de seguridad usadas en los estandares mas seguros del mundo.
                    Con DebeHaber, su contabilidad no solo esta disponible desde cualquier lugar pero tambien asegurado. Todo se controla desde la forma que enviamos, almacenamos, analizamos sus datos contables.
                </p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container-wide">
            <div class="row align-items-center text-center text-lg-left">
                <div class="col-10 col-lg-4 mx-auto order-md-2">
                    <h2 class="title is-2">Sus Datos Asegurados</h2>

                    <p class="lead">DebeHaber se almacena en los mismos data centers que su cuenta de <i>gmail</i>.</p>
                    <p>
                        Todos los datos de sus compras, ventas, y asientos contables se almacenan en los data centers de Google.
                        La misma esta certificada para la ISO 27001, ISO 27017, y la MTCS Tier 3 que son certificaciones de seguridad por entidades independientes como Union Europea y la IMDA de Singapore.
                        Adicionalmente, tomamos copias de seguridad diariamente, por la eventualidad que los servidores de Google se colapsen.
                    </p>

                    <a href="https://cloud.google.com/security/compliance"  target="_blank" class="btn btn-rounded">Leer más</a>
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
                    <h2 class="title is-2">Transacciones via OAuth 2</h2>
                    <p class="lead">OAuth2 es un estandard internacional de integración utilizado por Amazon, Bancos, Google, PayPal, y muchos otros.</p>

                    <p>
                        OAuth es un protocolo que permite la autenticación segura de un servicio (como API),
                        porque no divulga los datos importantes como tarjeta de créditos o contraseñas. Permitiendo trabajar sin la necesidad de almacenar información importantes.
                    </p>
                    <p>
                        DebeHaber utiliza OAuth2 tanto para la parte de integración con otros sistemas de gestión y
                        tambien para la parte de cobros para los servicios contables.
                    </p>
                    <a href="https://aplicacionesysistemas.com/que-es-oauth/"  target="_blank" class="btn btn-rounded">Leer más</a>
                </div>

                <div class="col-12 col-lg-6 pr-0">
                    <img src="assets/front-end/img/OAuth.png" alt="Autenticación OAuth" class="img-responsive shadow" data-aos="fade-left">
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container-wide">
            <div class="row align-items-center text-center text-lg-left">
                <div class="col-10 col-lg-4 mx-auto order-md-2">
                    <h2 class="title is-2">Comunicación Cifrada con SSL</h2>

                    <p class="lead">
                        SSL permite una comunicación encriptada entre su navegador y el sistema contable DebeHaber.
                    </p>

                    <p>
                        Cualquier dato que usted escribe para su libro de venta, compras, o asientos contables
                        se encrypta antes de enviar a los servidores de DebeHaber. Implementando SSL ayuda prevenir ataques MitM (Man in the Middle)
                        que sucede cuando alguien puede interceptar los datos antes que llegue a los servidores.
                    </p>

                    <a href="https://www.globalsign.com/es/centro-de-informacion-ssl/que-es-ssl/"  target="_blank" class="btn btn-rounded">Leer más</a>
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
                    <h2 class="title is-2">Seguridad contra CSRF</h2>

                    <p class="lead">
                        CSRF es un tipo de ataque que falsifica los datos.
                    </p>

                    <p>
                        En palabras sencillas, el ataque CSRF sucede cuando un hacker mal usa el código enviado por el servidor para que la victima envie datos erroneos o a otro lugar sin saberlo.

                        {{-- Todas los intercambio de datos que realiza el usuario con el servidor utilizan un token de seguridad,
                        que valida que la información que recibida coincida con el mismo
                        token de seguridad que el servidor ha generado para dicha solicitud. --}}
                    </p>
                    <p>
                        Muchos sistemas no tienen implementado este tipo de seguridad. Pero en el mundo real esto tipos de ataques son serios,
                        y por lo tanto DebeHaber y cada formulario del sistema, desde la ventana de login hasta la carga de los asientos contiene códigos de seguridad que previenen
                        este tipo de ataque.
                    </p>

                    <a href="https://es.wikipedia.org/wiki/Cross-site_request_forgery"  target="_blank" class="btn btn-rounded">Leer más acerca de CSRF</a>
                </div>

                <div class="col-12 col-lg-6 pr-0">
                    <img src="assets/front-end/img/screens/dash-2.jpg" alt="" class="img-responsive shadow" data-aos="fade-left">
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container-wide">
            <div class="row align-items-center text-center text-lg-left">
                <div class="col-10 col-lg-4 mx-auto order-md-2">
                    <h2 class="title is-2">Seguridad contra SQL Injection</h2>

                    <p>
                        Uno de los ataques mas comunes en apliciones o sitios web es la injección SQL.
                        Nuestra aplicacion toma las medidas de seguridad necesarias para evitar este tipo de ataques.</p>

                        <a href="https://aplicacionesysistemas.com/que-es-oauth/"  target="_blank" class="btn btn-rounded">Leer más</a>
                    </div>

                    <div class="col-12 col-lg-6 pl-0 order-md-1">
                        <img src="assets/front-end/img/secure-ssl.png" alt="" class="img-responsive shadow" data-aos="fade-right">
                    </div>
                </div>
            </div>
        </section>
    @endsection
