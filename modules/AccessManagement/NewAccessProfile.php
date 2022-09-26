<?php
include 'topInclude.php';
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

$loaddata=false;
$postpage="SaveProfile.php";
if(!empty($_GET)){
    if(isset($_GET['param'])){
        $LoadProfile= new AccessRol();
        $LoadProfile->idprofile=(int)$_GET['param'];
        $_ADOAccessRol= new ADOAccessRol();
        $_ADOAccessRol->GetProfileAccess($LoadProfile);
        if($LoadProfile->idprofile>0){
            $loaddata=true;
            $postpage="UpdateProfile.php";
        }
    }
}

?>
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
    <title>Nuevo Perfil de Acceso</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include ("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Perfil de Acceso
        </span>
        <span class="lead">
            <p>Agrega o modifica la informacion del perfil de usuarios</p>
        </span>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-5 mb-4 text-left">
        <form id="form_110" class=""  method="post" action="<?php echo $postpage;?>">
        <div class="form-group row">
            <label class="form-label col-3-lg pr-2 align-self-center" for="perfil">Perfil: </label>
            <input class="form-control col align-self-center" type="text" name="profile" value="<?php if($loaddata) echo $LoadProfile->profile; ?>" />
            <input type="hidden" name="idprofile" value="<?php if($loaddata) echo $LoadProfile->idprofile; ?>">
        </div>
        <div class="mt-3 mb-4">
            <input type="submit" name="SaveProfile" value="Guardar" class="btn btn-success btn-block">
        </div>
        </form>
    </div>
</div>
<!-- End content -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>
