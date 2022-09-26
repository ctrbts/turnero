<?php

include("topInclude.php");

//Carga Clase de control de vistas.
$HtmlViewsController = new HtmlViewsController("views/");

$redirect = false;
$redirectpage = "index.php";
$newuser = new UserObj();

if (!isset($_SESSION['UserObj'])) {
    //echo 'UserObj Not exist';
    if (!empty($_POST)) {
        if (isset($_POST['email']) && isset($_POST['contrasena'])) {
            $newuser->email = $_POST['email'];
            $newuser->password = $_POST['contrasena'];
            $_ADOUsers = new ADOUser();
            //$_ADOUsers->debug=true;
            $_ADOUsers->ExistEmail($newuser);
            if ($newuser->iduser > 0) {
                //echo "entro";
                $redirect = true;
                $redirectpage = "messageboard.php?messageid=3";
            }
        }
    } else {
        $redirect = true;
    }
} else {
    //echo 'UserObj exist';
    $redirect = true;
}
?>
<?php $HtmlViewsController->IncludeViews(array("HtmlTopHeader", "HtmlHeader")); ?>
<title>Registra tus datos</title>
<?php $HtmlViewsController->IncludeViews(array("HtmlBody")); ?>
<!-- Content -->
<div class="container text-center bg bg-white rounded border border-dark mt-3">
    <div class="p-3">
        <span class="h3">TÉRMINOS Y CONDICIONES DE USO DE LA WEB Y REGISTRO DE USUARIOS.</span>
    </div>
    <div class="text-left p-3">
        <span class="h4">1. Acceso a la Página Web.</span>
        <p class="lead">El acceso a la Página Web es gratuito, salvo en lo relativo al coste de la conexión a través de la red de
            telecomunicaciones suministrada por el proveedor de acceso contratado (ISP) por el Usuario, que estará a su exclusivo
            cargo.
        <p>
    </div>
    <div class="text-justify p-3">
        <span class="h4">2. Necesidad de Registro</span>
        <p class="lead">Por regla general, para el acceso a los contenidos de la Página Web no será necesario el registro del
            Usuario. No obstante, la utilización de determinados servicios estará condicionada al registro previo del Usuario,
            quien deberá completar todos los campos del formulario de inscripción con datos válidos (en adelante el “Usuario
            Registrado”). Quien aspire a convertirse en Usuario Registrado deberá verificar que la información que pone a
            disposición en este sitio web. Más allá de la aventura a fin de registrarse en la Página Web sea exacta, precisa y verdadera
            (en adelante los “Datos Personales”); asimismo asumirá el compromiso de actualizar los Datos Personales cada vez que
            los mismos sufran modificaciones. Los Usuarios Registrados garantizan y responden, en cualquier caso, de la veracidad,
            exactitud, vigencia y autenticidad de los Datos Personales puestos a disposición del Club.
        <p>
    </div>
    <div class="text-justify p-3">
        <span class="h4">3. Obligación de mantener actualizados los Datos Personales.</span>
        <p class="lead">Los Datos Personales introducidos por todo Usuario Registrado en la Página Web, deberán ser exactos,
            actuales y veraces en todo momento. Este sitio web, se reserva el derecho de solicitar algún
            comprobante y/o dato adicional a efectos de corroborar los Datos Personales, y de suspender temporal y/o
            definitivamente a aquellos Usuarios Registrados cuyos datos no hayan podido ser confirmados. La baja o
            inhabilitación de un Usuario Registrado implicará la baja de su participación en el espacio Blog, lás áreas
            colaborativas, y en el Ranking Online, sin que ello genere derecho a resarcimiento o indemnización alguna.
        <p>
    </div>
    <div class="text-justify p-3">
        <span class="h4">4. Acceso a la cuenta personal y obligación de confidencialidad de la Clave de Seguridad.</span>
        <p class="lead">Para transformarse en Usuario Registrado, el Usuario tendrá acceso a una cuenta personal («Perfil») mediante
            el ingreso de su apodo o nombre de usuario o correo electronico y clave de seguridad personal elegida («Clave de Seguridad»).
            Esta Clave de Seguridad es personal e intransferible. El Usuario Registrado se obliga a mantener en estricta confidencialidad su Clave
            de Seguridad. El Usuario Registrado será, en todo caso, responsable por todo daño, perjuicio, lesión o detrimento que del
            incumplimiento de esta obligación de confidencialidad se genere por cualquier causa.
            <br /><br />La Cuenta es personal, única e intransferible, y está prohibido que un mismo Usuario Registrado registre o posea
            más de una Cuenta. En caso que este sitio web detecte distintas Cuentas que contengan datos
            coincidentes o relacionados, podrá cancelarlas, suspenderlas o inhabilitarlas, a su sola discreción, siendo el
            mismo motivo suficiente para dar de baja al Usuario Registrado, incluso en su primera Cuenta. El Usuario Registrado será
            responsable por todas las operaciones efectuadas desde su Cuenta, pues el acceso a la misma está restringido al ingreso y uso
            de su Clave de Seguridad, de conocimiento exclusivo del Usuario y cuya confidencialidad es de su exclusiva responsabilidad.
            El Usuario Registrado se compromete a notificar, de forma inmediata y por un medio idóneo, fehaciente, eficiente y eficaz,
            cualquier uso no autorizado de su Cuenta, así como el ingreso por terceros no autorizados a la misma. Se encuentra prohibida
            la venta, cesión, transferencia o transmisión de la Cuenta bajo cualquier título, ya sea oneroso o gratuito.
            <br /><br />Este Sitio web se reserva el derecho de rechazar cualquier solicitud de registro o de cancelar un registro previamente aceptado,
            cuando a su sola discreción considere que no se ha dado cumplimiento a la totalidad de las pautas establecidas en los Términos y
            Condiciones o en los Terminos y Condiciones Particulares para Usuarios Creadores y/ o para Usuarios Colaboradores, sin que esté obligado a
            comunicar o exponer las razones de su decisión y sin que ello genere derecho a indemnización o resarcimiento alguno a favor del Usuario
            Registrado alcanzado por dicha decisión.
            <br /><br />El hecho de ser «Usuario Registrado» permite escribir una idea o comentario que se colocará inmediatamente en la
            página web sin ser previamente supervisada, partiendo teniendo en cuenta el compromiso y responsabilidad del mismo.
        <p>
    </div>
    <div class="text-justify p-3">
        <span class="h4">5. Normas generales de utilización de la Página Web.</span>
        <p class="lead">
            El Usuario y/o el Usuario Registrado, se obliga a utilizar la Página Web y todo su contenido y servicios conforme a lo establecido
            en la ley, la moral, el orden público, los presentes Términos y Condiciones, y los Terminos y Condiciones Particulares que en cada
            caso resulten aplicables. Asimismo, se obliga a hacer un uso adecuado de los servicios y/o contenidos de la Página Web y a no
            emplearlos para realizar actividades ilícitas o constitutivas de delito, que atenten contra los derechos de terceros y/o que
            infrinjan la regulación sobre propiedad intelectual e industrial, o cualesquiera otras normas del ordenamiento jurídico que puedan
            resultar aplicables y, en especial, el principio de buena fe que obliga a actuar leal, correcta y honestamente tanto en los tratos
            preliminares, celebración y ejecución de todo contrato. Como consecuencia de lo anterior, el Usuario se obliga a no difundir,
            transmitir, introducir y poner a disposición de terceros, cualquier tipo de material e información (datos, contenidos, mensajes,
            dibujos, archivos de sonido e imagen, fotografías, software, etc.) que sean contrarios a la ley, la moral, el orden público, los
            presentes Términos y Condiciones, y los Términos y Condiciones Particulares que resulten aplicables.
            <br /><br />A título meramente enunciativo, y en ningún caso limitativo, taxativo o excluyente, el Usuario y/o el Usuario Registrado,
            se compromete a:
        <ul>
            <li>a) No introducir o difundir contenidos o propaganda de carácter racista, xenófobo o, en general, discriminatorio, pornográfico,
                de apología del terrorismo o que atenten, vulneren o pudieren atentar o vulnerar los derechos humanos.</li>
            <li>
                b) No introducir o difundir en la red programas de datos (virus y/o software nocivos) susceptibles de provocar daños en los sistemas
                informáticos de este sitio web. Más allá de la aventura, sus proveedores, terceros o, en general, cualquier usuario de la red Internet.
            </li>
            <li>
                c) No difundir, transmitir o poner a disposición de terceros cualquier tipo de información, elemento o contenido que atente contra los derechos
                fundamentales y las libertades públicas reconocidos constitucionalmente y en los tratados internacionales.
            </li>
            <li>
                d) No difundir, transmitir o poner a disposición de terceros cualquier tipo de información, elemento o contenido que constituya publicidad
                ilícita o desleal.
            </li>
            <li>
                e) No transmitir publicidad no solicitada o autorizada, material publicitario, «correo basura», «cartas en cadena», «estructuras
                piramidales», o cualquier otra forma de solicitación, excepto en aquellas áreas (tales como espacios comerciales) que hayan sido
                exclusivamente concebidas para ello mediante una comunicación expresa de la Compañía que corresponda, comunicada debida y
                oportunamente en la Página Web.
            </li>
            <li>
                f) No introducir o difundir cualquier información y contenidos falsos, ambiguos o inexactos de forma que induzca a error a los
                receptores de la información.
            </li>
            <li>
                g) No difundir, transmitir o poner a disposición de terceros cualquier tipo de información, elemento o contenido que suponga una violación
                de los derechos de propiedad intelectual e industrial, patentes, marcas o copyright que correspondan a la Compañía o a terceros.
            </li>
            <li>
                h) No difundir, transmitir o poner a disposición de terceros cualquier tipo de información, elemento o contenido que suponga una
                violación del secreto de las comunicaciones y la legislación de datos de carácter personal y, en general, toda las normas
                jurídicas que regulen la protección y promoción del respeto a la vida privada e intimidad de las
                personas y sus familias.
            </li>
        </ul>
        <p class="lead">
            El Usuario y/o el Usuario Registrado, se obliga a mantener indemne este sitio web, ante cualquier posible
            reclamación, multa, pena, sanción o indemnización que pueda venir obligada a soportar como consecuencia del incumplimiento por
            parte del Usuario de cualquiera de las normas de utilización antes indicadas, reservándose, además, el Club el derecho a solicitar
            la indemnización por daños y perjuicios que corresponda. Asimismo, Este Sitio web, se reserva el derecho de
            anular la Cuenta de aquellos Usuarios Registrados que hagan un uso inapropiado de la Página Web o no respeten las observaciones y
            prohibiciones previstas por estos Términos y Condiciones, y los Términos y Condiciones Particulares que resulten aplicables en
            cada caso.
        </p>
        </p>
        <div class="text-justify p-3">
            <span class="h4">6. Responsabilidad</span>
            <p class="lead">Este sitio web sólo pone a disposición de los Usuarios un espacio virtual que puedan crear una solicitud
                de agendar una reunion y ser administrada la informacion para fines propios de este sitio web.
                <br />
                Este sitio web solicitara datos al usuario para fines de llenar la informacion requerida. Esta no tendra sera meramente informativa
                y la responsabilidad de almacenar y no hacer mal uso de la informacion sera cuestion de este sitio web.
            <p>
        </div>
        <div class="text-justify p-3">
            <span class="h4">7. Contenidos y servicios enlazados a través de la Página Web.</span>
            <p class="lead">El servicio de acceso a la Página Web puede incluir dispositivos técnicos de enlace, directorios e incluso
                instrumentos de búsqueda que permitan al Usuario acceder a otras páginas y portales de Internet (en adelante, “Sitios
                Enlazados”). En estos casos, Este sitio web sólo será responsables de los contenidos y servicios
                suministrados en los Sitios Enlazados en la medida en que tengan conocimiento efectivo de la ilicitud y no hayan desactivado
                el enlace con la diligencia debida.
                <br /><br />
                En ningún caso, la existencia de Sitios Enlazados debe presuponer la formalización de acuerdos ni asociación con los
                responsables o titulares de los mismos, ni la recomendación, promoción o identificación de este sitio web,
                con las manifestaciones, contenidos o servicios proveídos por dichos sitios.
            <p>
        </div>
        <div>
            <p class="lead">
                Para continuar con el registro, por favor introduce tu Nombre y Apellidos
            </p>
            <div>
                <form method="post" action="RegisterEngine.php" id="form_110">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="txtnombre">Nombre(s):</label>
                                <input type="text" class="form-control bg" name="nombre" id="element_1" style="background:#F8EFBA">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="txtappelido">Apellido(s):</label>
                                <input id="element_2" name="apellidos" class="form-control bg" type="text" value="" style="background:#F8EFBA" />
                            </div>
                        </div>
                    </div>
                    <div id="divmessageerror" class="text-center p-2 bg bg-danger text-white mt-2 mb-2">
                        <span id="message"></span>
                    </div>
                    <input type="hidden" value="<?php echo $newuser->email; ?>" name="email">
                    <input type="hidden" value="<?php echo $newuser->password; ?>" name="contrasena">
                    <button type="button" class="btn btn-success btn-block btn-lg mb-3" onclick="valida(); return false;">Acepto los t&eacute;rminos y condiciones para el uso de este sitio web</button>
                    <button type="button" class="btn btn-danger btn-block btn-lg mb-3" id="btn_cancel">Cancelar, regresar a pagina principal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#divmessageerror").hide();
    $("#btn_cancel").click(function() {
        document.location.href = "index.php"
    });

    function valida() {
        var nombre = document.getElementById("element_1").value;
        var apellido = document.getElementById("element_2").value;
        var letrero = document.getElementById("message");
        var submit_form = true;
        var message = "";
        if (nombre == "") {
            $("#divmessageerror").show();
            message = message + "Llena el campo de nombre(s) para continuar<br/>";
            letrero.innerHTML = message;
            submit_form = false;
        }
        if (apellido == "") {
            $("#divmessageerror").show();
            message = message + "Llena el campo de apellido(s) para continuar!<br/>";
            letrero.innerHTML = message;
            submit_form = false;
        }

        if (submit_form) {
            $("#divmessageerror").hide();
            document.getElementById("form_110").submit();
        }

    }
</script>
<!-- End content -->
<?php $HtmlViewsController->IncludeViews(array("HtmlFooter", "HtmlBottomFooter")); ?>
<?php

if ($redirect) {
    echo "<script type=\"text/javascript\"> window.location=\"$redirectpage\"</script>";
}

?>