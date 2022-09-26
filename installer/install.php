<?php

use Com\Notifications\EmailNotification;

require '../vendor/autoload.php';

include ('include/configurations/system/systemconfig.class.php');
 include ('include/common/ArrayList.php');

 error_reporting(0);

 $ListArrayValues= new ListArray();
 $errorChecklist1=false;
 $errorChecklist2=false;
 $errorChecklist3=false;
 $errorChecklist4=false;
 $errorChecklist5=false;
 $CheckList1Class="text-muted";
 $CheckList2Class="text-muted";
 $CheckList3Class="text-muted";
 $CheckList4Class="text-muted";
 $CheckList5Class="text-muted";
 $continueProcess=true;

 // Revisa si los valores estan por POST
 try {
    $ListArrayValues= GetPostedValues();
 } catch (\Throwable $th) {
     throw $th;
 }

 //Checklist
 //1. revisa la conexion de la base de datos con datos enviados.
 try {
     //Revisa si la info capurada de la base de datos se puede conectar.
     TestDataBase($ListArrayValues);
     $CheckList1Class="text-success";
 } catch (\Throwable $th) {
     throw $th;
     $errorChecklist1=true;
     $CheckList1Class="text-danger h5";
     $continueProcess=false;
 }

 //1.2 revisa si esta bien la configuracion de correo
 try {
     TestEmail($ListArrayValues->array);
 } catch (\Throwable $th) {
    throw $th;
    $errorChecklist1=true;
    $CheckList1Class="text-danger h5";
    $continueProcess=false;
 }

 //2. Crea archivo de Config.php
 if($continueProcess){
    try {
        $systemconfig= new systemConfig($ListArrayValues->array[1],
                                        $ListArrayValues->array[2],
                                        $ListArrayValues->array[3],
                                        $ListArrayValues->array[0]);
        $systemconfig->setSMTPInfo($ListArrayValues->array[4],$ListArrayValues->array[5],$ListArrayValues->array[6],$ListArrayValues->array[7],$ListArrayValues->array[8]);
        $systemconfig->loadTemplate();
        $systemconfig->SetConfigurationVars();
        $systemconfig->CreateConfigFile();
        $CheckList2Class="text-success";
    } catch (\Throwable $th) {
        $errorChecklist2=true;
        $CheckList2Class="text-danger h5";
        $continueProcess=false;
        echo $th;
    }
 }

