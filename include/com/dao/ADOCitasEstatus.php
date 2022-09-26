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
 * Description of ADOCitasEstatus
 *
 * @author Fernando Merlo
 */
class ADOCitasEstatus {
    private $mysqlconector;
    public $debug=false;

    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }

    public function AddNewStatus($EstatusCitaObj){
        if(!empty($EstatusCitaObj)){
            $this->mysqlconector->OpenConnection();
            $estado=  mysqli_real_escape_string($this->mysqlconector->conn,$EstatusCitaObj->estado);
            $sql = "INSERT INTO t_citas_estatus(estado,activo) VALUES ('$estado',1)";
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

    public function UpdateStatus($EstatusCitaObj){
        if(!empty($EstatusCitaObj)){
            $this->mysqlconector->OpenConnection();
            $idestatus=  mysqli_real_escape_string($this->mysqlconector->conn,$EstatusCitaObj->idestatus);
            $estado=  mysqli_real_escape_string($this->mysqlconector->conn,$EstatusCitaObj->estado);
            $active= mysqli_real_escape_string($this->mysqlconector->conn,$EstatusCitaObj->activo);
            $sql = "update t_citas_estatus set estado='$estado', activo=$active where idestatus=$idestatus";
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

    public function GetEstatus($ListOfEstatusCitas){
        if(!empty($ListOfEstatusCitas)){
            $this->mysqlconector->OpenConnection();
            $sql = "SELECT idestatus,estado,activo FROM t_citas_estatus WHERE ACTIVO=1;";

            if ($this->debug){
                echo $sql;
            }
             try{
               $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $estatus= new EstatusCitaObj();
                        $estatus->idestatus=$row['idestatus'];
                        $estatus->estado=  $row['estado'];
                        $estatus->activo=$row['activo'];
                        $ListOfEstatusCitas->addItem($estatus);
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
    public function GetEstatusById($EstatusCitaObj){
        if(!empty($EstatusCitaObj)){
            $this->mysqlconector->OpenConnection();
            $idestatus=  mysqli_real_escape_string($this->mysqlconector->conn,$EstatusCitaObj->idestatus);
            $sql = "SELECT idestatus,estado,activo FROM t_citas_estatus WHERE idestatus=$idestatus;";

            if ($this->debug){
                echo $sql;
            }
             try{
               $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $EstatusCitaObj->idestatus=$row['idestatus'];
                        $EstatusCitaObj->estado= $row['estado'];
                        $EstatusCitaObj->activo=$row['activo'];
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
}
