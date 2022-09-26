<?php

include ("topInclude.php");
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

    /*
     * Form state is the state of the gui to the user
     * 0 - New record
     * 1 - Load and edit data
     * 2- Load and can delete data
     */
    $_form_state=0;
    $_post_page="";
    $e_module;
    $show_data=false;

    if($_GET["formstate"]=="1"){

        $_form_state=1;
        $e_module= new ModulesMenu();
        if ($_GET['idmodulo']!="" || !isnull($_GET['idmodulo'])){
            $e_module= new ModulesMenu();
            $e_module->idmodulo=$_GET['idmodulo'];
            $_ADOModules= new ADOModules();
            $_ADOModules->GetModuleByID($e_module);
            $show_data=true;
            $_post_page="updateModule.php";
        }else{
            $_form_state=0;
        }
    }
    if($_GET["formstate"]=="2"){
        $_form_state=2;

    }

    if($_form_state==0){
         $_post_page="addnewModule.php";
    }
?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Modulos del sistema</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Contenido -->

<div class="p-3">
    <div class="mt-3 mb-4">
        <span class="lead" style="font-size:42px;">
              Detalle Modulo
        </span>
        <p></p>
        <span class="lead">
            Detalle de informacion del modulo
        </span>
    </div>
    <div class="d-flex justify-content-center" >
        <form id="form_1103136" class="text-left" style="width:340px;"  method="post" action="<?php echo $_post_page; ?>">
            <div class="form-group">
                <label class="form-label" for="element_1">Etiqueta </label>
                <input id="element_1" name="etiqueta" class="form-control" type="text" maxlength="255"
                value="<?php if($show_data) echo $e_module->etiqueta; ?>"  />
            </div>
            <div class="form-group">
                <label class="form-label" for="element_2">Ruta de Modulo </label>
                <input id="element_2" name="path" class="form-control" type="text" maxlength="255"
                value="<?php if($show_data) echo $e_module->path; ?>"/>
            </div>
            <div class="form-group">
                <label class="form-label" for="element_3">Accion* </label>
                <input id="element_3" name="accion" class="form-control" type="text" maxlength="255" value="<?php if($show_data) echo $e_module->accion; ?>"/>
            </div>
            <div class="form-group form-check">
                <input id="element_4_1" name="activo" class="form-check-input" type="checkbox" value="1" <?php if($e_module->activo=1) echo "checked=\"true\""  ?> />
                <label class="form-check-label" for="element_4_1">Activo</label>
            </div>
            <div class="p-2 mb-4">
                <input type="hidden" name="form_id" value="1103136" />
                    <?php
                        if($_form_state==1){
                            echo " <input type=\"hidden\" name=\"idmodulo\" value=\"$e_module->idmodulo\" />";
                        }
                    ?>
				<input id="saveForm" class="btn btn-success btn-block btn-lg" type="submit" name="submit" value="Guardar" />
            </div>
        </form>
    </div>
</div>

<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>