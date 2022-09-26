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

        if(isset($_GET['ck'])){
            $cid= base64_decode($_GET['ck']);
        }

    }
    if ($_form_state==0){
        $_post_page="addField.php";
    }

    if($_form_state==1){

        $_post_page="UpdateField.php";

        //Load Data from database
        $Campo = new CamposFormaObj();
        $Campo->idcampoforma=$cid;
        $ADOCampoForma = new ADOCamposForma();
        $ADOCampoForma->GetCampo($Campo);
        $showdata=true;

    }

    //Carga los tipos de datos activos
    $ListTipoCampo = new ArrayList();
    $ADOTipoCampo = new ADOTipoCampo();
    $ADOTipoCampo->GetTiposCamposActivos($ListTipoCampo);



?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Agregar Nuevo Campo para Forma</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Contenido -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Agregar Nuevo Campo para Forma
        </span>
        <div class="mt-3 mb-3">
            <span class="lead">
                <p>Para agregar un nuevo campo al formulario, llene el siguiente formulario</p>
            </span>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div>
            <form id="form_1103158" class="appnitro"  method="post" action="<?php echo $_post_page?>">
                <div class="form-group">
                    <label class="form-label" for="txt_nombre">Nombre</label>
                    <input class="form-control text-center" type="text" name="nombre" id="txt_nombre" value="<?php if($showdata) echo $Campo->nombre;?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label" for="txt_valor">Valor</label>
                    <input class="form-control text-center" id="txt_valor" type="text" name="valorpordefecto" value="<?php if($showdata) echo $Campo->valorpordefecto;?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label" for="cmb_field">Tipo de Campo</label>
                    <select name="idtipocampo" class="form-control text-center" id="cmb_field">
                        <?php foreach ($ListTipoCampo->array as $item){?>
                        <option  value="<?php echo $item->idtiposcampo;?>" <?php if($item->idtiposcampo==$Campo->idtipocampo) echo 'selected'; ?>  ><?php echo $item->tipo;?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="chk_active" type="checkbox" name="activo" value="1" style="font-size: large" <?php if($Campo->activo==EActivate::Activo) echo 'checked=true';?> />
                    <label class="form-check-label" for="chk_active">Activo</label>
                </div>
                <div class="mt-3 mb-4">
                    <input id="idforma" name="idforma" type="hidden" value="<?php echo base64_encode($id);?>"/>
                    <input name="idcampoforma" type="hidden" value="<?php if($showdata) echo base64_encode($cid);?>" />
                    <input class="btn btn-primary btn-block" id="saveForm" class="button_text" type="submit" name="submit" value="Guardar" />
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>