<?php

class objectTableField{

    private $fieldname;
    private $mysqlTypeField;
    private $parameter;
    private $isNullable=false;
    private $isPrimaryKey=false;
    private $Autoincrement=false;
   
    public function __construct(string $fieldname, $fieldobj){
        if(!isset($fieldname) && !is_null($fieldobj)){
            throw new Exception("NullReferenceException");
        }
        $this->fieldname=$fieldname;
        $this->mysqlTypeField= new mysqlTypeField($fieldname,gettype($fieldobj));
    }

    public function setConfiguration(string $parameter){
        if(!isset($parameter)){
            throw new Exception("NullReferenceException");
        }
           
        $this->parameter=$parameter;
    }

    public function setVarcharSize(int $size){
        $this->mysqlTypeField->setVarcharSize($size);
        return $this;
    }

    public function getMySQLString(){
        $this->ConstructParamter();
        return (!is_null($this->mysqlTypeField->toString())) ? $this->mysqlTypeField->toString().$this->parameter : null;
    }

    protected function setNullableConfig(bool $isnullable){
        $this->isNullable=$isnullable;
        return $this;
    }

    public function NotNullable(bool $isnullable){
        $this->setNullableConfig($isnullable);
        return $this;
    }

    protected function getNullableConfig(){
        return ($this->isNullable) ? " NOT NULL " : "";
    }
    
    protected function ConstructParamter(){
        //revisa si es primary key
        if($this->isPrimaryKey){
            $containsprimarykey= strpos($this->parameter,"PRIMARY KEY");
            $containsautoincrement =strpos($this->parameter,"AUTO_INCREMENT");
            // setea el autoincrement
            $this->parameter= ($containsautoincrement==false) ? $this->parameter.$this->getAutoincrementConfig():$this->parameter;
            // setea el primary key
            $this->parameter =($containsprimarykey==false)? $this->parameter.$this->getPrimaryKeyConfig() :$this->parameter;
        }else{
             //revisar la configuracion del campo null
            $this->parameter= $this->parameter ." ". $this->getNullableConfig();
        }
       
    }

    public function getFieldName(){
        return $this->fieldname;
    }

    public function setPrimaryKey(bool $isprimarykey){
        $this->isPrimaryKey=$isprimarykey;
        return $this;
    }

    public function setAutoincrement(bool $activeautoincrement){
        $this->Autoincrement=$activeautoincrement;
        return $this;
    }

    protected function getPrimaryKeyConfig(){
        return ($this->isPrimaryKey) ? " PRIMARY KEY " : "";
    }

    protected function getAutoincrementConfig(){
        return ($this->Autoincrement) ? " AUTO_INCREMENT " : "";
    }

    public function setFieldType(string $phptype){
        $this->mysqlTypeField->setFieldType($phptype);
        return $this;
    }


}

?>