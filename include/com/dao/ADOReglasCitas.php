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
 * Description of ADOReglasCitas
 *
 * @author Fernando Merlo
 */
class ADOReglasCitas {
    private $mysqlconector;
    public $debug=false;

    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }

    public function AddHorariosToDB($ReglaHorariosObj){
        if(!is_null($ReglaHorariosObj)){
            $this->mysqlconector->OpenConnection();

            $hr_inicio= mysqli_real_escape_string($this->mysqlconector->conn,$ReglaHorariosObj->hr_inicio);
            $hr_fin = mysqli_real_escape_string($this->mysqlconector->conn,$ReglaHorariosObj->hr_fin);

            $sql = "insert into t_regla_horarios(hr_inicio,hr_fin) values ('$hr_inicio','$hr_fin')";
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

    public function DeleteHorarios($ReglaHorariosObj){
         if(!is_null($ReglaHorariosObj)){
            $this->mysqlconector->OpenConnection();

            $idhrs= mysqli_real_escape_string($this->mysqlconector->conn,$ReglaHorariosObj->idhrs);

            $sql = "delete from t_regla_horarios where idhrs=$idhrs";
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

     public function UpdateHorarios($ReglaHorariosObj){
         if(!is_null($ReglaHorariosObj)){
            $this->mysqlconector->OpenConnection();

            $hr_inicio= mysqli_real_escape_string($this->mysqlconector->conn,$ReglaHorariosObj->hr_inicio);
            $hr_fin = mysqli_real_escape_string($this->mysqlconector->conn,$ReglaHorariosObj->hr_fin);
            $idhrs= mysqli_real_escape_string($this->mysqlconector->conn,$ReglaHorariosObj->idhrs);

            $sql = "update t_regla_horarios set hr_inicio='$hr_inicio',hr_fin='$hr_fin' where idhrs=$idhrs";
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

    public function getHorarios($ListReglasHrs){
        if(!is_null($ListReglasHrs)){
            $this->mysqlconector->OpenConnection();
            $sql = "Select idhrs,hr_inicio,hr_fin from t_regla_horarios;";
            if ($this->debug){
                echo $sql;
            }
            try{
                $result=$this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $hrs= new ReglaHorarios();
                        $hrs->idhrs=$row["idhrs"];
                        $hrs->hr_inicio=$row["hr_inicio"];
                        $hrs->hr_fin=$row["hr_fin"];
                        $ListReglasHrs->addItem($hrs);
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

    public function getHorasByID($ReglaHorariosObj){
        if(!is_null($ReglaHorariosObj)){
            $this->mysqlconector->OpenConnection();

            $idhrs= mysqli_real_escape_string($this->mysqlconector->conn,$ReglaHorariosObj->idhrs);

            $sql = "Select idhrs,hr_inicio,hr_fin from t_regla_horarios where idhrs=$idhrs;";
            if ($this->debug){
                echo $sql;
            }
            try{
                $result=$this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $ReglaHorariosObj->idhrs=$row["idhrs"];
                        $ReglaHorariosObj->hr_inicio=$row["hr_inicio"];
                        $ReglaHorariosObj->hr_fin=$row["hr_fin"];
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

    public function AddDiaDisp($ReglaDiasDispObj){
        if(!empty($ReglaDiasDispObj)){
            $this->mysqlconector->OpenConnection();

            $dia= mysqli_real_escape_string($this->mysqlconector->conn,$ReglaDiasDispObj->dia);
            $activo=  mysqli_real_escape_string($this->mysqlconector->conn,$ReglaDiasDispObj->activo);

            $sql = "insert into t_regla_diasdisp(dia,activo) values ('$dia',$activo)";
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

    public function AddListaDiasDisp($ListaReglaDiasDisp){
        if(!empty($ListaReglaDiasDisp)){
            foreach ($ListaReglaDiasDisp->array as $item){
                $this->AddDiaDisp($item);
            }
        }
    }

    public function DeleteAllDiasDisp(){
        $this->mysqlconector->OpenConnection();
        $sql = "delete from t_regla_diasdisp where iddias>0";

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

    public function getDiasDisp($ListaReglaDiasDisp){
        if(!empty($ListaReglaDiasDisp)){
            $this->mysqlconector->OpenConnection();
            $sql = "Select iddias,dia,activo from t_regla_diasdisp";
            if ($this->debug){
                echo $sql;
            }
            try{
                $result=$this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $diasdisp= new ReglasDiasDisp();
                        $diasdisp->iddias=$row['iddias'];
                        $diasdisp->dia=$row['dia'];
                        $diasdisp->activo=$row['activo'];
                        $ListaReglaDiasDisp->addItem($diasdisp);
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

    public function CleanAndInsertDiasDisp($ListaReglaDiasDisp){
        if(!empty($ListaReglaDiasDisp)){
            try{
                $this->DeleteAllDiasDisp();
            } catch (Exception $ex) {
                if($debug){
                    echo $ex->getMessage();
                }
            }
            try{
                $this->AddListaDiasDisp($ListaReglaDiasDisp);
            } catch (Exception $ex) {
                if($debug){
                    echo $ex->getMessage();
                }
            }

        }
    }

    public function AddDiaAsueto($ReglasDiaAsuetoObj){
        if(!empty($ReglasDiaAsuetoObj)){
            $this->mysqlconector->OpenConnection();
            $dia=  mysqli_real_escape_string($this->mysqlconector->conn,$ReglasDiaAsuetoObj->getDia());
            $sql = "insert into t_regla_diasasueto(dia) values ('$dia')";
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

    public function DeleteDiaAsueto($ReglasDiaAsuetoObj){
        if(!empty($ReglasDiaAsuetoObj)){
            $this->mysqlconector->OpenConnection();
            $iddiaasueto=  mysqli_real_escape_string($this->mysqlconector->conn,$ReglasDiaAsuetoObj->iddiaasueto);
            $sql = "delete from t_regla_diasasueto where iddiaasueto=$iddiaasueto";
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

    public function getDiasAsueto($ListaReglasDiaAsuetoObj){
        if(!empty($ListaReglasDiaAsuetoObj)){
            $this->mysqlconector->OpenConnection();
            //$sql = "Select iddiaasueto,DATE_FORMAT(dia,'%m/%d/%Y') from t_regla_diasasueto";
            $sql = "Select iddiaasueto,DATE_FORMAT(dia,'%Y-%m-%d') as diaform from t_regla_diasasueto";
            if ($this->debug){
                echo $sql;
            }
            try{
                $result=$this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $diaasueto= new ReglasDiaAsueto();
                        $diaasueto->iddiaasueto=$row['iddiaasueto'];
                        $diaasueto->dia=strtotime($row['diaform']);
                        $ListaReglasDiaAsuetoObj->addItem($diaasueto);
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
    public function getDiasAsuetoByYear($ListaReglasDiaAsuetoObj,$anosel){
        if(!empty($ListaReglasDiaAsuetoObj)){
            $this->mysqlconector->OpenConnection();
            $_anosel=  mysqli_real_escape_string($this->mysqlconector->conn,$anosel);
            $sql = "Select iddiaasueto,DATE_FORMAT(dia,'%Y-%m-%d') as diaform from t_regla_diasasueto where DATE_FORMAT(dia,'%Y')=$_anosel";
            if ($this->debug){
                echo $sql;
            }
            try{
                $result=$this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $diaasueto= new ReglasDiaAsueto();
                        $diaasueto->iddiaasueto=$row['iddiaasueto'];
                        //$diaasueto->setDia($row['dia']);
                        $diaasueto->dia=$row['diaform'];
                        $ListaReglasDiaAsuetoObj->addItem($diaasueto);
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

    public function AddTiempoEstimado($ReglasTiempoEstimadoObj){
        if(!empty($ReglasTiempoEstimadoObj)){
            $this->mysqlconector->OpenConnection();
            $var=  mysqli_real_escape_string($this->mysqlconector->conn,$ReglasTiempoEstimadoObj->getVariable());
            $valor=  mysqli_real_escape_string($this->mysqlconector->conn,$ReglasTiempoEstimadoObj->valor);
            $sql = "insert into t_regla_general(variable,valor) values ('$var','$valor')";
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

    public function DeleteTiempoEstimado($ReglasTiempoEstimadoObj){
        if(!empty($ReglasTiempoEstimadoObj)){
            $this->mysqlconector->OpenConnection();
            $var=  mysqli_real_escape_string($this->mysqlconector->conn,$ReglasTiempoEstimadoObj->getVariable());
            $sql = "delete from t_regla_general where variable='$var'";
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

    public function GetTiempoEstimado($ReglasTiempoEstimadoObj){
        if(!empty($ReglasTiempoEstimadoObj)){
            $this->mysqlconector->OpenConnection();
            $var=  mysqli_real_escape_string($this->mysqlconector->conn,$ReglasTiempoEstimadoObj->getVariable());
            $sql = "Select idreglageneral,variable,valor from t_regla_general where variable='$var'";
            if ($this->debug){
                echo $sql;
            }
            try{
                $result=$this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $ReglasTiempoEstimadoObj->idreglageneral=$row['idreglageneral'];
                        $ReglasTiempoEstimadoObj->variable=$row['variable'];
                        $ReglasTiempoEstimadoObj->valor=$row['valor'];
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

    public function AddTiempoEntreCita($ReglasTiempoEntreCita){
        if(!empty($ReglasTiempoEntreCita)){
            $this->mysqlconector->OpenConnection();
            $var=  mysqli_real_escape_string($this->mysqlconector->conn,$ReglasTiempoEntreCita->getVariable());
            $valor= mysqli_real_escape_string($this->mysqlconector->conn,$ReglasTiempoEntreCita->valor);
            $sql = "insert into t_regla_general(variable,valor) values ('$var','$valor')";
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

    public function DeleteTiempoEntreCita($ReglasTiempoEntreCita){
        if(!empty($ReglasTiempoEntreCita)){
            $this->mysqlconector->OpenConnection();
            $var=  mysqli_real_escape_string($this->mysqlconector->conn,$ReglasTiempoEntreCita->getVariable());
            $sql = "delete from t_regla_general where variable='$var'";
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

    public function GetTiempoEntreCita($ReglasTiempoEntreCita){
        if(!empty($ReglasTiempoEntreCita)){
            $this->mysqlconector->OpenConnection();
            $var=  mysqli_real_escape_string($this->mysqlconector->conn,$ReglasTiempoEntreCita->getVariable());
            $sql = "Select idreglageneral,variable,valor from t_regla_general where variable='$var'";
            if ($this->debug){
                echo $sql;
            }
            try{
                $result=$this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $ReglasTiempoEntreCita->idreglageneral=$row['idreglageneral'];
                        $ReglasTiempoEntreCita->valor=$row['valor'];
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




}
