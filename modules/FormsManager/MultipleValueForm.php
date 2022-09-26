<?php
    include ("topInclude.php");
    //Carga Clase de control de vistas.
    $HtmlViewsController = new HtmlViewsController("../../views/");
    $redirectpage="MultipleValueForm.php";
    $Token= new TokenGenerator();
    $TransactinoToken=$Token->Generate();
    $_SESSION['TToken']=$TransactinoToken;


      $commonfunctions = new CommonFunctions();
      $ListMultipleItems= new ArrayList();

      if(isset($_SESSION['MultipleValuesSel'])){
          $ListMultipleItems= unserialize($_SESSION['MultipleValuesSel']);
      }

      if(isset($_GET)){
          if(isset($_GET['k']) && isset($_GET['pk'])){
              $id= base64_decode($_GET['k']);
              $pid= base64_decode($_GET['pk']);

              //Revisar y carga si hay info en la base de datos
              $ADOMultipleValores = new ADOMultipleValores();
              $ADOCamposForma = new ADOCamposForma();
              $multiplevalores= new MultipleValoresObj;
              $Campoforma = new CamposFormaObj();

              $Campoforma->idcampoforma=$id;
              $ADOCamposForma->GetCampo($Campoforma);
              $ADOMultipleValores->GetMulValFromCampoForma($id, $multiplevalores);

              if(!empty($multiplevalores->valores)){
                  $valores=  explode("|", $multiplevalores->valores);
                  if(count($valores)>0 ){
                    if(count($ListMultipleItems->array)==0){
                        foreach($valores as $item){
                            $ListMultipleItems->addItem($item);
                        }
                        $_SESSION['MultipleValuesSel']=  serialize($ListMultipleItems);
                    }
                    if(count($ListMultipleItems->array)>count($valores)){
                        foreach($valores as $item){
                            if(!in_array($item,$ListMultipleItems->array)){
                                $ListMultipleItems->addItem($item);
                            }
                        }
                        $_SESSION['MultipleValuesSel']=  serialize($ListMultipleItems);
                    }
                  }
              }

          }
      }


      if(!isset($id) && !isset($pid)){
          $commonfunctions->RedirectPage("FormsManager.php");
      }
?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Administraci&oacute;n de Valores Multiples del Campo</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Contenido -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Administraci&oacute;n de Valores Multiples del Campo
            <br/>
            <strong>
                <?php echo $Campoforma->nombre?>
            </strong>
        </span>
        <div class="mt-3 mb-3">
            <span class="lead">
                <p>Para agregar un nuevo campo al formulario, llene el siguiente formulario</p>
            </span>
        </div>
    </div>
    <div class="mt-3 mb-3">
        <a class="btn btn-primary" href="FormConfig.php?k=<?php echo base64_encode($pid);?>">Regresar a Administraci&oacute;n de Campos</a>
    </div>
    <div class="mt-5">
      <div class="d-flex justify-content-center border">
        <form id="form_1103158" class=""  method="post" action="addMultipleValue.php">
            <input type="hidden" name="k" value="<?php echo base64_encode($id);?>" />
            <input type="hidden" name="pk" value="<?php echo base64_encode($pid);?>" />
            <input type="hidden" name="kmv" value="<?php echo base64_encode($multiplevalores->idcamposelmultiple) ?>">
            <input type="hidden" name="token" value="<?php echo $TransactinoToken?>">
            <!-- <input type="hidden" name="enableredirect" value="false"> -->
            <div class="form-group">
                <label class="form-group" for="valor">Valor a Guardar</label>
                <input class="form-control text-center" type="text" name="valor" id="valor"  />
            </div>
            <div class="mt-3 mb-4">
                <input id="saveForm" class="btn btn-success btn-block" type="submit" name="submit" value="Agregar" />
            </div>
        </form>
      </div>
    </div>
    <div class="">

            <div>
                <span class="h5">Lista de valores</span>
            </div>
            <?php
                foreach ($ListMultipleItems->array as $item){
            ?>
            <form id="" class=""  method="post" action="addMultipleValue.php">
            <div class="mt-3 mb-4">
                <span class="border p-3"><?php echo $item;?></span><span class="border p-3">
                <input class="btn btn-danger ml-3" type="submit" name="submit" value="Borrar" /></span>
                <input  type="hidden" name="index" value="<?php echo array_search($item,$ListMultipleItems->array);?>" />
                <input type="hidden" name="k" value="<?php echo base64_encode($id);?>" />
                <input type="hidden" name="pk" value="<?php echo base64_encode($pid);?>" />
                <input type="hidden" name="kmv" value="<?php echo base64_encode($multiplevalores->idcamposelmultiple) ?>">
                <input type="hidden" name="token" value="<?php echo $TransactinoToken?>">
                <!-- <input type="hidden" name="enableredirect" value="false"> -->
            </div>
            </form>
            <?php
                }
            ?>
    </div>
    </div>
</div>
<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>