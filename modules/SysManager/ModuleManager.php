<?php
include("topInclude.php");
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

$l_modules = new ArrayList();
$o_ADOModules =  new ADOModules();
$o_ADOModules->GetModulesActive($l_modules);
?>
<?php $HtmlViewsController->IncludeViews(array("HtmlTopHeader", "HtmlHeader")); ?>
<title>Administraci&oacute;n de Modulos</title>
<?php $HtmlViewsController->IncludeViews(array("HtmlBody")); ?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Administracion de Modulos
        </span>
    </div>
    <div class="mt-2 p-3">
        <form id="form_1103136" class="" method="post" action="">
            <p class="lead">Agrega o modifica los modulos actuales del sistema.</p>
            <div class="mb-3">
                <a href="ModuleForm.php" class="btn btn-primary">Agregar Nuevo Modulo</a>
            </div>
            <div class="table-responsive">
                <table style="width: 100%;" class="table table-sm table-hover table-striped table-bordered">
                    <tr>
                        <th>Modulo</th>
                        <th colspan="3">Opciones</th>
                    </tr>
                    <?php
                    foreach ($l_modules->array as $item) {
                        echo '<tr >';
                        echo "<td class=\"text-left pl-5\">$item->etiqueta</td>";
                        echo "<td><a class=\"btn btn-primary\" href=\"ModuleForm.php?formstate=1&idmodulo=$item->idmodulo\">Modificar</a></td>";
                        echo "<td><a class=\"btn btn-primary\" href=\"MenuManager.php?idmodulo=$item->idmodulo\">Agregar Menu</a></td>";
                        echo "<td><a class=\"btn btn-danger\" href=\"deletemessageboard.php?idmodulo=$item->idmodulo\">Borrar</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </form>
    </div>
</div>
<!-- End content -->
<?php $HtmlViewsController->IncludeViews(array("HtmlFooter", "HtmlBottomFooter")); ?>