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


include ("topInclude.php");
$commonfuncions= new CommonFunctions();
$debug=false;

if(isset($_GET)){
    if(isset($_GET['k'])){
        $Variablename= base64_decode($_GET['k']);

        $LogoConf = new SystemConfObj();
        $LogoConf->variable=$Variablename;

        if($debug){
            echo "<br>";
            var_dump($LogoConf);
        }

        $ADOSystemConf = new ADOSystemConf();
        $ADOSystemConf->debug=$debug;
        $ADOSystemConf->GetVariableByName($LogoConf);

        $ADOSystemConf->DeleteVariable($LogoConf);

    }
}

if(!$debug){
    $commonfuncions->RedirectPage("HeaderConfig.php");
}
?>