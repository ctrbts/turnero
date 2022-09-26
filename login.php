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

include("topInclude.php");

$redirect = true;
$redirectpage = "index.php";
$countFailedAttempts = (isset($_SESSION["failedattempts"])) ? $_SESSION["failedattempts"] : 0;
$commonfuncions = new CommonFunctions();

if (!empty($_POST)) {
    if (!empty($_POST['email']) && !empty($_POST['contrasena'])) {
        // if($_POST['captcha']==$_SESSION['captcha']['code']){
        //echo "entro<br />";

        if ($countFailedAttempts >= 3) {
            if (!empty($_POST['captcha'])) {
                if ($_POST['captcha'] != $_SESSION['captcha']['code']) {
                    $_SESSION["failedattempts"] = $countFailedAttempts + 1;
                    $commonfuncions->RedirectPage($redirectpage);
                } else {
                    $_SESSION["failedattempts"] = 0;
                }
            } else {
                $_SESSION["failedattempts"] = $countFailedAttempts + 1;
                $commonfuncions->RedirectPage($redirectpage);
            }
        }

        $log_user = new UserObj();
        $log_user->email = $_POST['email'];
        $log_user->password = $_POST['contrasena'];

        try {
            $_ADOUsers = new ADOUser();
            //$_ADOUsers->debug=true;
            $_ADOUsers->LoginUser($log_user);
            //echo "<br />";
            //echo $log_user->nombre."<br/>";
            if ($log_user->iduser > 0 || $log_user->iduser == -7) {
                if ($log_user->active == 1) {
                    $_SESSION['UserObj'] = serialize($log_user);
                    $_SESSION['Show_login'] = false;
                    $redirect = true;
                    if (isset($_SESSION['CitaPend'])) {
                        $redirectpage = "./modules/Agenda/RegistrarCita.php";
                    }
                } elseif ($log_user->active == 0) {
                    $_SESSION['UserObjNoActive'] = serialize($log_user);
                    $_SESSION['Show_login'] = true;
                    $redirect = true;
                    $redirectpage = "messageboard.php?messageid=1";
                }
            } else {
                $_SESSION["failedattempts"] = $countFailedAttempts + 1;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }

        // }
    } else {
        $_SESSION["failedattempts"] = $countFailedAttempts + 1;
    }
}

if ($redirect) {
    $commonfuncions->RedirectPage($redirectpage);
}
