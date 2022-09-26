<?php

/*
 * Copyright (C) 2018 Fernando Merlo
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

$commonfunctions = new CommonFunctions();

$debug=false;


echo '<br>';
if(!empty($_POST)){
    if(isset($_POST["nombre"]) && isset($_POST["valorpordefecto"]) && isset($_POST['idtipocampo']) && isset($_POST['idforma']) && isset($_POST['idcampoforma']) ){
        $idforma=  base64_decode($_POST['idforma']);
        $idcampoforma=  base64_decode($_POST['idcampoforma']);
        $nombre = $_POST['nombre'];
        $valorpordefecto= $_POST['valorpordefecto'];
        $idtiposcampo=$_POST['idtipocampo'];
        $activo="0";

        if(isset($_POST['activo'])){
            $activo=$_POST['activo'];
        }

        $newCampo = new CamposFormaObj();
        $newCampo->idcampoforma=$idcampoforma;
        $newCampo->idforma=$idforma;
        $newCampo->idtipocampo=$idtiposcampo;
        $newCampo->nombre= $nombre;
        $newCampo->valorpordefecto=$valorpordefecto;
        $newCampo->activo=$activo;

        if($debug){
            echo '<br>';
            var_dump($newCampo);
            echo '<br>';
        }

        $ADOCampoForma = new ADOCamposForma();
        $ADOCampoForma->debug=$debug;

        $ADOCampoForma->UpdateCampo($newCampo);

    }
}
if(!$debug){
   $commonfunctions->RedirectPage("FormConfig.php?k=".  base64_encode($idforma));
}
?>