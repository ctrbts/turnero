<?php

class objectTable{

    protected $Object;
    protected $ListFields;
    public $tableName;

    public function __construct($Object){
        if(!isset($Object) || is_null($Object) ){
            throw new Exception('NullReferenceException on objectTableMapper');
        }

        $this->Object = $Object;
        $this->ListFields= new ArrayList();
        $this->tableName= get_class($Object);
        $this->getFieldsFromObj();
    }


    public function getFieldsFromObj(){
        try {
            $vars_clase = get_class_vars(get_class($this->Object));
            foreach ($vars_clase as $nombre => $valor) {
                $field=new objectTableField($nombre,$valor);
                $this->ListFields->addItem($field);
                
            }
        } catch (\Throwable $th) {
           echo $th;
        }
        
    }

    public function Field(string $fieldname){

        if(!isset($this->ListFields->array[$this->GetIndexOfField($fieldname)])){
            throw new Exception("Field $fieldname not in the object");
        }

        return $this->ListFields->array[$this->GetIndexOfField($fieldname)];
    }

    protected function GetIndexOfField(string $fieldname){
        $index=0;
        $returnindex;
        foreach($this->ListFields->array as $fielobj){
            if($fielobj->getFieldName()==$fieldname){
                $returnindex=$index;
            }
            $index++;
        }
        return $returnindex;
    }

    protected function BuildSQLCommand(){
        $sql="CREATE TABLE IF NOT EXISTS `".$this->tableName."` (";
        $index=0;
        foreach($this->ListFields->array as $fieldobj){
            if(!is_null($fieldobj->getMySQLString())){
                if($index>0){
                    $sql=$sql.",";
                }
                $sql = $sql. $fieldobj->getMySQLString();
                $index++;
            }
        }
        $sql=$sql.");";
        return $sql;
    }

    public function toString(){
        return $this->BuildSQLCommand(); 
    }

    public function addField(string $nombre, $valueobj){
        $field=new objectTableField($nombre,$valueobj);
        $this->ListFields->addItem($field);
        return $this;
    }

}

?>