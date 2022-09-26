<?php?>
<!DOCTYPE html>
<html>
  <head>

    <title>Agenda electonica instalador</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
        <div class="display-3 mt-3">
            Instalador de Agenda electronica.
        </div>
        <div class="mt-2 mb-2">
            <span class="lead">
                Este es el instalador para la agenda electronica, es requirido que tengas la informaci&oacute;n de tu servidor para
                poder continuar.
            </span>
        </div>
        <div class="d-flex justify-content-center">
            <span class="lead">
                Requerimientos minimos para este sitio web.
                <div class="text-left">
                    <ul>
                        <li>PHP 5.0 o superior</li>
                        <li>MySQL Server 5.5 o superior</li>
                        <li>Permisos en carpeta de imagenes de escritura</li>
                    </ul>
                </div>
            </span>
        </div>
        <div class="d-flex justify-content-center">
            <div class="mt-2 mb-2 border rounded p-3 text-left " style="width:340px;">
                <form action="install.php" method="post"  class="needs-validation" id="frm_installer" novalidate>
                    <div class="form-group">
                        <label for="dbserver" class="form-label">Servidor de Base de Datos</label>
                        <input type="text" class="form-control" id="dbserver" name="dbserver" required>
                        <div class="invalid-feedback">
                            Ingrese el servidor MySQL.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dbuser" class="form-label">Usuario Base de Datos</label>
                        <input type="text" class="form-control" id="dbsuser" name="dbsuser" required>
                        <div class="invalid-feedback">
                            Ingrese el usuario.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dbpassword" class="form-label">Constrase&ntilde;a Base de Datos</label>
                        <input type="text" class="form-control" id="dbpassword" name="dbpassword" required>
                        <div class="invalid-feedback">
                           Ingrese la constrase&ntilde;a.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dbschema" class="form-label">Base de Datos</label>
                        <input type="text" class="form-control" id="dbpassword" name="dbschema" required>
                        <div class="invalid-feedback"> 
                           Ingrese la la base de datos.
                        </div>
                    </div>
                    <hr>
                    <div class="mt=3 mb-3">
                        <span class="h4">Configuracion PHPMailer</span>
                    </div>
                    <div class="form-group">
                        <label for="smtphost" class="form-label">Servidor SMTP</label>
                        <input type="text" class="form-control" id="smtphost" name="smtphost" value="smtp.host.com">
                    </div>
                    <div class="form-group">
                        <label for="smtpport" class="form-label">Puerto SMTP</label>
                        <input type="text" class="form-control" id="smtpport" name="smtpport" value="587">
                    </div>
                    <div class="form-group">
                        <label for="smtpuser" class="form-label">Usuario SMTP</label>
                        <input type="text" class="form-control" id="smtpuser" name="smtpuser" value="usuario_smtp">
                    </div>
                    <div class="form-group">
                        <label for="smtppass" class="form-label">Contrase&ntilde;a SMTP</label>
                        <input type="text" class="form-control" id="smtppass" name="smtppass" value="123456789">
                    </div>
                    <div class="form-group">
                        <label for="smtpemail" class="form-label">Email From SMTP</label>
                        <input type="text" class="form-control" id="smtpemail" name="smtpemail" value="infro@server.com">
                    </div>
                    <div>
                        <button  class="btn btn-primary btn-block" id="btn_install">Instalar</button>
                    </div>
                </form>
            </div>
        </div>    
    </div>
    <script>
        (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
            });
        }, false);
        })();
    </script>
  </body>
</html>