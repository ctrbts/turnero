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
 * Description of Reglascitas
 *
 * @author Fernando Merlo
 */
class Reglascitas
{
    private $ListReglaHorarios;
    private $ListDiasDisp;
    private $ListDiasAsueto;
    private $TiempoEstimadoObj;
    private $TiempoEntrecitaObj;
    private $_ADOReglasCitas;
    public $debug = false;

    public function __construct()
    {
        $this->_ADOReglasCitas = new ADOReglasCitas();
        $this->_ADOReglasCitas->debug = $this->debug;
        $this->ListReglaHorarios = new ArrayList();
        $this->ListDiasDisp = new ArrayList();
        $this->ListDiasAsueto = new ArrayList();
        $this->TiempoEstimadoObj = new ReglasTiempoEstimado();
        $this->TiempoEntrecitaObj = new ReglasTiempoEntreCita();
    }

    public function getListReglaHorarios()
    {
        $this->GetHorariosDisp();
        return $this->ListReglaHorarios;
    }

    public function getListDiasDisp()
    {
        $this->getDiasDisp();
        return $this->ListDiasDisp;
    }

    public function getListDiasAsueto()
    {
        $this->getDiasAsueto();
        return $this->ListDiasAsueto;
    }

    public function getTiempoEstimadoObj()
    {
        $this->getTiempoEst();
        return $this->TiempoEstimadoObj;
    }

    public function getTiempoEntrecitaObj()
    {
        $this->getTiempoEntreCita();
        return $this->TiempoEntrecitaObj;
    }

    private function GetHorariosDisp()
    {
        try {
            $this->_ADOReglasCitas->getHorarios($this->ListReglaHorarios);
        } catch (Exception $ex) {
            if ($this->debug) {
                echo $ex->getMessage();
            }
        }
    }

    private function getDiasDisp()
    {
        try {
            $this->_ADOReglasCitas->getDiasDisp($this->ListDiasDisp);
        } catch (Exception $ex) {
            if ($this->debug) {
                echo $ex->getMessage();
            }
        }
    }

    private function getDiasAsueto()
    {
        try {
            $this->_ADOReglasCitas->getDiasAsueto($this->ListDiasAsueto);
        } catch (Exception $ex) {
            if ($this->debug) {
                echo $ex->getMessage();
            }
        }
    }

    private function getTiempoEst()
    {
        try {
            $this->_ADOReglasCitas->GetTiempoEstimado($this->TiempoEstimadoObj);
        } catch (Exception $ex) {
            if ($this->debug) {
                echo $ex->getMessage();
            }
        }
    }

    private function getTiempoEntreCita()
    {
        try {
            $this->_ADOReglasCitas->GetTiempoEntreCita($this->TiempoEntrecitaObj);
        } catch (Exception $ex) {
            if ($this->debug) {
                echo $ex->getMessage();
            }
        }
    }
}
