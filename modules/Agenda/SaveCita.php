<?php

/*
 * Copyright (C) 2016 Fernando Merlo
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

use Com\Notifications\EmailNotification;

include 'topInclude.php';
$commonfuncions= new CommonFunctions();
$config = new Config();
$debug=false;


$savecita=false;
$redirectpage="../../messageboard.php?messageid=10";
$linkdevercita=$config->domain."/". $config->pathServer ."/modules/CitasManager/viewCita.php?param=";
$_linktoprint=$config->domain."/". $config->pathServer ."/modules/CitasManager/PrintCita.php?k=";
if(!empty($_POST)){
    if(isset($_POST['dia']) && isset($_POST['hr_inicio']) && isset($_POST['hr_fin']) && isset($_POST['param'])){
        $newCita = new CitasObj();
        $fecha=$_POST['dia'];
        if($debug){
            echo date("d/m/Y",$fecha)."<br />";
        }
        $newCita->dia=  date("d",$fecha);
        $newCita->mes= date("m",$fecha);
        $newCita->anio= date("Y",$fecha);
        $newCita->setHrInicio($_POST['hr_inicio']);
        $newCita->setHrFin($_POST['hr_fin']);
        $newCita->iduser=(int)$_POST['param'];
        $newCita->UserObj= unserialize( $_SESSION['UserObj']);

        $_ADOCitas = new ADOCitas();
        $_ADOCitas->debug=$debug;
        $_ADOCitas->getCita($newCita);

        //Configuramos ADO para insertar valores de Campos
        $ADOValoresForma = new ADOValoresForma();
        $ADOFormas = new ADOFormas();

        if($debug){
            echo '<br/ ><br/ >';
        }
        if($newCita->idcita==0){
            if($debug){
                echo $newCita->dia . "/".$newCita->mes."/".$newCita->anio." horario: ".$newCita->getHrInicio()." - ".$newCita->getHrFin() . " user id: " . $newCita->iduser."<br/>";
                echo '<br/ ><br/ >';
            }
            $savecita=true;
        }else{
            $redirectpage="../../messageboard.php?messageid=9";
        }

        if($savecita){
            // guarda la cita en la base de datos.
           $_ADOCitas->InsertCita($newCita);

            //Guarda los datos del formulario de la cita
            //1. volvemos a obtener la cita para obtener el id
            $_ADOCitas->getCita($newCita);
            //2. Carga los campos que se alojaron en memoria
            $ListCampos = unserialize($_SESSION['$ListCamposyValores']);

            //3. Configura el campo de idcita en cada valor
            // tambien configura el valor de idforma para agregarlo a la relacion cita-forma
            $idforma_sel= 0;
            $idformas= new ArrayList();
            foreach($ListCampos->array as $item){
                $item->CampoValoresObj->idcita=$newCita->idcita;
                if($idforma_sel<>$item->idforma){
                    $idforma_sel=$item->idforma;
                    $idformas->addItem($idforma_sel);
                }
                //4. Insertamos los valores en la base de datos.
                $ADOValoresForma->InsertValor($item->CampoValoresObj);
            }

            //5. Guarda la relacion de la cita y formulario
            foreach($idformas->array as $formaitem){
                $ADOFormas->InsertRelCitaForma($newCita->idcita, $formaitem);
            }

           if($debug){
               echo '<br/ ><br/ >';
               //var_dump($ListCampos);
           }
            //Envia el correo al usuario de confirmacion de cita
            $linkdevercita=$linkdevercita.base64_encode($newCita->idcita);
            $_linktoprint=$_linktoprint.base64_encode($newCita->idcita);
            $mensaje=  GetMessageTemplate($newCita->UserObj,$newCita,$linkdevercita,$_linktoprint);

            if($debug){
                echo '<br/ ><br/ >';
                echo $mensaje;
            }

            try{

                $emailNotification = new EmailNotification();
                $emailNotification->setAddresses([$newCita->UserObj->email])->setSubject("Nueva cita agendada");
                $emailNotification->setHtmlBody($mensaje);
                $emailNotification->send();

            } catch (Exception $ex) {
                if($debug){
                    echo $ex->getMessage();
                }
            }
        }


    }
}

function GetMessageTemplate($UserObj,$CitaObj,$link,$linkprint=NULL){
    $template= fopen("citaconfirmationtemplate.txt", "r")or die("Unable to open the file");
    $message="";
        while(!feof($template)){
            $linea=  fgets($template);
            $message .=$linea;
        }
    fclose($template);

    $f_dia = mktime(0, 0,0,$CitaObj->mes,$CitaObj->dia,$CitaObj->anio);
    $title_month=date('F',$f_dia);
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

$title_day=date('D',$f_dia);
switch ($title_day){
    case 'Mon': $title_day="Lunes";        break;
    case 'Tue': $title_day="Martes";        break;
    case 'Wed': $title_day="Miercoles";        break;
    case 'Thu': $title_day="Jueves";        break;
    case 'Fri': $title_day="Viernes";        break;
    case 'Sat': $title_day="Sabado";        break;
    case 'Sun': $title_day="Domingo";        break;
}
$tile_fecha=$title_day." ".date('d',$f_dia) . " de ". $title_month." ".  date('Y',$f_dia);

    $horarios=$CitaObj->getHrInicio()." a " .$CitaObj->getHrFin();

    $message= str_replace("@email",$UserObj->email, $message);
    $message= str_replace("@nombre",$UserObj->nombre, $message);
    $message= str_replace("@idcita",$CitaObj->idcita, $message);
    $message= str_replace("@dia",$tile_fecha, $message);
    $message= str_replace("@horarios",$horarios, $message);
    $message= str_replace("@link",$link, $message);

    if(!empty($linkprint)){
       $message= str_replace("@print",$linkprint, $message);
    }


    return $message;
}

if(!$debug){
    $commonfuncions->RedirectPage($redirectpage);
    unset($_SESSION['$ListCamposyValores']);
}
