<?php
    include ("topInclude.php");
    //Carga Clase de control de vistas.
    $HtmlViewsController = new HtmlViewsController("../../views/");

    //Load info from the database
    $TiposDatosCollection = new ArrayList();
    $ADOTipoCampo = new ADOTipoCampo();
    $ADOTipoCampo->GetTiposCampos($TiposDatosCollection);
?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Administraci&oacute;n de Tipo de Datos</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Contenido -->

<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Administraci&oacute;n de Tipo de Datos
        </span>
        <span class="lead">
            <p>
                Modulo para administrar los tipos de datos a utilizar las formas
            </p>
        </span>
    </div>
    <div class="mt-3 mb-4">
        <a class="btn btn-primary" href="TypeFieldsForm.php">Agregar Nuevo Tipo</a>
        <a class="btn btn-primary" href="FormsManager.php">Regresar a Administracion de Formas</a>
    </div>
    <div class="d-flex justify-content-center">
        <div>
        <table class="table table-hover">
                        <tr>
                            <th>Tipo de Campo</th>
                            <th>Descripci&oacute;n</th>
                            <th>Selecci&oacute;n Multiple</th>
                            <th>Opciones</th>
                        </tr>

                            <?php foreach($TiposDatosCollection->array as $item){
                                    $selmultiple = "No";
                                    if($item->selmultiple=="1"){
                                        $selmultiple="Si";
                                    }
                                ?>
                        <tr>
                                <td><?php echo $item->tipo; ?></td>
                                <td><?php echo $item->descripcion; ?></td>
                                <td>
                                    <?php echo $selmultiple; ?><br/>
                                </td>
                                <td>

                                    <a class="btn btn-primary" href="TypeFieldsForm.php?k=<?php echo base64_encode($item->idtiposcampo);?>&s=1" >Modificar</a> &nbsp;&nbsp;
                                    <?php
                                        if($item->activo==EActivate::Activo){
                                    ?>
                                    <a class="btn btn-danger" href="updateActivationTypeField.php?k=<?php echo base64_encode($item->idtiposcampo);?>&o=0" >Desactivar</a> &nbsp;&nbsp;
                                    <?php
                                      }
                                    ?>
                                    <?php
                                        if($item->activo==EActivate::Inactivo){
                                    ?>
                                    <a  class="btn btn-success" href="updateActivationTypeField.php?k=<?php echo base64_encode($item->idtiposcampo);?>&o=1" >Activar</a> &nbsp;&nbsp;
                                    <?php
                                      }
                                    ?>
                                    <a class="btn btn-danger" href="deleteMessageBoard.php?k=<?php echo base64_encode($item->idtiposcampo);?>&r=<?php echo base64_encode("deleteTypeField.php");?>&pb=<?php echo base64_encode("TypeFieldsManager.php");?>" >Borrar</a>
                                </td>
                        </tr>
                            <?php }?>

                    </table>
        </div>
    </div>
</div>
<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>
