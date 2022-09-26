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
 * Descripcion de HtmlviewsController Class
 * Clase para controlar las vistas y agregarse a los modulos
 * Este controlador su funcion es incluir las vistas dentro del ambiente de desarollo
 *
 * @author Fernando Merlo
 */

class HtmlViewsController{

    private $ViewList;
    private $path;

    public function __construct($path){
        $this->ViewList= new ArrayList();
        $this->ViewList->addItem("HtmlTopHeader");
        $this->ViewList->addItem("HtmlHeader");
        $this->ViewList->addItem("HtmlBody");
        $this->ViewList->addItem("HtmlFooter");
        $this->ViewList->addItem("HtmlBottomFooter");
        $this->path=$path;
    }

   /*
    * Function para incluir vistas de documento html
    * Excluyendo las opciones que determinen el parametro
    * param : excludedViews como array, lista de exclusion para incluir las clases
    */
    public function IncludeViewsExclude($excludedViews){
        foreach($this->ViewList->array as $value){
            if(!empty($excludedViews)){
                if(!in_array($value,$excludedViews)){
                    include ($this->path.$value.".php");
                }
            }else{
                include ($this->path.$value.".php");
            }

        }
    }

    /*
    * Function para incluir vistas de documento html
    * con parametro para incluir las vistas selecionadas
    * param : Views como array, lista para incluir las clases
    */

    public function IncludeViews($Views){
        foreach($this->ViewList->array as $value){
            if(!empty($Views)){
                if(in_array($value,$Views)){
                    include ($this->path.$value.".php");
                }
            }else{
                include ($this->path.$value.".php");
            }

        }
    }
}

?>