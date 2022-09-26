<?php

/* 
 * Copyright (C) 2018 ITLMIV
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

include 'topInclude.php';
$commonfunctions = new CommonFunctions();
$debug=false;
$id="";

if(isset($_POST)){
    if(isset($_POST['k']) && isset($_POST['estatus'])){
        $id=  base64_decode($_POST['k']);
        $estatus=$_POST['estatus'];
        
        $citaobj = new CitasObj();
        $citaobj->idcita=$id;
        $citaobj->idestatus=$estatus;
        
        $ADOCitas = new ADOCitas();
        $ADOCitas->debug=$debug;
        $ADOCitas->UpdateEstatusCita($citaobj);
        
    }
}

if(isset($_GET)){
    if(isset($_GET['k']) && isset($_GET['estatus']) && isset($_GET['token'])){
        $token= $_GET['token'];

        if(isset($_SESSION['TToken'])){
            if($token==$_SESSION['TToken']){
                $id=  base64_decode($_GET['k']);
                $estatus=$_GET['estatus'];
                    
                $citaobj = new CitasObj();
                $citaobj->idcita=$id;
                $citaobj->idestatus=$estatus;
                    
                $ADOCitas = new ADOCitas();
                $ADOCitas->debug=$debug;
                $ADOCitas->UpdateEstatusCita($citaobj);
            }
        }
    }
}
if(isset($_GET['enableredirect'])){
    $enableredirect=$_GET['enableredirect'];
    if($enableredirect=="false"){
        exit;
    }

    if($enableredirect=="true"){
        if(isset($_GET['redirectpage'])){
            $redirectpage=$_GET['redirectpage'];
            $commonfunctions->RedirectPage($redirectpage);
        }else{
            $commonfunctions->RedirectPage("viewCita.php?param=".  base64_encode($id));
        }
    }
    
}else{
    if(!$debug){
        $commonfunctions->RedirectPage("viewCita.php?param=".  base64_encode($id));
    }
}
?>