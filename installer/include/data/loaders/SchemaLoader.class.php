<?php

class SchemaLoader {

    protected $SchemaInstaller;

    public function __construct(string $name){
        $this->SchemaInstaller = new SchemeInstaller($name);
    }

    public function LoadSchema(){
        if(!$this->SchemaInstaller->CheckScheme()){
            $this->SchemaInstaller->CreateScheme();
        }
    }

}

?>