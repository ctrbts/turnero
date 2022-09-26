<?php

class MenuObjMap implements iobject, iObjMapper{
    private $Object;
    private $ObjectTableConfig;

    //Configuracion de Tabla
    protected $idfield="idmenu";
    protected $tablename="t_menus";

    public function __construct(){
        $this->setObjConfiguration();
    }

    public function __desctruct(){
        unset($Object);
        unset($ObjectTableConfig);
    }

    public function setPrimaryKey(string $idfield){
        $this->idfield=$idfield;
    }
    public function getPrimaryKey(){
        return $this->idfield;
    }
    public function getTableName(){
        return $this->tablename;
    }
    public function setTableName(string $tablename){
        $this->tablename=$tablename;
    } 

    public function setObjConfiguration(){
        $this->Object= new MenuObj();
        $this->ObjectTableConfig= new objectTable($this->Object);
    }

    public function getObjectTableConfig(){
        return $this->ObjectTableConfig;
    }

    public function setTableConfig(){
        $this->ObjectTableConfig->tableName=$this->tablename;
    }

    public function setTable(string $table){
        $this->ObjectTableConfig->tableName=$table;
    }

    public function PrimaryKey(){
        $this->ObjectTableConfig->Field($this->idfield)->setPrimaryKey(true);
    }
}

?>