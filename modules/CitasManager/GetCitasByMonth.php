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
if(!empty($_GET)){
    if(isset($_GET['mes']) && isset($_GET['anio']) && isset($_GET['token'])){
        if(isset($_SESSION['UserObj'])){
            $mes=$_GET['mes'];
            $anio=$_GET['anio'];
            $token=$_GET['token'];
            $UserLogged=  unserialize($_SESSION['UserObj']);
            if($token==md5($UserLogged->email)){
                $_ADOCitas= new ADOCitas();
                $ListOfCitas= new ArrayList();
                $_ADOCitas->GetCitasFromDB($ListOfCitas, $mes, $anio);
               // echo count($ListOfCitas->array);
               foreach($ListOfCitas->array as $item){
                   $item->idcitaenc= base64_encode($item->idcita);
                   $item->getUserObj();
                   $item->getEstatus();
               }

                echo json_encode($ListOfCitas->array);
            }
        }
    }
}