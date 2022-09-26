
<?php
    include ("topInclude.php");
    //Carga Clase de control de vistas.
    $HtmlViewsController = new HtmlViewsController("../../views/");

    $_form_state=0;
    $showdata=false;

    if(isset($_GET)){
        if(isset($_GET['k'])){
            $id= base64_decode($_GET['k']);
        }
        if(isset($_GET["s"])){
            $status=$_GET["s"];
            if($status=="1"){
                $_form_state=1;
            }
        }
    }
    if ($_form_state==0){
        $_post_page="addTypeField.php";
    }

    if($_form_state==1){

        $_post_page="UpdateTypeField.php";

        //Load Data from database
        $TipoCampoObjeto= new TipoCampoObj();
        $TipoCampoObjeto->idtiposcampo=$id;
        $ADOTipoCampo= new ADOTipoCampo();
        $ADOTipoCampo->GetTipoCampo($TipoCampoObjeto);

        $showdata=true;
        $chkSeleccionMultiple ="";
        $chkActivo="";

        if($TipoCampoObjeto->selmultiple=="1"){
            $chkSeleccionMultiple="checked";
        }

        if($TipoCampoObjeto->activo=="1"){
            $chkActivo="checked";
        }
        //var_dump($TipoCampoObjeto->htmlcode);
    }
?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Agregar Nuevo Tipo de Dato</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Contenido -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Agregar o Modificar Tipo de Dato
        </span>
        <span class="lead">
            <p>
                LLene los datos solicitados para agregar un nuevo tipo de dato
            </p>
        </span>
    </div>
    <div class="d-flex justify-content-center">
        <form id="form_1103158" class=""  method="post" action="<?php echo $_post_page?>">
            <div class="form-group">
                <label class="form-label" for="txt_descrpcion">Descripci&oacute;n</label>
                <input type="text" name="descripcion" id="txt_descrpcion" class="form-control text-center"
                        value="<?php if($showdata) echo $TipoCampoObjeto->descripcion;?>" />
            </div>
            <div class="form-group">
                <label class="form-label" for="txt_tipo">Tipo:</label>
                <input type="text" name="tipo" id="txt_tipo" class="form-control text-center"
                        value="<?php if($showdata) echo $TipoCampoObjeto->tipo;?>" />
            </div>
            <div class="form-group">
                <label class="form-label" for="txt_html">Codigo HTML:</label>
                <textarea name="html" id="txt_html" class="form-control" style="height:100px;"><?php if($showdata) echo $TipoCampoObjeto->htmlcode;?></textarea>
                <small>
                    Usar la expression &value para definir donde se desplegara el valor en el codigo HTML y la expression
                    &name para identificar el nombre del control
                    Consulta el manual para mas informacion.
                </small>
            </div>
            <div class="mt-4 mb-4">
                <span class="h4">Opciones</span>
            </div>
            <div class="row">
                <div class="col-lg col-sm-3">
                    <div class="form-check">
                        <input type="checkbox" name="seleccionmultiple" id="chk_selmultiple" clsas="form-check-input"
                                value="1" <?php if($showdata) echo $chkSeleccionMultiple;?> />
                        <label class="form-check-label" for="chk_selmultiple"><strong>Seleccion Multiple</strong> </label>
                    </div>
                </div>
                <div class="col-lg col-sm-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="activo" id="chk_activo" value="1" <?php if($showdata) echo $chkActivo;?> />
                        <label class="form-check-label" for="chk_activo"> <strong>Activo</strong></label>
                    </div>
                </div>
            </div>
            <div class="mt-4 mb-5">
                    <input type="hidden" name="idtiposcampo" value="<?php if($showdata) echo $id;?>" />
                    <input id="saveForm" class="btn btn-primary btn-lg" type="submit" name="submit" value="Guardar" />
            </div>
        </form>
    </div>
</div>
<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>>