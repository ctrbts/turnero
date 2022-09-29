<?php
include("topInclude.php");
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

//Limpia variable de seleccion multiple si existe;
unset($_SESSION['MultipleValuesSel']);

$commonfuncions = new CommonFunctions();

if (isset($_GET)) {

    if (isset($_GET['k'])) {
        $id =  base64_decode($_GET['k']);
        //Carga los datos de la forma
        $Forma = new FormasObj();
        $Forma->idforma = $id;
        $ADOFormas = new ADOFormas();
        $ADOFormas->GetForma($Forma);

        //Carga los campos asignados a la forma
        $ListCampos = new ArrayList();
        $ADOCampoForma = new ADOCamposForma();
        $ADOCampoForma->GetCampos($id, $ListCampos);

        $Forma->CamposFormaCollection = $ListCampos;
    } else {
        $commonfuncions->RedirectPage("FormsManager.php");
    }
} else {
    $commonfuncions->RedirectPage("FormsManager.php");
}


?>
<?php $HtmlViewsController->IncludeViews(array("HtmlTopHeader", "HtmlHeader")); ?>
<title>Adminstrar formularios</title>
<?php $HtmlViewsController->IncludeViews(array("HtmlBody")); ?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-5">
        <span class="lead" style="font-size:42px;">
            Administración de campos del formulario<br /> <strong><?php echo $Forma->descripcion; ?></strong>
        </span>
        <div class="mt-3 mb-3">
            <span class="lead mb-3">
                <p>Definir campos para el formulario a llenar por el paciente al momento de agendar un turno.</p>
            </span>
        </div>

    </div>
    <div class="mt-3 mb-3">
        <a class="btn btn-primary" href="FieldDetailFrom.php?k=<?php echo base64_encode($id); ?>">Agregar Nuevo Campo</a>&nbsp;&nbsp;&nbsp;
        <a class="btn btn-primary" href="TypeFieldsManager.php"> Modificar Tipos de Datos</a>&nbsp;&nbsp;&nbsp;
        <a class="btn btn-primary" href="FormsManager.php"> Regresar a Administración de formularios</a>&nbsp;&nbsp;&nbsp;
    </div>
    <div class="p-3">
        <div class="table-responsive">
            <table class="table table-sm table-hover table-striped table-bordered">
                <tr>
                    <th>Campo</th>
                    <th>Tipo de Dato</th>
                    <th colspan="4">Opciones</th>
                </tr>

                <?php
                foreach ($Forma->CamposFormaCollection->array as $item) {
                    $item->GetTipoCampo();
                ?>
                    <tr>
                        <td>
                            <?php echo $item->nombre; ?>
                        </td>
                        <td>
                            <?php echo $item->TipoCampoObj->tipo; ?>
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="FieldDetailFrom.php?k=<?php echo base64_encode($id); ?>&s=1&ck=<?php echo base64_encode($item->idcampoforma); ?>">Modificar</a>
                        </td>
                        <?php if ($item->activo == EActivate::Activo) { ?>
                            <td>
                                <a class="btn btn-danger btn-sm" href="updateActivationField.php?k=<?php echo base64_encode($item->idcampoforma); ?>&o=0&pk=<?php echo base64_encode($id); ?>">Desactivar</a>
                            </td>
                        <?php  } ?>
                        <?php if ($item->activo == EActivate::Inactivo) { ?>
                            <td>
                                <a class="btn btn-success btn-sm" href="updateActivationField.php?k=<?php echo base64_encode($item->idcampoforma); ?>&o=1&pk=<?php echo base64_encode($id); ?>">Activar</a>
                            </td>
                        <?php  } ?>
                        <td>
                            <a class="btn btn-danger btn-sm" href="deleteMessageBoard.php?k=<?php echo base64_encode($item->idcampoforma) ?>&r=<?php echo base64_encode("deleteField.php") ?>&pb=<?php echo base64_encode("FormConfig.php?k=" .  base64_encode($id) . ""); ?>&pk=<?php echo base64_encode($id) ?>">Borrar</a>
                        </td>
                        <?php if ($item->TipoCampoObj->selmultiple == "1") { ?>
                            <td>
                                <a class="btn btn-primary btn-sm" href="MultipleValueForm.php?k=<?php echo base64_encode($item->idcampoforma) ?>&pk=<?php echo base64_encode($id); ?>">Definir Valores Multiples</a>
                            </td>
                        <?php  } else { ?>
                            <td>

                            </td>
                        <?php } ?>
                    </tr>
                <?php
                }
                ?>

            </table>
        </div>
    </div>
</div>
<!-- End content -->
<?php $HtmlViewsController->IncludeViews(array("HtmlFooter", "HtmlBottomFooter")); ?>