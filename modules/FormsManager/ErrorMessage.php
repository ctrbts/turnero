<?php
    include ("topInclude.php"); 
    //Carga Clase de control de vistas.
    $HtmlViewsController = new HtmlViewsController("../../views/");
    
    $commonfunctions = new CommonFunctions();
    
    if(isset($_GET)){
        if(isset($_GET['m']) && isset($_GET['rp']) ){
            $mensaje=  base64_decode($_GET['m']);
            
            $redirecpage=  base64_decode($_GET['rp']);
        }
    }

?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Mensaje de sistema</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<!-- Contenido -->
       <img id="top" src="../../images/top.png" alt="">
        
       <div id="form_container">
           <h1><a>Mensaje de Sistema</a></h1>
           <form id="form_1103136sdfsdf" class="appnitro"  method="post" action="">
                    
                <div class="form_description">
			<h2>Error en el sistema</h2>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p><?php echo $mensaje?></p>
                        <p>&nbsp;</p>
                        
                        <div>
                            <a href="<?php echo $redirecpage;?>">&nbsp;&nbsp;Regresar</a>
                        </div>
		</div>	
           </form>
       </div>
<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>