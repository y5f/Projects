<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Loginform {

    private $form;
    private $connect_user;
    function __construct($noError) {
        
        //---- Création du formulaire --//
        $this->form=new Form();
        $this->form->setAttribute('action', '');
        $this->form->setAttribute('method', 'post');

        if(isset($_POST['connexion'])){
           $noError=$this->connecteRequest($_POST['login'], $_POST['pass']);
        }
        $msgErr=$noError;

        $auth=new Hgroup();
        //**** LOGIN **********
        $p_log=new P();
        $l_log=new Label('');
        $l_log->setAttribute('class', 'lab');
        $l_log->addElement(new Text('Login :'));
        $log=new Input();
        $log->setAttribute('type', 'text');
        $log->setAttribute('name', 'login');
        $log->setAttribute('value', '');
        $log->setAttribute('required', '');
        $p_log->addElements(Array($l_log,$log));
        
        //****** PASSE ********
        
        $p_pass=new P();
        $l_pass=new Label('');
        $l_pass->setAttribute('class', 'lab');
        $l_pass->addElement(new Text('Mot de pass :'));
        $pass=new Input();
        $pass->setAttribute('type', 'password');
        $pass->setAttribute('name', 'pass');
        $pass->setAttribute('required', '');
        $p_pass->addElements(Array($l_pass,$pass));
        
        //-- Le bouton de connexion --//
        $p_connect=new P();
        $bou_connect=new Input();
        $bou_connect->setAttribute('type', 'submit');
        $bou_connect->setAttribute('name', 'connexion');
        $bou_connect->setAttribute('value', 'Connexion');
        $p_connect->addElement($bou_connect);
        
        $p_fogot=new P();
        $a_fogot=new A(new Text('Mot de passe oublié ?'), '?initialAuthor&pass');
        $p_fogot->addElement($a_fogot);
        
        $wrapper=new Fieldset('Connexion');
        $wrapper->addElements(Array($p_log,$p_pass,$p_connect,$p_fogot));
        
        //---- Le logo ^pour aviaco --//
        $f_logo=new P();
        $f_logo->setAttribute('class', 'logo');
        $logo=new Img('upload/logo-aviaco.png');
        $f_logo->addElement($logo);
        
        //-- Notification d'erreur de connexion ---//
        $not_err=new P();
        $not_err->setAttribute('class', 'notifErr');
        $not_err->addElement(new Text($msgErr));
        
        $auth->addElements(Array($wrapper,$f_logo,$not_err));
        
        $this->form->addElement($auth);
        
    }
    function getConnexion() {
        echo $this->form->toHTML();
    }
    function connecteRequest($log,$pass) {
        $logOK='';
        foreach (EmployeQuery::create()->find() as $usr) {
            $l=$usr->getEmail();
            $p=password_verify($pass,$usr->getPasse());
            if($p && $log===$l){
                
                //--- Protection contre la double connexion --//
                //if(!$usr->getEtat()){
                    $logOK=TRUE;
                    $usr->setEtat(TRUE);
                    $usr->save();
                    $_SESSION['aviaco']['usr']=$log;
                    header('Location: http://aviaco.com/av-admin');
                //}else{
                  //   $logOK='Une personne s\'est déjà connectée avevc vos identifiants, deconnectez-le d\'abord';
                //}
            }else{
                $logOK='Login ou mot de passe incorrect !';
            }
            
        }
        return $logOK;
    }
    function getUser(){
        return $this->connect_user;
    }
}
