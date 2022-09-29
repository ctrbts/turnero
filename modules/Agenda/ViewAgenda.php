<?php
include("topInclude.php");
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

?>
<?php
$fecha = time();
$month = date('m', $fecha);
$year = date('Y', $fecha);
?>
<?php $HtmlViewsController->IncludeViews(array("HtmlTopHeader", "HtmlHeader")); ?>
<title>Turnos disponibles</title>
<?php $HtmlViewsController->IncludeViews(array("HtmlBody")); ?>

<?php include("../../inModuleMenu.php"); ?>

<!-- Content -->
<script type="text/javascript">
    var d = new Date();
    var selected_mes = d.getMonth();
    var selected_year = d.getYear();
</script>

<div>
    <div class="m-3">
        <span class="display-4">Agenda de turnos</span>
    </div>
    <div class="mt-3">
        <span class="lead">Calendario de turnos disponibles</span>
    </div>
    <div class="table-responsive" id="calendar-max">
        <form id="form_110" class="appnitro" method="post" action="addReglaHrs.php">
            <!-- <div>
                <table style="width: 100%" id="controlbuttons">
                    <tr>
                        <td class="text-left p-1"><a class="btn bn-sm btn-success" href="prevmonth">Mes Anterior</a></td>
                        <td class="text-right p-1"><a class="btn bn-sm btn-success" href="nextmonth">Siguiente Mes</a></td>
                    </tr>
                </table>
            </div> -->
            <div id="contentdiv"></div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery-1.12.1.min.js"></script>
<script type="text/javascript" src="../../js/general.js"></script>
<!-- End content -->
<?php $HtmlViewsController->IncludeViews(array("HtmlFooter", "HtmlBottomFooter")); ?>