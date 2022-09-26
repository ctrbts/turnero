<?php
    include ("topInclude.php");
    //Carga Clase de control de vistas.
    $HtmlViewsController = new HtmlViewsController("../../views/");

    $_DateFunctions = new DateFunctions();

    if(empty($_POST) && empty($_GET)){
        $mes=  date("m");
        if(strlen($mes)<2){
            $mes="0".$mes;
        }
        $anio= date("Y");
    }else{
        if(isset($_POST['month'])){
            $mes=$_POST['month'];
        }else{
            $mes=$_GET['month'];
        }
        if(isset($_POST['year'])){
            $anio=$_POST['year'];
        }else{
            $anio=$_GET['year'];
        }

    }

    $ListofCitas= new ArrayList();
    $_ADOCitas= new ADOCitas();
    $_ADOCitas->GetCitasFromDB($ListofCitas, $mes, $anio);
    $UserLogged= unserialize($_SESSION['UserObj']);
    $token=md5($UserLogged->email);
    $_ADOCitasEstatus =  new ADOCitasEstatus();
    $_ListOfStatus = new ArrayList();
    $_ADOCitasEstatus->GetEstatus($_ListOfStatus);
?>
 <?php  $HtmlViewsController->IncludeViews(array("HtmlTopHeader","HtmlHeader"));?>
 <title>Administracion de Accesos</title>
<?php  $HtmlViewsController->IncludeViews(array("HtmlBody"));?>
<?php include ("../../inModuleMenu.php"); ?>
<!-- Content -->
<div class="p-3">
    <div class="mt-3 mb-3">
        <span class="lead" style="font-size:42px;">
            Administraci&oacute;n de Turnos
        </span>
        <span class="lead">
            <p>Turnos Programadas</p>
        </span>
    </div>
<!-- Controles de filtros -->
    <div>
        <div>
        <form id="form_1101" class="appnitro" method="post" action="#">
               <div id="FilterByMonth">
                   Mes : <select id="Mes_SelOp">
                       <option value="01">Enero</option>
                       <option value="02">Febrero</option>
                       <option value="03">Marzo</option>
                       <option value="04">Abril</option>
                       <option value="05">Mayo</option>
                       <option value="06">Junio</option>
                       <option value="07">Julio</option>
                       <option value="08">Agosto</option>
                       <option value="09">Septiembre</option>
                       <option value="10">Octube</option>
                       <option value="11">Noviembre</option>
                       <option value="12">Diciembre</option>
                   </select>
                   &nbsp;
                   Año:
                   <select id="Anio_SelOp">

                   </select>
                   Estado:
                   <select id="Estado_SelOp">
                       <?php
                           echo '<option value="Todos" selected>Todos</option>';
                           echo '<option value="0">Agendadas</option>';
                            foreach($_ListOfStatus->array as $item){
                                $idestatus= $item->idestatus;
                                $estado=$item->estado;
                                echo '<option value="'.$idestatus.'">'. $estado .'</option>';
                            }
                       ?>
                   </select>
               </div>
               <input type="hidden" value="<?php echo $token;?>" id="usertoken" />
           </form>
        </div>
    </div>
    <div class="p-3">
        <form id="form_110" class="table table-hover table-sm table-bordered"  method="post" action="UpdateDefaultProfile.php">
               <h3>Total de Turnos Agendadas: <span id="countcitas"></span></h3>
               <table style="width: 100%" id="citastables">
                   <tr>
                       <th># Turno</th>
                       <th>Fecha</th>
                       <th>Hora </th>
                       <th>Usuario</th>
                       <th>Estado</th>
                   </tr>
               </table>
           </form>
    </div>
