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
 * Description of Config
 *
 * @author Fernando Merlo
 */
class Config {
    // to production
    /* public $username="admin";
    public $password="admin_pasS";
    public $database="turnos";
    public $servername="163.10.29.5";
    public $pathServer= "turnero";
    public $domain="http://sistemas.folp.unlp.edu.ar"; */

    // to development
    public $username="root";
    public $password="";
    public $database="turnos";
    public $servername="localhost";
    public $pathServer= "folp_turnero";
    public $domain="http://localhost";

    // smtp config
    public $smtpHost="smtp.gmail.com";
    public $smtpAuth=true;
    public $smtpUserName="code4odonto@gmail.com";
    public $smtpPassword="maotzhqupoqxoefu";
    public $smtpPort=465;
    public $smtpFrom="code4odonto@gmail.com";
}
