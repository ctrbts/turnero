<?php

class SchemeInstaller{
    protected $SchemeName;
    private $mysql;

    public function __construct(string $name){
        $this->SchemeName=(is_null($name)) ? "db_turnero" : $name;
        $this->mysql=new MysqlConnectorExt();
    }

    public function CreateScheme(){
        $this->mysql->OpenConnectionNoScheme();
        $sql="CREATE SCHEMA `$this->SchemeName` DEFAULT CHARACTER SET latin2;";
        try {
           $return= $this->mysql->conn->query($sql);
        } catch (\Throwable $th) {
            echo $ex->getMessage();
        }
        $this->mysql->CloseDataBase();
    }

    public function CheckScheme(){
        try {
            $value=  $this->mysql->OpenConnectionNoScheme();
            if ($this->mysql->conn->select_db($this->SchemeName)) {
                return true;
            } else {
               return false;
            }
            $this->mysql->CloseDataBase();
        } catch (\Throwable $th) {
            return false;
        }


    }



}
?>