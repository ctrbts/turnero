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

$ADOSystemConf= new ADOSystemConf();
$ADOSystemConf->debug=$debug;

if(isset($_POST) && isset($_FILES)){

    $dir_subida = '../../images/';
    $fichero_subido = $dir_subida . basename($_FILES['fichero_usuario']['name']);

    if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido)) {
        $SysVariable = new SystemConfObj();
        $SysVariable->variable="LogoImageFile";
        $SysVariable->valor=basename($_FILES['fichero_usuario']['name']);

        $ADOSystemConf->InsertVariable($SysVariable);


    } else {

    }

    if(isset($_POST['encabezado'])){
        $encabezado=$_POST['encabezado'];
        $EncabezadoConf = new SystemConfObj();
        $EncabezadoConf->variable="PublicMainHeader";
        $EncabezadoConf->valor=$encabezado;

        $ADOSystemConf->InsertVariable($EncabezadoConf);
    }
}

if(!$debug){
    $commonfuncions->RedirectPage("HeaderConfig.php");
}

?>