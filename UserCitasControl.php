<?php
$DateFunctions = new DateFunctions();
$Token = new TokenGenerator();
$TransactinoToken = $Token->Generate();
$_SESSION['TToken'] = $TransactinoToken;
$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if (!empty($_SESSION['UserObj'])) {
    $SessionUser = new UserObj();
    $SessionUser = unserialize($_SESSION['UserObj']);
    //carga las turnos del usuario
    $SessionUser->GetCitas();

    $ListCitasAgendadas = new ArrayList();
    $ListaCitasAtendidas = new ArrayList();
    $ListCitasCanceladas =  new ArrayList();
    $ListaCitasNoAtendidas = new ArrayList();

    foreach ($SessionUser->ListOfCitas->array as $item) {
        $item->getEstatus();
        switch ($item->EstatusCitaObj->idestatus) {
            case 0:
                $ListCitasAgendadas->addItem($item);
                break;
            case 1:
                $ListaCitasAtendidas->addItem($item);
                break;
            case 2:
                $ListCitasCanceladas->addItem($item);
                break;
            case 3:
                $ListaCitasNoAtendidas->addItem($item);
        }
    }

    $SessionUser->GetProfile();

    //variable para mostrar las notas de cita
    $show_controls = false;
    //Obtiene las variables del sistema para validar los perfiles
    $AdminProfileSistema = new SystemConfObj();
    $AdminProfileSistema->variable = "ProfileAdmin";

    $AdminAgendaSistema = new SystemConfObj();
    $AdminAgendaSistema->variable = "ProfileAdminAgenda";

    $CalendarFrame = new SystemConfObj();
    $CalendarFrame->variable = "GoogleMainCalendar";

    $ADOSystemConf = new ADOSystemConf();
    $ADOSystemConf->GetVariableByName($AdminProfileSistema);
    $ADOSystemConf->GetVariableByName($AdminAgendaSistema);
    $ADOSystemConf->GetVariableByName($CalendarFrame);

    //Obtiene las turnos del mes y año actual
    //definde variable para el paginado del control de turnos
    $actualpage = 1;
    //obtiene el total de registros por pagina
    $recordbypages = 7;
    if (isset($_GET["page"])) {
        if (is_numeric($_GET["page"])) {
            $actualpage = $_GET["page"];
        }
    }
    $ADOCitas = new ADOCitas();
    $ListCitas = new ArrayList();
    // $totalofpages=  $ADOCitas->GetCitasByMonth(05,2018,11,$actualpage   ,$ListCitas);
    //obtiene las turnos de la base de datos con paginado
    $totalofpages =  $ADOCitas->GetCitasAll($recordbypages, $actualpage, $ListCitas);

    //Carga usuarios registrados
    $ADOUsers = new ADOUser();
    $ListUsers = new ArrayList();
    $ADOUsers->GetAllRegisteredUsersBy(null, "iduser desc", $ListUsers);
}
?>

