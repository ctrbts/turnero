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

$commonfuncions = new CommonFunctions();
$newuser = new UserObj();
$debug = false;
$redirectpage = "./modules/UserActivation/SendActivationMail.php";

if (!empty($_POST)) {
    $newuser->email = $_POST['email'];
    $newuser->nombre = $_POST['nombre'];
    $newuser->apellidos = $_POST['apellidos'];
    $newuser->password = $_POST['contrasena'];
    $newuser->active = 0;
    $newuser->generateToken();

    $_ADOUser = new ADOUser();
    $_ADOUser->debug = $debug;

    //carga el perfil selecionado por default para todos los nuevos usuarios
    $DefaultProfile = new AccessRol();
    $_ADOUser->GetDefaultProfileAccess($DefaultProfile);
    $newuser->ProfileObj = $DefaultProfile;

    if ($debug) {
        echo "<br />";
        echo "perfil default : " . $newuser->ProfileObj->idprofile;
    }

    try {
        $_ADOUser->AddNewUser($newuser);
        if ($debug) {
            echo "<br />";
            echo "Record added";
        }
        $_SESSION['UserObjNoActive'] =  serialize($newuser);
        //send email
    } catch (Exception $ex) {
        if ($debug) {
            echo "<br />";
            echo $ex->getMessage();
        }
    }

    if ($debug) {
        echo "<br />";
        echo $newuser->email;
        echo "<br />";
        echo $newuser->nombre;
        echo "<br />";
        echo $newuser->apellidos;
        echo "<br />";
        echo $newuser->password;
        echo "<br />";
        echo $newuser->activationtoken;
    }
}

if (!$debug) {
    $commonfuncions->RedirectPage($redirectpage);
}
