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
$redirectpage="../../index.php";

if(!empty($_SESSION['UserObjRecoverPass'])){
    if(isset($_SESSION['UserObjRecoverPass'])){
        if(!empty($_POST)){
            if(!empty($_POST['newpass']) && !empty($_POST['passconfirm'])){
                $newpass=$_POST['newpass'];
                $confirmpass=$_POST['passconfirm'];
                if($newpass==$confirmpass){
                    $UserObjRecoverPass= new UserObj();
                    $UserObjRecoverPass= unserialize($_SESSION['UserObjRecoverPass']);
                    $UserObjRecoverPass->password=$newpass;
                    if($debug){
                        echo '<br/>';
                        echo "Usuario: $UserObjRecoverPass->email pass: $UserObjRecoverPass->password";
                    }
                    $_ADOUsers = new ADOUser();
                    $_ADOUsers->debug=$debug;
                    try{
                        $_ADOUsers->UpdatePassword($UserObjRecoverPass);
                        if($debug){
                            echo '<br/>';
                            echo 'Password Updated';
                        }
                        $redirectpage="../../messageboard.php?messageid=8";
                        unset($_SESSION['UserObjRecoverPass']);
                    } catch (Exception $ex) {
                        if ($debug){
                            echo $ex->getMessage();
                        }

                    }
                }
            }
        }
    }
}
if(!$debug){
    $commonfuncions->RedirectPage($redirectpage);

}