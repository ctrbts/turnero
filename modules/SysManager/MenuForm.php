
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
    $show_data=false;
    $l_module = new ModulesMenu();
    $l_menu= new MenuObj();


    if(!empty($_GET)){
        $_form_state=$_GET['formstate'];
        $l_module->idmodulo=$_GET['idmodulo'];

        $_ADOModules = new ADOModules();
        $_ADOModules->GetModuleByID($l_module);

        if($_GET['idmenu']!=""){
            $l_menu->idmenu=$_GET['idmenu'];
            $_ADOMenus = new ADOMenus();
            $_ADOMenus->GetMenuByID($l_menu);
        }


    }

    if ($_form_state==0){
        $_post_page="addMenutoModulo.php";
    }

    if ($_form_state==1){
        $_post_page="updateMenutoModulo.php";
        $show_data=true;
    }

?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Detalle de menu</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Contenido -->

<div class="p-3">
    <div class="mt-3 mb-4">
        <span class="lead" style="font-size:42px;">
            Detalle de Menu
        </span>
        <p></p>
        <span class="lead">
            Informacion de modificacion o captura de menu.
        </span>
    </div>
    <div class="d-flex justify-content-center" >
        <form id="form_1104636" class="text-left" style="width:340px;"  method="post" action="<?php echo $_post_page; ?>">
            <div class="form-group">
                <label class="form-label" for="element_1">Modulo :</label>
                <input type="text" class="form-control" value="<?php echo $l_module->etiqueta;?>" id="element_1" readonly >
            </div>
            <div class="form-group">
                <label class="form-label" for="element_2">Etiqueta </label>
                <input id="element_2" name="etiqueta" class="form-control"
                       type="text" maxlength="255" value="<?php if($show_data) echo $l_menu->etiqueta;?>" />
            </div>
            <div class="form-group">
                <label class="form-label" for="element_3">Ruta de Menu </label>
                <input id="element_3" name="path" class="form-control" type="text"
                        maxlength="255" value="<?php if($show_data) echo $l_menu->path;?>"/>
            </div>
            <div class="form-group">
                <label class="form-label" for="element_4">Accion* </label>
                <input id="element_4" name="accion" class="form-control"
                       type="text" maxlength="255" value="<?php if($show_data) echo $l_menu->accion;?>"/>
                <small>*Opcional</small>
            </div>
            <div class="form-check mb-2">
                <input id="element_5_1" name="activo" class="form-check-input" type="checkbox" value="1" <?php if($l_menu->activo==1) echo "checked=\"true\"";?> />
                <label class="form-check-label" for="element_5_1">Activo</label>
            </div>
            <div class="p-2 mb-4">
                <input type="hidden" name="form_id" value="1103136" />
                <input type="hidden" name="idmodulo" value="<?php echo $l_module->idmodulo;?>" />
                <?php if($_form_state==1){ ?>
                <input type="hidden" name="idmenu" value="<?php echo $l_menu->idmenu;?>" />
                <?php } ?>
			    <input id="saveForm" class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="Guardar" />
            </div>
        </form>
    </div>
</div>
<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>