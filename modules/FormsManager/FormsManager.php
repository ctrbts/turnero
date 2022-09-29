<?php
include("topInclude.php");
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

//Load the Forms
$ADOFormas = new ADOFormas();
$LisFormas = new ArrayList();
$ADOFormas->GetFormas($LisFormas);


?>
<?php $HtmlViewsController->IncludeViews(array("HtmlTopHeader", "HtmlHeader")); ?>
<!-- Titulo de pagina web -->
<title>Administraci&oacute;n de Formas</title>
<!-- Seccion para agregar personalizacion de css,js y demas -->

<?php $HtmlViewsController->IncludeViews(array("HtmlBody")); ?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Contenido -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Administraci&oacute;n de Formularios
        </span>
        <span class="lead">
            <p>Modulo para administrar los formularios antes de reservar un turno, estos formularios pueden ser selecionables o predeterminadas</p>
        </span>
    </div>
    <div>
        <a class="btn btn-primary m-3" href="FormsAdd.php">Agregar nuevo formulario</a>
        <a class="btn btn-primary m-3" href="TypeFieldsManager.php"> Modificar tipos de datos</a>&nbsp;&nbsp;&nbsp;
    </div>
    <div class="table-responsive p-3">
        <table class="table table-bordered table-sm table-hover">
            <tr>
                <th>&nbsp;&nbsp;Nombre del formulario&nbsp;</th>
                <th>&nbsp;Presentacion&nbsp;</th>
                <th colspan="4">&nbsp;Opciones&nbsp;</th>

            </tr>
            <?php
            foreach ($LisFormas->array as $item) {
                $opcion = "";
                if ($item->visible == 1 && $item->seleccion == 0) {
                    $opcion = "Visible";
                }
                if ($item->visible == 0 && $item->seleccion == 1) {
                    $opcion = "Seleccion";
                }
                $activo = $item->activo;

            ?>
                <tr>
                    <td><?php echo $item->descripcion; ?></td>
                    <td>
                        <?php echo $opcion; ?>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="FormConfig.php?k=<?php echo base64_encode($item->idforma); ?>">Configurar formulario</a>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="FormsAdd.php?s=1&k=<?php echo base64_encode($item->idforma); ?>"> Modificar </a>
                    </td>
                    <td>
                        <?php
                        if ($activo == EActivate::Activo) {
                        ?>
                            <a class="btn btn-sm btn-danger" href="updateActivation.php?k=<?php echo base64_encode($item->idforma) ?>&o=0">Desactivar</a>
                        <?php
                        } else {
                        ?>
                            <a class="btn btn-sm btn-success" href="updateActivation.php?k=<?php echo base64_encode($item->idforma) ?>&o=1">Activar</a>
                        <?php
                        }
                        ?>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-danger" href="deleteMessageBoard.php?k=<?php echo base64_encode($item->idforma) ?>&r=<?php echo base64_encode("deleteForm.php") ?>&pb=<?php echo base64_encode("FormsManager.php"); ?>">Borrar</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>
<!-- Fin de contenido -->
<?php $HtmlViewsController->IncludeViews(array("HtmlFooter", "HtmlBottomFooter")); ?>