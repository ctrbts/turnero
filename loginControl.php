<?php

/*
 * Copyright (C) 2016 Fernando Merlo
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

$_SESSION['captcha'] = simple_php_captcha();
$countFailedAttempts = (isset($_SESSION["failedattempts"])) ? $_SESSION["failedattempts"] : 0;
?>
<div class="container">
    <div class="row justify-content-center my-4">
        <!-- Acceso de usuario -->
        <div class="col-lg-5 m-3 p-3 card shadow-sm">
            <div class="p-3">
                <h4 class="mb-3">Ingreso para pacientes registrados</h4>
                <h6 class="text-muted">Si usted ya ha solicitado un turno anteriormente, ingrese con el correo electrónico que informó y su contraseña</h6>
            </div>
            <div class="p-3">
                <form name="loginfrm" action="login.php" method="POST" class="text-left">
                    <div class="form-group">
                        <label for="emaillogin">E-mail:</label>
                        <input type="text" class="form-control" id="emaillogin" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Contrase&ntilde;a:</label>
                        <input type="password" class="form-control" id="password" name="contrasena">
                    </div>
                    <?php
                    if ($countFailedAttempts >= 3) {
                    ?>
                        <div class="text-center">
                            <?php echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code" height="80px;" >'; ?>
                            <div class="form-group">
                                <label for="captchatxt">Ingresa el texto de la imagen</label>
                                <input type="text" class="form-control" id="captchatxt" name="captcha">
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <div>
                        <button type="submit" class="btn btn-block btn-success my-5">
                            Ingresar
                        </button>
                    </div>
                    <div class="text-center py-3">
                        <a href="./modules/UserActivation/ForgotPassword.php">
                            Si perdió su contraseña o no la recuerda haga click en este enlace
                        </a>
                    </div>
                </form>
            </div>

        </div>

        <!-- Registro de usuario -->
        <div class="col-lg-5 m-3 p-3 card shadow-sm">
            <div class="p-3">
                <h4 class="mb-3">Registro para nuevos pacientes</h4>
                <h6 class="text-muted">Si esta es la primera vez que utiliza el sistema de turnos online, deberá registrarse y completar sus datos para solicitar un turno</h6>
            </div>
            <div class="p-3">
                <form name="loginRegister" action="RegistrarNuevoUsuario.php" method="POST" class="text-left" id="loginRegister">
                    <div class="form-group">
                        <label for="emaillogin">E-mail:</label>
                        <input type="email" class="form-control" id="regemail" name="email">
                    </div>
                    <div class="form-group">
                        <label for="pass1">Nueva Contrase&ntilde;a:</label>
                        <input type="password" name="contrasena" class="form-control" value="" id="pass1">
                    </div>
                    <div class="form-group">
                        <label for="pass2">Confirma tu Contrase&ntilde;a:</label>
                        <input type="password" name="contrasenaval" class="form-control" value="" id="pass2" onkeyup="checkPass(); return false;"><br />
                        <span id="confirmMessage" class="confirmMessage"></span>
                    </div>
                    <div class="pb-3">
                        <input type="button" name="login" class="btn btn-primary btn-block" value="Registrar" onclick="checkform(); return false">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var subit_form = true;
    var passwordmatch = false;

    function checkPass() {
        //Store the password field objects into variables ...
        var pass1 = document.getElementById('pass1');
        var pass2 = document.getElementById('pass2');
        //Store the Confimation Message Object ...
        var message = document.getElementById('confirmMessage');
        //Set the colors we will be using ...
        var goodColor = "#66cc66";
        var badColor = "#ff6666";
        //Compare the values in the password field
        //and the confirmation field
        if (pass1.value == pass2.value) {
            //The passwords match.
            //Set the color to the good color and inform
            //the user that they have entered the correct password
            pass2.style.backgroundColor = goodColor;
            message.style.color = goodColor;
            message.innerHTML = ""
            passwordmatch = true;
        } else {
            //The passwords do not match.
            //Set the color to the bad color and
            //notify the user.
            pass2.style.backgroundColor = badColor;
            message.style.color = badColor;
            message.innerHTML = "Las contraseñas no coinciden, teclea correctamente la nueva contrase&ntilde;a"
        }
    }

    function checkform() {
        var newemail = document.getElementById("regemail").value;
        var pass1 = document.getElementById('pass1');
        var pass2 = document.getElementById('pass2');
        //alert(newemail);
        var message = "";
        var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
        if (newemail == "" || !re.test(newemail)) {
            //alert("if 1");
            subit_form = false;
            message = "E-mail invalido!";
        }

        if (pass1.value == "" && pass2.value == "") {
            //alert("if 2");
            subit_form = false;
            message = "Contraseñas invalidas!";
        }

        if (pass1.value != pass2.value) {
            //alert("if 3");
            subit_form = false;
            message = "Contraseñas no concuerdan!";
        }

        if (subit_form) {
            document.getElementById("loginRegister").submit();
        } else {
            alert(message);
        }
    }
</script>