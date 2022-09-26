<?php

class mysqlTypeField{

    public $fieldName;
    public $filetype;
    protected $sqlStatment;
    private $VarcharDefault=255;

    public function __construct(string $fieldname, string $filetype){
        if(is_null($fieldname) && is_null($filetype)){
            throw new Exception("NullReferenceException.");
        }

        $this->fieldName=$fieldname;
        $this->filetype=$filetype;
    }

    public function setVarcharSize(int $size){
        if($size>255){
            $size=255;
        }
        $this->VarcharDefault=$size;
    }

    protected function getSQLType(){
        switch ($this->filetype) {
            case 'boolean':
                return "TINYINT(1)"; 
                break;

            case 'integer':
                return "INT"; 
                break;

            case 'double':
                return "DOUBLE"; 
                break;

            case 'string':
                return "VARCHAR($this->VarcharDefault)"; 
                break;
            
            case 'date':
                return "DATETIME"; 
                break;
            
            case 'longtext':
                return "LONGTEXT";
                break;
                
            default:
                return null;
                break;
        }
    }

    public function toString(){
        return (!is_null($this->getSQLType())) ? "`".$this->fieldName ."` ". $this->getSQLType() : null;
    }

    public function setFieldType(string $phptype){
        $this->filetype=$phptype;
    }



}

?>