</div>
     <script type="text/javascript">

           $('#Mes_SelOp option[value="<?php echo $mes;?>"]').attr('selected','selected');

           $('#Mes_SelOp').change(function(){
              var mes= $('#Mes_SelOp').val();
              var anio= $('#Anio_SelOp').val();
              var token= $('#usertoken').val();
              var estatus=$('#Estado_SelOp').val()
              ClearTable();
              FillTable(mes,anio,token,estatus);

           });

           $('#Anio_SelOp').change(function(){
              var mes= $('#Mes_SelOp').val();
              var anio= $('#Anio_SelOp').val();
              var token= $('#usertoken').val();
              var estatus=$('#Estado_SelOp').val()
              ClearTable();
              FillTable(mes,anio,token,estatus);
           });

           $('#Estado_SelOp').change(function(){
              var mes= $('#Mes_SelOp').val();
              var anio= $('#Anio_SelOp').val();
              var token= $('#usertoken').val();
              var estatus=$('#Estado_SelOp').val()
              ClearTable();
              FillTable(mes,anio,token,estatus);
           });

           $().ready(function(){
               $selecoption=$('#Anio_SelOp');
               anio= new Date().getFullYear()-4;
               for(i=0;i<=6;i++){
                   anio++;
                   actualyear=new Date().getFullYear();
                   selectedmark="";
                   if(anio==actualyear){
                       selectedmark="selected";
                   }
                   $('<option '+ selectedmark +' >'+anio +'</option>').appendTo($selecoption);

               }


               //fill table
               FillTable('<?php echo $mes;?>','<?php echo $anio;?>','<?php echo $token;?>','Todos');



           })

           function GetTileDay(dia, mes, anio){
             var title="";
             var monthname="";
             var dayname="";
             var d= new Date(anio,mes,dia);
             // get Month name
             switch(mes){
                 case "01" :
                       monthname="Enero"; break;

                 case "02" : monthname="Febrero"; break;
                 case "03" : monthname="Marzo"; break;
                 case "04" : monthname="Abril"; break;
                 case "05" : monthname="Mayo"; break;
                 case "06" : monthname="Junio"; break;
                 case "07" : monthname="Julio"; break;
                 case "08" : monthname="Agosto"; break;
                 case "09" : monthname="Septiembre"; break;
                 case "10" : monthname="Octubre"; break;
                 case "11" : monthname="Noviembre"; break;
                 case "12" : monthname="Diciembre"; break;

             }

             //get day english name
             var weekday = new Array(7);
             weekday[0]=  "Domingo";
             weekday[1] = "Lunes";
             weekday[2] = "Martes";
             weekday[3] = "Miercoles";
             weekday[4] = "Jueves";
             weekday[5] = "Viernes";
             weekday[6] = "Sabado";

             dayname=weekday[d.getDay()];

             title= dayname+ " "+dia.toString()+" de "+monthname.toString() + " del " +anio.toString() + "";

             return title;

           }

           function FillTable(mes,anio,token,estado){
               //url:'GetCitasByMonth.php?mes=<?php echo $mes;?>&anio=<?php echo $anio;?>&token=<?php echo $token;?>'
               var filter=false;
               if(estado=="Todos"){
                   filter=false;
               }else{
                   filter=true;
               }
               $.ajax({
                url:'GetCitasByMonth.php?mes='+mes+'&anio='+anio+'&token='+token+'',
                type:'get',
                dataType: "json",
                success:function(result){
                     //var obj1=$.parseJSON(result);
                    var obj1=result;
                     //populate table
                     var htmltablerow='';
                     for(var i=0;i<obj1.length;i++){
                         if(filter){
                             //alert(obj1[i].EstatusCitaObj.idestatus +"="+estado);
                            if(obj1[i].EstatusCitaObj.idestatus==estado){
                                var daytitle=GetTileDay(obj1[i].dia,obj1[i].mes,obj1[i].anio);
                                htmltablerow+='<tr>';
                                htmltablerow+='<td style="text-align: center"><a href="viewCita.php?param='+ obj1[i].idcitaenc +'">'+ obj1[i].idcita +'</a></td>';
                                htmltablerow+='<td><a href="viewCita.php?param='+ obj1[i].idcitaenc +'">'+ daytitle +'</a></td>';
                                htmltablerow+='<td>'+obj1[i].hr_inicio+' - '+ obj1[i].hr_fin +'</td>';
                                htmltablerow+='<td>'+ obj1[i].UserObj.nombre +' '+ obj1[i].UserObj.apellidos +'</td>';
                                htmltablerow+='<td>'+obj1[i].EstatusCitaObj.estado+'</td>';
                                htmltablerow+='</tr>';
                                $('#countcitas').html(i+1);
                            }
                        }else{
                            var daytitle=GetTileDay(obj1[i].dia,obj1[i].mes,obj1[i].anio);
                            htmltablerow+='<tr>';
                            htmltablerow+='<td style="text-align: center"><a href="viewCita.php?param='+ obj1[i].idcitaenc +'">'+ obj1[i].idcita +'</a></td>';
                            htmltablerow+='<td><a href="viewCita.php?param='+ obj1[i].idcitaenc +'">'+ daytitle +'</a></td>';
                            htmltablerow+='<td>'+obj1[i].hr_inicio+' - '+ obj1[i].hr_fin +'</td>';
                            htmltablerow+='<td>'+ obj1[i].UserObj.nombre +' '+ obj1[i].UserObj.apellidos +'</td>';
                            htmltablerow+='<td>'+obj1[i].EstatusCitaObj.estado+'</td>';
                            htmltablerow+='</tr>';
                            $('#countcitas').html(i+1);
                        }

                     }

                     $("#citastables").append(htmltablerow);
               }});
           }



           function ClearTable(){
             $('#citastables tr:not(:first)').remove();
           }



       </script>
<!-- End content -->
<?php  $HtmlViewsController->IncludeViews(array("HtmlFooter","HtmlBottomFooter"));?>