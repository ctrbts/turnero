<?php
    include ("topInclude.php");
    //Carga Clase de control de vistas.
    // Revisar la ruta de donde se encuentra las vistas
    $HtmlViewsController = new HtmlViewsController("../../views/");

    $debug=false;
    $redirectpage=false;
    //$dia;
    //$horario;

    //Lista de valores insertados para mostrar enpagina sin consultar Base de Datos
    $ListaValores= new ArrayList();

    if(!empty($_POST)){
       if(!empty($_POST['day'])){
           $dia=$_POST['day'];
       }

       if(!empty($_POST['horario'])){
           $horario=$_POST['horario'];
           $v=  explode("|", $horario);
           $horario_inicio=$v[0];
           $horario_fin=$v[1];
       }

       if(!isset($_SESSION['CitaPend'])){
           $_SESSION['CitaPend']=$dia."|".$horario_inicio;
           //echo $_SESSION['CitaPend'];
       }

       //Revisa si tenemos campos de formas
       foreach($_POST as $key=>$item){
           //busca si existe campos con el caracter "_"
           $searchfield= strpos($key,"_");

           if($searchfield!==false){
               //formatea el valor para obterner la llave del campo
               $splitvalue=  explode("_", $key);
               //obtiene el ultimo valor y lo valida
               if(is_numeric($splitvalue[count($splitvalue)-1])){
                   $idformacampo=$splitvalue[count($splitvalue)-1];

                   if($item!==""){
                       //obtiene el objeto de CampoObj
                       $campo = new CamposFormaObj();
                       $campo->idcampoforma=$idformacampo;
                       $ADOCampoForma = new ADOCamposForma();
                       $ADOCampoForma->GetCampo($campo);



                       //crea nuevo objeto ValorCampoFormaObj para guardar la informacion.
                       $ValorCampo = new ValorCampoFormaObj();
                       $ValorCampo->idforma=$campo->idforma;
                       $ValorCampo->idcampoforma=$campo->idcampoforma;
                       $ValorCampo->valor=$item;

                       $campo->CampoValoresObj=$ValorCampo;

                       //Guarda en memoria los valores para mostrarlos en memoria
                       $ListaValores->addItem($campo);
                   }
                   if($debug){
                    echo '<br/>Variable: '. $key .' Valor: '. $item .' id: '. $splitvalue[count($splitvalue)-1] .'<br/>';
                   }
               }
           }

       }
       //Guarda el Valor en Memoria para guardarlo al confirmar la cita
       $_SESSION['$ListCamposyValores']=  serialize($ListaValores);

    }else{
        if(isset($_SESSION['CitaPend'])){
            $v=  explode("|", $_SESSION['CitaPend']);
            $dia=$v[0];
            $horario_inicio=$v[1];
            $horario_fin=$v[2];
        }else{
            $redirectpage=true;
        }
    }

 $UserLogged= new UserObj();
 if(isset($_SESSION['UserObj'])){
     $UserLogged=  unserialize($_SESSION['UserObj']);
     if($UserLogged->iduser<=0){
          $redirectpage=true;
     }
 }else{
     $redirectpage=true;
 }

$Show_login=true;
if(isset($_SESSION['Show_login'])){
    $Show_login=$_SESSION['Show_login'];
}

if($debug){
    var_dump($horario_inicio);
   if(isset($dia) && isset($horario_inicio)){
    echo date('d/m/Y',$dia) . " - Horarios : " . $horario_inicio."<br/>";
    }
}

$title_month=date('F',$dia);
switch ($title_month){
    case "January" : $title_month="Enero"; break;
    case "February" : $title_month="Febrero"; break;
    case "March" : $title_month="Marzo";        break;
    case "April" : $title_month="Abril";        break;
    case "May" : $title_month="Mayo";        break;
    case "June" : $title_month="Junio";        break;
    case "July" : $title_month="Julio";        break;
    case "August" : $title_month="Agosto";        break;
    case "September" : $title_month="Septiembre";        break;
    case "October" : $title_month="Octubre";        break;
    case "November" : $title_month="Noviembre";        break;
    case "December" : $title_month="Diciembre";        break;
}

