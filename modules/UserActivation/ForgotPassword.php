
<?php
include 'topInclude.php';
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

$_SESSION['captcha'] = simple_php_captcha();

?>
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
    <title>Recuperar Contraseña</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<!-- Content -->
<div class="p-3 m-3">
    <div class="mt-3 mb-3">
        <span class="display-4">Recupera tu contrase&ntilde;a</span>
    </div>
    <div>
        <p class="lead">&nbsp;Para recuperar tu contraseña solo llena el siguiente informaci&oacute;n requerida</p>
    </div>
    <div class="d-flex justify-content-center p-3" >
         <form id="form_110" method="post" action="PasswordRecovery.php" style="width:400px;">
            <div class="form-group">
                <label for="emailusr">Correo el&eacute;ctronico</label>
                <input type="email" name='email' class="form-control text-center" id="emailusr">
            </div>
            <div class="form-group">
                    <?php
                         echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';
                    ?>
                <label for="captcha">Ingresa el texto que aparece en la imagen</label>
                <input id="captcha" type="text" name="captcha" value="" class="form-control text-center" />
                <input id="codecaptcha" type="hidden" name="codecaptcha" value="<?php echo $_SESSION['captcha']['code'];?>" />
            </div>
            <div>
                <span id="messageboard" style="font-size: large; color: red; font-weight: bold"></span>
            </div>
            <div class="mb-5">
                <button type="button" class="btn btn-block btn-primary" onclick="validateemail(); return false;">Recuperar Contrase&ntilde;a</button>
            </div>
        </form>
    </div>

</div>
       <script type="text/javascript">
           function validateemail(){
               var emailusr= document.getElementById("emailusr").value;
               var codecaptcha=document.getElementById("codecaptcha").value;
               var captcha=document.getElementById("captcha").value;
               var message=document.getElementById("messageboard");
               message.innerHTML = "";
               var subit_form=true;
               var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
               if(emailusr=="" || !re.test(emailusr)){
                    subit_form=false;
                    message.innerHTML = "E-mail invalido!<br/>";
               }
               if(captcha=="" || codecaptcha!=captcha){
                   subit_form=false;
                    message.innerHTML = "Texto de imagen invalido! porfavor intente de nuevo.<br/>";
               }

               if(subit_form){
                   document.getElementById("form_110").submit();
               }


           }
       </script>
<!-- End content -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>