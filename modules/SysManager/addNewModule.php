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
include ("topInclude.php");
$commonfuncions= new CommonFunctions();
$debug=false;
$newModule = new ModulesMenu();

$newModule->etiqueta=$_POST["etiqueta"];
$newModule->hasmenus=0;
$newModule->activo=1;
$newModule->path= $_POST["path"];
$newModule->accion=$_POST["accion"];

if (debug){
   echo $newModule->etiqueta;
}

try{
    $_ADOModules = new ADOModules();
    $_ADOModules->debug=$debug;
    $_ADOModules->AddModuleToDB($newModule);

    if($debug){
        echo "</br>";
        echo "Record Added";
    }
    $commonfuncions->RedirectPage("ModuleManager.php");


} catch (Exception $ex) {
    if ($debug){
        echo ex;
    }
}



?>