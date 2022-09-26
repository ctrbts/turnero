<?php
include ("topInclude.php");
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

if(!empty($_GET)){
    if(isset($_GET['idcita'])){
        $idcita=$_GET['idcita'];
    }
}

?>
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<title>Mensaje de sistema</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<!-- Content -->
<div class="p-3 mt-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
             Cancelaci&oacute;n de Turno
        </span>
        <span class="lead">
            <p>&#191;Desea Cancelar Esta Turno?</p>
        </span>

    </div>
    <div class="mt-4 mb-3">
        <p class="lead">La cita se cancelara y no tendra derecho a reclamar el horario solicitado para atenci&oacute;n. desea cancelar la cita?</p>
        <p>&nbsp;</p>
    </div>
    <div class="mt-3 mb-4">
    <div class="row">
        <div class="col-lg">
            <a class="btn btn-danger btn-lg mt-3 mb-3" href="cancelCita.php?idcita=<?php echo $idcita;?>">Si Deseo Cancelar la Turno</a>
        </div>
        <div class="col-lg">
            <a class="btn btn-primary btn-lg mt-3 mb-3" href="./../../index.php">No y Regresar</a>
        </div>
    </div>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>

</div>
<!-- End content -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>