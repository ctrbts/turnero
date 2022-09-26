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
 * Description of ADOSystemConf
 *
 * @author Fernando Merlo
 */
class ADOSystemConf {
    private $mysqlconector;
    public $debug=false;

    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }

    public function InsertVariable($SystemConfObj){
        if(!empty($SystemConfObj)){
            $existvariable=false;
            $existvariable=$this->ExistVariable($SystemConfObj);

            if(!$existvariable){

                $this->mysqlconector->OpenConnection();

                $variable= mysqli_real_escape_string($this->mysqlconector->conn,$SystemConfObj->variable);
                $valor= mysqli_real_escape_string($this->mysqlconector->conn,$SystemConfObj->valor);

                $sql= new SqlQueryBuilder("insert");
                $sql->setTable("t_systemconf");
                $sql->addColumn("variable");
                $sql->addColumn("valor");
                $sql->addValue($variable);
                $sql->addValue($valor);

                if($this->debug){
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
            }else{

                $this->UpdateVariableByName($SystemConfObj);
            }
        }
    }
    public function DeleteVariable($SystemConfObj){
        if(!empty($SystemConfObj)){
            $this->mysqlconector->OpenConnection();

            $idvariable = mysqli_real_escape_string($this->mysqlconector->conn,$SystemConfObj->idvariable);

            $sql= new SqlQueryBuilder("delete");
            $sql->setTable("t_systemconf");
            $sql->setWhere("idvariable=$idvariable");

            if($this->debug){
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
    public function UpdateVariable($SystemConfObj){
        if(!empty($SystemConfObj)){
            $this->mysqlconector->OpenConnection();

            $variable= mysqli_real_escape_string($this->mysqlconector->conn,$SystemConfObj->variable);
            $valor= mysqli_real_escape_string($this->mysqlconector->conn,$SystemConfObj->valor);
            $idvariable = mysqli_real_escape_string($this->mysqlconector->conn,$SystemConfObj->idvariable);

            $sql= new SqlQueryBuilder("update");
            $sql->setTable("t_systemconf");
            $sql->addColumn("variable");
            $sql->addColumn("valor");
            $sql->addValue($variable);
            $sql->addValue($valor);
            $sql->setWhere("idvariable=$idvariable");

            if($this->debug){
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
    public function UpdateVariableByName($SystemConfObj){
        if(!empty($SystemConfObj)){
            $this->mysqlconector->OpenConnection();

            $variable= mysqli_real_escape_string($this->mysqlconector->conn,$SystemConfObj->variable);
            $valor= mysqli_real_escape_string($this->mysqlconector->conn,$SystemConfObj->valor);

            $sql= new SqlQueryBuilder("update");
            $sql->setTable("t_systemconf");
            $sql->addColumn("valor");
            $sql->addValue($valor);
            $sql->setWhere("variable='$variable'");

            if($this->debug){
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
    public function GetVariableByID($SystemConfObj){
        if(!empty($SystemConfObj)){
            $this->mysqlconector->OpenConnection();

            $idvariable = mysqli_real_escape_string($this->mysqlconector->conn,$SystemConfObj->idvariable);

            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_systemconf");
            $sql->addColumn("variable");
            $sql->addColumn("valor");
            $sql->setWhere("idvariable=$idvariable");

            if($this->debug){
                echo '<br/>';
                echo $sql->buildQuery();
                echo '<br/>';
            }

            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOCampoForma::GetAllCampos:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $SystemConfObj->variable=$row["variable"];
                    $SystemConfObj->valor=$row["valor"];
                }
            }

            $this->mysqlconector->CloseDataBase();
        }
    }
    public function GetVariableByName($SystemConfObj){
        if(!empty($SystemConfObj)){
            $this->mysqlconector->OpenConnection();

            $variable= mysqli_real_escape_string($this->mysqlconector->conn,$SystemConfObj->variable);

            $sql= new SqlQueryBuilder("select");
            $sql->setTable("t_systemconf");
            $sql->addColumn("variable");
            $sql->addColumn("valor");
            $sql->addColumn("idvariable");

            $sql->setWhere("variable='$variable'");

            if($this->debug){
                echo '<br/>';
                echo $sql->buildQuery();
                echo '<br/>';
            }

            $result=  $this->mysqlconector->conn->query($sql->buildQuery()) or trigger_error("Error ADOCampoForma::GetAllCampos:mysqli=".mysqli_error($this->mysqlconector->conn),E_USER_ERROR);
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    $SystemConfObj->variable=$row["variable"];
                    $SystemConfObj->valor=$row["valor"];
                    $SystemConfObj->idvariable=$row['idvariable'];
                }
            }



            $this->mysqlconector->CloseDataBase();
        }
    }

    public function ExistVariable($SystemConfObj){
        $exist=false;
        if(!empty($SystemConfObj)){
            $existconf= new SystemConfObj();
            $existconf->variable=$SystemConfObj->variable;
            $this->GetVariableByName($existconf);

            if(!empty($existconf->idvariable)){
                $exist=true;
            }
        return $exist;
        }
    }

}
