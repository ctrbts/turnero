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

use Com\Notifications\EmailNotification;

include 'topInclude.php';

$commonfuncions = new CommonFunctions();
$debug = false;
$redirectpage = "../../messageboard.php?messageid=4";

if (isset($_SESSION['UserObjNoActive'])) {
    $UserNotActive = new UserObj();
    $UserNotActive =  unserialize($_SESSION['UserObjNoActive']);
    if (!empty($UserNotActive->email)) {

        $messg = GetMessageTemplate($UserNotActive->email, $UserNotActive->activationtoken);
        if ($debug) {
            echo '<br/>';
            echo $messg;
        }
        try {
            $emailNotification = new EmailNotification();
            $emailNotification->setAddresses([$UserNotActive->email])->setSubject("Activacion de Cuenta en Sistema De Agenda web");
            $emailNotification->setHtmlBody($messg);
            $emailNotification->send();
        } catch (Exception $ex) {
            if ($debug) {
                echo $ex->getMessage();
            }
        }
    }
}

if (!$debug) {
    $commonfuncions->RedirectPage($redirectpage);
}

function GetMessageTemplate($email, $token)
{
    $template = fopen("activationemailtemplate.txt", "r") or die("Unable to open the file");
    $message = "";
    while (!feof($template)) {
        $linea =  fgets($template);
        $message .= $linea;
    }
    fclose($template);
    $ServerConfig = new Config();
    $serverpath = $ServerConfig->domain . "/" . $ServerConfig->pathServer;
    $message = str_replace("@email", $email, $message);
    $message = str_replace("@token", $token, $message);
    $message = str_replace("@serverpath", $serverpath, $message);

    return $message;
}
