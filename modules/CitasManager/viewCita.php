<?php
    include 'topInclude.php';
    //Carga Clase de control de vistas.
    $HtmlViewsController = new HtmlViewsController("../../views/");
    $Token= new TokenGenerator();
    $TransactinoToken=$Token->Generate();
    $_SESSION['TToken']=$TransactinoToken;

    $_DateFunctions = new DateFunctions();

    //variable para mostrar las notas de cita
    $show_controls=false;

    //Obtiene el usuario en session para ver si puede agregar notas a la cita
    if(isset($_SESSION['UserObj'])){
        $UserLogged= new UserObj();
        $UserLogged= unserialize($_SESSION['UserObj']);
        $UserLogged->GetProfile();

    }


    //Valida que el perfil del usuario sea administrador y administrador de agenda
    if(($UserLogged->ProfileObj->idprofile==EUserProfile::Adminsirtator) || ($UserLogged->ProfileObj->idprofile==EUserProfile::AgendaManager)){
        $show_controls=true;
    }

    //Obtiene los estados de la cita
    $ListofEstadosCita = new ArrayList();
    $ADOCitasEstatus = new ADOCitasEstatus();
    $ADOCitasEstatus->GetEstatus($ListofEstadosCita);


    if(!empty($_GET)){
        if(isset($_GET['param'])){
            $LoadedCita= new CitasObj();
            $LoadedCita->idcita=  base64_decode($_GET['param']);
            $_ADOCitas= new ADOCitas();
            $_ADOCitas->getCitabyID($LoadedCita);
            $daytitle= $_DateFunctions->getSpanishLongDate($LoadedCita->mes, $LoadedCita->dia, $LoadedCita->anio);
            $LoadedCita->getEstatus();
            $EstatusCita=$LoadedCita->EstatusCitaObj->estado;

            //Carga datos de las formas
            $LoadedCita->GetFormas();
            foreach($LoadedCita->FormasCollection->array as $forma){
                $forma->GetCamposDeForma();
            }

            //Carga Usuario que creo la forma
            $LoadedCita->getUserObj();
        }
    }
?>
<?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
        <title>Detalle de Turno</title>
        <style>
            .notas{
                font-size: large;
                width: 100%;
                height:150px;

            }
        </style>

<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include ("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-4">
        <span class="display-4">Turno No. <?php echo $LoadedCita->idcita;?></span>
    </div>
    <?php
        if($show_controls){
    ?>
    <div class="d-flex justify-content-center border-bottom mb-3">
        <form action="updateEstatusCita.php" method="post" name="frm_cita_estatus" id="frmcitaestatus" >
            <div class="form-group">
                <label for="cmb_estatus" class="form-label">Estado de Turno:</label>
                <select name="estatus" id="cmb_estatus" class="form-control" >
                    <option value="0" >Agendada</option>
                    <?php

                            foreach($ListofEstadosCita->array as $estado){
                            $chekedstado="";

                            if($estado->idestatus==$LoadedCita->EstatusCitaObj->idestatus){
                                $chekedstado="selected";
                            }
                    ?>
                    <option value="<?php echo $estado->idestatus;?>" <?php echo $chekedstado;?> ><?php echo $estado->estado;?></option>
                    <?php
                            }
                    ?>
                </select>
                <input type="hidden" name="k" value="<?php echo base64_encode($LoadedCita->idcita);?>" />
            </div>
        </form>
    </div>
    <?php }?>
<!-- Datos de Turno agendada -->
    <div>
        <p class="h5">Infromaci&oacute;n  de la cita</p>
    </div>
    <div class="d-flex justify-content-center text-left p-2 lead">
        <ul>
            <li>Usario :<strong> <?php echo $LoadedCita->UserObj->nombre." ".$LoadedCita->UserObj->apellidos?></strong></li>
            <li>Fecha : <strong><?php echo $daytitle; ?></strong></li>
            <li>Horario : <strong><?php echo $LoadedCita->getHrInicio(). "- ". $LoadedCita->getHrFin() ; ?></strong></li>
            <li>Estado: <strong><?php echo $EstatusCita;?></strong></li>
        </ul>
    </div>
<!-- Datos de formulario dinamico -->
    <div>
               <?php
                    foreach($LoadedCita->FormasCollection->array as $forma){

               ?>
               <h2><?php echo $forma->descripcion;?></h2>
               <div class="d-flex justify-content-center text-left p-2 lead">
                <ul >
                <?php
                            foreach($forma->CamposFormaCollection->array as $campos){
                                $campos->GetValorObj();
                                if(!empty($campos->ValorCampoFormaObj->valor)){
                ?>
                    <li>
                        <label><?php echo $campos->nombre;?></label> : <?php echo $campos->ValorCampoFormaObj->valor ?>
                    </li>
                <?php

                                }
                            }
                ?>
                </ul>
               </div>
               <?php
                    }
               ?>
    </div>
<!-- Notas en cita -->
    <?php
        if($show_controls){
    ?>
    <div class="d-flex justify-content-center">
        <form action="updateNota.php" method="post" name="frm_cita_note" id="frmcitanote" >
            <div class="form-group">
                <label for="notas">Notas:</label><br/>
                <textarea name="cita_nota" class="form-control" id="notas" style="width:320px; height:150px;" ><?php echo $LoadedCita->nota;?></textarea>
                <button class="btn btn-primary btn-block mt-2" type="submit">Guardar Nota</button>
                <input type="hidden" name="k" value="<?php echo base64_encode($LoadedCita->idcita);?>" />
            </div>
        </form>
    </div>
    <?php
        }
    ?>
    <div class="row mt-4 mb-3">
        <div class="col text-right mr-4">
            <button class="btn btn-lg btn-primary text-black" type="button" onclick="openInNewTab();">Imprimir </button>
            <?php if($LoadedCita->EstatusCitaObj->idestatus!=EStatusCita::Cancelada){?>
            <button class="btn btn-lg btn-primary" type="button" id="btn_downloadical_<?php echo base64_encode($LoadedCita->idcita) ?>">Descargar cita</button>
            <?php }?>
        </div>
        <?php if($LoadedCita->EstatusCitaObj->idestatus==EStatusCita::Agendada){ ?>
        <div class="col text-left ml-2">
            <button type="button" class="btn btn-danger btn-lg text-white" name="CancelCita" id="btnCancelCita"> Cancelar Turno</button>
        </div>
        <?php }?>
    </div>
</div>
       <script type="text/javascript">
           $("#btnCancelCita").click(function(){
               document.location.href="CancelCitaMessageboard.php?idcita=<?php echo $LoadedCita->idcita; ?>"
           })
           function openInNewTab() {
            url="PrintCita.php?k=<?php echo base64_encode($LoadedCita->idcita); ?>"
            var win = window.open(url, '_blank');
            win.focus();
          }

          function openGoogleInt() {
            //url="GoogleCalendarInt.php?k=<?php echo base64_encode($LoadedCita->idcita); ?>"
           url="CheckGoogleInt.php?k=<?php echo base64_encode($LoadedCita->idcita); ?>"
            var win = window.open(url, '_blank');
            win.focus();
          }


          $("#cmb_estatus").change(function(){
             document.getElementById("frmcitaestatus").submit();
          });

          $("button[id*='btn_downloadical_']").click(function(){
              var id=this.id;
              var values=id.split('_');
              document.location.href="icalCita.php?token=<?php echo base64_encode($TransactinoToken)?>&c="+values[2]+"&enaberledirect=false";
          });
       </script>
<!-- End content -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>