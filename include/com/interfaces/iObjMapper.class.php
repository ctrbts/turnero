<?php

interface iObjMapper{

    public function setObjConfiguration();
    public function getObjectTableConfig();
    public function setTableConfig();
    public function setTable(string $table);
    public function PrimaryKey();

}

?>