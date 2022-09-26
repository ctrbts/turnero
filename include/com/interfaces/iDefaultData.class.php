<?php

interface iDefaultData{

    public function __construct();
    public function buildInstruction(string $instruction);
    public function defaultData();
    public function getSQLStr();
    public function getInstructionsListArray();
    public function loadDefaults();

}

?>