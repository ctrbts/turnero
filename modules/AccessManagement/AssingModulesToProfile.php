<?php

include 'topInclude.php';
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

$pagepost="SaveAsignationModules.php";

//carga modulos y menus
$l_modulemenus =  new ArrayList();
$_ADOModules = new ADOModules();
$_ADOAccessRol = new ADOAccessRol();
$_ADOModules ->GetModulesActive($l_modulemenus);
$idprofile=0;
$loaddata=false;
$checked="";

if(!empty($_GET)){
    if(isset($_GET['param'])){
        $idprofile=$_GET['param'];
        //carga los id de modulos.
       $LoadedProfile= new AccessRol();
       $LoadedProfile->idprofile=$idprofile;
       $_ADOAccessRol->GetProfileAccess($LoadedProfile);
       $_ADOAccessRol->GetModulesId($LoadedProfile);
       $_ADOAccessRol->GetMenusId($LoadedProfile);
       //echo count($LoadedProfile->ListIdMenus->array);
    }
}else{
    echo '<script type="text/javascript">document.location.href="AccessManagement.php"</script>';
}
?>

<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<title>Administracion de Accesos</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include ("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Administracion de Accesos

        </span>
        <span class="lead">
            <p>Selecciona Los modulos y menus para el perfil <strong><?php echo $LoadedProfile->profile?></strong></p>
        </span>
    </div>
    <div class="d-flex justify-content-center">
        <form id="form_110" class="text-left"  method="post" action="<?php echo $pagepost;?>">
               <ul>
               <?php

               foreach ($l_modulemenus->array as $item) {
                   $result=false;
                   foreach($LoadedProfile->ListIdModules->array as $i){
                        //echo $i."=".$idModule.'<br/>';
                        if($i==$item->idmodulo){
                            $result=true;
                        }
                    }


                   if($result){
                       $checked='checked="true"';
                   }else{
                       $checked="";
                   }
                   ?>
                   <li class="border-bottom p-2">
                       <p class="h6">Modulo </p>
                       <input id="module" name="module_<?php echo $item->idmodulo;?>" type="checkbox" value="<?php echo $item->idmodulo;?>" <?php echo $checked;?> /> <?php echo $item->etiqueta?>
                       <p class="h6 mt-3">Submenus </p>
                      <?php
                        $item->getMenus();
                        if(count($item->ListofMenuObj->array)>0){
                            echo '<ul>';
                            foreach($item->ListofMenuObj->array as $menus){
                                $r=false;
                                foreach ($LoadedProfile->ListIdMenus->array as $it){
                                    if($it==$menus->idmenu){
                                        $r=true;
                                    }
                                }

                                if($r){
                                    $checked='checked="true"';
                                }else{
                                    $checked="";
                                }

                                echo "<li>";
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;<input id=\"menu\" name=\"menu_$menus->idmenu\" type=\"checkbox\" value=\"$menus->idmenu\"  $checked/> $menus->etiqueta";
                                echo "</li>";

                            }
                            echo '</ul>';
                        }

                       ?>
                       <p>&nbsp;</p>
                   </li>
                   <?php
               }
               ?>
               </ul>
               <div class="m-4">
                   <input type="hidden" name="idprofile" value="<?php echo $idprofile;?>">
                   <input class="btn btn-success btn-block " type="submit" name="GuardaPerfilDefault" value="Guardar">
               </div>
           </form>
    </div>
</div>
<!-- End content -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>