$title_day=date('D',$dia);
switch ($title_day){
    case 'Mon': $title_day="Lunes";        break;
    case 'Tue': $title_day="Martes";        break;
    case 'Wed': $title_day="Miercoles";        break;
    case 'Thu': $title_day="Jueves";        break;
    case 'Fri': $title_day="Viernes";        break;
    case 'Sat': $title_day="Sabado";        break;
    case 'Sun': $title_day="Domingo";        break;
}

if($redirectpage){
    echo '<script type="text/javascript">document.location.href="../../index.php"</script>';
}

?>
<!-- Encabezado HTML -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
<!-- Titulo de pagina web -->
    <title>Confirmar Turno</title>
<!-- Seccion para agregar personalizacion de css,js y demas -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include ("../../inModuleMenu.php"); ?>
<!-- Contenido -->
<div class="bg bg-white border border-dark">
    <div class="mt-3 mb-3">
        <span class="display-4">Confirmar Turno</span>
    </div>
    <div class="mt-2 mb-3">
        <span class="h4">Desea Confirmar la Turno?</span>
    </div>
    <div>
        <form id="form_110" class=""  method="post" action="SaveCita.php">
            <div class="m-1 p1">
                <span class="h4">D&iacute;a:</span><br/>
                <span class="h4 text-danger"><?php echo $title_day." ".date('d',$dia) . " de ". $title_month." ".  date('Y',$dia);?></span>
            </div>
            <div class="m-3 p1">
                <span class="h4">Horario :</span><br/>
                <span class="h4 text-danger"><?php echo $horario_inicio; ?> - <?php echo $horario_fin; ?></span>
            </div>
            <div class="m-3 p1">
                <span class="h4">Nombre :</span><br/>
                <span class="h4 text-danger"><?php echo $UserLogged->nombre." ".$UserLogged->apellidos;?></span>
            </div>
            <div class="m-3 p1">
                <span class="h4">Correo el&eacute;ctronico:</span><br/>
                <span class="h4 text-danger"><?php echo $UserLogged->email;?></span>
            </div>

            <h2>Informacion de Formas:</h2>
                       <ul>
                           <?php
                                foreach($ListaValores->array as $itemcampo){

                           ?>
                           <li>
                               <?php echo $itemcampo->nombre ;?> : <?php echo $itemcampo->CampoValoresObj->valor ;?>
                           </li>
                           <?php
                                }
                           ?>
                       </ul>
               <div style="text-align: center; padding-top: 15px;">
                   <input type="hidden" name="dia" value="<?php echo $dia;?>">
                   <input type="hidden" name="hr_inicio" value="<?php echo $horario_inicio;?>">
                   <input type="hidden" name="hr_fin" value="<?php echo $horario_fin;?>">
                   <input type="hidden" name="param" value="<?php echo $UserLogged->iduser;?>">
                  <div class="row mt-3 mb-4">
                      <div class="col-lg text-right">
                          <button class="btn btn-danger btn-lg"  style="width:200px;"
                                  type="button" name="Cancelar" onclick="cancelar(); return false;" >Cancelar</button>
                      </div>
                      <div class="col-lg text-left">
                            <button class="btn btn-success btn-lg" style="width:200px;"
                                  type="button" name="GuardaCita" onclick="createcita(); return false;" >Guardar</button>
                      </div>
                  </div>
               </div>
        </form>
    </div>
</div>
        <script type="text/javascript">
            function cancelar(){
                document.location.href="clearPendingCita.php";
            }
            function createcita(){
                document.getElementById('form_110').submit();
            }
        </script>
<!-- Fin de contenido -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>