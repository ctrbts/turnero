<?php

/* 
 * Copyright (C) 2016 MarcoCantu
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

include ("topInclude.php");
$commonfuncions= new CommonFunctions();
//validacion

$debug=false;
$hrsobj= new ReglaHorarios();
$hrsobj->hr_inicio=$_POST['hrsinicio'];
$hrsobj->hr_fin =$_POST['hrsfin'];

if ($debug){
   echo $hrsobj->hr_inicio; 
   echo "</br>";
}

try{
    
    if($hrsobj->hr_inicio!="" || $hrsobj->hr_fin!=""){
        $_ADOReglaHrs = new ADOReglasCitas();
        $_ADOReglaHrs->debug=$debug;
        $_ADOReglaHrs->AddHorariosToDB($hrsobj);
        if($debug){
            echo "</br>";
            echo "Record Added";
        }
    }else{
        throw new Exception("Valores de hrs invalidos", 23423, null);
    }
   
    
} catch (Exception $ex) {
    if ($debug){
        echo "</br>";
        echo $ex->getMessage();
        
    }
}

 if(!$debug){
        $commonfuncions->RedirectPage("AgendaConfManager.php");
       
    }