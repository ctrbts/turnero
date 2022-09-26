<?php
include ("topInclude.php");
 //Carga Clase de control de vistas.
 $HtmlViewsController = new HtmlViewsController("../../views/");

//load hrs
$l_hrs =  new ArrayList();
$_ADOReglasCitas = new ADOReglasCitas();
$_ADOReglasCitas->getHorarios($l_hrs);

//load dias disp
$l_dias = new ArrayList();
$_ADOReglasCitas->getDiasDisp($l_dias);

$htmlcheckedtrue=' checked="true "';
$chk_lunes=false;
$chk_martes=false;
$chk_miercoles=false;
$chk_jueves=false;
$chk_viernes=false;
$chk_sabado=false;
$chk_domingo=false;

foreach($l_dias->array as $item){
    switch ($item->dia){
        case "lunes":
            $chk_lunes=true;
            break;
        case "martes":
            $chk_martes=true;
            break;
        case "miercoles":
            $chk_miercoles=true;
            break;
        case "jueves":
            $chk_jueves=true;
            break;
        case "viernes":
            $chk_viernes=true;
            break;
        case "sabado":
            $chk_sabado=true;
            break;
        case "domingo":
            $chk_domingo=true;
            break;
    }
}

// load select of years in dias de asueto
$ano= date("Y");
if(!empty($_POST)){
    if(!empty($_POST['Viewyear'])){
        $ano=$_POST['ano'];
    }
}
$anos=array();
for($i=2;$i>=0;$i--){
    $r=$ano-$i;
    $anos[]=$r;

}
for($e=1;$e<=5;$e++){
    $r=$ano+$e;
    $anos[]=$r;

}

// load table of dias de asueto
$l_diasasueto = new ArrayList();
$_ADOReglasCitas->getDiasAsuetoByYear($l_diasasueto,$ano);
//Convert days to spanish
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

//load Tiempo Estimado de cita
$TiempoEstimado= new ReglasTiempoEstimado();
$_ADOReglasCitas->GetTiempoEstimado($TiempoEstimado);


//Load tiempo Estimado entre cita
$TiempoEntreCita= new ReglasTiempoEntreCita();
$_ADOReglasCitas->GetTiempoEntreCita($TiempoEntreCita);

