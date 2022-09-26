<?php

interface iobject{

    public function setPrimaryKey(string $idfield);
    public function getPrimaryKey();
    public function getTableName();
    public function setTableName(string $tablename);

}

?>