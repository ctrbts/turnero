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
 * Description of ADOValoresForma
 *
 * @author ITLMIV
 */
class ADOValoresForma {
    private $mysqlconector;
    public $debug=false;
    
    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }
    
    public function InsertValor($ValorCampoFormaObj){
        if(!empty($ValorCampoFormaObj)){
            $this->mysqlconector->OpenConnection();
            
            $idforma= mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idforma);
            $idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idcampoforma);
            $valor=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->valor);
            $idcita=mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idcita);
            
            $sql= new SqlQueryBuilder("insert");
            $sql->setTable("t_formas_valores");
            $sql->addColumn("idforma");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("valor");
            $sql->addColumn("idcita");
            
            $sql->addValue($idforma);
            $sql->addValue($idcampoforma);
            $sql->addValue($valor);
            $sql->addValue($idcita);
            
            if($debug){
                echo '<br />';
                echo $sql->buildQuery();
                echo '<br />';
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
    public function UpdateValor($ValorCampoFormaObj){
        if(!empty($ValorCampoFormaObj)){
            $this->mysqlconector->OpenConnection();
            
            $idformavalores= mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idformavalores);
            $idforma= mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idforma);
            $idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idcampoforma);
            $valor=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->valor);
            $idcita=mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idcita);
            
            $sql= new SqlQueryBuilder("update");
            $sql->setTable("t_formas_valores");
            $sql->addColumn("idforma");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("valor");
            $sql->addColumn("idcita");
            $sql->setWhere("idformavalores=$idformavalores");
            
            $sql->addValue($idforma);
            $sql->addValue($idcampoforma);
            $sql->addValue($valor);
            $sql->addValue($idcita);
            
            if($debug){
                echo '<br />';
                echo $sql->buildQuery();
                echo '<br />';
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
    public function UpdateValorPorCampo($ValorCampoFormaObj){
        if(!empty($ValorCampoFormaObj)){
            $this->mysqlconector->OpenConnection();
            
            $idformavalores= mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idformavalores);
            $idforma= mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idforma);
            $idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idcampoforma);
            $valor=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->valor);
            $idcita=mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idcita);
            
            $sql= new SqlQueryBuilder("update");
            $sql->setTable("t_formas_valores");
            $sql->addColumn("idforma");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("valor");
            $sql->addColumn("idcita");
            $sql->setWhere("idcampoforma=$idcampoforma");
            
            $sql->addValue($idforma);
            $sql->addValue($idcampoforma);
            $sql->addValue($valor);
            $sql->addValue($idcita);
            
            if($debug){
                echo '<br />';
                echo $sql->buildQuery();
                echo '<br />';
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
    public function DeleteValor($ValorCampoFormaObj){
        if(!empty($ValorCampoFormaObj)){
            $this->mysqlconector->OpenConnection();
            
            $idformavalores= mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idformavalores);
            
            $sql= new SqlQueryBuilder("delete");
            $sql->setTable("t_formas_valores");
            
            $sql->setWhere("idformavalores=$idcampoforma");
            
            
            if($debug){
                echo '<br />';
                echo $sql->buildQuery();
                echo '<br />';
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
    public function DeleteValorPorCampo($ValorCampoFormaObj){
        if(!empty($ValorCampoFormaObj)){
            $this->mysqlconector->OpenConnection();
            
           $idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idcampoforma);
           $idforma= mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idforma);
            
            $sql= new SqlQueryBuilder("delete");
            $sql->setTable("t_formas_valores");
            
            $sql->setWhere("idcampoforma=$idcampoforma and idforma=$idforma");
            
            
            if($debug){
                echo '<br />';
                echo $sql->buildQuery();
                echo '<br />';
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
    public function GetValor($ValorCampoFormaObj){
        if(!empty($ValorCampoFormaObj)){
            $this->mysqlconector->OpenConnection();
            
            $idformavalores= mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idformavalores);
            
            
            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formas_valores");
            $sql->addColumn("idforma");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("valor");
            $sql->addColumn("idformavalores");
            $sql->addColumn("idcita");
            
            
            $sql->setWhere("idformavalores=$idformavalores");
            
            if($debug){
                echo '<br />';
                echo $sql->buildQuery();
                echo '<br />';
            }
            
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOFormas::GetFormas:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $ValorCampoFormaObj->idforma=$row['idforma'];
                     $ValorCampoFormaObj->idcampoforma=$row['idcampoforma'];
                     $ValorCampoFormaObj->idformavalores=$row['idformavalores'];
                     $ValorCampoFormaObj->valor=$row['valor'];
                 }
            }            
            
            $this->mysqlconector->CloseDataBase();
        }
    }
    public function GetValorPorCampo($ValorCampoFormaObj){
        if(!empty($ValorCampoFormaObj)){
            $this->mysqlconector->OpenConnection();
            
            $idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idcampoforma);
            $idforma=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idforma);
            
            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formas_valores");
            $sql->addColumn("idforma");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("valor");
            $sql->addColumn("idformavalores");
            $sql->addColumn("idcita");
            
            $sql->setWhere("idcampoforma=$idcampoforma and idforma=$idforma");
            
            if($debug){
                echo '<br />';
                echo $sql->buildQuery();
                echo '<br />';
            }
            
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOFormas::GetFormas:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $ValorCampoFormaObj->idforma=$row['idforma'];
                     $ValorCampoFormaObj->idcampoforma=$row['idcampoforma'];
                     $ValorCampoFormaObj->idformavalores=$row['idformavalores'];
                     $ValorCampoFormaObj->valor=$row['valor'];
                 }
            }            
            
            $this->mysqlconector->CloseDataBase();
        }
    }
    public function GetValorPorCita($ValorCampoFormaObj){
        if(!empty($ValorCampoFormaObj)){
            $this->mysqlconector->OpenConnection();
            
            $idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idcampoforma);
            $idforma=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idforma);
            $idcita=  mysqli_real_escape_string($this->mysqlconector->conn,$ValorCampoFormaObj->idcita);
            
            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formas_valores");
            $sql->addColumn("idforma");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("valor");
            $sql->addColumn("idformavalores");
            $sql->addColumn("idcita");
            
            $sql->setWhere("idcampoforma=$idcampoforma and idforma=$idforma and idcita=$idcita");
            
            if($debug){
                echo '<br />';
                echo $sql->buildQuery();
                echo '<br />';
            }
            
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOFormas::GetFormas:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $ValorCampoFormaObj->idforma=$row['idforma'];
                     $ValorCampoFormaObj->idcampoforma=$row['idcampoforma'];
                     $ValorCampoFormaObj->idformavalores=$row['idformavalores'];
                     $ValorCampoFormaObj->valor=$row['valor'];
                 }
            }            
            
            $this->mysqlconector->CloseDataBase();
        }
    }
    
}
