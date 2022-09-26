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
 * Description of CamposFormaObj
 *
 * @author Fernando Merlo
 */
class CamposFormaObj {
    public $idcampoforma;
    public $idforma;
    public $idtipocampo;
    public $nombre;
    public $TipoCampoObj;
    public $activo;
    public $valorpordefecto;
    public $ValorCampoFormaObj;
    public $MultipleValoresObj;
    private $ArrayMultipleValues;
    public $idcita;

    public function GetTipoCampo(){
        if(empty($this->TipoCampoObj)){
            if(isset($this->idtipocampo) || !empty($this->idtipocampo)){
                $this->TipoCampoObj= new TipoCampoObj();
                $this->TipoCampoObj->idtiposcampo=  $this->idtipocampo;
                $ADOTipoCampo= new ADOTipoCampo();
                $ADOTipoCampo->GetTipoCampo($this->TipoCampoObj);
                unset($ADOTipoCampo);
            }
        }
    }

    public function GetMultipleValuesOption(){
        if(empty($this->MultipleValoresObj)){
            if(isset($this->idcampoforma) || !empty($this->idcampoforma)){
                $this->MultipleValoresObj = new MultipleValoresObj();
                $ADOMultipleValores= new ADOMultipleValores();
                $ADOMultipleValores->GetMulValFromCampoForma($this->idcampoforma, $this->MultipleValoresObj);
                unset($ADOMultipleValores);
            }
        }
    }

    private function SetMultipleValuesonArry(){
        $this->GetMultipleValuesOption();
        if(!empty($this->MultipleValoresObj->valores)){
            $this->ArrayMultipleValues= new ArrayList();
            $values=  explode("|", $this->MultipleValoresObj->valores);
            foreach($values as $item){
                $this->ArrayMultipleValues->addItem($item);
            }
        }
    }

    public function DisplayCampo(){
        $control = "";
        $this->GetTipoCampo();
        if(!empty($this->TipoCampoObj)){
            if($this->TipoCampoObj->selmultiple=="1"){
                $control= $this->TipoCampoObj->htmlcode;
                //encuentra la variable $id y la remplaza con el id del campo
                $control=  str_replace("&id", $this->idcampoforma, $control);

                ////encuentra si existe la variable &list
                $findname=strpos($control, "&name");
                if($findname!==false){
                    $str_val=  explode("&list", $control);
                    $control= str_replace("&name", $this->nombre,$str_val[0]);
                    $this->SetMultipleValuesonArry();
                    foreach($this->ArrayMultipleValues->array as $item){
                        $control= $control.$str_val[1];
                        $control=str_replace("&name", $this->nombre ,$control);
                        $control=str_replace("&value", $item ,$control);
                    }
                     $control= $control.$str_val[2];
                }

            }else{
                $control= $this->TipoCampoObj->htmlcode;
                //encuentra la variable $id y la remplaza con el id del campo
                $control=  str_replace("&id", $this->idcampoforma, $control);

                //encuentra donde se pone el valor de nombre en el campo
                $findname=strpos($control, "&name");
                if($findname!==false){
                    $control=  str_replace("&name", $this->nombre, $control);
                }

                //encuentra donde se pone el valor por default
                $findvalue=strpos($control, "&value");
                if($findvalue!==false){
                    $control=  str_replace("&value", $this->valorpordefecto, $control);
                }

            }
        }

        return $control;
    }

    public function GetValorObj(){
        if(empty($this->ValorCampoFormaObj)){
            if(isset($this->idcampoforma) && isset($this->idforma) && isset($this->idcita)){
                $this->ValorCampoFormaObj = new ValorCampoFormaObj();
                $this->ValorCampoFormaObj->idcampoforma=$this->idcampoforma;
                $this->ValorCampoFormaObj->idforma=$this->idforma;
                $this->ValorCampoFormaObj->idcita=  $this->idcita;
                $ADOValoresForma = new ADOValoresForma();
                $ADOValoresForma->GetValorPorCita($this->ValorCampoFormaObj);
                unset($ADOValoresForma);
            }
        }
    }

}
