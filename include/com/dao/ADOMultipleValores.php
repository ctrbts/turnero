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

/**
 * Description of ADOMultipleValores
 *
 * @author ITLMIV
 */
class ADOMultipleValores {
    private $mysqlconector;
    public $debug=false;
    
    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }
    
    public function InsertMultipleValores($MultipleValoresObj){
        if(!empty($MultipleValoresObj)){
            $this->mysqlconector->OpenConnection();
            
            $idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,$MultipleValoresObj->idcampoforma);
            $idcampotipo= mysqli_real_escape_string($this->mysqlconector->conn,$MultipleValoresObj->idcampotipo);
            $valores=  mysqli_real_escape_string($this->mysqlconector->conn,$MultipleValoresObj->valores);
            
            $sql= new SqlQueryBuilder("insert");
            $sql->setTable("t_campos_selmultiple");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("idcampotipo");
            $sql->addColumn("valores");
            
            $sql->addValue($idcampoforma);
            $sql->addValue($idcampotipo);
            $sql->addValue($valores);
            
            if ($this->debug){
                echo $sql->buildQuery();
            }
            try{
                $this->mysqlconector->conn->query($sql->buildQuery());
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
            
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function UpdateMultipleValores($MultipleValoresObj){
        if(!empty($MultipleValoresObj)){
            $this->mysqlconector->OpenConnection();
            
            $idcamposelmultiple=  mysqli_real_escape_string($this->mysqlconector->conn,$MultipleValoresObj->idcamposelmultiple);
            $idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,$MultipleValoresObj->idcampoforma);
            $idcampotipo= mysqli_real_escape_string($this->mysqlconector->conn,$MultipleValoresObj->idcampotipo);
            $valores=  mysqli_real_escape_string($this->mysqlconector->conn,$MultipleValoresObj->valores);
            
            $sql= new SqlQueryBuilder("update");
            $sql->setTable("t_campos_selmultiple");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("idcampotipo");
            $sql->addColumn("valores");
            
            $sql->addValue($idcampoforma);
            $sql->addValue($idcampotipo);
            $sql->addValue($valores);
            
            $sql->setWhere("idcamposelmultiple=$idcamposelmultiple");
            
            if ($this->debug){
                echo $sql->buildQuery();
            }
            try{
                $this->mysqlconector->conn->query($sql->buildQuery());
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
            
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function GetMulValFromCampoForma($idcampoforma,$MultipleValoresObj){
        if(!empty($idcampoforma)){
            $this->mysqlconector->OpenConnection();
            
            $_idcampoforma= mysqli_real_escape_string($this->mysqlconector->conn,$idcampoforma);
            
            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_campos_selmultiple");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("idcampotipo");
            $sql->addColumn("valores");
            $sql->addColumn("idcamposelmultiple");
            
            $sql->setWhere("idcampoforma=$_idcampoforma");
            
            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOCampoForma::GetAllCampos:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $MultipleValoresObj->idcampoforma=$row['idcampoforma'];
                     $MultipleValoresObj->idcamposelmultiple=$row['idcamposelmultiple'];
                     $MultipleValoresObj->idcampotipo=$row['idcampotipo'];
                     $MultipleValoresObj->valores=$row['valores'];
                 }
            }
            
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    private function CheckBeforeDelete($idcampoforma){
        $delete=false;
        if(!empty($idcampoforma)){
            $this->mysqlconector->OpenConnection();
            
            $_idcampoforma= mysqli_real_escape_string($this->mysqlconector->conn,$idcampoforma);
            
            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_campos_selmultiple");
            $sql->addColumn("count(1) as contador");
            $sql->setWhere("idcampoforma=$_idcampoforma");
            
            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOTipoCampo::GetTipoCampo:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $contador= intval($row['contador']);
                     if($contador==0){
                         $delete=true;
                     }
                 }
            }
            
            $this->mysqlconector->CloseDataBase();
        }
        return $delete;
    }
    
    public function DeleteMulVal($idcampoforma){
        if(!empty($idcampoforma)){
            
            $this->mysqlconector->OpenConnection();
            
            $_idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,$idcampoforma);
            
            $sql= new SqlQueryBuilder("delete");
            $sql->setTable("t_campos_selmultiple");
            $sql->setWhere("idcampoforma=".$_idcampoforma);
            
            if ($this->debug){
                echo $sql->buildQuery();
            }
            try{
                $this->mysqlconector->conn->query($sql->buildQuery());
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
            
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function GetMulValObj($MultipleValoresObj){
        if(!empty($MultipleValoresObj)){
            $this->mysqlconector->OpenConnection();
            
            $_idcamposelmultiple= mysqli_real_escape_string($this->mysqlconector->conn,$MultipleValoresObj->idcamposelmultiple);
            
            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_campos_selmultiple");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("idcampotipo");
            $sql->addColumn("valores");
            $sql->addColumn("idcamposelmultiple");
            
            $sql->setWhere("idcamposelmultiple=$_idcamposelmultiple");
            
            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOMultipleValores::GetMulValObj:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $MultipleValoresObj->idcampoforma=$row['idcampoforma'];
                     $MultipleValoresObj->idcamposelmultiple=$row['idcamposelmultiple'];
                     $MultipleValoresObj->idcampotipo=$row['idcampotipo'];
                     $MultipleValoresObj->valores=$row['valores'];
                 }
            }
            
            $this->mysqlconector->CloseDataBase();
        }
    }
}
