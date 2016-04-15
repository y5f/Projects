<?php 
session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <?Php
        require_once 'vendor/autoload.php';
        require_once 'generated-conf/config.php';
        
        $mesFontes=new Font();
        $mesFontes->getFonts();
        ?>
        <title><?php echo InfosQuery::create()->findOne()->getTitre(); ?></title>
        <!-- Cette ligne a un effet sur le bootstrap -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- gestion du device -->
        <link href="dist/css/bootstrap.min.css" rel="stylesheet">
        <!---------- -->
        <link href="styles/style-sheets.css" type="text/css" rel="stylesheet">
        
        <script src="scripts/jquery-ui.js" type="text/javascript"></script>
        <script src="scripts/jquery.js" type="text/javascript"></script>
        <script src="scripts/script.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    </head>
    <body>
        <?php

	//####### CREATION DE L'ENTETE ###############
	//-- On crée une entête a partir de la classe Header de HTML 5---
        $head=new Head();
        $head->getHeader();	
		
	//####### CREATION DE LA PARTIE CENTRALE DE LA PAGE ######
        
        $folio=new Portfolio();
        $accueil=new Middle();
        if(isset($_GET['url']) && $_GET['url']!='home'){
            if(!isset($_GET['list'])){
                $folio->getPortfolio();
            }else{
                $ma_liste=new Listmodel();
                $ma_liste->getList();
            }
        }else{
            $accueil->getContents();
        }  
        //$mon_slide=new Img('upload/image_1.jpg');
        //echo $mon_slide->toHTML();
	
	//############ CREATION DU FOOTER ####################
	$foo=new Foot();
	$foo->getFoot(); 
	
        ?>
        <!-- Cible l'appel des plug-in JavaScript de bootstrap
            <script src="http://code.jquery.com/jquery.js"></script>
            <script src="js/bootstrap.min.js"></script>
        -->
    </body>
</html>
