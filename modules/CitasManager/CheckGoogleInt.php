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
if(isset($_GET)){
    if(isset($_GET['k'])){
        $id=  base64_decode($_GET['k']);

        //var_dump($_GET);
        if(isset($_GET['code'])){
         $code=$_GET['code'];
        }

        $tokenpath =__DIR__ . '/google-api-php-client-2.2.2/token.json';
        if (!file_exists($tokenpath)) {
            $client=getClient($code);
        }else{
            $show_verification=false;
            echo "<script type='text/javascript'>document.location.href='GoogleCalendarInt.php?k=". base64_encode($id) ."';</script>";
        }


    }
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient($code)
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
    $client->revokeToken($tokenPath);
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

            if(check_code()){

                $authCode=$code;
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

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
         <?php

        if($show_verification){
    ?>
    <p>Google Calendar API Check Credentials</p>
    <form method="get" name="frm_googlecode" action="CheckGoogleInt.php" >
        <label>Google Verification code:</label>
        <input name="code" type="text" >
        <input name="k" type="hidden" value="<?php echo base64_encode($id);?>" >
        <p><button>Verify</button></p>
    </form>
    <?php
        }
    ?>
    </body>
</html>
