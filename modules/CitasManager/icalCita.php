<?php
include 'topInclude.php';
$commonfunctions = new CommonFunctions();

if (isset($_GET['c']) && isset($_GET['token']) && isset($_SESSION['TToken'])) {
    $token = base64_decode($_GET['token']);
    $Stoken = $_SESSION['TToken'];
    if ($token == $Stoken) {

        $id = base64_decode($_GET['c']);

        $cita = new CitasObj();
        $cita->idcita = $id;
        $ADOCita = new ADOCitas();
        $ADOCita->getCitabyID($cita);

        $ICalendar = new icalendar($cita);

        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: inline; filename=CitaNo' . $id . '.ics');
        echo $ICalendar->getStrICal();
    }
}

if (isset($_GET['enableredirect'])) {
    $redirectpage = $_GET['enableredirect'];
    if ($redirectpage == "true") {
        if (isset($_GET['redirectpage'])) {
            $redirectpage = $_GET['redirectpage'];
            $commonfunctions->RedirectPage($redirectpage);
        } else {
            if (isset($id)) {
                $commonfunctions->RedirectPage("viewCita.php?param=" .  base64_encode($id));
            } else {
                $commonfunctions->RedirectPage("../../index.php");
            }
        }
    } elseif ($redirectpage == "false") {
        exit();
    } else {
        $commonfunctions->RedirectPage("../../index.php");
    }
} else {
    if (isset($id)) {
        $commonfunctions->RedirectPage("viewCita.php?param=" .  base64_encode($id));
    } else {
        $commonfunctions->RedirectPage("../../index.php");
    }
}
