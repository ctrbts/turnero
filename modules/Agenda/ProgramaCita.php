<?php
include("topInclude.php");
include('CitasCalFunctions.php');
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

$value;

if (!empty($_GET)) {
    if (!empty($_GET['v'])) {
        $value = $_GET['v'];
    }
} else {
    $value =  time();
}

$l =  new ArrayList();
$l = GetNumCitasDis(date("j", $value), date("n", $value), date("Y", $value));
$c = count($l->array);
?>
<?php $HtmlViewsController->IncludeViews(array("HtmlTopHeader", "HtmlHeader")); ?>
<title>Progromar Turno</title>
<?php $HtmlViewsController->IncludeViews(array("HtmlBody")); ?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="display-4">Programa tu Turno</span>
    </div>
    <div>
        <span class="lead">&nbsp;&nbsp;Seleciona el horario disponible que desas agendar tu cita.</span>
    </div>
    <div class="mt-2">
        <form id="form_110" class="" method="post" action="RegistraFormas.php">
            <input type="hidden" name="day" value="<?php echo $value; ?>">
            <div>
                <ul>
                    <?php
                    $index = 0;
                    foreach ($l->array as $item) {
                        // echo "<li>";
                        $value = $item->getHrInicio() . "|" . $item->getHrFin();
                        // echo "<input type=\"radio\" name=\"horario\" value=\"$value\">".$item->getHrInicio() . " - " . $item->getHrFin()."<br />";
                        // echo "</li>";
                    ?>
                        <li>
                            <input type="radio" name="horario" value="<?php echo $value ?>" id="horario_<?php echo $index ?>" />
                            <label for="horario_<?php echo $index ?>"><?php echo $item->getHrInicio() . " - " . $item->getHrFin() ?></label>
                        </li>
                    <?php
                        $index++;
                    }
                    ?>
                </ul>
                <div class="mt-3 mb-4">
                    <button type="submit" class="btn btn-success btn-lg">Siguiente</button>
                </div>
            </div>

        </form>
    </div>
</div>
<!-- End content -->
<?php $HtmlViewsController->IncludeViews(array("HtmlFooter", "HtmlBottomFooter")); ?>