<?php
include ("topInclude.php");
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

$hrsobj = new ReglaHorarios();
$show_data=false;

if(!empty($_GET)){
    $hrsobj->idhrs=$_GET['idhrs'];
    $_ADOReglaHrs = new ADOReglasCitas();
    $_ADOReglaHrs->getHorasByID($hrsobj);
    $show_data=true;
}


?>

<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
    <title>Modificar Horarios</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include ("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="">
    <div class="mt-3 mb-5">
        <span class="lead" style="font-size:42px;">
             Configuraci&oacute;n de disponibilidad de citas
        </span>
        <span class="lead">
            <p>Modificar Horario Selecionado</p>
        </span>
    </div>
    <div class="d-flex justify-content-center">
        <form id="form_110" class="appnitro"  method="post" action="updateHorarios.php">
            <h3>Modificar Horario Selecionado</h3>
            <label class="description" for="element_2">Horas  </label>
            <div>
                <input id="element_1" name="hrsinicio" class="element text xsmall" type="text" maxlength="5" value="<?php if($show_data) echo $hrsobj->hr_inicio; ?>" /> :
                <input id="element_2" name="hrsfin" class="element text xsmall" type="text" maxlength="5" value="<?php if($show_data) echo $hrsobj->hr_fin; ?>" />
                <input name="idhrs" type="hidden" value="<?php if($show_data) echo $hrsobj->idhrs; ?>" />
                <input id="saveForm" class="btn btn-success" type="submit" name="submit" value="Guardar" />
            </div>
            <div class="mt-4 mb-4">
                <a class="btn btn-primary" href="AgendaConfManager.php"> Regresar </a>
            </div>
        </form>
    </div>
</div>
<!-- End content -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>