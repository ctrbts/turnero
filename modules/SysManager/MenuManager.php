
<?php
include ("topInclude.php");
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

$selected_idmodulo=-1;
$show_modulestoselect=false;
$l_modules = new ArrayList();
$post_page="";
$o_ADOModules =  new ADOModules();
$l_module= new ModulesMenu();

if(empty($_POST)){
    if(empty($_GET)){

        $o_ADOModules->GetModulesActive($l_modules);
        $show_modulestoselect=true;
        $post_page="MenuManager.php";

    }else{
        $selected_idmodulo=$_GET['idmodulo'];
        $post_page="#";

        $l_module->idmodulo=$selected_idmodulo;
        $o_ADOModules->GetModuleByID($l_module);
    }
}else{
    $selected_idmodulo=$_POST['idmodulo'];
    $post_page="#";
    $l_module->idmodulo=$selected_idmodulo;
    $o_ADOModules->GetModuleByID($l_module);
}

if($l_module->idmodulo>0){
    $l_module->getMenus();
}

?>
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
    <title>Administraci&oacute;n de Menus</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include ("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Administraci&oacute;n de Menus
        </span>
        <div>
        <form id="form_113763" class=""  method="post" action="<?php echo $post_page;?>">
                <?php
                    if (!$show_modulestoselect){
                ?>
                <div class="mt-2">
                    <p class="lead">Agrega o modificar menus. Modulo: <strong><?php echo $l_module->etiqueta; ?></strong> </p>
                </div>

                 <div>
                     <a class="btn btn-primary" href="MenuForm.php?formstate=0&idmodulo=<?php echo $l_module->idmodulo;?>">Agregar Nuevo Menu</a>
                </div>
                <div class="m-2 p-2 ">
                    <div class="table-responsive d-flex justify-content-center">
                        <table class="table table-bordered" style="width:40%;">
                            <tr>
                                <th scope="col">Menu</td>
                                <th  scope="col" colspan="2">Opciones</th>
                            </tr>
                            <?php
                                foreach($l_module->ListofMenuObj->array as $item){
                                    echo "<tr>";
                                    echo "<td>$item->etiqueta</td>";
                                    echo "<td><a class=\"btn btn-sm btn-primary \" href=\"MenuForm.php?formstate=1&idmodulo=$item->idmodulo&idmenu=$item->idmenu\">Modificar</a></td>";
                                    echo "<td><a class=\"btn btn-sm btn-danger \" href=\"deleteMenuMessageboard.php?idmodulo=$item->idmodulo&idmenu=$item->idmenu\">Borrar</a></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                </div>


                <?php
                    }else{
                ?>
                <div class="d-flex justify-content-center">
                    <div class="form-group">
                        <label for="selectmodule" class="form-label">Selecione el Modulo:</label>
                        <select class="form-control" name="idmodulo" id="selectmodule">
                            <?php
                                foreach ($l_modules->array as $item){
                                    echo "<option  value=\"$item->idmodulo\">$item->etiqueta</option>\n\t\t\t";
                                }
                                ?>
                        </select>
                        <input id="saveForm" class="btn btn-primary m-2" type="submit" name="submit" value="Ver Menus" />
                    </div>
                </div>




                <?php
                    }
                ?>
            </form>
        </div>
    </div>
</div>

<!-- End content -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>
