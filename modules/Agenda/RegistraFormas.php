<?php

include("topInclude.php");
//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("../../views/");

$commonfuncions = new CommonFunctions();
$debug = false;
$redirectpage = false;
if (!empty($_POST)) {
    if (!empty($_POST['day'])) {
        $dia = $_POST['day'];
    }

    if (!empty($_POST['horario'])) {
        $horario = $_POST['horario'];
        $v =  explode("|", $horario);
        $horario_inicio = $v[0];
        $horario_fin = $v[1];
    }

    if (!isset($_SESSION['CitaPend'])) {
        $_SESSION['CitaPend'] = $dia . "|" . $horario_inicio;
        //echo $_SESSION['CitaPend'];
    }
}

$UserLogged = new UserObj();
if (isset($_SESSION['UserObj'])) {
    $UserLogged =  unserialize($_SESSION['UserObj']);
    if ($UserLogged->iduser <= 0) {
        $redirectpage = true;
    }
} else {
    $redirectpage = true;
}

$Show_login = true;
if (isset($_SESSION['Show_login'])) {
    $Show_login = $_SESSION['Show_login'];
}


if ($redirectpage) {
    $commonfuncions->RedirectPage("../../index.php");
}

//Carga Formularios
//Primero debe mostrar los formularios visibles
//despues la seleccion multiple de formularios

$Formas = new ArrayList();
$ADOFormas = new ADOFormas();
$ADOFormas->GetFormasActivas($Formas);

//carga campos de la forma
foreach ($Formas->array as $item) {
    $item->GetCamposDeForma();
}

?>
<?php $HtmlViewsController->IncludeViews(array("HtmlTopHeader", "HtmlHeader")); ?>
<title>Registar Forma</title>
<?php $HtmlViewsController->IncludeViews(array("HtmlBody")); ?>
<?php include("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="display-4">Requisitos de Turno</span>
    </div>
    <div class="d-flex justify-content-center border p-4">
        <form id="forma" name="form_1103158" class="" method="post" action="RegistrarCita.php">
            <input type="hidden" name="day" value="<?php echo $dia; ?>">
            <input type="hidden" name="horario" value="<?php echo $horario; ?>">
            <input type="hidden" name="param" value="<?php echo $UserLogged->iduser; ?>">
            <div class="text-left">
                <?php
                $displayselectedforms = false;
                $html_forms = "";
                $html_selectform = '<select class="form-control" id="selectform" onchange="SelectForm()" >';
                $html_selectform = $html_selectform . '<option value="div_-1" >--- Seleccione una Opcion ---</option>';
                foreach ($Formas->array as $item) {
                    //Despliega las formas visible primero
                    if ($item->visible == "1") {
                        //Despliega el encabezado
                        echo '<h2>' . $item->descripcion . '</h2>';
                        foreach ($item->CamposFormaCollection->array  as $childitem) {
                            $childitem->GetTipoCampo();
                            echo $childitem->DisplayCampo();
                        }
                    }

                    //Genera seleccion multiple de formularios
                    $saltolinea = "\r\n";
                    if ($item->seleccion == 1) {

                        $displayselectedforms = true;

                        $html_selectform = $html_selectform . '<option value="div_' . $item->idforma . '">' . $item->descripcion . '</option>';

                        //crea los formularios en div invisibles
                        $html_forms = $html_forms .  '<div class="m-2 p-2" id="div_' . $item->idforma . '" style="display:none">' . $saltolinea;

                        $html_forms = $html_forms . '<h2>' . $item->descripcion . '</h2>' . $saltolinea;
                        //$html_forms=$html_forms. '<div id=Form_"'.$item->idforma.'">'.$saltolinea;
                        foreach ($item->CamposFormaCollection->array  as $childitem) {
                            $childitem->GetTipoCampo();
                            $html_forms = $html_forms . $childitem->DisplayCampo();
                        }
                        $html_forms = $html_forms . '' . $saltolinea;
                        $html_forms = $html_forms . '</div>' . $saltolinea;
                    }
                }
                $html_selectform = $html_selectform . "</select>";
                if ($displayselectedforms) {
                    echo '<p></p>';
                    echo '<p></p>';
                    echo "Seleccione una opcion: " . $html_selectform;
                    echo '<p></p>';
                    echo $html_forms;
                }
                ?>
            </div>
            <div id="div_-1" style="display:none"></div>
            <div class="mt-3 mb-3">
                <button class="btn btn-success btn-lg" type="submit" id="saveForm" name="btn_saveform">Siguiente</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    <?php
    if (count($Formas->array) == 0) {
    ?>
        document.getElementById('forma').submit();
    <?php
    }
    ?>

    function SelectForm() {
        var e = document.getElementById("selectform");
        var value = e.options[e.selectedIndex].value;
        var text = e.options[e.selectedIndex].text;

        HideAllDiv();
        document.getElementById(value).style.display = "block";
        $("#saveForm").attr("disabled", false);

    }

    function HideAllDiv() {
        var selectofdivs = document.getElementById('selectform');

        if (selectofdivs.hasChildNodes()) {
            var children = selectofdivs.childNodes;
            for (var c = 0; c < children.length; c++) {
                //alert(children[c].value);
                document.getElementById(children[c].value).style.display = "none";

            }
        }
    }
</script>
<!-- End content -->
<?php $HtmlViewsController->IncludeViews(array("HtmlFooter", "HtmlBottomFooter")); ?>