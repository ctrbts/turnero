<?php
    include ("topInclude.php");
    //Carga Clase de control de vistas.
    $HtmlViewsController = new HtmlViewsController("../../views/");
    $commonfuncions = new CommonFunctions();

    //Carga los datos del formulario
    $ADOSystemConf = new ADOSystemConf();

    //Info de logo acutual
    $LogoConf = new SystemConfObj();
    $LogoConf->variable="LogoImageFile";

    $ADOSystemConf->GetVariableByName($LogoConf);

    //Info del titulo
    $TitleConf = new SystemConfObj();
    $TitleConf->variable="PublicMainHeader";

    $ADOSystemConf->GetVariableByName($TitleConf);

?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Modulos del sistema</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Contenido -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Configuraci&oacute;n de Logotipo y Encabezado
        </span>
        <span class="lead">
            <p>Agrega una imagen y titulo en el encabezado del sitio web.</p>
        </span>
    </div>
    <div class="d-flex justify-content-center mt-3 mb-3 p-2">
        <form id="form_1104636" class=""  method="post" action="addLogoConfig.php" enctype="multipart/form-data">
        <?php if(empty($LogoConf->idvariable)){ ?>
        <div class="form-group">
            <label class="" for="file_select">Selecione el logotipo a configurar. este debe tener un tama&ntilde;o maximo de 3MB.</label>
            <input class="form-control-file" id="file_select" name="fichero_usuario" type="file" accept="image/x-png,image/gif,image/jpeg" />
        </div>
        <?php } ?>
        <div class="pt-3 pb-3">
            <div class="form-group">
                <label class="form-label" for="txt_encabezado"> Puede Selecionar un encabezado para todas la paginas:</label>
                <input class="form-control form-control-lg" type="text" id="txt_encabezado" name="encabezado" <?php if(!empty($TitleConf->idvariable)){ echo 'value="'.$TitleConf->valor.'"';}?> />
            </div>
        </div>
        <div>
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <button class="btn btn-success btn-lg"  >Guardar Configracion</button>
        </div>
        </form>
    </div>
    <?php if(!empty($LogoConf->idvariable)){ ?>
    <div class="d-flex justify-content-center mt-3 mb-3 p-2">
        <div class="card" style="width: 18rem;">
            <img src="../../images/<?php echo $LogoConf->valor;?>" class="card-img-top" />
            <div class="card-body">
                <p class="card-text lead"> Logotipo Actual </p>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col">
            <button class="btn btn-danger btn-lg" id="" onclick="RemoveLogo('<?php echo base64_encode($LogoConf->variable)?>');" style="font-size:Large;" type="button">Remover Imagen</button>
        </div>
    </div>
    <?php } ?>
</div>
    <script type="text/javascript">
        function RemoveLogo(valor){

           document.location.href="deleteConf.php?k=" + valor;
        }
    </script>
<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>
