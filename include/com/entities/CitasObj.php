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
 * Description of CitasObj
 *
 * @author Fernando Merlo
 */
class CitasObj {
    public $idcita;
    public $dia;
    public $mes;
    public $anio;
    public $hr_inicio;
    public $hr_fin;
    public $existindb=false;
    public $iduser;
    public $UserObj;
    public $idestatus=0;
    public $EstatusCitaObj;

    /*25 Oct 2018
     *   Agregar la funcionalidad de formularios
     *
     */

    public $FormasCollection;

    /*6 Nov 2018
     *    Se Agrego la variable idcitaenc para encripctar el idcita.
     */
    public $idcitaenc;

    /**7 Nov 2018
     *   Se agrega campo de notas
     *
     */
    public $nota;

    public function getHrFin(){
        return $this->hr_fin;
    }

    public function getHrInicio(){
        return $this->hr_inicio;
    }

    public function setHrInicio($hr_str){
        $this->hr_inicio=$hr_str;
    }

    public function setHrFin($hr_str){
        $this->hr_fin=$hr_str;
    }

    public function getUserObj(){

        if($this->iduser>0){
            $_ADOUser = new ADOUser();
            $this->UserObj= new UserObj();
             $this->UserObj->iduser=$this->iduser;
            $_ADOUser->getUserByID($this->UserObj);
        }
    }

    public function getEstatus(){

        if($this->idestatus==0){
            $this->EstatusCitaObj=new EstatusCitaObj();
            $this->EstatusCitaObj->idestatus=0;
            $this->EstatusCitaObj->estado="Agendada";
            $this->EstatusCitaObj->activo=1;
        }else{
            $_ADOCitasEstatus= new ADOCitasEstatus();
            //$_ADOCitasEstatus->debug=true;
            $this->EstatusCitaObj=new EstatusCitaObj();
            $this->EstatusCitaObj->idestatus=  $this->idestatus;
            //$_ADOCitasEstatus->debug=true;
            $_ADOCitasEstatus->GetEstatusById($this->EstatusCitaObj);
        }
    }

    public function GetFormas(){
        if(!isset($this->FormasCollection)){
            $this->FormasCollection= new ArrayList();
            $ADOFormas = new ADOFormas();
            $ADOFormas->GetFormasByCita($this->idcita,$this->FormasCollection);

        }
    }

    public function getCitaDateStartUTC(){
        if((!is_null($this->dia) && !is_null($this->mes) && !is_null($this->anio)) && (!is_null($this->hr_inicio) && !is_null($this->hr_fin))){
           $newdate= new DateTime($this->anio."-".$this->mes."-".$this->dia." ".$this->hr_inicio);
           $newdate->setTimezone(new DateTimeZone("UTC"));
        }
        return (isset($newdate)) ? $newdate : null;
    }

    public function getCitaDateEndUTC(){
        if((!is_null($this->dia) && !is_null($this->mes) && !is_null($this->anio)) && (!is_null($this->hr_inicio) && !is_null($this->hr_fin))){
           $newdate= new DateTime($this->anio."-".$this->mes."-".$this->dia." ".$this->hr_fin);
           $newdate->setTimezone(new DateTimeZone("UTC"));
        }
        return (isset($newdate)) ? $newdate : null;
    }

}
