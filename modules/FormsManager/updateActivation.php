<?php

/*
 * Copyright (C) 2018 Fernando Merlo
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
$debug=false;
if(isset($_GET)){

    include ("topInclude.php");


    $commonfunctions = new CommonFunctions();


    if(isset($_GET['k']) && isset($_GET['o']) ){
        $formobj = new FormasObj();
        $id= base64_decode($_GET['k']);
        $option= $_GET['o'];

        $formobj->idforma=$id;

        if ($debug){
            echo var_dump($formobj);
            echo "</br>";
        }

        $ADOFormas= new ADOFormas();
        $ADOFormas->debug=$debug;

        try {

            if($option=="1"){
                $ADOFormas->ActivateForma($formobj);
            }

            if($option=="0"){
                $ADOFormas->DeactivateForma($formobj);
            }

            if($debug){
                echo '<br>';
                echo 'Data inserted.';
            }
        } catch (Exception $ex) {
            if($debug){
                echo $ex;
            }
        }
    }


}

if(!$debug){
    $commonfunctions->RedirectPage("FormsManager.php");
}
?>