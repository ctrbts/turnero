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
$newmenu =  new MenuObj();

$newmenu->etiqueta=$_POST["etiqueta"];
$newmenu->hasmenus=0;
$newmenu->activo=1;
$newmenu->path= $_POST["path"];
$newmenu->accion=$_POST["accion"];
$newmenu->idmodulo=$_POST['idmodulo'];

if ($debug){
   echo $newmenu->idmodulo;
   echo "</br>";
}

try{
    $_ADOMenus = new ADOMenus();
    $_ADOMenus->debug=$debug;
    $_ADOMenus->AddMenuToModuleDB($newmenu);
    if($debug){
        echo "</br>";
        echo "Record Added";
    }

    if(!$debug){
        $commonfuncions->RedirectPage("MenuManager.php?idmodulo=".$newmenu->idmodulo);

    }

} catch (Exception $ex) {
    if ($debug){
        echo "</br>";
        echo ex;
    }
}