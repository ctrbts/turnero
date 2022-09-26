<?php

class MysqlConnectorExt extends MysqlConnector {

    public function OpenConnectionNoScheme(){
        $config = new Config();
        $this->conn= new mysqli($config->servername, $config->username,  $config->password);
        if($this->conn->connect_error){
            die("Connection failed: " . mysqli_connect_error());
        }
    }
}


?>