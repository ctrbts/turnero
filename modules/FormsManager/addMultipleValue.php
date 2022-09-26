<?php
include ('topInclude.php');
$ListMultipleItems= new ArrayList();
$commonfunctions = new CommonFunctions();
$id;
$pid;
      
if(isset($_SESSION['MultipleValuesSel'])){ 
    $ListMultipleItems= unserialize($_SESSION['MultipleValuesSel']);
}

if(isset($_POST)){
    if(isset($_POST['k']) && isset($_POST['pk']) && isset($_POST['token']) && isset($_POST['kmv']) ){

        $token=$_POST['token'];
        $SessionToken=(isset($_SESSION['TToken'])) ? $_SESSION['TToken'] : null;

        if($token==$SessionToken){
            $id= base64_decode($_POST['k']);
            $pid= base64_decode($_POST['pk']);
            $kmv=base64_decode($_POST['kmv']);
            $accion=$_POST['submit'];

            if(isset($_POST['valor'])){
                $valor=$_POST['valor'];
                if($accion=="Agregar"){
                $ListMultipleItems->addItem($_POST['valor']);
                }
                
                
            }
            if($accion=="Borrar"){
                echo 'borra registro';
                $index= intval( $_POST['index']);
                unset($ListMultipleItems->array[$index]);
            }

            $_SESSION['MultipleValuesSel']=  serialize($ListMultipleItems);
            
            // realiza formato para guardar la info en la base de datos.
            $valuefield="";
            for($index=0;$index<=(count($ListMultipleItems->array)-1); $index++){
                if(isset($ListMultipleItems->array[$index])){
                    if($index>0){
                        $valuefield= $valuefield."|";
                    }
                    $valuefield=$valuefield.$ListMultipleItems->array[$index];
                }
            }

            $ADOMultipleValores = new ADOMultipleValores();
            $ADOMultipleValores->debug=true;

            //guarda informacion en base de datos
            if(!empty($kmv)){
                $MultipleValoresObj = new MultipleValoresObj();
                $MultipleValoresObj->idcamposelmultiple=$kmv;
                
                
                $ADOMultipleValores->GetMulValObj($MultipleValoresObj);
                $MultipleValoresObj->valores=$valuefield;

                $ADOMultipleValores->UpdateMultipleValores($MultipleValoresObj);
            }else{
                $CampoformaObj = new CamposFormaObj();
                $CampoformaObj->idcampoforma=$id;
                $MultipleValoresObj = new MultipleValoresObj();

                $ADOCampoForma = new ADOCamposForma();
                $ADOCampoForma->GetCampo($CampoformaObj);
                $CampoformaObj->GetTipoCampo();

                $MultipleValoresObj->idcampoforma=$CampoformaObj->idcampoforma;
                $MultipleValoresObj->idcampotipo=$CampoformaObj->TipoCampoObj->idcampotipo;
                $MultipleValoresObj->valores=$valuefield;

                $ADOMultipleValores->InsertMultipleValores($MultipleValoresObj);
            }
        }
    }              
}
if(isset($_POST['enableredirect'])){
    $redirect=$_POST['enableredirect'];
    if($redirect=="true"){
        if(isset($_POST['redirectpage'])){
            $page=$_POST['redirectpage'];
            $commonfunctions->RedirectPage($page);
        }else{
           exit();
        }
    }
}else{
    $commonfunctions->RedirectPage("MultipleValueForm.php?k=".base64_encode($id)."&pk=".base64_encode($pid));
}

?>