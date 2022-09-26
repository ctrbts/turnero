<?php
include ("topInclude.php");

//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("views/");

$messageid=0;
$title="";
$subtitle="";
$message="";
$link="";

if(!empty($_GET) || !empty($_POST)){
    if(isset($_GET['messageid'])){
        $messageid=$_GET['messageid'];
    }
    if(isset($_POST['messageid'])){
        $messageid=$_POST['messageid'];
    }
}
switch ($messageid){
    case 1:
        $title="Usuario Inactivo.";
        $subtitle="Este usuario aun no ha sido activado. revise su correo electronico enviado por el sistema para activar la cuenta<br/>";
        $message="Si desea que se reenvie la activacion precione el siguente link <a href=\"\">Reenviar activacion </a>";
        $link="<a href=\"index.php\">Regresar al menu principal</a>";
        break;
    case 2:
        $title="Activacion de usuario.";
        $subtitle="Para activar tu cuenta, se envio un correo electronico con los pasos de activacion.<br/>";
        $message="Si desea que se reenvie la activacion precione el siguente link <a href=\"\">Reenviar activacion </a>";
        $link="<a href=\"index.php\">Regresar al menu principal</a>";
        break;
    case 3:
        $title="E-mail ya registrado";
        $subtitle="El e-mail que se intenta registrar ya se encuentra registrado.<br/>";
        $message="Intente accesar al sistema o si no recuerda la contraseña de clic en la siguiente opcion<br /> <a href=\"./modules/UserActivation/ForgotPassword.php\">Recuperar contraseña<a/>";
        $link="<a href=\"index.php\">Regresar al menu principal</a>";
        break;
    case 4:
        $title="Gracias por registrarte.";
        $subtitle="Es necesario Activar tu cuenta. Para activar tu cuenta, se envio un correo electronico con los pasos de activacion.<br/>";
        $message="Si desea que se reenvie la activacion precione el siguente link <a href=\"./modules/UserActivation/SendActivationMail.php\">Reenviar activacion </a>";
        $link="<a href=\"index.php\">Regresar al menu principal</a>";
        break;
    case 5:
        $title="Gracias por Activar tu cuenta.";
        $subtitle="Una vez activada tu cuenta puedes accesar al sistema para agendar una cita y terner mas opciones.<br/>";
        $message="Para continuar ingresa tu usuario y contrase&ntilde;a en la pagina principal";
        $link="<a href=\"index.php\">Regresar al menu principal</a>";
        break;
    case 6:
        $title="Para cambiar tu contrasena revisa tu correo el&eacute;ctronico";
        $subtitle="Se ha mandado un correo electronico a tu cuenta con los pasos para reiniciar tu contraseña<br/>";
        $message="Sigue los pasos que se mencionan en el correo.";
        $link="<a href=\"index.php\">Regresar al menu principal</a>";
        break;
    case 7:
        $title="Correo el&eacute;ctronico invlaido";
        $subtitle="El correo l&eacute;ctronico proporcionado no se encuentra en nuestros registro revise si esta escrito correctamente o internte registrarse de nuevo.<br/>";
        $message="&nbsp;";
        $link="<a href=\"index.php\">Regresar al menu principal</a>";
        break;
    case 8:
        $title="Tu Contraseña se ha cambiado con exito!";
        $subtitle="Ya puedes accesar con tu nueva contraseña al sistema de turnos.<br/>";
        $message="&nbsp;";
        $link="<a href=\"index.php\">Regresar al menu principal</a>";
        break;
    case 9:
        $title="Lo Sentimos la turnos que deseas hacer ya no esta disponible";
        $subtitle="Los horarios que selecionastes ya no estan dispobiles te recomendamos que seleciones otro horario.<br/>";
        $message="&nbsp;";
        $link="<a href=\"index.php\">Regresar al menu principal</a>";
        break;
    case 10:
        $title="Gracias! tu Turno se ha agendado con exito!";
        $subtitle="Tu cita se ha agendado con exito, revisa tu E-mail para la confirmacion de tu cita.<br/>";
        $message="Para ver tu programacion ve al menu principal.";
        $link="<a href=\"index.php\">Regresar al menu principal</a>";
        break;
}

?>
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
        <title>Cuenta aun no esta activada</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<div class="bg bg-white border rounded border-dark">
    <div>
        <span class="display-4">
            <?php echo $title;?>
        </span>
    </div>
    <div class="text-center mt-5 p2">
            <p class="h5"><?php echo $subtitle;?></p>
    </div>
    <div class="mt-1 p-4">
          <span class="lead"> <strong><?php echo $message;?></strong> </span>
    </div>
    <div class="text-center p-3 m-5">
        <div class="" style="font-size:2em;">
            <?php echo $link;?>
        </div>
    </div>
</div>
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>
