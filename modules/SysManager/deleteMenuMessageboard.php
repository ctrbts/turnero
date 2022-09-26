<?php
    include ("topInclude.php");
    //Carga Clase de control de vistas.
    $HtmlViewsController = new HtmlViewsController("../../views/");
?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Mensaje del sistema</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<!-- Contenido -->
<div class="p-3 mt-3">
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
            <a class="btn btn-danger btn-lg" href="deleteMenu.php?idmenu=<?php echo $_GET['idmenu'];?>&idmodulo=<?php echo $_GET['idmodulo'];?>">Si Deseo Borrar</a>
        </div>
        <div class="col">
            <a class="btn btn-primary btn-lg" href="MenuManager.php?idmodulo=<?php echo $_GET['idmodulo'];?>">No y Cancelar</a>
        </div>
    </div>
</div>
<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>