<?php
include 'topInclude.php';
//Carga Clase de control de vistas.
// Revisar la ruta de donde se encuentra las vistas
$HtmlViewsController = new HtmlViewsController("../../views/");

//Codigo PHP  

?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Recuperar Contraseña</title>
<!-- Seccion para agregar personalizacion de css,js y demas -->

<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include ("../../inModuleMenu.php"); ?>
<!-- Contenido -->

<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>