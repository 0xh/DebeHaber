
@extends('layouts.website')

@section('title', 'Contactenos | DebeHaber')

@section('content')
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
            <div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <main>

                            <section class="section contact">
                            <div class="container">
                                <div class="section-heading">
                                    <h2>Escríbenos</h2>
                                    <p class="lead">Estamos aquí para ayudarle, escríbanos utilizando el formulario de abajo.</p>
                                </div>

                                <form action="srv/contact.php" method="post" class="form form-contact" name="form-contact" response-message-animation="slide-in-up">
                            <div class="form-group">
                                <label for="contact_fullname">Nombre</label>
                                <input type="text" name="Contact[fullName]" id="contact_fullname" class="form-control bg-1" placeholder="Nombre" required>
                            </div>

                            <div class="form-group">
                                <label for="contact_email">Correo</label>
                                <input type="email" name="Contact[email]" id="contact_email" class="form-control bg-1" placeholder="Correo" required>
                                <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tu correo con nadie mas.</small>
                            </div>

                            <div class="form-group">
                                <label for="contact_email">Mensaje</label>
                                <textarea name="Contact[message]" id="contact_message" class="form-control bg-1" placeholder="Escriba su mensaje" rows="8" required></textarea>
                            </div>

                            <div class="form-group">
                                <button id="contact-submit" data-loading-text="Sending..." name="submit" type="submit" class="btn btn-primary px-5 py-3">
                                    Enviar
                                </button>
                            </div>
                        </form>

                        <div class="response-message">
                            <div class="section-heading">
                                <i class="lnr lnr-thumbs-up font-xl"></i>
                                <h2 class="bold">Gracias!!</h2>
                                <p class="response">Tu mensaje ha sido envido, contactaremos con usted en la brevedad.</p>
                            </div>
                        </div>

                    </div>
                  </div>
              </div>
          </div>
      </div>
@endsection
