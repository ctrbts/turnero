<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
           // test database
           //include ("../include/com/database/MysqlConnector.php");
           //$conector= new MysqlConnector("../systemconf/Config.php");

           //$config= new Config();
           //echo $config->database;

           /*try{
               $conector->OpenConnection();
               echo "Connection success";
               $conector->CloseDataBase();
           } catch (Exception $ex) {
               echo $ex;
           }*/

            //test ado
            chdir('../include');
            include ("../modules/incmodules.php");

        echo '</br>';
            include ("../include/com/dao/ADOModules.php");
            include ("../systemconf/Config.php");
            $ADOModules = new ADOModules("./Config.php");
            echo $ADOModules->vartest;

        ?>
    </body>
</html>
