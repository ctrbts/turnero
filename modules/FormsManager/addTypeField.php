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
    if(isset($_POST["descripcion"]) && isset($_POST["tipo"]) && isset($_POST["html"]) ){
        $descripcion=$_POST["descripcion"];
        $tipo=$_POST["tipo"];
        $html=$_POST["html"];
        if (isset($_POST["seleccionmultiple"])){
            $seleccionmultiple=$_POST["seleccionmultiple"];
        }

        if(isset($_POST["activo"])){
            $activo=$_POST["activo"];
        }

        $TipoCampoObj = new TipoCampoObj();
        $TipoCampoObj->descripcion=$descripcion;
        $TipoCampoObj->tipo=$tipo;
        $TipoCampoObj->htmlcode=$html;
        if(isset($_POST["seleccionmultiple"])){
            $TipoCampoObj->selmultiple=$seleccionmultiple;
        }
        if(isset($_POST["activo"])){
            $TipoCampoObj->activo=$activo;
        }

        if($debug){
            echo '<br />';
            var_dump($TipoCampoObj);
            echo '<br />';
        }

       $ADOTipoCampo= new ADOTipoCampo();
       $ADOTipoCampo->debug=$debug;
       $ADOTipoCampo->InsertTipoCampo($TipoCampoObj);

    }
}

if(!$debug){
   $commonfunctions->RedirectPage("TypeFieldsManager.php");
}
