<?php

interface iobjconfig{
    public function __construct();
    public function setTableConfiguration();
    public function Field(string $fieldname);
    public function getSQLStr();
    public function addField(string $nombre,$objecType);
}

?>