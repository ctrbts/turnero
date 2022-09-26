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
 * Description of ADOTipoCampo
 *
 * @author Fernando Merlo
 */
class ADOTipoCampo {

    private $mysqlconector;
    public $debug=false;

    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }

    public function InsertTipoCampo($TipoCampoObj){
        if(!empty($TipoCampoObj)){
            $this->mysqlconector->OpenConnection();
            $descripcion = mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->descripcion);
            $tipo=  mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->tipo);
            //$htmlcode= mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->htmlcode);
            $htmlcode= $TipoCampoObj->htmlcode;
            $seleccionmultiple= mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->selmultiple);
            $activo=  mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->activo);

            $sql = new SqlQueryBuilder("insert");
            $sql->setTable("t_campos_tipos");
            $sql->addColumn("descripcion");
            $sql->addColumn("tipo");
            $sql->addColumn("htmlcode");
            $sql->addColumn("selmultiple");
            $sql->addColumn("activo");

            $sql->addValue($descripcion);
            $sql->addValue($tipo);
            $sql->addValue(base64_encode($htmlcode));
            $sql->addValue($seleccionmultiple);
            $sql->addValue($activo);

            if ($this->debug){
                echo '<br/>';
                echo $sql->buildQuery();
                echo '<br/>';
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

    public function UpdateTipoCampo($TipoCampoObj){
        if(!empty($TipoCampoObj)){
            $this->mysqlconector->OpenConnection();
            $idtiposcampo=  mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->idtiposcampo);
            $descripcion = mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->descripcion);
            $tipo=  mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->tipo);
            //$htmlcode= mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->htmlcode);
            $htmlcode= $TipoCampoObj->htmlcode;
            $seleccionmultiple= mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->selmultiple);
            $activo=  mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->activo);

            $sql = new SqlQueryBuilder("update");
            $sql->setTable("t_campos_tipos");
            $sql->addColumn("descripcion");
            $sql->addColumn("tipo");
            $sql->addColumn("htmlcode");
            $sql->addColumn("selmultiple");
            $sql->addColumn("activo");

            $sql->addValue($descripcion);
            $sql->addValue($tipo);
            $sql->addValue(base64_encode($htmlcode));
            $sql->addValue($seleccionmultiple);
            $sql->addValue($activo);

            $sql->setWhere("idtiposcampo=$idtiposcampo");

            if ($this->debug){
                echo '<br/>';
                echo $sql->buildQuery();
                echo '<br/>';
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

    public function ActivateTipoCampo($TipoCampoObj){
        if(!empty($TipoCampoObj)){
            $this->mysqlconector->OpenConnection();
            $idtiposcampo=  mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->idtiposcampo);


            $sql = new SqlQueryBuilder("update");
            $sql->setTable("t_campos_tipos");
            $sql->addColumn("activo");

            $sql->addValue(1);

            $sql->setWhere("idtiposcampo=$idtiposcampo");

            if ($this->debug){
                echo '<br/>';
                echo $sql->buildQuery();
                echo '<br/>';
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

    public function DeactivateTipoCampo($TipoCampoObj){
        if(!empty($TipoCampoObj)){
            $this->mysqlconector->OpenConnection();
            $idtiposcampo=  mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->idtiposcampo);


            $sql = new SqlQueryBuilder("update");
            $sql->setTable("t_campos_tipos");
            $sql->addColumn("activo");

            $sql->addValue(0);

            $sql->setWhere("idtiposcampo=$idtiposcampo");

            if ($this->debug){
                echo '<br/>';
                echo $sql->buildQuery();
                echo '<br/>';
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

    public function GetTiposCampos($TipoCamposCollection){
        if(!empty($TipoCamposCollection)){
            $this->mysqlconector->OpenConnection();

            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_campos_tipos");
            $sql->addColumn("idtiposcampo");
            $sql->addColumn("descripcion");
            $sql->addColumn("tipo");
            $sql->addColumn("activo");
            $sql->addColumn("htmlcode");
            $sql->addColumn("selmultiple");

            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOTipoCampos::GetTiposCampos:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $TipoCampoObjec = new TipoCampoObj() ;
                     $TipoCampoObjec->idtiposcampo=$row['idtiposcampo'];
                     $TipoCampoObjec->descripcion=$row['descripcion'];
                     $TipoCampoObjec->tipo=$row['tipo'];
                     $TipoCampoObjec->activo=$row['activo'];
                     $TipoCampoObjec->htmlcode= base64_decode( $row['htmlcode']);
                     $TipoCampoObjec->selmultiple=$row['selmultiple'];

                     $TipoCamposCollection->addItem($TipoCampoObjec);
                 }
            }


            $this->mysqlconector->CloseDataBase();
        }
    }

    public function GetTipoCampo($TipoCampoObj){
        if(!empty($TipoCampoObj)){
            $this->mysqlconector->OpenConnection();
            $idtiposcampo= mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->idtiposcampo);

            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_campos_tipos");
            $sql->addColumn("idtiposcampo");
            $sql->addColumn("descripcion");
            $sql->addColumn("tipo");
            $sql->addColumn("activo");
            $sql->addColumn("htmlcode");
            $sql->addColumn("selmultiple");
            $sql->setWhere("idtiposcampo=$idtiposcampo");


            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOTipoCampo::GetTipoCampo:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {

                     $TipoCampoObj->idtiposcampo=$row['idtiposcampo'];
                     $TipoCampoObj->descripcion=$row['descripcion'];
                     $TipoCampoObj->tipo=$row['tipo'];
                     $TipoCampoObj->activo=$row['activo'];
                     $TipoCampoObj->htmlcode= base64_decode($row['htmlcode']);
                     $TipoCampoObj->selmultiple=$row['selmultiple'];

                 }
            }


            $this->mysqlconector->CloseDataBase();
        }
    }

    private function CheckBeforeDelete($TipoCampoObj){
        $delete=false;
        if(!empty($TipoCampoObj)){
            $this->mysqlconector->OpenConnection();
            $idtiposcampo= mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->idtiposcampo);

            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_formulario_campos");
            $sql->addColumn("count(1) as contador");
            $sql->setWhere("idtipocampo=$idtiposcampo");

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
            return $delete;
        }
    }

    public function DeleteTipoCampo($TipoCampoObj){
        $deleted=false;
        if(!empty($TipoCampoObj)){
            $checkbeforedelete= $this->CheckBeforeDelete($TipoCampoObj);

            if($checkbeforedelete){
                $this->mysqlconector->OpenConnection();
                $idtiposcampo=  mysqli_real_escape_string($this->mysqlconector->conn,$TipoCampoObj->idtiposcampo);

                $sql= new SqlQueryBuilder("delete");
                $sql->setTable("t_campos_tipos");
                $sql->setWhere("idtiposcampo=$idtiposcampo");

                if($this->debug){
                    echo '</br>';
                    echo $sql->buildQuery();
                    echo '</br>';
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


    public function GetTiposCamposActivos($TipoCamposCollection){
        if(!empty($TipoCamposCollection)){
            $this->mysqlconector->OpenConnection();

            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_campos_tipos");
            $sql->addColumn("idtiposcampo");
            $sql->addColumn("descripcion");
            $sql->addColumn("tipo");
            $sql->addColumn("activo");
            $sql->addColumn("htmlcode");
            $sql->addColumn("selmultiple");

            $sql->setWhere("activo=1");

            if($this->debug){
                echo '</br>';
                echo $sql->buildQuery();
                echo '</br>';
            }
            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOTipoCampos::GetTiposCampos:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                 while($row = $result->fetch_assoc()) {
                     $TipoCampoObjec = new TipoCampoObj() ;
                     $TipoCampoObjec->idtiposcampo=$row['idtiposcampo'];
                     $TipoCampoObjec->descripcion=$row['descripcion'];
                     $TipoCampoObjec->tipo=$row['tipo'];
                     $TipoCampoObjec->activo=$row['activo'];
                     $TipoCampoObjec->htmlcode= base64_decode( $row['htmlcode']);
                     $TipoCampoObjec->selmultiple=$row['selmultiple'];

                     $TipoCamposCollection->addItem($TipoCampoObjec);
                 }
            }


            $this->mysqlconector->CloseDataBase();
        }
    }


}
