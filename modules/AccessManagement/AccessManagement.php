
<?php
include 'topInclude.php';
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");
$_ADOAccessRol= new ADOAccessRol();

// carga los perfiles de la base de datos
$l_Profiles = new ArrayList();
$_ADOAccessRol->getActiveAccessProfiles($l_Profiles);
$DefaultProfile = new AccessRol();
$_ADOAccessRol->GetDefaultProfileAccess($DefaultProfile);
//echo $DefaultProfile->idprofile;
?>
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
    <title>Administracion de Accesos</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include ("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Administraci&oacute;n de Accesos
        </span>
        <span class="lead">
            <p>Asigna permisos a modulos y menus del sistema a un grupo de usuarios</p>
        </span>
    </div>
    <div class="m-4">
        <a class="btn btn-primary" href="NewAccessProfile.php">Agregar Nuevo Perfil</a>
    </div>
    <div class="d-flex justify-content-center">
        <form id="form_110" class="appnitro"  method="post" action="UpdateDefaultProfile.php" >
            <div class="form-group row text-left">
                <label for="defaultProfile" class="form-label col-lg align-self-center">Perfil de nuevos Usuarios:</label>
                <select class="form-control col-lg align-self-center" name="SetDefualtProfile">
                  <?php
                     if(count($l_Profiles->array)>0){
                       foreach ($l_Profiles->array as $item){
                           $checked="";
                           if($DefaultProfile->idprofile==$item->idprofile){
                                $checked='selected="true"';
                           }
                           echo "<option value=\"$item->idprofile\" $checked>$item->profile</option>";
                       }
                     }
                  ?>
               </select>
            </div>
            <div>
                <input class="btn btn-success" type="submit" name="GuardaPerfilDefault" value="Guardar">
            </div>
        </form>
    </div>
    <div class="table-responsive d-flex justify-content-center p-2">
        <table class="table table-bordered" style="width:40%;">
                   <tr>
                       <th scope="col">Perfiles</th>
                       <th colspan="3" scope="col">Opciones</th>
                   </tr>
                   <?php
                        //muestra tabla de permisos
                        if(count($l_Profiles->array)>0){
                            foreach ($l_Profiles->array as $item){
                                echo '<tr>';
                                echo "<td>$item->profile</td>";
                                echo "<td><a class=\"btn btn-primary btn-sm\" href=\"NewAccessProfile.php?param=$item->idprofile\">Modificar</a></td>";
                                echo "<td><a class=\"btn btn-primary btn-sm\" href=\"AssingModulesToProfile.php?param=$item->idprofile\">Asignar Permisos</a></td>";
                                echo "<td></td>";
                                echo '</tr>';
                            }
                        }
                   ?>
        </table>
    </div>
</div>

    <?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>
