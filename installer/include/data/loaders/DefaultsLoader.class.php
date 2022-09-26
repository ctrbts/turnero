<?php

class DefaultsLoader {

    protected $ListDefaults;

    public function __construct(){
        $this->ListDefaults= new ArrayList();
        $this->LoadDefaultsConfig();
    }

    public function LoadDefaultsConfig(){
        $config= new Config();
        $dirname =$_SERVER['DOCUMENT_ROOT']."/".$config->pathServer."/installer/include/data/configurations";
        $FolderScanned=scandir($dirname);
        foreach($FolderScanned as $Key=>$Value){
            if (!in_array($Value,array(".",".."))){
                if(is_dir($dirname."/".$Value)){
                    scanDirectory($dirname."/".$Value);
                }
                if(strpos($Value,"class.php")){
                    $splitedname= explode(".",$Value);
                    $Object = new $splitedname[0];
                    $this->ListDefaults->addItem($Object);
                }
            }
        }
    }

    public function debugDefaults(){
        foreach($this->ListDefaults->array as $item){
            echo var_dump($item)."<br/><br/>";
        }
    }

    public function LoadDefaults(){
        try {
            foreach($this->ListDefaults->array as $item){
                $item->loadDefaults();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}

?>