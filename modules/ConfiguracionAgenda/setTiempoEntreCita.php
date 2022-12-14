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
$debug=false;
$TiempoCita= new ReglasTiempoEntreCita();

if(!empty($_POST)){
    if(!empty($_POST['tiempodecita'])){
        $TiempoCita->valor=$_POST['tiempodecita'];
        if($debug){
            echo '</br>';
            echo $TiempoCita->valor;
        }
       $_ADOReglasCitas = new ADOReglasCitas();
        $_ADOReglasCitas->debug=$debug;
        try{
            
            $_ADOReglasCitas->DeleteTiempoEntreCita($TiempoCita);
            if($debug){
               echo '</br>'; 
            }
            $_ADOReglasCitas->AddTiempoEntreCita($TiempoCita);
            if($debug){
               echo '</br>';
               echo 'Record Added';
            }
        } catch (Exception $ex) {
            if($debug){
                echo '</br>';
                echo $ex->getMessage();
            }

        }
        
    }
}

if(!$debug){
    $commonfuncions->RedirectPage("AgendaConfManager.php#TiempoEstimado");

    }
 