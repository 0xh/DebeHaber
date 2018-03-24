
@extends('layouts.website')

@section('content')

    <section class="section features reasons bg-6 alpha-6">
        <div class="container">
            <div class="section-heading text-center">
                <h1>Sistema Contable para Paraguay</h1>
                <br>
                <p class="lead">
                    DebeHaber es un software contable on-line para Paraguay, nuestro sistema contable se encuentra actualizado con las últimas
                    disposiciones de la SET.
                    Además con el DebeHaber usted puede acceder a sus datos desde cualquier lugar, ya que sus datos permanecen seguros en la nube.</p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container-wide">
            <div class="row align-items-center text-center text-lg-left">
                <div class="col-10 col-lg-4 mx-auto order-md-2">
                    <h2>Reporte de Hechauka</h2>

                    <p class="lead">Con el debehaber usted puede generar su reporte de Hechauka de manera automática.</p>
                    <p>
                        Nuestro sistema contable puede generarle el reporte de Hechauka para que usted pueda subirlo directamente al sistema Marangatú.
                      de esta forma el archivo es generado y descargado en su navegador, usted ahorra tiempo y le facilitamos el trabajo.</p>

                    <a href="http://www.set.gov.py/portal/PARAGUAY-SET/Biblioteca?folder-id=repository:collaboration:/sites/PARAGUAY-SET/categories/SET/biblioteca-virtual/hechauka"  target="_blank" class="btn btn-rounded">Leer más</a>
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
                    <h2>Libro de Ventas y Compras</h2>
                    <p class="lead">Con el debehaber usted puede generar su reporte de Hechauka de manera automática.</p>

                    <p>
                        Con DebeHaber usted puede generar sus reportes de Libro de Ventas y Libro de Compras con un solo clik.
                        Estos reportes pueden llegarle directamente al correo de forma automática.
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
                    <h2>Generación de Asientos Automáticos</h2>

                    <p class="lead">
                        Con el DebeHaber usted puede generar los asientos de todas sus ventas y compras con un solo click,
                        puede generar asientos resumidos o detallados.
                    </p>

                    <p>
                      La generación de asientos automáticos es una funcionalidad que le permitirá seleccionar un rango de fecha, por ejemplo tomar todas las ventas de un mes, y generar un solo asiento
                      para todas la ventas de dicho mes.
                      Esto sin duda le permitirá ahorrar tiempo, ya que el DebeHaber hará el trabajo por usted.
                    </p>

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
                    <h2>Dashboard de Estadísticas</h2>
                    <p class="lead">
                        Estádisticas del estado contable me su empresa en tiempo real.
                    </p>
                    <p>
                        Con el Dashboard del DebeHaber, usted puede saber a una simple vista, el nivel de cumplimiento
                        en cuanto a su contablidad, saber el porcentaje de Ventas por Asentar, Los próximos vencimientos, etc.
                    </p>
                </div>
                <div class="col-12 col-lg-6 pr-0">
                    <img src="assets/front-end/img/screens/dash-2.jpg" alt="" class="img-responsive shadow" data-aos="fade-left">
                </div>
            </div>
        </div>
    </section>
    @endsection