<!-- Tablero Publico -->
<?php if ($SessionUser->idprofile == EUserProfile::PublicUser) { ?>
    <div class="container-fluid">
        <div class="pt-5">
            <h2>Sistema de turnos en línea</h2>
            <h5>Hospital Odontológico Universitario</h5>
        </div>
        <div class="p-5">
            <a class="btn btn-lg btn-primary shadow text-white" href="./modules/Agenda/ViewAgenda.php">Solicitar un nuevo turno</a>
        </div>
        <div class="text-left p-5">
            <div class="row">
                <div class="col-lg">
                    <?php
                    if (count($SessionUser->ListOfCitas->array) == 0) {
                        echo '<span class="h5">No se encontraron turnos.</span>';
                    }

                    //Turnos Agendados
                    if (count($ListCitasAgendadas->array) > 0) {
                        echo '<div class="pb-3">';
                        echo '<h3 class="mb-4">Turnos Agendados</h3>';
                        foreach ($ListCitasAgendadas->array as $item) {
                            $hr_inicio = $item->getHrInicio();
                            $hr_fin =   $item->getHrFin();
                            $fechaEtiqueta = $DateFunctions->getSpanishLongDate($item->mes, $item->dia, $item->anio);

                            $_idcita =  base64_encode($item->idcita);

                            echo "<a href=./modules/CitasManager/viewCita.php?param=$_idcita>";
                            echo "Dia: $fechaEtiqueta ";
                            echo "Horario : $hr_inicio - $hr_fin<a/>";
                            echo '<hr />';
                        }
                        echo '</div>';
                    }


                    //Turnos Atendidas
                    if (count($ListaCitasAtendidas->array) > 0) {
                        echo '<div class="pb-3">';
                        echo '<h3>Turnos Atendidas</h3>';
                        $showrows = 5;
                        $index = 0;
                        foreach ($ListaCitasAtendidas->array as $item) {
                            $hr_inicio = $item->getHrInicio();
                            $hr_fin =   $item->getHrFin();
                            $fechaEtiqueta = $DateFunctions->getSpanishLongDate($item->mes, $item->dia, $item->anio);

                            $_idcita =  base64_encode($item->idcita);

                            if ($index <= $showrows) {
                                echo "<a href=./modules/CitasManager/viewCita.php?param=$_idcita>";
                                echo "Dia: $fechaEtiqueta ";
                                echo "Horario : $hr_inicio - $hr_fin<a/>";
                                echo '<hr />';
                            }
                            $index++;
                        }
                        echo '</div>';
                    }


                    //Turnos Cancelados
                    if (count($ListCitasCanceladas->array) > 0) {
                        echo '<div class="pb-3">';
                        echo '<h3>Turnos Cancelados</h3>';
                        $showrows = 5;
                        $index = 0;
                        foreach ($ListCitasCanceladas->array as $item) {
                            $hr_inicio = $item->getHrInicio();
                            $hr_fin =   $item->getHrFin();
                            $fechaEtiqueta = $DateFunctions->getSpanishLongDate($item->mes, $item->dia, $item->anio);

                            $_idcita =  base64_encode($item->idcita);

                            if ($index <= $showrows) {
                                echo "<a href=./modules/CitasManager/viewCita.php?param=$_idcita>";
                                echo "Dia: $fechaEtiqueta ";
                                echo "Horario : $hr_inicio - $hr_fin <a/>";
                                echo '<hr/>';
                            }
                        }
                        echo '</div>';
                    }

                    //Turnos No Atendidas
                    if (count($ListaCitasNoAtendidas->array) > 0) {
                        echo '<div class="pb-3">';
                        echo '<h3>Turnos No Atendidas</h3>';
                        foreach ($ListaCitasNoAtendidas->array as $item) {
                            $hr_inicio = $item->getHrInicio();
                            $hr_fin =   $item->getHrFin();
                            $fechaEtiqueta = $DateFunctions->getSpanishLongDate($item->mes, $item->dia, $item->anio);

                            $_idcita =  base64_encode($item->idcita);

                            echo "<a href=./modules/CitasManager/viewCita.php?param=$_idcita>";
                            echo "Dia: $fechaEtiqueta ";
                            echo "Horario : $hr_inicio - $hr_fin <a/>";
                            echo '<hr/>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>

                <div class="col-md">
                    <span class="display-4">
                        Espacio de publicidad
                    </span>
                    <p class="lead">
                        Es esta seccion puede colocar algun aviso, o alguna recomendacion para el paciente.
                    </p>
                    <video width="100%" controls>
                        <source src="movie.mp4" type="video/mp4">
                        <source src="movie.ogg" type="video/ogg">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Tablero administrador -->
<?php if ($SessionUser->idprofile == EUserProfile::Adminsirtator || $SessionUser->idprofile == EUserProfile::AgendaManager) { ?>
    <div>
        <div class="pt-3">
            <h2>Agenda el&eacute;ctronica</h2>
            <p>&nbsp;Programaci&oacute;n de agenda</p>
        </div>
        <div class="p-3 table-responsive">
            <table class="table table-sm table-hover table-striped table-bordered" id="">
                <tbody>
                    <tr>
                        <th scope="col"># Turno</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Horario</th>
                        <th scope="col">Nombre de Usuario</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Opciones</th>
                    </tr>
                    <!-- Contenido turnos Agendados -->
                    <?php
                    foreach ($ListCitas->array as $cita) {
                        $hr_inicio = $cita->getHrInicio();
                        $hr_fin = $cita->getHrFin();
                        $fechaEtiqueta = $DateFunctions->getSpanishLongDate($cita->mes, $cita->dia, $cita->anio);
                        $cita->getUserObj();
                        $cita->getEstatus();
                        $_idcita =  base64_encode($cita->idcita);

                    ?>
                        <tr>
                            <td><?php echo $cita->idcita ?></td>
                            <td><?php echo $fechaEtiqueta ?></td>
                            <td><?php echo $hr_inicio . " - " . $hr_fin ?></td>
                            <td><?php echo $cita->UserObj->nombre . " " . $cita->UserObj->apellidos ?></td>
                            <td><?php echo $cita->EstatusCitaObj->estado ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary mb-2" id="btn_view_<?php echo  $_idcita ?>">Ver</button>
                                <?php if ($cita->idestatus == EStatusCita::Agendada) { ?>
                                    <button type="button" class="btn btn-sm btn-success mb-2" id="btn_close_<?php echo  $_idcita ?>">Cerrar</button>
                                    <button type="button" class="btn btn-sm btn-danger mb-2" id="btn_cancel_<?php echo  $_idcita ?>">Cancelar</button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <!-- Control de paginado -->
            Paginas
            <?php include('htmlcontrols/HtmlPagingControl.class.php') ?>
        </div>
        <!-- Control de usuarios registrados -->
        <div class="mt-2">
            <div class="row p-3">
                <div class="col">
                    <div>
                        <span class="h4">Ultimos Usuarios Registrados</span>
                    </div>
                    <div class="table-responsive" id="">
                        <table class="table table-sm table-hover table-striped table-bordered" id="">
                            <tbody>
                                <tr>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                                <?php
                                $TotalRecordsUser = (count($ListUsers->array) < 10) ? count($ListUsers->array) : 10;

                                for ($i = 0; $i <= ($TotalRecordsUser - 1); $i++) {
                                    $userObj = new UserObj();
                                    $userObj = $ListUsers->array[$i];
                                ?>
                                    <tr>
                                        <td><?php echo $userObj->nombre . " " . $userObj->apellidos ?></td>
                                        <td><?php echo $userObj->email ?></td>
                                        <td><?php echo ($userObj->active == EActivate::Activo) ? "Activo" : "No Activo" ?></td>
                                        <td>
                                            <?php if ($userObj->active == EActivate::Activo) { ?>
                                                <button type="button" class="btn btn-danger btn-sm" id="btn_deactivate_<?php echo $userObj->email ?>_<?php echo $userObj->activationtoken ?>">Desactivar</button>
                                            <?php } ?>
                                            <?php if ($userObj->active == EActivate::Inactivo) { ?>
                                                <button type="button" class="btn btn-success btn-sm" id="btn_activate_<?php echo $userObj->email ?>_<?php echo $userObj->activationtoken ?>">Activar</button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="4" class="text-right p-3">
                                        <button type="button" class="btn btn-primary btn-sm" id="btn_users_more"> Ver mas.</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Seccion de contadores -->
                <div class="col">
                    <div class="mb-3">
                        <span class="h3">Estadisticas de usuarios</span>
                    </div>
                    <div class="pl-5 text-left">
                        <?php
                        $ADOUsers->debug = false;
                        $TotalRegisteredUSers = $ADOUsers->CountUsersRegisterd(null);
                        $TotalInactiveUsers = $ADOUsers->CountUsersRegisterd("active=0");
                        $TotalCitasActivas = $ADOCitas->CountCitas("idestatus=" . EStatusCita::Agendada);
                        $TotalCitasAtendidas = $ADOCitas->CountCitas("idestatus=" . EStatusCita::Atendida);
                        $TotalCitasCanceladas = $ADOCitas->CountCitas("idestatus=" . EStatusCita::Cancelada);
                        ?>
                        <ul>
                            <li>
                                Total de Usuarios Registrados: <?php echo $TotalRegisteredUSers ?>
                            </li>
                            <li>
                                Total de Usuarios Inactivos: <?php echo $TotalInactiveUsers ?>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <span class="h3">Estadisticas de de Turnos</span>
                    </div>
                    <div class="pl-5 text-left">
                        <ul>
                            <li>
                                Total de Turnos por Atender: <?php echo $TotalCitasActivas ?>
                            </li>
                            <li>
                                Total de Turnos Atendidas: <?php echo $TotalCitasAtendidas ?>
                            </li>
                            <li>
                                Total de Turnos Cancelados: <?php echo $TotalCitasCanceladas ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Cuadros de dialogos -->
<div id="dialog-confirm" title="Mensaje de Sistema">
    <p>¿Desea Cerrar la Turno Selecionada?</p>
</div>
<div id="dialog-cancel" title="Mensaje de Sistema">
    <p>¿Desea Cancelar la Turno Selecionada?</p>
</div>

<script>
    var idselected;
    $("button[id*='btn_view_']").click(function() {
        var id = this.id;
        var values = id.split('_');
        document.location.href = "modules/CitasManager/viewCita.php?param=" + values[2];
    });

    $("button[id*='btn_close_']").click(function() {
        var id = this.id;
        var values = id.split('_');
        idselected = values[2];
        $("#dialog-confirm").dialog("open");
    });

    $("button[id*='btn_cancel_']").click(function() {
        var id = this.id;
        var values = id.split('_');
        idselected = values[2];
        $("#dialog-cancel").dialog("open");
    });

    $("#btn_users_more").click(function() {
        document.location.href = "modules/UserManager/UserManager.php";
    });

    $("button[id*='btn_deactivate_']").click(function() {
        var id = this.id;
        var values = id.split('_');
        document.location.href = "modules/UserActivation/deactivation.php?email=" + values[2] +
            "&param=" + values[3] + "&enableredirect=true&redirectpage=<?php echo $url ?>";
    });
    $("button[id*='btn_activate_']").click(function() {
        var id = this.id;
        var values = id.split('_');
        document.location.href = "modules/UserActivation/activation.php?email=" + values[2] +
            "&param=" + values[3] + "&enableredirect=true&redirectpage=<?php echo $url ?>";
    });

    $(function() {
        $("#dialog-confirm").dialog({
            autoOpen: false,
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Si": function() {
                    document.location.href = "modules/CitasManager/UpdateEstatusCita.php?k=" +
                        idselected + "&estatus=<?php echo EStatusCita::Atendida ?>&token=<?php echo $TransactinoToken ?>&enableredirect=true" +
                        "&redirectpage=<?php echo $url ?>";
                    $(this).dialog("close");
                },
                "No": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#dialog-cancel").dialog({
            autoOpen: false,
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Si": function() {
                    document.location.href = "modules/CitasManager/UpdateEstatusCita.php?k=" +
                        idselected + "&estatus=<?php echo EStatusCita::Cancelada ?>&token=<?php echo $TransactinoToken ?>&enableredirect=true" +
                        "&redirectpage=<?php echo $url ?>";
                    $(this).dialog("close");
                },
                "No": function() {
                    $(this).dialog("close");
                }
            }
        });
    });
</script>