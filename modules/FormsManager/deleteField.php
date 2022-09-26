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


$debug=false;
if(isset($_GET)){
 
    include ("topInclude.php");
   
    
    $commonfunctions = new CommonFunctions();
    
    
    if(isset($_GET['k']) && isset($_GET['pk']) ){
        $id= base64_decode($_GET['k']);
        $pid= base64_decode($_GET['pk']);
        
        $Campo= new CamposFormaObj();
        $Campo->idcampoforma=$id;
         
        if ($debug){
            echo var_dump($Campo);
            echo "</br>";
        }
       
        $ADOCampoForma = new ADOCamposForma();
        $ADOCampoForma->debug=$debug;
        
        try {
            
           //TODO : Delete Campos,Valores
           $deleted=$ADOCampoForma->DeleteCampo($Campo);
           
           if(!$deleted){
               $messageError="El registro no se borro dado a que existe informacion usando este mismo.<br>Revise el manual para informacion";
               $redirecpage="FormConfig.php?k=".  base64_encode($pid);
               $errorpage="ErrorMessage.php?m=" . base64_encode($messageError) . "&rp=". base64_encode($redirecpage)."";
               if(!$debug){
                $commonfunctions->RedirectPage($errorpage);
               }
           }else{
               if(!$debug){
                    $commonfunctions->RedirectPage("FormConfig.php?k=".  base64_encode($pid));
                }
           }
           
           
        } catch (Exception $ex) {
            if($debug){
                echo $ex;
            }
        }
    }
    
    
}


?>