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
include 'topInclude.php';
$commonfuncions= new CommonFunctions();
$debug=false;
$redirectpage="AccessManagement.php";

$l_modules = new ArrayList();
$l_menus= new ArrayList();

if(!empty($_POST)){
    foreach($_POST as $name => $item){
        if(strstr($name,'module_')){
            if($debug){
                echo '<br/>';
                echo "$name value= $item";
            }
            $l_modules->addItem($item);
        }
        if(strstr($name, 'menu_')){
            if($debug){
                echo '<br/>';
                echo "$name value= $item";
            }
            $l_menus->addItem($item);
        }
    }
    $idprofile=(int)$_POST['idprofile'];

    $_ADOAccessRol = new ADOAccessRol();
    $_ADOAccessRol->debug=$debug;
    try{
        $_ADOAccessRol->InsertAccessModules($l_modules, $idprofile);
        if($debug){
            echo '<br/>';
            echo "Records added";
        }
        $_ADOAccessRol->InsertAccessMenus($l_menus, $idprofile);
        if($debug){
            echo '<br/>';
            echo "Records added";
        }
    } catch (Exception $ex) {
        if($debug){
            echo '<br/>';
            echo $ex->getMessage();
        }
    }
}

if(!$debug){
    $commonfuncions->RedirectPage($redirectpage);

}
