<?php
include 'topInclude.php';
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

$redirect = false;
$redirectpage = "";
$_SESSION['captcha'] = simple_php_captcha();

if (!empty($_GET)) {
    if (!empty($_GET['e']) && !empty($_GET['email'])) {
        $UserRecover = new UserObj();
        $UserRecover->email = $_GET['email'];
        $_ADOUser = new ADOUser();
        $_ADOUser->ExistEmail($UserRecover);
        if ($UserRecover->iduser > 0) {
            $idencripted = md5($UserRecover->iduser . $UserRecover->email);
            if ($idencripted != $_GET['e']) {
                $redirectpage = "../../index.php";
                $redirect = true;
            } else {
                $_SESSION['UserObjRecoverPass'] =  serialize($UserRecover);
            }
        } else {
            $redirectpage = "../../messageboard.php?messageid=7";
            $redirect = true;
        }
    } else {
        $redirectpage = "../../index.php";
        $redirect = true;
    }
} else {
    $redirectpage = "../../index.php";
    $redirect = true;
}

?>
<?php $HtmlViewsController->IncludeViews(array("HtmlTopHeader", "HtmlHeader")); ?>
<title>Recuperar Contraseña</title>
<?php $HtmlViewsController->IncludeViews(array("HtmlBody")); ?>
<!-- Content -->
<p>&nbsp;</p>
<div class="p-3 m-3">
    <div class="mt-3 mb-3">
        <span class="display-4">Recupera tu contrase&ntilde;a</span>
    </div>
    <div>
        <h2>&nbsp;Cambia tu contraseña</h2>
        <p>&nbsp;Teclea tu nueva contraseña.</p>
    </div>
    <div class="d-flex justify-content-center p-3">
        <form id="form_11" method="post" action="ResetPassToUser.php" style="width:400px;">
            <div class="form-group">
                <label for="newpass">Teclea tu nueva Contraseña:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input id="pass1" type="password" name="newpass" value="" class="form-control text-center">
            </div>
            <div class="form-group">
                <label for="confirmpass">Confirma tu nueva contraseña:</label>&nbsp;&nbsp;
                <input id="pass2" type="password" name="passconfirm" value="" class="form-control text-center" onkeyup="checkPass(); return false;">
                <div style="padding-left:250px;">
                    <span id="confirmMessage"></span>
                </div>
            </div>
            <div class="form-group">
                <div >
                    <?php
                    echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';
                    ?>
                </div>
                <label for="capthaconfirm">Ingresa el texto que aparece en la imagen:</label>&nbsp;&nbsp;
                <input id="captcha" type="password" name="captchaconfirm" value="" class="form-control text-center">
                <input id="captchacode" type="hidden" name="confirmcaptcha" value="<?php echo $_SESSION['captcha']['code']; ?>">
                    <div style="padding-left:344px;">
                    <span id="captchaMessage" style="font-size: medium; font-weight: bold;color: red;"></span>
                </div>
            </div>
            <div>
                <input class="btn btn-block btn-primary" type="button" name="CambiarPass" value="Cambiar Contraseña" onclick="validateForm(); return false;">
            </div>
        </form>
    </div>
</div>

<?php
if ($redirect) {
    if (isset($_SESSION['UserObjRecoverPass'])) {
        unset($_SESSION['UserObjRecoverPass']);
    }
    echo "<script type=\"text/javascript\"> window.location=\"$redirectpage\"</script>";
}
?>
<script type="text/javascript">
    var passconfirm = true;

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
            message.innerHTML = "Revisa tus contraseñas!"
            passconfirm = false;
        }
    }

    function validateForm() {
        var chaptchacode = document.getElementById('captchacode').value;
        var captcha = document.getElementById('captcha').value;
        var pass1 = document.getElementById('pass1').value;
        var pass2 = document.getElementById('pass2').value;

        var captchaMessage = document.getElementById('captchaMessage');
        var message = document.getElementById('confirmMessage');
        var submit_form = true;
        captchaMessage.innerHTML = "";
        if (chaptchacode != captcha) {
            submit_form = false;
            captchaMessage.innerHTML = "El codigo no es igual al de la imagen."
        }

        if (pass1 == "" || pass2 == "") {
            submit_form = false;
            message.innerHTML = "Contraseñas no debe ser en blanco.";
            message.style.color = "#ff6666";
        }

        if (pass1 == pass2) {
            //submit_form=true;
        } else {
            submit_form = false;
        }

        if (submit_form) {
            document.getElementById('form_11').submit();
        }

    }
</script>
<!-- End content -->
<?php $HtmlViewsController->IncludeViews(array("HtmlFooter", "HtmlBottomFooter")); ?>