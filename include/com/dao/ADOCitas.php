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
 * Description of ADOCitas
 *
 * @author Fernando Merlo
 */
class ADOCitas {
   private $mysqlconector;
    public $debug=false;

    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }

    public function InsertCita($CitaObj){
        if(!empty($CitaObj)){
            $this->mysqlconector->OpenConnection();
            $hr_inicio=  mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->getHrInicio());
            $hr_fin=mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->getHrFin());
            $dia= mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->dia);
            $mes=  mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->mes);
            $anio =  mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->anio);
            $iduser=  mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->iduser);
            $sql = "insert into t_citas(dia,mes,anio,hr_inicio,hr_fin,iduser,idestatus) values('$dia','$mes','$anio','$hr_inicio','$hr_fin',$iduser,0);";
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

    public function getCitasProg($ListCitas,$dia,$mes,$anio,$hr_inicio,$hr_fin){
        if(!empty($ListCitas)){
            $this->mysqlconector->OpenConnection();

            $_dia= mysqli_real_escape_string($this->mysqlconector->conn,$dia);
            $_mes= mysqli_real_escape_string($this->mysqlconector->conn,$mes);
            $_anio= mysqli_real_escape_string($this->mysqlconector->conn,$anio);
            $_hr_inicio=  mysqli_real_escape_string($this->mysqlconector->conn,$hr_inicio);
            $_hr_fin= mysqli_real_escape_string($this->mysqlconector->conn,$hr_fin);

            $sql = "SELECT idcita,dia,mes,anio,hr_inicio,hr_fin,iduser,idestatus,editmode,nota from t_citas where dia='$_dia' and mes='$_mes' and anio='$_anio' and hr_inicio='$_hr_inicio' and hr_fin='$_hr_fin' ;";

            if ($this->debug){
                echo $sql;
            }

            try{
                $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $cita =  new CitasDBObj();
                        $cita->idcita=$row['idcita'];
                        $cita->dia=$row['dia'];
                        $cita->mes=$row['mes'];
                        $cita->anio=$row['anio'];
                        $cita->setHrInicio($row['hr_inicio']);
                        $cita->setHrFin($row['hr_fin']);
                        $cita->iduser=$row['iduser'];
                        $cita->idestatus=$row['idestatus'];
                        $cita->editmode=$row['editmode'];
                        $cita->nota=$row['nota'];
                        $ListCitas->addItem($cita);
                    }
                }
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
        }

        $this->mysqlconector->CloseDataBase();
    }

    public function getCita($CitaObj){
        if(!empty($CitaObj)){
            $this->mysqlconector->OpenConnection();
                $hr_inicio=  mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->getHrInicio());
                $hr_fin=  mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->getHrFin());
                $dia= mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->dia);
                $mes= mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->mes);
                $anio= mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->anio);


                $sql = "SELECT idcita,dia,mes,anio,hr_inicio,hr_fin,iduser,idestatus,editmode,nota from t_citas where dia='$dia' and mes='$mes' and anio='$anio' and hr_inicio='$hr_inicio' and hr_fin='$hr_fin' ;";

                if ($this->debug){
                    echo $sql;
                }

                try{
                    $result= $this->mysqlconector->conn->query($sql);
                    if($result->num_rows>0){
                        while($row = $result->fetch_assoc()) {
                            $CitaObj->idcita=$row['idcita'];
                            $CitaObj->dia=$row['dia'];
                            $CitaObj->mes=$row['mes'];
                            $CitaObj->anio=$row['anio'];
                            $CitaObj->setHrInicio($row['hr_inicio']);
                            $CitaObj->setHrFin($row['hr_fin']);
                            $CitaObj->iduser=$row['iduser'];
                            $CitaObj->idestatus=$row['idestatus'];
                            $CitaObj->editmode=$row['editmode'];
                            $CitaObj->nota=$row['nota'];
                        }
                    }
                } catch (Exception $ex) {
                    if($this->debug){
                        echo $ex->getMessage();
                    }
                }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function GetCitasByUser($ListaCitaObj,$CitaObj){
        if(!empty($ListaCitaObj) && !empty($CitaObj)){
            $this->mysqlconector->OpenConnection();

            $iduser=  mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->iduser);

            $sql = 'SELECT idcita,dia,mes,anio,hr_inicio,hr_fin,iduser,idestatus,editmode,nota from t_citas where iduser='.$iduser.' order by DATE(concat(anio,"-",mes,"-",dia)) desc ;';

            if ($this->debug){
                echo $sql;
            }

            try{
                $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $cita =  new CitasObj();
                        $cita->idcita=$row['idcita'];
                        $cita->dia=$row['dia'];
                        $cita->mes=$row['mes'];
                        $cita->anio=$row['anio'];
                        $cita->setHrInicio($row['hr_inicio']);
                        $cita->setHrFin($row['hr_fin']);
                        $cita->iduser=$row['iduser'];
                        $cita->idestatus=$row['idestatus'];
                        $cita->editmode=$row['editmode'];
                        $cita->nota=$row['nota'];
                        $ListaCitaObj->addItem($cita);
                    }
                }
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
        }

        $this->mysqlconector->CloseDataBase();
    }

    public function GetCitasFromDB($ListaCitaObj,$month,$year){
        if(!empty($ListaCitaObj)){
            $this->mysqlconector->OpenConnection();

            $_month= mysqli_real_escape_string($this->mysqlconector->conn,$month);
            $_year=  mysqli_real_escape_string($this->mysqlconector->conn,$year);

            $sql = "SELECT idcita,dia,mes,anio,hr_inicio,hr_fin,iduser,idestatus,editmode,nota from t_citas where anio='$_year' and mes='$_month' order by  DATE(concat(anio,'-',mes,'-',dia)) desc ;";

            if ($this->debug){
                echo $sql;
            }

            try{
                $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $cita =  new CitasObj();
                        $cita->idcita=$row['idcita'];
                        $cita->dia=$row['dia'];
                        $cita->mes=$row['mes'];
                        $cita->anio=$row['anio'];
                        $cita->setHrInicio($row['hr_inicio']);
                        $cita->setHrFin($row['hr_fin']);
                        $cita->iduser=$row['iduser'];
                        $cita->idestatus=$row['idestatus'];
                        $cita->editmode=$row['editmode'];
                        $cita->nota=$row['nota'];
                        $ListaCitaObj->addItem($cita);
                    }
                }
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    protected function GetAllCitasFromDB($ListaCitaObj){
        if(!empty($ListaCitaObj)){
            $this->mysqlconector->OpenConnection();

            $sql = "SELECT idcita,dia,mes,anio,hr_inicio,hr_fin,iduser,idestatus,editmode,nota from t_citas order by  DATE(concat(anio,'-',mes,'-',dia)) desc ;";

            if ($this->debug){
                echo $sql;
            }

            try{
                $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $cita =  new CitasObj();
                        $cita->idcita=$row['idcita'];
                        $cita->dia=$row['dia'];
                        $cita->mes=$row['mes'];
                        $cita->anio=$row['anio'];
                        $cita->setHrInicio($row['hr_inicio']);
                        $cita->setHrFin($row['hr_fin']);
                        $cita->iduser=$row['iduser'];
                        $cita->idestatus=$row['idestatus'];
                        $cita->editmode=$row['editmode'];
                        $cita->nota=$row['nota'];
                        $ListaCitaObj->addItem($cita);
                    }
                }
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    protected function GetCitasFromDBByYear($year,$ListaCitaObj){
        if(!empty($ListaCitaObj)){
            $this->mysqlconector->OpenConnection();

            $_year=  mysqli_real_escape_string($this->mysqlconector->conn,$year);

            $sql = "SELECT idcita,dia,mes,anio,hr_inicio,hr_fin,iduser,idestatus,
                    editmode,nota from t_citas where anio='$_year' order by  DATE(concat(anio,'-',mes,'-',dia)) desc ;";

            if ($this->debug){
                echo $sql;
            }

            try{
                $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $cita =  new CitasObj();
                        $cita->idcita=$row['idcita'];
                        $cita->dia=$row['dia'];
                        $cita->mes=$row['mes'];
                        $cita->anio=$row['anio'];
                        $cita->setHrInicio($row['hr_inicio']);
                        $cita->setHrFin($row['hr_fin']);
                        $cita->iduser=$row['iduser'];
                        $cita->idestatus=$row['idestatus'];
                        $cita->editmode=$row['editmode'];
                        $cita->nota=$row['nota'];
                        $ListaCitaObj->addItem($cita);
                    }
                }
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function GetCitasFromDBJSON($data,$month,$year){
        if(!empty($ListaCitaObj)){
            $this->mysqlconector->OpenConnection();

            $_month= mysqli_real_escape_string($this->mysqlconector->conn,$month);
            $_year=  mysqli_real_escape_string($this->mysqlconector->conn,$year);

            $sql = "SELECT idcita,dia,mes,anio,hr_inicio,hr_fin,iduser,idestatus,editmode,nota from t_citas where anio='$_year' and mes='$_month' order by dia ;";

            if ($this->debug){
                echo $sql;
            }

            try{
                $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        /*$cita =  new CitasObj();
                        $cita->idcita=$row['idcita'];
                        $cita->dia=$row['dia'];
                        $cita->mes=$row['mes'];
                        $cita->anio=$row['anio'];
                        $cita->setHrInicio($row['hr_inicio']);
                        $cita->setHrFin($row['hr_fin']);
                        $cita->iduser=$row['iduser'];
                        $cita->idestatus=$row['idestatus'];
                        $cita->editmode=$row['editmode'];
                        $ListaCitaObj->addItem($cita);*/
                        $data[]=($row);
                    }
                }
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function getCitabyID($CitaObj){
        if(!empty($CitaObj)){
            $this->mysqlconector->OpenConnection();
                $idcita= mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->idcita);
                $sql = "SELECT idcita,dia,mes,anio,hr_inicio,hr_fin,iduser,idestatus,editmode,nota from t_citas where idcita=".$idcita .";";
                if ($this->debug){
                    echo $sql;
                }

                try{
                    $result= $this->mysqlconector->conn->query($sql);
                    if($result->num_rows>0){
                        while($row = $result->fetch_assoc()) {
                            $CitaObj->idcita=$row['idcita'];
                            $CitaObj->dia=$row['dia'];
                            $CitaObj->mes=$row['mes'];
                            $CitaObj->anio=$row['anio'];
                            $CitaObj->setHrInicio($row['hr_inicio']);
                            $CitaObj->setHrFin($row['hr_fin']);
                            $CitaObj->iduser=$row['iduser'];
                            $CitaObj->idestatus=$row['idestatus'];
                            $CitaObj->editmode=$row['editmode'];
                            $CitaObj->nota=$row['nota'];
                        }
                    }
                } catch (Exception $ex) {
                    if($this->debug){
                        echo $ex->getMessage();
                    }
                }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function CancelCita($CitaObj){
        if(!empty($CitaObj)){
            $this->mysqlconector->OpenConnection();
            $idcita=  mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->idcita);
            $sql = "update t_citas set idestatus=2 where idcita=$idcita";
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

    public function UpdateNota($nota,$idcita){
        if(!empty($nota) && !empty($idcita)){
            $this->mysqlconector->OpenConnection();

            $_nota= mysqli_real_escape_string($this->mysqlconector->conn,$nota);
            $_idcita= mysqli_real_escape_string($this->mysqlconector->conn,$idcita);

            $sql= new SqlQueryBuilder("update");
            $sql->setTable("t_citas");
            $sql->addColumn("nota");
            $sql->addValue($_nota);
            $sql->setWhere("idcita=$_idcita");

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

    public function UpdateEstatusCita($CitaObj){
        if(!empty($CitaObj)){
            $this->mysqlconector->OpenConnection();
            $idcita=  mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->idcita);
            $idestatus= mysqli_real_escape_string($this->mysqlconector->conn,$CitaObj->idestatus);

            $sql = "update t_citas set idestatus=$idestatus where idcita=$idcita";

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

    public function GetCitasByYear($year,$RecordsByPage,$actualpage,$ListaCitaObj){
        $ListaTemp= new ArrayList();
        $this->GetCitasFromDBByYear($year,$ListaTemp);
        $Paging= new PagingController($RecordsByPage);
        $ListaCitaObj->array=$Paging->GetRecordsPaging($actualpage,$ListaTemp)->array;
        return $Paging->totalPages;
    }

    public function GetCitasByMonth($month,$year,$RecordsByPage,$actualpage,$ListaCitaObj){
        $ListaTemp= new ArrayList();
        $this->GetCitasFromDB($ListaTemp,$month,$year);
        $Pagin= new PagingController($RecordsByPage);
        $ListaCitaObj->array= $Pagin->GetRecordsPaging($actualpage,$ListaTemp)->array;
        return $Pagin->totalPages;
    }

    public function GetCitasAll($RecordsByPage,$actualpage,$ListaCitaObj){
        $ListaTemp= new ArrayList();
        $this->GetAllCitasFromDB($ListaTemp);
        $Pagin= new PagingController($RecordsByPage);
        $ListaCitaObj->array= $Pagin->GetRecordsPaging($actualpage,$ListaTemp)->array;
        return $Pagin->totalPages;
    }

    public function CountCitas($Condition){
        $returnvalue=0;
        $this->mysqlconector->OpenConnection();

        $sql="select count(1) as countcitas from t_citas ";
        if (!is_null($Condition)){
            $where=mysqli_real_escape_string($this->mysqlconector->conn,$Condition);
            $sql=$sql." where ".$where;
        }
        if ($this->debug){
            echo $sql;
        }
        $result=$this->mysqlconector->conn->query($sql);
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()) {
                $returnvalue=$row["countcitas"];
            }
        }
        $this->mysqlconector->CloseDataBase();
        return $returnvalue;
    }
}
