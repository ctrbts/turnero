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

date_default_timezone_set("America/Argentina/Buenos_Aires");
error_reporting(0);
require 'vendor/autoload.php';

//Carga Configuracion del sistema Config.php
$pathsplit = explode("/", $_SERVER['PHP_SELF']);
if (count($pathsplit) > 2) {
    $root = $_SERVER["DOCUMENT_ROOT"] . "/" . $pathsplit[1];
} else {
    $root = $_SERVER["DOCUMENT_ROOT"];
}
SearchConfig($root);
$config = new Config();
$pathconfig = "/" . $config->pathServer;

//Inicia Session
session_start();
$_SESSION['Show_login'] = true;

$direccion = "/" . $config->pathServer;
$logoutpage = "$config->domain/$direccion/logout.php";
$profilepage = "$config->domain$direccion/UserProfile.php";
if (isset($_SESSION['UserObj'])) {
    $_SESSION['Show_login'] = false;
}

// Carga Clases del sistema
$Path = $_SERVER['DOCUMENT_ROOT'] . $direccion . "/include/com";
$ClassPath = scandir($Path);
scanDirectory($Path);

//Carga Clases Externas
include($_SERVER['DOCUMENT_ROOT'] . $direccion . "/include/external/simplecapcha/simple-php-captcha.php");
include($_SERVER['DOCUMENT_ROOT'] . $direccion . "/include/external/phpqrcode-git/lib/full/qrlib.php");

// Funcion para cargar clases
function scanDirectory($dirname)
{
    $FolderScanned = scandir($dirname);
    foreach ($FolderScanned as $Key => $Value) {
        if (!in_array($Value, array(".", ".."))) {
            if (is_dir($dirname . "/" . $Value)) {
                scanDirectory($dirname . "/" . $Value);
            }
            if (strpos($Value, ".php")) {
                include($dirname . "/" . $Value);
            }
        }
    }
}

// Busca el archivo de configuracion
function SearchConfig($root)
{
    $FolderScanned = scandir($root);
    foreach ($FolderScanned as $key => $Value) {
        if (!in_array($Value, array(".", ".."))) {
            if (is_dir($root . "/" . $Value)) {
                SearchConfig($root . "/" . $Value);
            }
            if ($Value == "Config.php") {
                require_once($root . "/" . $Value);
                return $root . "/" . $Value . "Config.php";
                exit;
            }
        }
    }
}
