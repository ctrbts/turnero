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
$redirectpage="../../messageboard.php?messageid=5";
$returnajaxvl=0;

if(!empty($_GET)){
    if(!empty($_GET['email']) && !empty($_GET['param'])){
        $usertoactivate= new UserObj();
        $usertoactivate->email=$_GET['email'];
        $usertoactivate->activationtoken=$_GET['param'];

        $_ADOUser = new ADOUser();
        $_ADOUser->debug=$debug;
        try{
            $_ADOUser->DeactivateUser($usertoactivate);
            $returnajaxvl=1;
            if($debug){
                echo '<br/>';
                echo "Usuario Activo;";
            }
        } catch (Exception $ex) {
            if($debug){
                echo '<br/>';
                echo $ex->getMessage();
            }
        }
    }
    if(isset($_GET['returnajax'])){
        echo $returnajaxvl;
        $debug=false;
    }
}

if(!$debug){
    if(isset($_GET['enableredirect'])){
        $enableredirect=$_GET['enableredirect'];
        if($enableredirect=="true"){
            if(isset($_GET['redirectpage'])){
                $redirectpage=$_GET['redirectpage'];
                $commonfuncions->RedirectPage($redirectpage);
            }else{
                $commonfuncions->RedirectPage($redirectpage);
            }
        }
        if($enableredirect=="false"){
            exit;
        }
    }else{
         $commonfuncions->RedirectPage($redirectpage);
    }
}