//3.Creacion de esquema de base de datos
 if($continueProcess){
    include ("classLoader.php");
    try {
        $config= new Config();
        $SchemaLoader = new SchemaLoader($config->database);
        $SchemaLoader->LoadSchema();
        $CheckList3Class="text-success";
    } catch (\Throwable $th) {
        $errorChecklist3=true;
        $CheckList3Class="text-danger h5";
        $continueProcess=false;
        echo $th;
    }
 }

 //4.Creacion de Tablas
 if($continueProcess){
    try {
        $TableLoader = new TableLoader();
        $TableLoader->LoadTables();
        $CheckList4Class="text-success";
    } catch (\Throwable $th) {
        $errorChecklist4=true;
        $CheckList4Class="text-danger h5";
        $continueProcess=false;
        echo $th;
    }
 }

 //5.Carga de datos predeterminados
 if($continueProcess){
    try {
        $DefaultsLoader = new DefaultsLoader();
        $DefaultsLoader->LoadDefaults();
        $CheckList5Class="text-success";
    } catch (\Throwable $th) {
        $errorChecklist5=true;
        $CheckList5Class="text-danger h5";
        $continueProcess=false;
        echo $th;
    }
 }


 function TestDataBase(ListArray $ListArrayValues){
    try {
        $conn= new mysqli($ListArrayValues->array[0], $ListArrayValues->array[1],  $ListArrayValues->array[2]);
        if($conn->connect_error){
           throw new Exception( mysqli_connect_error());
        }
        $conn->close();
    } catch (\Throwable $th) {
        throw $th;
    }
 }

 function TestEmail(array $ListArrayValues){

    if ($ListArrayValues[4] == "smtp.host.com") {
        return false;
    }

    try {
        $emailTest =  new EmailNotification();
        $emailTest->setHost($ListArrayValues[4]);
        $emailTest->setPort($ListArrayValues[5]);
        $emailTest->setUser($ListArrayValues[6]);
        $emailTest->setPassword($ListArrayValues[7]);
        $emailTest->setFrom($ListArrayValues[8]);
        $emailTest->setAddresses([$ListArrayValues[8]]);
        $emailTest->setSubject("Email de prueba de Sistema de turnos");
        $emailTest->setHtmlBody("Email de prueba de la configuracion del correo");
        $emailTest->send();
    } catch (\Throwable $th) {
        throw $th;
    }

 }

 function GetPostedValues(){
    $ListArrayValues= new ListArray();
     if(!isset($_POST)){
       throw new Exception("page not posted");
     }

     if(!isset($_POST['dbserver']) || !isset($_POST['dbsuser']) || !isset($_POST['dbpassword']) || !isset($_POST['dbschema']) ){
         throw new Exception("missing values for configuration");
     }

     $smtphost= (isset($_POST['smtphost'])) ? $_POST['smtphost'] : "smtp.host.com";
     $smtpport= (isset($_POST['smtpport'])) ? $_POST['smtpport'] : "587";
     $smtpuser= (isset($_POST['smtpuser'])) ? $_POST['smtpuser'] : "user";
     $smtppass= (isset($_POST['smtppass'])) ? $_POST['smtppass'] : "pass";
     $smtpemail = (isset($_POST['smtpemail'])) ? $_POST['smtpemail'] : "info@server.com";

     $ListArrayValues->addItem($_POST['dbserver']);
     $ListArrayValues->addItem($_POST['dbsuser']);
     $ListArrayValues->addItem($_POST['dbpassword']);
     $ListArrayValues->addItem($_POST['dbschema']);
     $ListArrayValues->addItem($smtphost); // 4
     $ListArrayValues->addItem($smtpport);
     $ListArrayValues->addItem($smtpuser);
     $ListArrayValues->addItem($smtppass);
     $ListArrayValues->addItem($smtpemail);
     return $ListArrayValues;
 }

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Agenda electonica instalador</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
        <div class="display-2 mb-4">Processo de Instalaci&oacute;n</div>
        <div class="d-flex justify-content-center">
            <div class="lead text-left">
                <ol>
                    <li class="<?php echo $CheckList1Class; ?> m-3">
                         <strong> Revisi&oacute;n de conectividad con la base de datos.</strong>
                        <?php if($errorChecklist1){?>
                        <div class="m-2 text-danger">
                            <small>- Error al conectarse a la base de datos. verifique la informaci&oacute;n</small>
                        </div>
                        <?php }?>
                    </li>
                    <li class="<?php echo $CheckList2Class; ?> m-3">
                        <strong>Creaci&oacute;n de Archivo Config.php</strong>
                        <?php if($errorChecklist2){?>
                        <div class="m-2 text-danger">
                            <small>- El arhcivo de configuraci&oacute;n Config.php ya existe dentro de la aplicaci&oacute;n </small>
                        </div>
                        <?php }?>
                    </li>
                    <li class="<?php echo $CheckList3Class?> m-3">
                        <strong>Creaci&oacute;n de Esquema de Base de Datos</strong>
                    </li>
                    <?php if($errorChecklist3){?>
                        <div class="m-2 text-danger">
                            <small>- Error al crear esquema de base de datos, revise los privilegios de usuario. </small>
                        </div>
                    <?php }?>
                    <li class="<?php echo $CheckList4Class?> m-3">
                        <strong>Creaci&oacute;n de Tablas</strong>
                        <?php if($errorChecklist4){?>
                        <div class="m-2 text-danger">
                            <small>- Error al crear tablas. </small>
                        </div>
                        <?php }?>
                    </li>
                    <li class="<?php echo $CheckList5Class?> m-3">
                        <strong>Creaci&oacute;n de informaci&oacute;n predeterminada</strong>
                        <?php if($errorChecklist5){?>
                        <div class="m-2 text-danger">
                            <small>- Error al cargar datos predeterminados. </small>
                        </div>
                        <?php }?>
                    </li>
                </ol>
            </div>
        </div>
        <?php if($continueProcess){?>
        <div>
            <span class="h4 text-success">Instalaci&oacute;n existosa.</span>
        </div>
        <?php } ?>
        <div class="mt-3">
            <?php if(!$continueProcess){?>
            <button type="button" class="btn btn-primary btn-lg" id="btn_back">Regresar</button>
            <?php } ?>
            <?php if($continueProcess){?>
            <button type="button" class="btn btn-success btn-lg" id="btn_continue">Continuar</button>
            <?php } ?>
        </div>
    </div>
    <script>
        $("#btn_back").click(function(){
            document.location.href="index.php";
        });
        $("#btn_continue").click(function(){
            document.location.href="../index.php";
        });
    </script>
  </body>
</html>
