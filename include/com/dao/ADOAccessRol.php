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
 * Description of ADOAccessRol
 *
 * @author Fernando Merlo
 */
class ADOAccessRol
{
    private $mysqlconector;
    public $debug = false;

    public function __construct()
    {
        $this->mysqlconector = new MysqlConnector();
    }

    public function InsertRol($AccessRolObj)
    {
        if (!empty($AccessRolObj)) {
            $this->mysqlconector->OpenConnection();

            $profile = mysqli_real_escape_string($this->mysqlconector->conn, $AccessRolObj->profile);
            $active = mysqli_real_escape_string($this->mysqlconector->conn, $AccessRolObj->active);

            $sql = "insert into t_user_profiles(profile,active) values('$profile',$active)";
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

    public function UpdateProfile($AccessRolObj)
    {
        if (!empty($AccessRolObj)) {
            $this->mysqlconector->OpenConnection();

            $profile = mysqli_real_escape_string($this->mysqlconector->conn, $AccessRolObj->profile);
            $idprofile = mysqli_real_escape_string($this->mysqlconector->conn, $AccessRolObj->idprofile);

            $sql = "update t_user_profiles set profile='" . $profile . "' where idprofile=$idprofile";
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

    public function SetDefatulAccessProfleToNewUsers($AccessRolObj)
    {
        if (!empty($AccessRolObj)) {
            if ($AccessRolObj->idprofile > 0) {
                $this->mysqlconector->OpenConnection();

                $idprofile = mysqli_real_escape_string($this->mysqlconector->conn, $AccessRolObj->idprofile);

                $sql = "insert into t_systemconf(variable,valor) values('ProfileToNewUsers','$idprofile')";
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
    }

    public function UpdateDefatulAccessProfleToNewUsers($AccessRolObj)
    {
        if (!empty($AccessRolObj)) {
            if ($AccessRolObj->idprofile > 0) {
                $this->mysqlconector->OpenConnection();

                $idprofile = mysqli_real_escape_string($this->mysqlconector->conn, $AccessRolObj->idprofile);

                $sql = "update t_systemconf set valor='$idprofile' where variable='ProfileToNewUsers'";
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
    }


    public function getActiveAccessProfiles($ListAccessRolObj)
    {
        if (!empty($ListAccessRolObj)) {
            $this->mysqlconector->OpenConnection();
            $sql = "select idprofile, profile, active from t_user_profiles where idprofile > 0;";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $result = $this->mysqlconector->conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $AccesRol = new AccessRol();
                        $AccesRol->idprofile = $row['idprofile'];
                        $AccesRol->profile = $row['profile'];
                        $AccesRol->active = $row['active'];
                        $ListAccessRolObj->addItem($AccesRol);
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

            $idprofile = mysqli_real_escape_string($this->mysqlconector->conn, $AccessRolObj->idprofile);

            $sql = "select idprofile,profile,active from t_user_profiles where idprofile=$idprofile;";
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

    public function InsertAccessModules($ListIdModules, $idprofile)
    {
        if (!empty($ListIdModules) && !empty($idprofile)) {
            $this->DeleteAccessModule($idprofile);
            foreach ($ListIdModules->array as $item) {
                $this->InsertAccessModule($item, $idprofile);
            }
        }
    }

    private function InsertAccessModule($idModule, $idprofile)
    {
        if (!empty($idModule) && !empty($idprofile)) {
            if ($idModule > 0) {
                $this->mysqlconector->OpenConnection();

                $_idprofile = mysqli_real_escape_string($this->mysqlconector->conn, $idprofile);
                $_idmodule = mysqli_real_escape_string($this->mysqlconector->conn, $idModule);

                $sql = "insert into t_profile_module(idprofile,idmodulo) values ($_idprofile,$_idmodule)";
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
    }

    private function DeleteAccessModule($idprofile)
    {
        $this->mysqlconector->OpenConnection();

        $_idprofile = mysqli_real_escape_string($this->mysqlconector->conn, $idprofile);

        $sql = "delete from t_profile_module where idprofile=$_idprofile ";
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

    public function InsertAccessMenus($ListIdMenu, $idprofile)
    {
        if (!empty($ListIdMenu) && !empty($idprofile)) {
            $this->DeleteAccessMenu($idprofile);
            foreach ($ListIdMenu->array as $item) {
                $this->InsertAccessMenu($item, $idprofile);
            }
        }
    }

    private function InsertAccessMenu($idmenu, $idprofile)
    {
        if (!empty($idmenu) && !empty($idprofile)) {
            if ($idmenu > 0) {
                $this->mysqlconector->OpenConnection();

                $_idprofile = mysqli_real_escape_string($this->mysqlconector->conn, $idprofile);
                $_idmenu = mysqli_real_escape_string($this->mysqlconector->conn, $idprofile);

                $sql = "insert into t_profile_menu(idprofile,idmenu) values ($_idprofile,$idmenu)";
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
    }

    private function DeleteAccessMenu($idprofile)
    {
        $this->mysqlconector->OpenConnection();
        $_idprofile = mysqli_real_escape_string($this->mysqlconector->conn, $idprofile);
        $sql = "delete from t_profile_menu where idprofile=$_idprofile ";
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

    public function GetModulesId($AccessRolObj)
    {
        if (!empty($AccessRolObj)) {
            $l_moduloid = new ArrayList();
            $this->mysqlconector->OpenConnection();
            $idprofile = mysqli_real_escape_string($this->mysqlconector->conn, $AccessRolObj->idprofile);
            $sql = "select idmodulo from t_profile_module where idprofile=$idprofile;";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $result = $this->mysqlconector->conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $l_moduloid->addItem($row['idmodulo']);
                    }
                }
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
            $AccessRolObj->ListIdModules = $l_moduloid;
        }
    }

    public function GetMenusId($AccessRolObj)
    {
        if (!empty($AccessRolObj)) {
            $l_menuid = new ArrayList();
            $this->mysqlconector->OpenConnection();
            $idprofile = mysqli_real_escape_string($this->mysqlconector->conn, $AccessRolObj->idprofile);
            $sql = "select idmenu from t_profile_menu where idprofile=$idprofile;";
            if ($this->debug) {
                echo $sql;
            }
            try {
                $result = $this->mysqlconector->conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $l_menuid->addItem($row['idmenu']);
                    }
                }
            } catch (Exception $ex) {
                if ($this->debug) {
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
            $AccessRolObj->ListIdMenus = $l_menuid;
        }
    }
}
