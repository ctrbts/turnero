<?php

/*
 * Copyright (C) 2018 Fernando Merlo
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
 * Description of ADOCamposForma
 *
 * @author Fernando Merlo
 */
class ADOCamposForma {
    private $mysqlconector;
    public $debug=false;

    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }

    public function InsertCampo($CampoFormaObj){
        if(!empty($CampoFormaObj)){
            $this->mysqlconector->OpenConnection();

            $idforma= mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->idforma);
            $nombre=  mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->nombre);
            $activo=  mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->activo);
            $valorpordefecto=  mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->valorpordefecto);
            $idtipocampo= mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->idtipocampo);

            $sql = new SqlQueryBuilder("insert");
            $sql->setTable("t_formulario_campos");
            $sql->addColumn("idforma");
            $sql->addColumn("nombre");
            $sql->addColumn("activo");
            $sql->addColumn("valorpordefecto");
            $sql->addColumn("idtipocampo");

            $sql->addValue($idforma);
            $sql->addValue($nombre);
            $sql->addValue($activo);
            $sql->addValue($valorpordefecto);
            $sql->addValue($idtipocampo);

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

    public function UpdateCampo($CampoFormaObj){
        if(!empty($CampoFormaObj)){
            $this->mysqlconector->OpenConnection();

            $idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->idcampoforma);
            $idforma= mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->idforma);
            $nombre=  mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->nombre);
            $activo=  mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->activo);
            $valorpordefecto=  mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->valorpordefecto);
            $idtipocampo= mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->idtipocampo);

            $sql = new SqlQueryBuilder("update");
            $sql->setTable("t_formulario_campos");
            $sql->addColumn("idforma");
            $sql->addColumn("nombre");
            $sql->addColumn("activo");
            $sql->addColumn("valorpordefecto");
            $sql->addColumn("idtipocampo");

            $sql->addValue($idforma);
            $sql->addValue($nombre);
            $sql->addValue($activo);
            $sql->addValue($valorpordefecto);
            $sql->addValue($idtipocampo);

            $sql->setWhere("idcampoforma=".$idcampoforma);

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

    public function ActivateCampo($CampoFormaObj){
        if(!empty($CampoFormaObj)){
            $this->mysqlconector->OpenConnection();
            $idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,  $CampoFormaObj->idcampoforma);

            $sql= new SqlQueryBuilder("update");
            $sql->setTable("t_formulario_campos");
            $sql->addColumn("activo");
            $sql->addValue("1");
            $sql->setWhere("idcampoforma=$idcampoforma");

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

    public function DeactivateCampo($CampoFormaObj){
        if(!empty($CampoFormaObj)){
            $this->mysqlconector->OpenConnection();
            $idcampoforma=  mysqli_real_escape_string($this->mysqlconector->conn,  $CampoFormaObj->idcampoforma);

            $sql= new SqlQueryBuilder("update");
            $sql->setTable("t_formulario_campos");
            $sql->addColumn("activo");
            $sql->addValue("0");
            $sql->setWhere("idcampoforma=$idcampoforma");

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

    public function GetCampos($idforma, $CampoFormaCollection ){
        if(!empty($CampoFormaCollection) && isset($idforma)){
            $this->mysqlconector->OpenConnection();

            $_idforma= mysqli_real_escape_string($this->mysqlconector->conn,$idforma);

            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formulario_campos");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("idforma");
            $sql->addColumn("idtipocampo");
            $sql->addColumn("nombre");
            $sql->addColumn("activo");
            $sql->addColumn("valorpordefecto");

            $sql->setWhere("idforma=$_idforma");
            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOCampoForma::GetAllCampos:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $CampoObj= new CamposFormaObj();
                     $CampoObj->idcampoforma=$row['idcampoforma'];
                     $CampoObj->idforma=$row['idforma'];
                     $CampoObj->idtipocampo=$row['idtipocampo'];
                     $CampoObj->nombre=$row['nombre'];
                     $CampoObj->valorpordefecto=$row['valorpordefecto'];
                     $CampoObj->activo=$row['activo'];
                     $CampoFormaCollection->addItem($CampoObj);
                 }
            }

            $this->mysqlconector->CloseDataBase();
        }
    }

    public function GetCampo($CampoFormaObj){
        if(!empty($CampoFormaObj) ){
            $this->mysqlconector->OpenConnection();

            $idcampoforma= mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->idcampoforma);

            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formulario_campos");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("idforma");
            $sql->addColumn("idtipocampo");
            $sql->addColumn("nombre");
            $sql->addColumn("activo");
            $sql->addColumn("valorpordefecto");

            $sql->setWhere("idcampoforma=$idcampoforma");
            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOCampoForma::GetAllCampos:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $CampoFormaObj->idcampoforma=$row['idcampoforma'];
                     $CampoFormaObj->idforma=$row['idforma'];
                     $CampoFormaObj->idtipocampo=$row['idtipocampo'];
                     $CampoFormaObj->nombre=$row['nombre'];
                     $CampoFormaObj->valorpordefecto=$row['valorpordefecto'];
                     $CampoFormaObj->activo=$row['activo'];

                 }
            }

            $this->mysqlconector->CloseDataBase();
        }
    }

    private function CheckBeforeDelete($CampoFormaObj){
        $delete=false;
        if(!empty($CampoFormaObj)){
            $this->mysqlconector->OpenConnection();
            $idcampoforma= mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->idcampoforma);

            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formas_valores");
            $sql->addColumn("count(1) as contador");
            $sql->setWhere("idcampoforma=$idcampoforma");

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

    public function DeleteCampo($CampoFormaObj){
        $deleted=false;
        if(!empty($CampoFormaObj)){

            if($this->CheckBeforeDelete($CampoFormaObj)){

                $this->mysqlconector->OpenConnection();
                $idcampoforma= mysqli_real_escape_string($this->mysqlconector->conn,$CampoFormaObj->idcampoforma);

                $sql= new SqlQueryBuilder("delete");
                $sql->setTable("t_formulario_campos");
                $sql->setWhere("idcampoforma=$idcampoforma");

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

    public function GetCamposActivos($idforma, $CampoFormaCollection ){
        if(!empty($CampoFormaCollection) && isset($idforma)){
            $this->mysqlconector->OpenConnection();

            $_idforma= mysqli_real_escape_string($this->mysqlconector->conn,$idforma);

            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formulario_campos");
            $sql->addColumn("idcampoforma");
            $sql->addColumn("idforma");
            $sql->addColumn("idtipocampo");
            $sql->addColumn("nombre");
            $sql->addColumn("activo");
            $sql->addColumn("valorpordefecto");

            $sql->setWhere("idforma=$_idforma and activo=1");
            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOCampoForma::GetAllCampos:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $CampoObj= new CamposFormaObj();
                     $CampoObj->idcampoforma=$row['idcampoforma'];
                     $CampoObj->idforma=$row['idforma'];
                     $CampoObj->idtipocampo=$row['idtipocampo'];
                     $CampoObj->nombre=$row['nombre'];
                     $CampoObj->valorpordefecto=$row['valorpordefecto'];
                     $CampoObj->activo=$row['activo'];
                     $CampoFormaCollection->addItem($CampoObj);
                 }
            }

            $this->mysqlconector->CloseDataBase();
        }
    }

}
