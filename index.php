<?php

include("topInclude.php");

$Show_login = true;
if (isset($_SESSION['Show_login'])) {
    $Show_login = $_SESSION['Show_login'];
}

//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("views/");
?>

<?php $HtmlViewsController->IncludeViews(array("HtmlTopHeader", "HtmlHeader")); ?>
<title>Agenda electronica y control de turnos.</title>
<?php $HtmlViewsController->IncludeViews(array("HtmlBody")); ?>

<?php include("inModuleMenu.php"); ?>
<?php
if ($Show_login) {
    include 'loginControl.php';
} else {

    include "UserCitasControl.php";
}

?>

<?php $HtmlViewsController->IncludeViews(array("HtmlFooter", "HtmlBottomFooter")); ?>