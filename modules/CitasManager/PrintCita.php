<!DOCTYPE html>
<!--
Copyright (C) 2018 Fernando Merlo

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
-->
<?php
include 'topInclude.php';
$_DateFunctions = new DateFunctions();
$commonfuncions = new CommonFunctions();
if (isset($_GET)) {
    if (isset($_GET['k'])) {
        $id =  base64_decode($_GET['k']);

        //Carga los datos de la cita
        $LoadedCita = new CitasObj();
        $LoadedCita->idcita =  $id;
        $_ADOCitas = new ADOCitas();
        $_ADOCitas->getCitabyID($LoadedCita);
        $daytitle = $_DateFunctions->getSpanishLongDate($LoadedCita->mes, $LoadedCita->dia, $LoadedCita->anio);
        $LoadedCita->getEstatus();
        $EstatusCita = $LoadedCita->EstatusCitaObj->estado;
        $LoadedCita->GetFormas();
        foreach ($LoadedCita->FormasCollection->array as $forma) {
            $forma->GetCamposDeForma();
        }

        //Carga Usuario que creo la forma
        $LoadedCita->getUserObj();

        //forma la liga deacuerdo a la configuracion
        $config = new Config();
        $linkcita = $config->domain . "/" . $config->pathServer . "/modules/CitasManager/viewCita.php?param=" . $_GET['k'];

        //Configura el nombre de la imagen QR
        $QRcodeImg = "../../images/qrcita_" . $id . ".png";
    }
}

?>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            background-color: white;
            font-family: "Open Sans", "Lucida Grande", Tahoma, Arial, Verdana, sans-serif;
        }

        .container {
            display: flex;
        }

        .fixed {
            width: 373px;

            padding-top: 5%
        }

        .flex-item {
            flex-grow: 1;
            padding-left: 15px;
            padding-top: 15px;
            text-align: left;
        }

        .maincontent {
            width: 750px;

        }

        ul {
            font-size: 100%;
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        li {
            display: block;
            margin: 0;
            padding: 4px 5px 2px 9px;
            position: relative;
        }
    </style>
    <title></title>
</head>

<body>
    <div class="maincontent">
        <?php
        $LogoImageConf = new SystemConfObj();
        $LogoImageConf->variable = "LogoImageFile";

        $ADOSystemConf = new ADOSystemConf();
        $ADOSystemConf->GetVariableByName($LogoImageConf);

        $TitleConf = new SystemConfObj();
        $TitleConf->variable = "PublicMainHeader";

        $ADOSystemConf->GetVariableByName($TitleConf);
        ?>
        <?php
        if (!empty($LogoImageConf->idvariable) && !empty($TitleConf->idvariable)) {
            $Configuration = new Config();
            $img = $Configuration->domain . "/" . $Configuration->pathServer . "/images/" . $LogoImageConf->valor;
        ?>
            <div style="text-align: left;padding-left: 30px;">
                <center>
                    <img style="height: 80px; width: 150px;" align="middle" src="<?php echo $img; ?>" />
                    <?php echo $TitleConf->valor; ?>
                </center>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="container">
        <div class="fixed">
            <center>
                <?php
                QRcode::png($linkcita, $QRcodeImg, "L", 4, 2);
                echo '<img src="' . $QRcodeImg . '" />';

                //rebuild cache
                QRtools::buildCache();
                ?>
            </center>
        </div>
        <div class="flex-item">
            <h2>Informaci&oacute;n de tu Turno:</h2>
            <h2>Turno No. <?php echo $LoadedCita->idcita; ?></h2>
            <ul>
                <il>
                    <label>Usario :</label><strong><?php echo $LoadedCita->UserObj->nombre . " " . $LoadedCita->UserObj->apellidos ?></strong>
                    <li>Fecha : <strong><?php echo $daytitle; ?></strong></li>
                    <li>Horario : <strong><?php echo $LoadedCita->getHrInicio() . "- " . $LoadedCita->getHrFin(); ?></strong></li>
                </il>
                <p>&nbsp;&nbsp;&nbsp;Estado: <?php echo $EstatusCita; ?></p>
            </ul>
            <div>
                <?php
                foreach ($LoadedCita->FormasCollection->array as $forma) {
                ?>
                    <h2><?php echo $forma->descripcion; ?></h2>
                    <ul>
                        <?php
                        foreach ($forma->CamposFormaCollection->array as $campos) {
                            $campos->GetValorObj();
                            if (!empty($campos->ValorCampoFormaObj->valor)) {
                        ?>
                                <li>
                                    <label><?php echo $campos->nombre; ?></label> : <?php echo $campos->ValorCampoFormaObj->valor ?>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>