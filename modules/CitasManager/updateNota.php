<?php

/* 
 * Copyright (C) 2018 ITLMIV
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
$commonfunctions = new CommonFunctions();
$debug=false;
$id="";

if(isset($_POST)){
    if(isset($_POST['k']) && isset($_POST['cita_nota'])){
        $id=  base64_decode($_POST['k']);
        $nota=$_POST['cita_nota'];
        
        $ADOCitas = new ADOCitas();
        $ADOCitas->debug=$debug;
        $ADOCitas->UpdateNota($nota, $id);
    }
}

if(!$debug){
    $commonfunctions->RedirectPage("viewCita.php?param=".  base64_encode($id));
}
?>