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
$debug=false;
$redirectpage="../../UserProfile.php";
if(!empty($_POST)){
    if(isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['email']) && isset($_POST['token']) ){
        $UserToUpdate = new UserObj();
        $UserToUpdate->email=$_POST['email'];
        $_ADOUser = new ADOUser();
        $_ADOUser->debug=$debug;
        $_ADOUser->ExistEmail($UserToUpdate);

        if($_POST['token']==$UserToUpdate->activationtoken){
           $UserToUpdate->nombre=$_POST['nombre'];
           $UserToUpdate->apellidos=$_POST['apellidos'];
           if(!$UserToUpdate->email=="admin@server.com" || !$UserToUpdate->email=="adminagenda@server.com"){
             $_ADOUser->UpdateUserProfile($UserToUpdate);
           }

           if($debug){
               echo '<br/>Updated User';
           }

           if(isset($_POST['password'])){
               if($_POST['password']!=""){
                $UserToUpdate->password=$_POST['password'];
                if($UserToUpdate->email!="admin@server.com" && !$UserToUpdate->email!="adminagenda@server.com"){
                    $_ADOUser->UpdatePassword($UserToUpdate);
                }
                if($debug){
                     echo '<br/>Updated Password';
                 }
               }
           }
           unset( $_SESSION['UserObj']);
           $_SESSION['UserObj']=serialize( $UserToUpdate);
        }
    }
}

if(!$debug){
    $commonfuncions->RedirectPage($redirectpage);
}