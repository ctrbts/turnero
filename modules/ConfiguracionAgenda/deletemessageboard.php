
<?php
include ("topInclude.php");
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

$option="";
$delete_page="#";
$return_page="#";
$idfield="";
$fieldvalue="";

if(!empty($_GET)){
    $option=$_GET['option'];
    $fieldvalue=$_GET['fieldvalue'];
}

var_dump($option);

if($option=="deletehrs"){
    $delete_page="deleteReglaHrs.php?idhrs=$fieldvalue";
    $return_page="AgendaConfManager.php";
}

if($option=="deleteasuetodia"){
    $delete_page="deleteReglaDiaAsueto.php?iddiaasueto=$fieldvalue";
    $return_page="AgendaConfManager.php#DiasAsueto";
}
?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Mensaje de sistema</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<!-- Contenido -->
<div class=" mt-3">
    <div class="mt-3 mb-5">
        <span class="lead text-danger" style="font-size:42px;">
            Eliminar Registro
        </span>
        <p></p>
        <span class="h4 text-danger">
            Eliminando este registro, no podra restablecer los cambios en este sitio.
            <br/><br/>
            &iquest;Desea eliminar el registro selecionado?
        </span>
    </div>
    <div class="row mb-4 p-2">
        <div class="col">
        <td>
            <a class="btn btn-danger btn-lg" href="<?php echo $delete_page;?>">Si Deseo Borrar</a></td>
        </div>
        <div class="col">
            <a class="btn btn-primary btn-lg" href="<?php echo $return_page;?>">No y Cancelar</a>
        </div>
    </div>
</div>
<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>