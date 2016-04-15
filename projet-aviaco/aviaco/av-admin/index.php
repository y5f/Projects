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
        <?Php
        require_once '../vendor/autoload.php';
        require_once '../generated-conf/config.php';
        
        $mesFontes=new Font();
        $mesFontes->getFonts();
        ?>
        <title><?php echo InfosQuery::create()->findOne()->getTitre(); ?></title>
        <link href="styles/style-sheets.css" type="text/css" rel="stylesheet">
        
        <script src="scripts/jquery-ui.js" type="text/javascript"></script>
        <script src="scripts/jquery.js" type="text/javascript"></script>
        <script src="../ckeditor/ckeditor.js" type="text/javascript"></script>
        <script src="scripts/script.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-plagin/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-plagin/jquery-ui.min.js" type="text/javascript"></script>
        
    </head>
    <body>
        <?php 
            
            ///--- Un objet de type Entete ---//
            $entete=new Entete();
            $entete->getEntete();
            
            //--- Si on clique sur deconnexion ---//
            if(isset($_GET['action'])){
                if($_GET['action']=='dec'){
                    //--- On deconnecte l'utilisateur depuis la base de données --//
                    $emp=EmployeQuery::create()->filterByIdEmploye($_GET['user'])->findOne();
                    if($emp){
                        $etat=$emp->setEtat(FALSE);
                        $etat->save();
                        unset($_SESSION['aviaco']['usr']);
                        header('Location: http://aviaco.com/av-admin');
                    }
                }
            }
            
            //-- Un objet de type Body ---//
            $body=new Body();
            
            if(!isset($_SESSION['aviaco']['usr'])){
                $auth=new Loginform(null);
                $auth->getConnexion();
            }else {
                //-- On recupère l'utilisateur en question et on verifie si une session de lui existe --//
                $usr=EmployeQuery::create()->filterByEmail($_SESSION['aviaco']['usr'])->findOne();
                if($usr){
                    if($usr->getEtat()){
                       $body->getBody();
                    }else{
                        //-- On demande à l'internaute de se reconnecter en lui notifiant qu'il été deconnecté --//
                        $notif='Vous avez été deconnecté par le propriétaire de ce compte';
                        $auth=new Loginform($notif);
                        $auth->getConnexion();
                    }
                }
            }
            

            // objet de type Footer //
            $footer=new Pied();
            $footer->getFooter();
            
        ?>
    </body>
</html>

