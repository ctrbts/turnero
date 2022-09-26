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

include('topInclude.php');
include('CitasCalFunctions.php');

$pageRequest = "ProgramaCita.php";

if (!empty($_GET)) {
    if (!empty($_GET['PageRequest'])) {
        $pageRequest = $_GET['PageRequest'];
    }
}

$_Reglacita = new Reglascitas();

$mes;
$anio;

$date = time();
if (!empty($_GET)) {
    if (!empty($_GET['month']) && !empty($_GET['year'])) {
        $t =  strtotime($_GET['month'] . "/01/" . $_GET['year']);
        $newf = date('Y-m-d', $t);
        $date = $t;
        $mes = $_GET['month'];
        $anio = $_GET['year'];
    }
}

$day = date('d', $date);
$month = date('m', $date);
$year = date('Y', $date);

//get the first dathe of the month

$first_day =  mktime(0, 0, 0, $month, 1, $year);
// get the name of the month
$title = date('F', $first_day);
switch ($title) {
    case "January":
        $title = "Enero";
        break;
    case "February":
        $title = "Febrero";
        break;
    case "March":
        $title = "Marzo";
        break;
    case "April":
        $title = "Abril";
        break;
    case "May":
        $title = "Mayo";
        break;
    case "June":
        $title = "Junio";
        break;
    case "July":
        $title = "Julio";
        break;
    case "August":
        $title = "Agosto";
        break;
    case "September":
        $title = "Septiembre";
        break;
    case "October":
        $title = "Octubre";
        break;
    case "November":
        $title = "Noviembre";
        break;
    case "December":
        $title = "Diciembre";
        break;
}

//day of the week of the first day of the month
$day_of_week = date('D', $first_day);

//black spaces of the calendar

switch ($day_of_week) {
    case "Sun":
        $blank = 0;
        break;
    case "Mon":
        $blank = 1;
        break;
    case "Tue":
        $blank = 2;
        break;
    case "Wed":
        $blank = 3;
        break;
    case "Thu":
        $blank = 4;
        break;
    case "Fri":
        $blank = 5;
        break;
    case "Sat":
        $blank = 6;
        break;
}

// how many days have a month
$days_in_month =  cal_days_in_month(0, $month, $year);


echo '<table id="CalendarTable" >' . "\n";
echo '<tr>' . "\n\t" . '<th colspan=7>' . $title . " " . $year . '</th>' . "\n" . '</tr>' . "\n";
echo '<tr>' . "\n\t" . '<td id="daytitle">Domingo</td>' . "\n\t" . '<td id="daytitle">Lunes</td>' . "\n\t" . '<td id="daytitle">Martes</td>' . "\n\t" . '<td id="daytitle">Miercoles</td>' . "\n\t" . '<td id="daytitle">Jueves</td>' . "\n\t" . '<td id="daytitle">Viernes</td>' . "\n\t" . '<td id="daytitle">Sabado</td>' . "\n" . '</tr>' . "\n";

$day_count = 1;
echo '<tr>' . "\n\t";

while ($blank > 0) {
    echo '<td id="blankday"></td>' . "\n\t";
    $blank = $blank - 1;
    $day_count++;
}

$day_num = 1;

while ($day_num <= $days_in_month) {
    $l =  new ArrayList();
    //echo $anio;
    $l = GetNumCitasDis($day_num, $mes, $anio);
    $c = count($l->array);
    $val = mktime(0, 0, 0, $mes, $day_num, $anio);

    $message = "";
    if ($c > 0) {
        $message = "<br><a class='btn btn-sm btn-warning px-3 py-2 shadow' id=\"ProgamaCita\" href=\"$pageRequest?v=$val\">Turnos disponibles ($c)</a><br/>";
    } else {
        $message = "<br>";
    }

    echo '<td><a id="dayNum">' . $day_num . '</a> ' . $message . ' </td>' . "\n\t\t";
    $day_num++;
    $day_count++;
    if ($day_count > 7) {
        echo '</tr>' . "\n" . '<tr>' . "\n";
        $day_count = 1;
    }
}

while ($day_count > 1 && $day_count <= 7) {
    echo '<td id="blankday"> </td>' . "\n";
    $day_count++;
}

echo '</tr>' . "\n" . '</table>';
