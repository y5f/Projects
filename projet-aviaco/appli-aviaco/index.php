<?php session_start();?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <?php

        //--- On carge le fichier autoload du vendor ---//

        require_once 'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

        //-- On charge le scripte de connexion à la base de données --//

        require_once 'generator'.DIRECTORY_SEPARATOR.'generated-conf'.DIRECTORY_SEPARATOR.'config.php';

        ?>
        <title><?php echo InfosQuery::create()->findOne()->getTitre(); ?></title>
        
        <!-- Bibliotheque google qui gère les MAP -->
        <script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
        
        <!--
            Appel des fichiers JS et les feuilles de styles
        -->
        <link href="styles/styles-sheet.css" type="text/css" rel="stylesheet">
        <script src="scripts/upload.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui.js" type="text/javascript"></script>
        <script src="scripts/jquery.js" type="text/javascript"></script>
        <script src="scripts/script.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-plagin/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-plagin/jquery-ui.min.js" type="text/javascript"></script>
        
    </head>
    <body id="wrapper">
        <div id="MyIg"></div>
        <?php
        
        //---- Création de l'entête -----//
        $head=new Head();

        //--- Si on clique sur deconnexion ---//
        if(isset($_GET['action'])){
            if($_GET['action']=='dec'){
                //--- On deconnecte l'utilisateur depuis la base de données --//
                $emp=EmployeQuery::create()->filterByIdEmploye($_GET['user'])->findOne();
                if($emp){
                    $etat=$emp->setEtat(FALSE);
                    $etat->save();
                    unset($_SESSION['aviaco']['adm']);
                    header('Location: http://appli-aviaco.org');
                }
            }
        }
        
        //---- Création du contenu au milieur ---//
        $body=new Middle();
        
        if(!isset($_SESSION['aviaco']['adm'])){
            $auth=new Loginform(null);
            $auth->getForm();
        }else {
            //-- On recupère l'utilisateur en question et on verifie si une session de lui existe --//
            $usr=EmployeQuery::create()->filterByEmail($_SESSION['aviaco']['adm'])->findOne();
            if($usr){
                if($usr->getEtat()){
                    $head->getHeaders();
                    $body->getContenu();
                }else{
                    //-- On demande à l'internaute de se reconnecter en lui notifiant qu'il été deconnecté --//
                    $notif='Vous avez été deconnecté par le propriétaire de ce compte';
                    $auth=new Loginform($notif);
                    $auth->getForm();
                }
            }
        }
        
        //--- Création du pied de page --//
        $pg=new Foot();
        $pg->getFooter();
        
        ?>
    </body>
</html>
