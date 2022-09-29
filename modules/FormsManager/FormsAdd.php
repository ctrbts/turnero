<?php
    include ("topInclude.php");
    //Carga Clase de control de vistas.
    $HtmlViewsController = new HtmlViewsController("../../views/");

    $show_data=false;
    $_form_state=0;
    $_post_page="";

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
        $_post_page="addForm.php";
    }

    if($_form_state==1){
        $_post_page="updateForm.php";
        $_ADOFOrmas= new ADOFormas();
        //$_ADOFOrmas->debug=true;
        $FormaObj= new FormasObj();
        $FormaObj->idforma=$id;
        $_ADOFOrmas->GetForma($FormaObj);

        $show_data=true;

        $visiblecheked="";
        if ($FormaObj->visible=="1") {
            $visiblecheked="checked";
        }

        $seleccionchecked="";
        if($FormaObj->seleccion=="1"){
         $seleccionchecked="checked";
        }

        $activochecked="";
        if($FormaObj->activo=="1"){
            $activochecked="checked";
        }

    }
?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Agregar nuevo formulario</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Contenido -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Agregar nuevo formulario
        </span>
        <span class="lead">
            <p>
                Inserte o modifique la informaci&oacute;n principal del formulario.
            </p>
        </span>
    </div>
    <div class="d-flex justify-content-center text-left">
        <div>
            <form id="form_1103158" class="appnitro"  method="post" action="<?php echo $_post_page;?>">
                <div class="form-group">
                    <label class="form-label" for="element_2">Descripcion de Formulario </label>
                    <input id="element_2" name="descripcion" class="form-control" type="text" maxlength="255"
                           value="<?php if($show_data) echo $FormaObj->descripcion;?>" />
                </div>
                <div>
                    <span>Mostrar Formulario como:</span>
                    <div>
                        <br/>
                        <input type="radio" name="opcion_formulario" value="visible" <?php if($_form_state==0) echo 'checked';?><?php if($show_data) echo $visiblecheked;?> />&nbsp;Visible
                       <br/>
                        <input type="radio" name="opcion_formulario" value="seleccion" <?php if($show_data) echo $seleccionchecked;?>/>&nbsp;Selecci&oacute;n
                    </div>
                </div>
                <div class="form-check mt-4">
                    <input class="form-check-input" id="element_2" type="checkbox" name="activo" value="1" <?php if($show_data) echo $activochecked;?> />
                    <label class="form-check-label" for="element_2">Activar </label>
                </div>
                <div class="mt-4 mb-4">
                    <input id="idforma" name="idforma" type="hidden" value="<?php if($show_data) echo base64_encode($id);?>"/>
                    <input id="saveForm" class="btn btn-primary btn-block" type="submit" name="submit" value="Guardar" />
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>