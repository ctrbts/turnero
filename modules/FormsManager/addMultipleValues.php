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


if(!empty($_POST)){
    if(isset($_POST["k"]) && isset($_POST["pk"]) && isset($_SESSION['MultipleValuesSel']) ){
        $idcampoforma=  base64_decode($_POST['k']);
        $idforma = base64_decode($_POST['pk']);

        if(isset($_SESSION['MultipleValuesSel'])){
          $ListMultipleItems= unserialize($_SESSION['MultipleValuesSel']);
        }

        //1.- Carga la informacion del campo ya que necesitamos el tipo
        $CampoForma= new CamposFormaObj();
        $CampoForma->idcampoforma=$idcampoforma;
        $ADOCampoForma= new ADOCamposForma();
        $ADOCampoForma->GetCampo($CampoForma);
        $CampoForma->GetTipoCampo();


        //2.- Prepara los valores a string
        $valor="";
        $fila=1;
        foreach($ListMultipleItems->array as $item){
            if($fila==1){
                $valor= $valor . $item;
            }else{
                $valor= $valor ."|". $item;
            }
            $fila=$fila+1;
        }

        //3. Guarda datos en base de datos
        $multiplevalores = new MultipleValoresObj();
        $multiplevalores->idcampoforma=$CampoForma->idcampoforma;
        $multiplevalores->idcampotipo=$CampoForma->TipoCampoObj->idtiposcampo;
        $multiplevalores->valores=$valor;


        $ADOMultipleValores = new ADOMultipleValores();
        $ADOMultipleValores->debug=$debug;
        $ADOMultipleValores->DeleteMulVal($multiplevalores->idcampoforma);
        $ADOMultipleValores->InsertMultipleValores($multiplevalores);

        //4. limpia array en memoria de los valores
        unset($_SESSION['MultipleValuesSel']);
        unset($ListMultipleItems);

        if(!$debug){
            $commonfunctions->RedirectPage("FormConfig.php?k=".base64_encode($idforma));
        }

        if($debug){
            echo '<br>';
            echo 'info de objeto multiplevalores :<br>';
            var_dump($multiplevalores);
            echo '<br>';
            echo 'info de campo :<br>';
            var_dump($CampoForma);
            echo '<br>';
            echo 'info de valor:<br>';
            echo $valor;
        }
    }
}

?>