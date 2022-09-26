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
 * Description of ADOModules
 *
 * @author Fernando Merlo
 */
class ADOModules {

    private $mysqlconector;
    public $debug=false;


    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }

    public function AddModuleToDB($newModule){
        if(!is_null($newModule)){
            $this->mysqlconector->OpenConnection();
            $etiqueta = mysqli_real_escape_string($this->mysqlconector->conn,$newModule->etiqueta);
            $path = mysqli_real_escape_string($this->mysqlconector->conn,$newModule->path);
            $hasmenus= mysqli_real_escape_string($this->mysqlconector->conn,$newModule->hasmenus);
            $accion= mysqli_real_escape_string($this->mysqlconector->conn,$newModule->accion);

            $sql = "INSERT INTO t_modulos(ETIQUETA,ACTIVO,PATH,HASMENUS,ACCION) VALUES ('$etiqueta',1,'$path',$hasmenus,'$accion')";
            if ($this->debug){
                echo $sql;
            }
            try{
                $this->mysqlconector->conn->query($sql);
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }

            $this->mysqlconector->CloseDataBase();

        }
    }

    public function UpdateModuleinDB($ModulesMenuObj){
          if(!is_null($ModulesMenuObj)){
              $this->mysqlconector->OpenConnection();

            $etiqueta = mysqli_real_escape_string($this->mysqlconector->conn,$ModulesMenuObj->etiqueta);
            $path = mysqli_real_escape_string($this->mysqlconector->conn,$ModulesMenuObj->path);
            $hasmenus= mysqli_real_escape_string($this->mysqlconector->conn,$ModulesMenuObj->hasmenus);
            $accion= mysqli_real_escape_string($this->mysqlconector->conn,$ModulesMenuObj->accion);
            $idmodulo= mysqli_real_escape_string($this->mysqlconector->conn,$ModulesMenuObj->idmodulo);
            $activo= mysqli_real_escape_string($this->mysqlconector->conn,$ModulesMenuObj->activo);

              $sql = "UPDATE t_modulos SET ETIQUETA='$etiqueta',ACTIVO=$activo,PATH='$path',ACCION='$accion' where IDMODULO=$idmodulo;";
            if ($this->debug){
                echo $sql;
            }
            try{
                $this->mysqlconector->conn->query($sql);
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }

              $this->mysqlconector->CloseDataBase();
          }
    }

    public function DeleteModuleinDB($ModulesMenuObj){
        if(!is_null($ModulesMenuObj)){
            $this->mysqlconector->OpenConnection();
            $idmodulo= mysqli_real_escape_string($this->mysqlconector->conn,$ModulesMenuObj->idmodulo);
            $sql = "delete from t_modulos where idmodulo=$idmodulo";
            if ($this->debug){
                echo $sql;
            }
            try{
                $this->mysqlconector->conn->query($sql);
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function GetModulesActive($ListModules){
        if(!is_null($ListModules)){
            $this->mysqlconector->OpenConnection();
            $sql = "SELECT IDMODULO,ETIQUETA,ACTIVO,PATH,HASMENUS,ACCION FROM t_modulos WHERE ACTIVO=1;";

            if ($this->debug){
                echo $sql;
            }
             try{
               $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $mod= new ModulesMenu();
                        $mod->idmodulo=$row["IDMODULO"];
                        $mod->etiqueta=$row["ETIQUETA"];
                        $mod->activo=$row["ACTIVO"];
                        $mod->path=$row["PATH"];
                        $mod->hasmenus=$row["HASMENUS"];
                        $mod->accion=$row["ACCION"];
                        $ListModules->addItem($mod);
                    }
                }else {

                    if($this->debug) echo "0 results";
                }
            } catch (Exception $ex) {
               if($this->debug){
                    echo $ex->getMessage();
                }
            }

            $this->mysqlconector->CloseDataBase();
        }
    }

    public function GetModuleByID($ModulesMenuObj){
         if(!is_null($ModulesMenuObj)){
            $this->mysqlconector->OpenConnection();
            $sql = "SELECT IDMODULO,ETIQUETA,ACTIVO,PATH,HASMENUS,ACCION FROM t_modulos WHERE ACTIVO=1 AND IDMODULO=$ModulesMenuObj->idmodulo;";
            if ($this->debug){
                echo $sql;
            }
            try{
                $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $ModulesMenuObj->idmodulo=$row["IDMODULO"];
                        $ModulesMenuObj->etiqueta=$row["ETIQUETA"];
                        $ModulesMenuObj->activo=$row["ACTIVO"];
                        $ModulesMenuObj->path=$row["PATH"];
                        $ModulesMenuObj->hasmenus=$row["HASMENUS"];
                        $ModulesMenuObj->accion=$row["ACCION"];
                    }
                }else{

                    if($this->debug) echo "0 results";
                }

            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();

         }
    }


}
