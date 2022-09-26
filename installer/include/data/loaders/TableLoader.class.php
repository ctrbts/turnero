<?php

class TableLoader {

    protected $ListTableConfigurations;
    protected $mysql;

    public function __construct(){
            $this->ListTableConfigurations= new ArrayList();
            $this->LoadTablesConfigurations();
            $this->mysql= new MysqlConnector();
    }

    public function LoadTablesConfigurations(){
        $config= new Config();
        $dirname =$_SERVER['DOCUMENT_ROOT']."/".$config->pathServer."/installer/include/configurations/tables";
        $FolderScanned=scandir($dirname);
        foreach($FolderScanned as $Key=>$Value){
            if (!in_array($Value,array(".",".."))){
                if(is_dir($dirname."/".$Value)){
                    scanDirectory($dirname."/".$Value);
                }
                if(strpos($Value,"class.php")){
                    $splitedname= explode(".",$Value);
                    $Object = new $splitedname[0];
                    $this->ListTableConfigurations->addItem($Object);
                }
            }
        }
    }
    
    public function LoadTables(){
        try {
            $this->mysql->openConnection();
            foreach($this->ListTableConfigurations->array as $item){
                $this->mysql->conn->query($item->getSQLStr());
            }
            $this->mysql->CloseDataBase();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}

?>