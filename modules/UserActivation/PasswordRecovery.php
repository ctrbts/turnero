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
$commonfuncions= new CommonFunctions();
$debug=false;
$redirectpage="../../messageboard.php?messageid=6";

if(!empty($_POST)){
    if(!empty($_POST['email'])){
        //valida si el email esta registrado en la base de datos
        $UserRecover = new UserObj();
        $UserRecover->email=$_POST['email'];
        if($debug){
            echo '<br/>';
            echo $UserRecover->email;
        }
        $_ADOUser = new ADOUser();
        $_ADOUser->debug=$debug;
        $_ADOUser->ExistEmail($UserRecover);
        //si el usario existe
        if($UserRecover->iduser>0){
            //Encripta el iduser con su correo para generar liga de reseteo de password
            $idencripted=  md5($UserRecover->iduser.$UserRecover->email);
            if($debug){
               echo '<br/>';
               echo $idencripted;
            }

            //utiliza la funcion para tomar la plantilla del correo en texto plano.
            $mensaje=GetMessageTemplate($idencripted,$UserRecover->email);

            if($debug){
                echo '<br/>';
                echo $mensaje;
            }


            //envia el correo al usuario.
            try{
                $emailNotification =  new EmailNotification();
                $emailNotification->setAddresses([$UserRecover->email])->setSubject("Sistema de Turnos - Reinicio de Contraseña");
                $emailNotification->setHtmlBody($mensaje);
                $emailNotification->send();

            } catch (Exception $ex) {
                if($debug){
                    echo $ex->getMessage();
                }
            }


            //$_SESSION['UserRecoverPassObj']=  serialize($UserRecover);
            //$redirectpage="SendPasswordReset.php";

        }else{
            // manda a la pagina de messageboard con el mensaje de que no existe el email.
            if($debug){
                echo '<br/>';
                echo "User not Found";
            }
            $redirectpage="../../messageboard.php?messageid=7";
        }

    }
}

if(!$debug){
    $commonfuncions->RedirectPage($redirectpage);

}

function GetMessageTemplate($idencripted,$email){
    $template= fopen("recoverpasstemplate.txt", "r")or die("Unable to open the file");
    $message="";
        while(!feof($template)){
            $linea=  fgets($template);
            $message .=$linea;
        }
    fclose($template);
    $ServerConfig= new Config();
    $serverpath= $ServerConfig->domain."/".$ServerConfig->pathServer;

    $message= str_replace("@iduserencripted",$idencripted, $message);
    $message= str_replace("@email",$email, $message);
    $message= str_replace("@serverpath",$serverpath, $message);

    return $message;
}