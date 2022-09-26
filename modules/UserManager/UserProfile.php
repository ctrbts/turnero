<?php
include 'topInclude.php';
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");
$redirect=false;

if(!empty($_SESSION)){
    if(isset($_SESSION['UserObj'])){
        $UserLogged= unserialize($_SESSION['UserObj']);

    }else{
        $redirect=true;
    }
}else{
    $redirect=true;
}

?>
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
    <title>Perfil de Usuario</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include ("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Mi Perfil
        </span>
        <span class="lead">
            <p>Actualiza tu contrase&ntilde;a o perfil de usuario</p>
        </span>
    </div>
    <div class="d-flex justify-content-center">
        <form id="form_110" class=""  method="post" action="UpdateUserProfile.php">
            <div class="form-group">
                <label class="form-label" for="nombre">Nombre</label>
                <input class="form-control text-center" name="nombre" id="nombre" type="text" value="<?php echo $UserLogged->nombre?>" />
            </div>
            <div class="form-group">
                <label class="form-label" for="apellidos">Apellidos</label>
                <input class="form-control  text-center" name="apellidos" id="apellidos" type="text" value="<?php echo $UserLogged->apellidos?>" />
                <p></p>
                <p>Email: <?php echo $UserLogged->email?><input type="hidden" name="email" value="<?php echo $UserLogged->email?>" /></p>
                <input type="hidden" name="token" value="<?php echo $UserLogged->activationtoken?>">
            </div>
            <?php if($UserLogged->email!="admin@soporte.com" && $UserLogged->email!="agenda@soporte.com"){ ?>
               <h3>Cambiar Contraseña</h3>
               <div class="form-group">
                   <label class="form-label" for="password">Contraseña</label>
                   <input class="form-control text-center" name="password" id="password" type="password" value="" /><br />
                   <label class="form-label" for="passwordconf">Confirmar Contraseña</label>
                   <input class="form-control text-center" id="passwordconf" type="password" value="" />
                   <p><span id="MessageBoard" style="color: red; font-size: medium"></span></p>
               </div>
            <?php }?>
            <div class="m-5">
                   <input class="btn btn-success btn-lg" type="button" id="SaveInfo" value="Guardar mis Datos" />
            </div>
        </form>
    </div>
</div>
       <script type="text/javascript" >
           //validate the password
           $('#SaveInfo').click(function(){
                var submitform=false;
                $('#MessageBoard').html("");
                var pass= $('#password').val();
                var confpass=$('#passwordconf').val();
                var name=$('#nombre').val();
                if(pass!="" && confpass!=""){
                    if(pass!=confpass){
                      $('#MessageBoard').html("Contraseñas no coinciden");
                      return false;
                    }else{
                        submitform=true;
                    }
                }


                if(name!=""){
                    submitform=true;
                }else{
                    $('#MessageBoard').html("Tu nombre no puede estar en Blanco");
                }

                if(submitform==true){

                    document.getElementById("form_110").submit();
                }

           })
       </script>
<!-- End content -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>