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

//include ('topInclude.php');
date_default_timezone_set("America/Argentina/Buenos_Aires");

function GetNumCitasDis($dia,$mes,$anio){
    $l_citas = new ArrayList;
    $_Reglacita = new Reglascitas();
    $_Reglacita->debug=true;
    $valid_day= false;

    //converti a dia las variables $dia, $mes y $anio
    $f_s=  mktime(23,59,59,$mes,$dia,$anio);
    $e=date('l',$f_s);
    $t_dia=TranslateDay($e);

    //Valida el dia en la base de datos
    $l_dias= new ArrayList();
    $l_dias = $_Reglacita->getListDiasDisp();
    foreach ($l_dias->array as $items){

        if($items->dia==$t_dia){
            $valid_day=true;
        }
    }

    //valida si el dia es asueto
    $l_diasasueto = new ArrayList();
    $l_diasasueto= $_Reglacita->getListDiasAsueto();
    foreach($l_diasasueto->array as $item){
         $item_date=date('m/d/Y',$item->dia);
         $var_date=date('m/d/Y',$f_s);
         if($item_date==$var_date){
             $valid_day=false;
         }
    }

    //valida que la cita no se programe en el pasado
    //echo date('d/m/Y H:i',time()) ." > ". date('d/m/Y H:i',$f_s) ;
    //;
    //echo date("d/m/Y",$f_s)."<br />";
    //echo time()."<br />";
    if($f_s<time()  ){
        $valid_day=false;
    }

    // obtiene los horarios dispoibles de acuerdo a las horas programadas
    if($valid_day){
        //echo "entroo valida_day";
        $l_horarios= $_Reglacita->getListReglaHorarios();
        //se obtiene el intervalo entre turnos
        $_tiempoestobj =new ReglasTiempoEstimado();
        $_tiempoestobj=  $_Reglacita->getTiempoEstimadoObj();

        $_tiempoentrecitaobj = new ReglasTiempoEntreCita();
        $_tiempoentrecitaobj= $_Reglacita->getTiempoEntrecitaObj();

       $val1=  intval($_tiempoestobj->valor);
       $val2= intval($_tiempoentrecitaobj->valor);

       $resul=$val1+$val2;

       // por cada horario definido realiza el calculo de turnos

        foreach ($l_horarios->array as $item){
            $minutes=get_minutes ( $item->hr_inicio, $item->hr_fin,$resul);
            //echo $minutes[0]."<br/>";
            for($i=0;$i<count($minutes)-1;$i++){
                $addhorario = true;
                $cita = new CitasObj();
                $cita->dia=$dia;
                $cita->mes=$mes;
                $cita->anio=$anio;
                $cita->setHrInicio($minutes[$i]);
                $cita->setHrFin($minutes[$i+1]);
                $valid=SearchCitaOnDB($dia,$mes,$anio,$cita->getHrInicio(),$cita->getHrFin());
                if($valid==1){
                   $addhorario=false;
                }


                $diahoy= $cita->dia."/".$cita->mes;
                //echo $diahoy."-". date('j/n'). "<br />";

                //valida si la fecha es el dia de hoy
                if(date('j/n')==$diahoy){
                    // si la hora actual es mayor a la cita no se agrega el horario
                    if(time()>strtotime($minutes[$i])){
                         $addhorario=false;
                    }
                }

                if($addhorario){
                    $l_citas->addItem($cita);
                }

            }

        }

    }

    return $l_citas;
}

function TranslateDay($dia_str_eng){
    $return_title="";
    switch ($dia_str_eng){
        case "Monday": $return_title="lunes"; break;
        case "Tuesday": $return_title="martes"; break;
        case "Wednesday": $return_title="miercoles"; break;
        case "Thursday": $return_title="jueves"; break;
        case "Friday": $return_title="viernes"; break;
        case "Saturday": $return_title="sabado"; break;
        case "Sunday": $return_title="domingo"; break;
    }
    return $return_title;
}

function get_minutes ( $start, $end , $interval) {

   while ( strtotime($start) <= strtotime($end) ) {
       $minutes[] = date("H:i:s", strtotime( "$start" ) );
       $start = date("H:i:s", strtotime( "$start + {$interval} mins")) ;
   }
   return $minutes;
}

function SearchCitaOnDB($dia,$mes,$anio,$hr_inicio,$hr_fin){
    $result=0;

    if(strlen($dia)==1){
        $dia="0".$dia;
    }
    if(strlen($mes)==1){
        $mes="0".$mes;
    }

    //carga turnos de la base de datos
    $l_citasondb = new ArrayList();
    $_ADOCitas = new ADOCitas();
    $_ADOCitas->getCitasProg($l_citasondb,$dia,$mes,$anio,$hr_inicio,$hr_fin);
    if(count($l_citasondb->array)>0){
        $result=1;
    }
    return $result;
}

/*$l =  new ArrayList();
$l =GetNumCitasDis("22", "02", "2016");
echo count($l->array)."<br />";
foreach($l->array as $item){
    echo $item->dia."/".$item->mes."/".$item->anio." ";
    echo $item->getHrInicio()."-".$item->getHrFin()."<br/>";
}*/