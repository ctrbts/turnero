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
 * Description of AccessRol
 *
 * @author Fernando MerloGea
 */

class FormasObj{
    public $idforma;
    public $descripcion;
    public $activo;
    public $visible;
    public $seleccion;
    public $CamposFormaCollection;
    public $idcita;
    public $CitaObj;

    public function GetCamposDeForma(){
        if(!isset($this->CamposFormaCollection)){
            $this->CamposFormaCollection= new ArrayList();
        }

        if(isset($this->idforma)){
            $ADOCamposForma= new ADOCamposForma();
            $ADOCamposForma->GetCamposActivos($this->idforma, $this->CamposFormaCollection);
            $this->SetIdCitaenCampos();
        }
    }

    protected function SetIdCitaenCampos(){
        if(count($this->CamposFormaCollection->array)>0){
            foreach($this->CamposFormaCollection->array as $campo){
                $campo->idcita= $this->idcita;
            }
        }
    }

}

?>