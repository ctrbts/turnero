<?php

/*
 * Copyright (C) 2018 Marco Antonio Cantu Gea
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
 * Description of ADOFormas
 *
 * @author Marco Antonio Cantu Gea
 */
class ADOFormas {
    
    private $mysqlconector;
    public $debug=false;
    
    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }
    
    public function InsertForma($FormasObj){
        if(!empty($FormasObj)){
            $this->mysqlconector->OpenConnection();
            $descripcion= mysqli_real_escape_string($this->mysqlconector->conn,$FormasObj->descripcion );
            $activo=  mysqli_real_escape_string($this->mysqlconector->conn,$FormasObj->activo);
            $visible= mysqli_real_escape_string($this->mysqlconector->conn,$FormasObj->visible);
            $seleccion=  mysqli_real_escape_string($this->mysqlconector->conn,$FormasObj->seleccion);
            
            $sql = new SqlQueryBuilder("insert");
            $sql->setTable("t_formas");
            $sql->addColumn("descripcion");
            $sql->addValue($descripcion);
            $sql->addColumn("activo");
            $sql->addValue($activo);
            $sql->addColumn("visible");
            $sql->addValue($visible);
            $sql->addColumn("seleccion");
            $sql->addValue($seleccion);
            
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
    
    public function DeactivateForma($FormasObj){
        if(!empty($FormasObj)){
            $this->mysqlconector->OpenConnection();
            $idforma=  mysqli_real_escape_string($this->mysqlconector->conn,  $FormasObj->idforma);
            //$sql= "update t_formas set activo=0 where idforma=$idforma";
            
            $sql= new SqlQueryBuilder("update");
            $sql->setTable("t_formas");
            $sql->addColumn("activo");
            $sql->addValue("0");
            $sql->setWhere("idforma=$idforma");
            
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
    
    public function ActivateForma($FormasObj){
        if(!empty($FormasObj)){
            $this->mysqlconector->OpenConnection();
            $idforma=  mysqli_real_escape_string($this->mysqlconector->conn,  $FormasObj->idforma);
            //$sql= "update t_formas set activo=0 where idforma=$idforma";
            
            $sql= new SqlQueryBuilder("update");
            $sql->setTable("t_formas");
            $sql->addColumn("activo");
            $sql->addValue("1");
            $sql->setWhere("idforma=$idforma");
            
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
    
    public function UpdateForma($FormasObj){
        if(!empty($FormasObj)){
            $this->mysqlconector->OpenConnection();
            $idforma= mysqli_real_escape_string($this->mysqlconector->conn,$FormasObj->idforma);
            $descripcion=  mysqli_real_escape_string($this->mysqlconector->conn,$FormasObj->descripcion);
            $visible=  mysqli_real_escape_string($this->mysqlconector->conn,$FormasObj->visible);
            $seleccion=  mysqli_real_escape_string($this->mysqlconector->conn,$FormasObj->seleccion);
            $activo= mysqli_real_escape_string($this->mysqlconector->conn,$FormasObj->activo);
            
            $sql= new SqlQueryBuilder("update");
            $sql->setTable("t_formas");
            $sql->addColumn("descripcion");
            $sql->addColumn("visible");
            $sql->addColumn("seleccion");
            $sql->addColumn("activo");
            
            $sql->addValue($descripcion);
            $sql->addValue($visible);
            $sql->addValue($seleccion);
            $sql->addValue($activo);
            
            $sql->setWhere("idforma=$idforma");
            
            if($this->debug){
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
    
    public function GetFormas($FormasCollection){
        if(!empty($FormasCollection)){
            $this->mysqlconector->OpenConnection();
            
            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formas");
            $sql->addColumn("idforma");
            $sql->addColumn("descripcion");
            $sql->addColumn("visible");
            $sql->addColumn("seleccion");
            $sql->addColumn("activo");
            
            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOFormas::GetFormas:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $newFormaObj = new FormasObj();
                     $newFormaObj->idforma=$row["idforma"];
                     $newFormaObj->descripcion=$row["descripcion"];
                     $newFormaObj->visible=$row["visible"];
                     $newFormaObj->seleccion=$row["seleccion"];
                     $newFormaObj->activo=$row["activo"];
                     $FormasCollection->addItem($newFormaObj);
                 }
            }
            
            $this->mysqlconector->CloseDataBase();
        }
    }
 
    public function GetForma($FormaObj){
        if(!empty($FormaObj)){
            $this->mysqlconector->OpenConnection();
            
            $idforma=  mysqli_real_escape_string($this->mysqlconector->conn,$FormaObj->idforma);
            
            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formas");
            $sql->addColumn("idforma");
            $sql->addColumn("descripcion");
            $sql->addColumn("visible");
            $sql->addColumn("seleccion");
            $sql->addColumn("activo");
            $sql->setWhere("idforma=$idforma");
            
            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOFormas::GetFormas:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $FormaObj->idforma=$row["idforma"];
                     $FormaObj->descripcion=$row["descripcion"];
                     $FormaObj->visible=$row["visible"];
                     $FormaObj->seleccion=$row["seleccion"];
                     $FormaObj->activo=$row["activo"];
                 }
            }
            
            
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    public function DeleteForma($FormasObj){
        $deleted=false;
        if(!empty($FormasObj)){
            
            if($this->CheckBeforeDelete($FormasObj)){

                $this->mysqlconector->OpenConnection();
                $idforma=  mysqli_real_escape_string($this->mysqlconector->conn,  $FormasObj->idforma);
                //$sql= "update t_formas set activo=0 where idforma=$idforma";

                $sql= new SqlQueryBuilder("delete");
                $sql->setTable("t_formas");
                $sql->setWhere("idforma=$idforma");

                if ($this->debug){
                    echo $sql->buildQuery();
                }
                try{
                    $this->mysqlconector->conn->query($sql->buildQuery());
                    $deleted=true;
                } catch (Exception $ex) {
                    if($this->debug){
                        echo $ex->getMessage();
                    }
                }
                $this->mysqlconector->CloseDataBase();
            }
        }
        return $deleted;
    }
    
    private function CheckBeforeDelete($FormasObj){
        $delete=false;
        if(!empty($FormasObj)){
            $this->mysqlconector->OpenConnection();
            $idforma=  mysqli_real_escape_string($this->mysqlconector->conn,  $FormasObj->idforma);
            
            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formulario_campos");
            $sql->addColumn("count(1) as contador");
            $sql->setWhere("idforma=$idforma");
            
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
    
    public function GetFormasActivas($FormasCollection){
        if(!empty($FormasCollection)){
            $this->mysqlconector->OpenConnection();
            
            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formas");
            $sql->addColumn("idforma");
            $sql->addColumn("descripcion");
            $sql->addColumn("visible");
            $sql->addColumn("seleccion");
            $sql->addColumn("activo");
            $sql->setWhere("activo=1");
            
            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOFormas::GetFormas:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $newFormaObj = new FormasObj();
                     $newFormaObj->idforma=$row["idforma"];
                     $newFormaObj->descripcion=$row["descripcion"];
                     $newFormaObj->visible=$row["visible"];
                     $newFormaObj->seleccion=$row["seleccion"];
                     $newFormaObj->activo=$row["activo"];
                     $FormasCollection->addItem($newFormaObj);
                 }
            }
            
            $this->mysqlconector->CloseDataBase();
        }
    }
    
    
    public function InsertRelCitaForma($idcita,$idforma){
        if(!empty($idcita) && !empty($idforma)){
            $this->mysqlconector->OpenConnection();
            $_idcita= mysqli_real_escape_string($this->mysqlconector->conn,$idcita );
            $_idforma=  mysqli_real_escape_string($this->mysqlconector->conn,$idforma);
            
            $sql = new SqlQueryBuilder("insert");
            $sql->setTable("t_citas_formas");
            $sql->addColumn("idcita");
            $sql->addValue($_idcita);
            $sql->addColumn("idforma");
            $sql->addValue($_idforma);
            
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
    
    public function GetFormasByCita($idcita,$FormasCollection){
        if(!empty($FormasCollection)){
            $this->mysqlconector->OpenConnection();
            
            $_idcita= mysqli_real_escape_string($this->mysqlconector->conn,$idcita);
            
            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formas inner join t_citas_formas on t_citas_formas.idforma=t_formas.idforma");
            $sql->addColumn("t_formas.idforma");
            $sql->addColumn("descripcion");
            $sql->addColumn("visible");
            $sql->addColumn("seleccion");
            $sql->addColumn("activo");
            $sql->setWhere("idcita=$_idcita");
            
            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOFormas::GetFormas:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $newFormaObj = new FormasObj();
                     $newFormaObj->idforma=$row["idforma"];
                     $newFormaObj->descripcion=$row["descripcion"];
                     $newFormaObj->visible=$row["visible"];
                     $newFormaObj->seleccion=$row["seleccion"];
                     $newFormaObj->activo=$row["activo"];
                     $newFormaObj->idcita=$idcita;
                     $FormasCollection->addItem($newFormaObj);
                 }
            }
            
            $this->mysqlconector->CloseDataBase();
        }
    }
}
