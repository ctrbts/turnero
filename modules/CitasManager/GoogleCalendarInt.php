<!DOCTYPE html>
<!--
Copyright (C) 2018 Fernando Merlo

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
-->
<?php
include 'topInclude.php';
$config = new Config();

$show_verification=true;
require __DIR__ . '/google-api-php-client-2.2.2/vendor/autoload.php';
$r_page="";

$url_cita=$config->domain."/".$config->pathServer.'/modules/CitasManager/viewCita.php?param=';

if(isset($_GET)){
    if(isset($_GET['k']) ){

        $idcita=  base64_decode($_GET['k']);


        $LoadedCita = new CitasObj();
        $LoadedCita->idcita=$idcita;
        $ADOCitas= new ADOCitas();
        $ADOCitas->getCitabyID($LoadedCita);
        $UsuariodeCita = new UserObj();
        $UsuariodeCita->iduser= $LoadedCita->iduser;
        $ADOUser = new ADOUser();
        $ADOUser->getUserByID($UsuariodeCita);
        /***
         * Inicia la interface con google
         *
         */
        // Get the API client and construct the service object.
        $client = getClient();
        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event(array(
          'summary' => 'Sistema de Agenda Electronica, Turno No.' . $LoadedCita->idcita.' '.$UsuariodeCita->nombre .' '. $UsuariodeCita->apellidos ,
          'description' => 'Turno Agendada de ' .$UsuariodeCita->nombre." ".$UsuariodeCita->apellidos. ' mas informacion : "'.$url_cita.  base64_encode($idcita).'"' ,
          'start' => array(
            'dateTime' => $LoadedCita->anio.'-'.$LoadedCita->mes.'-'.$LoadedCita->dia.'T'.$LoadedCita->hr_inicio.'-06:00',
            'timeZone' => 'America/Argentina/Buenos_Aires',
          ),
          'end' => array(
            'dateTime' => $LoadedCita->anio.'-'.$LoadedCita->mes.'-'.$LoadedCita->dia.'T'.$LoadedCita->hr_fin.'-06:00',
            'timeZone' => 'America/Argentina/Buenos_Aires',
          ),
          'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
              array('method' => 'email', 'minutes' => 24 * 60),
              array('method' => 'popup', 'minutes' => 10),
            ))
            ));

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);

        $r_page= "document.location.href='".$event->htmlLink."';";
    }
}



/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $credentialjson = __DIR__.'/google-api-php-client-2.2.2/client_secret_92879714463-3b3kofj3d3nknqu1lfno8ct7e850grdj.apps.googleusercontent.com.json';
    $googlepath =__DIR__ . '/google-api-php-client-2.2.2/';

    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API PHP Quickstart');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig($credentialjson);
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = $googlepath.'token.json';
    if (file_exists($tokenPath)) {

        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $show_verification=false;
        } else {

            if(!check_code()){
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                echo 'Open the following link <a href="'. $authUrl.'" target="_blank">Log in into google</a>';
            }

            if(isset($_GET['code'])){

                $authCode=$_GET['code'];
                echo $authCode;

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode(trim($authCode));
                $client->setAccessToken($accessToken);
//
//                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

function check_code(){
    $exist=false;
    if(isset($_GET['code'])){
        $exist=true;
    }
    return $exist;
}



?>


<!DOCTYPE html>
<html>
  <head>
    <title>Google Calendar API Add Event</title>
    <meta charset="utf-8" />
  </head>
  <body>


  </body>
  <script type="text/javascript">

      <?php
        echo $r_page;
      ?>


  </script>
</html>
