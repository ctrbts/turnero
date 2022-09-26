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

if(!empty($_POST)){
    if(!empty($_POST['profile'])){
        $NewProfile = new AccessRol();
        $NewProfile->profile=$_POST['profile'];
        $NewProfile->idprofile=$_POST['idprofile'];
        //$NewProfile->active=1;

        if($debug){
            echo '<br />';
            echo $NewProfile->profile;
        }

        // guarda el perfil
        $_ADOAccessRol = new ADOAccessRol();
        $_ADOAccessRol->debug=$debug;

        try{
            $_ADOAccessRol->UpdateProfile($NewProfile);

            if($debug){
                echo 'Record added;';
            }
        } catch (Exception $ex) {
            if($debug){
                echo $ex->getMessage();
            }
        }
    }
}

if(!$debug){
    $commonfuncions->RedirectPage($redirectpage);
}