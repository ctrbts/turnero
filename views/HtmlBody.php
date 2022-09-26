<?php
// Imprime el Logo y titulo
    $LogoImageConf = new SystemConfObj();
    $LogoImageConf->variable="LogoImageFile";

    $ADOSystemConf = new ADOSystemConf();
    $ADOSystemConf->GetVariableByName($LogoImageConf);

    $TitleConf = new SystemConfObj();
    $TitleConf->variable= "PublicMainHeader";

    $ADOSystemConf->GetVariableByName($TitleConf);
?>
</head>
<body id="main_body">

    <div class="text-center">

<?php
    if(!empty($LogoImageConf->idvariable) || !empty($TitleConf->idvariable)){
        $Configuration = new Config();
        $img = $Configuration->domain."/".$Configuration->pathServer."/images/".$LogoImageConf->valor;
?>
<?php if( $TitleConf->valor!="" || $LogoImageConf->valor!="" ){?>
<div  class="text-center p-3 rounded border border-dark bg-white" >
    <?php if(!empty($LogoImageConf->idvariable)){?>
    <img style="height: 80px; width: 150px;"  align="middle" src="<?php echo $img;?>" />
    <?php }?>
    <?php if($TitleConf->valor!=""){?>
    <div><span class="h2"><?php echo $TitleConf->valor?></span></div>
    <?php }?>
</div>
<?php
     }
    }
?>