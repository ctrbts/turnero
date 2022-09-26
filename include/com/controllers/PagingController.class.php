<?php
    class PagingController{

        private $RecordsByPage=10;
        public $totalPages=1;

        public function __construct($RecordsByPage){
            $this->RecordsByPage=$RecordsByPage;
        }

        public function GetRecordsPaging($ActualPage,$ListOfObjects){
            $ReturnedList= new ArrayList();
            $totalrecords=count($ListOfObjects->array);
            if($totalrecords>=$this->RecordsByPage){
                $this->totalPages=ceil($totalrecords / $this->RecordsByPage);
            }
            if($ActualPage<=$this->totalPages){
                $start=($ActualPage-1)*$this->RecordsByPage;
                $end=($start+$this->RecordsByPage)-1;
                for($index=$start; $index<=$end;$index++){
                    $cita= $ListOfObjects->array[$index];
                    if(!is_null($cita)){
                        $ReturnedList->addItem($cita);
                    }
                    
                }
            }
            return $ReturnedList;
        }

    }
?>