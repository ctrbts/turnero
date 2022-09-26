<?php

class icalendar
{
    private $CitaObj;
    private $strICal;

    public function __construct($CitaObj)
    {
        $this->CitaObj = new CitasObj();
        $this->CitaObj = $CitaObj;
    }

    protected function SetConfig()
    {
        $eol = "\r\n";

        if ((!is_null($this->CitaObj->dia) && !is_null($this->CitaObj->mes) && !is_null($this->CitaObj->anio)) && (!is_null($this->CitaObj->hr_inicio) && !is_null($this->CitaObj->hr_fin))) {
            $startDate = $this->CitaObj->getCitaDateStartUTC()->format("Ymd");
            $startHr = $this->CitaObj->getCitaDateStartUTC()->format("His");
            $endDate = $this->CitaObj->getCitaDateEndUTC()->format("Ymd");
            $endHr = $this->CitaObj->getCitaDateEndUTC()->format("His");

            $this->strICal = "BEGIN:VCALENDAR" . $eol .
                "VERSION:2.0" . $eol .
                'PRODID:-//project/author//NONSGML v1.0//EN' . $eol .
                "CALSCALE:GREGORIAN" . $eol .
                'BEGIN:VEVENT' . $eol .
                'UID:' . md5(uniqid(mt_rand(), true)) . '' . $eol .
                'DTSTAMP:' . date("Ymd") . "T" . date("His") . "Z" . $eol .
                'DTSTART:' . strval($startDate) . "T" . strval($startHr) . "Z" . $eol .
                'DTEND:' . strval($endDate) . "T" . strval($endHr) . "Z" . $eol .
                'SUMMARY:Turno Agendada - ' . $this->GetTileWebSite() . $eol .
                'DESCRIPTION:' . $this->getURLCita() . $eol .
                'URL;VALUE=URI:' . $this->getURLCita() . $eol .
                'END:VEVENT' . $eol .
                'END:VCALENDAR';
        }
    }

    public function getStrICal()
    {
        $this->SetConfig();
        return $this->strICal;
    }

    private function getURLCita()
    {
        $config = new Config();
        $url = $config->domain . "/" . $config->pathServer . "/modules/CitasManager/viewCita.php?param=" . base64_encode($this->CitaObj->idcita);
        return $url;
    }

    private function GetTileWebSite()
    {
        $ADOSystemConf = new ADOSystemConf();
        $TitleConf = new SystemConfObj();
        $TitleConf->variable = "PublicMainHeader";
        $ADOSystemConf->GetVariableByName($TitleConf);
        return (is_null($TitleConf->valor)) ? "Sitio web" : $TitleConf->valor;
    }
}
