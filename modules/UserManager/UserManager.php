<?php
include 'topInclude.php';
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

//carga usuarios
$_ADOUser = new ADOUser();
$l_users = new ArrayList();
$_ADOUser->getAllRegisteredUsers($l_users);

$l_Profiles = new ArrayList();
$_ADOAccessRol = new ADOAccessRol();
$_ADOAccessRol->getActiveAccessProfiles($l_Profiles);


//se implementa paginado
$actualpage = 1;
//obtiene el total de registros por pagina
$recordbypages = 7;
if (isset($_GET["page"])) {
    if (is_numeric($_GET["page"])) {
        $actualpage = $_GET["page"];
    }
}
// Crea paginado de la lista de usuarios obtenida
$HtmlPaging = new PagingController($recordbypages);
$ListUsers = new ArrayList();
$ListUsers->array = $HtmlPaging->GetRecordsPaging($actualpage, $l_users)->array;
$totalofpages = $HtmlPaging->totalPages;

?>
<?php $HtmlViewsController->IncludeViews(array("HtmlTopHeader", "HtmlHeader")); ?>
<title>Administracion de Usuarios y Pacientes Registrados</title>
<?php $HtmlViewsController->IncludeViews(array("HtmlBody")); ?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <h2>
        Administracion de Usuarios y Pacientes Registrados
        </h2>
        <span class="lead">
            <p>Muestra los usuarios y pacientes registrados en el sistema de turnos.</p>
        </span>
    </div>
    <div class="table-responsive mt-3 p-2">
        <form id="form_110" class="" method="post" action="UpdateDefaultProfile.php">
            <table id="TableUsers" class="table table-sm">
                <tr>
                    <th>Usuario</th>
                    <th>E-Mail</th>
                    <th>Estado</th>
                    <th>Perfil</th>
                    <th colspan="3">Opciones</th>
                </tr>
                <?php
                foreach ($ListUsers->array as $item) {
                    $item->GetProfile();
                    $s_activo = "No Activo";
                    $buttonlabel = "Activar";
                    if ($item->active == 1) {
                        $s_activo = "Activo";
                        $buttonlabel = "Desactivar";
                    }
                    $s_profile = $item->ProfileObj->profile;
                    $i_idprofile = $item->ProfileObj->idprofile;

                    echo "<tr>";
                    echo "<td>$item->nombre&nbsp;$item->apellidos</td>";
                    echo "<td>$item->email</td>";
                    echo "<td>$s_activo</td>";
                    echo "<td>";
                    echo "<select class=\"form-control\" id=\"SelectRolOp_$item->iduser\">";
                    foreach ($l_Profiles->array as $i) {

                        $selected = "";
                        if ($i->idprofile == $i_idprofile) {
                            $selected = "selected=\"true\"";
                        }

                        echo "<option value=\"$i->idprofile\" $selected >$i->profile</option>";
                    }
                    echo '</select>';
                    echo "</td>";
                    echo "<td>";
                    echo "<input type=\"hidden\" id=\"iduser_$item->iduser\" value=\"$item->iduser\">";
                    echo "<input type=\"hidden\" id=\"activationtoken_$item->iduser\" value=\"$item->activationtoken\">";
                    echo "<input type=\"hidden\" id=\"email_$item->iduser\" value=\"$item->email\">";
                    echo "</td>";
                    if ($item->active == EActivate::Activo) {
                        echo "<td><input class=\"btn btn-danger\" type=\"button\" id=\"button_$item->iduser\" value=\"$buttonlabel\" /></td>";
                    }
                    if ($item->active == EActivate::Inactivo) {
                        echo "<td><input class=\"btn btn-success\" type=\"button\" id=\"button_$item->iduser\" value=\"$buttonlabel\" /></td>";
                    }
                    echo "<td></td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <?php include('../../htmlcontrols/HtmlPagingControl.class.php') ?>
        </form>
    </div>
</div>
<script type="text/javascript" src="../../js/general.js"></script>
<!-- End content -->
<?php $HtmlViewsController->IncludeViews(array("HtmlFooter", "HtmlBottomFooter")); ?>