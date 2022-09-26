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

/**
 * Description of UserObj
 *
 * @author Fernando Merlo
 */
class UserObj {
    public $iduser=0;
    public $email;
    public $password;
    public $nombre;
    public $apellidos;
    public $active;
    public $idprofile;
    public $ListOfCitas;
    public $ProfileObj;
    public $activationtoken;

    public function generateToken(){
        $result= md5($this->email.$this->nombre . $this->password);
        $this->activationtoken=$result;
        return $result;
    }

    public function GetProfile(){
        if($this->idprofile>0){
            $_ADOUser = new ADOUser();
            $this->ProfileObj = new AccessRol();
            $this->ProfileObj->idprofile=  $this->idprofile;
            $_ADOUser->GetProfileAccess($this->ProfileObj);
        }
    }

    public function GetCitas(){
        $this->ListOfCitas=  new ArrayList();
        if($this->iduser>0){
            $_ADOCitas = new ADOCitas();
            $_ADOCitas->GetCitasByUser($this->ListOfCitas, $this);

        }
    }


}
