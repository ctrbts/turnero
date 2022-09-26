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
 * Description of ModulesMenu
 *
 * @author Fernando Merlo
 */
class ModulesMenu {
    public $idmodulo=-1;
    public $etiqueta;
    public $activo;
    public $path;
    public $hasmenus;
    public $accion;
    public $ListofMenuObj;

    public function getMenus(){
        //$this->ListofMenuObj= new ArrayList();
        $ListMenu = new ArrayList();
        $idmodulo= $this->idmodulo;
        $_ADOMenus = new ADOMenus();
        $_ADOMenus->GetMenusByModule($ListMenu,$idmodulo);
        $this->ListofMenuObj=$ListMenu;
    }


}