?>
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
    <title>Configuracion de Agenda</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include ("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="">
    <div class="mt-3 mb-5">
        <span class="lead" style="font-size:42px;">
            Configuracion de disponibilidad de agenda
        </span>
        <span class="lead">
            <p>Configura las opciones para la disponibilidad de la agenda a usuarios</p>
        </span>
    </div>
<!-- Configuracion de Horarios -->
    <div class="d-flex justify-content-center mb-3">
        <form id="form_110" class="appnitro"  method="post" action="addReglaHrs.php">
            <h3>Horarios disponibles para citas</h3>
            <div>
                <label class="" for="">Horas</label>
                <input id="element_1" name="hrsinicio" class="element text xsmall" type="text" maxlength="5" value="" /> :
                <input id="element_2" name="hrsfin" class="element text xsmall" type="text" maxlength="5" value="" />
                <input  id="saveForm" class="btn btn-primary btn-sm" type="submit" name="submit" value="Guardar" />
            </div>
            <div class="mt-3">
                <table class="table table-hover table-sm">
                    <tr>
                        <th>Horario</th>
                        <th colspan="2">Opciones</th>
                    </tr>

                    <?php
                        foreach ($l_hrs->array as $item){
                            echo "<tr>";
                            echo "<td>$item->hr_inicio - $item->hr_fin</td>";
                            echo "<td><a class=\"btn btn-primary btn-sm\" href=\"ModificarHorario.php?idhrs=$item->idhrs\"> Modificar</a></td>";
                            echo "<td><a class=\"btn btn-danger btn-sm\" href=\"deletemessageboard.php?option=deletehrs&fieldvalue=$item->idhrs\"> Borrar</a> </td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
        </form>
    </div>
<!-- Configuracion de dias habiles -->
    <div class="table-responsive">
    <div class="d-flex justify-content-center">
        <form id="form_111" class=""  method="post" action="updateDiasDisp.php">
            <h3>Dias h&aacute;biles para citas</h3>
            <label class="description" for="element_2">Dias  </label>
                <table class="table" >
                    <tr>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miercoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sabado</th>
                        <th>Domingo</th>
                    </tr>
                        <tr>
                            <td class="text-center"><input id="element_2_1" name="lunes" class="" type="checkbox" value="1" <?php if($chk_lunes) echo $htmlcheckedtrue;?> /></td>
                            <td><input id="element_2_1" name="martes" class="" type="checkbox" value="1" <?php if($chk_martes) echo $htmlcheckedtrue;?>/></td>
                            <td><input id="element_2_1" name="miercoles" class="" type="checkbox" value="1" <?php if($chk_miercoles) echo $htmlcheckedtrue;?>/></td>
                            <td><input id="element_2_1" name="jueves" class="" type="checkbox" value="1" <?php if($chk_jueves) echo $htmlcheckedtrue;?>/></td>
                            <td><input id="element_2_1" name="viernes" class="" type="checkbox" value="1" <?php if($chk_viernes) echo $htmlcheckedtrue;?>/></td>
                            <td><input id="element_2_1" name="sabado" class="" type="checkbox" value="1" <?php if($chk_sabado) echo $htmlcheckedtrue;?>/></td>
                            <td><input id="element_2_1" name="domingo" class="" type="checkbox" value="1" <?php if($chk_domingo) echo $htmlcheckedtrue;?>/></td>
                        </tr>
                </table>
            <div class="mt-2 mb-4">
                <input id="saveForm" class="btn btn-success btn-lg" type="submit" name="submit" value="Guardar" />
            </div>
        </form>
    </div>
    </div>
<!-- Configuracion de dias de asueto -->
    <div class="d-flex justify-content-center">
        <form id="form_112_1" class="appnitro"  method="post" action="AgendaConfManager.php">
            <h3>Dias feriados y de asueto</h3>
            <a name="DiasAsueto" id="DiasAsueto"></a>
            <label class="description" for="element_2">Dias que no habra citas</label>
            <p></p>
            Año:
            <select name="ano">
                <?php
                    foreach($anos as $i){
                        if($i==$ano){
                            echo "<<option selected>$i</option>>";
                        }else{
                            echo "<<option>$i</option>>";
                        }
                    }
                    ?>
                </select>
            <input id="saveForm" class="btn btn-primary btn-sm" type="submit" name="Viewyear" value="Ver" />
        </form>
    </div>
    <div class="d-flex justify-content-center">
    <form id="form_112" class=""  method="post" action="addReglaDiaAsueto.php">
        <div>
            Fecha:
            <input id="element_1" name="fechaasueto" class="element text small" type="text" maxlength="10" value="" />
            <input id="saveForm" class="button_text" type="submit" name="submit" value="Guardar" />
        </div>
        <div class="mt-3 mb-3">
            <table class="table">
                <tr>
                    <th>Fecha</th>
                    <th colspan="2">Opciones</th>
                </tr>
                    <?php
                         foreach($l_diasasueto->array as $item){
                            echo "<tr>";
                            echo "<td>$item->dia</td>";
                            echo "<td><a class=\"btn btn-danger btn-sm\" href=\"deletemessageboard.php?option=deleteasuetodia&fieldvalue=$item->iddiaasueto\">Borar</a></td>";
                            echo "<td></td>";
                            echo "</tr>";
                        }
                    ?>
            </table>
        </div>
    </form>
    </div>
<!-- Configuracion de tiempo estimado de atencion -->
    <div class="mt-3 mb-3">
        <form id="form_113" class=""  method="post" action="setTiempoEstimado.php">
            <h3>Tiempo estimado de atencion de citas</h3>
            <a id="TiempoEstimado" name="TiempoEstimado"></a>
            Tiempo:
            <input id="element_1" name="tiempodecita" class="pl-2" type="text" maxlength="2" value="<?php echo $TiempoEstimado->valor;?>" style="width:40px;" />
            Minutos. &nbsp;&nbsp;&nbsp;&nbsp;
            <input id="saveForm" class="btn btn-success btn-sm" type="submit" name="submit" value="Guardar" />

        </form>
    </div>
<!-- Configuracion entre Citas -->
    <div class="mt-3 mb-5">
        <form id="form_113" class=""  method="post" action="setTiempoEntreCita.php">
            <h3>Tiempo entre citas</h3>
            Tiempo:
            <input id="element_1" name="tiempodecita" class="pl-2" type="text" maxlength="2" value="<?php echo $TiempoEntreCita->valor;?>" style="width:40px;" />
            Minutos. &nbsp;&nbsp;&nbsp;&nbsp;
            <input id="saveForm" class="btn btn-success btn-sm" type="submit" name="submit" value="Guardar" />
        </form>
    </div>
</div>
<!-- End content -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>
