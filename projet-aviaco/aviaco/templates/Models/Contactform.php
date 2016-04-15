<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Contactform {

    private $errors='';
    private $name='';
    private $visitor_email='';
    private $visitor_tel='';
    private $user_message='';
    private $content;
    function __construct() {
        
        $this->content=new Hgroup();
        //$this->content->setAttribute('class', 'contact-form');
        $er='err';
        $isValidate='valider';
        
        if(isset($_GET['valider'])){
            $isOK=$this->traiterForm($_POST['name'], $_POST['email'],$_POST['tel'], $_POST['message'], $_POST['6_letters_code']);
            
            if(!$this->errors && $isOK){
                $this->errors='Votre message a été bien envoyé, merci de votre visite';
                $er='isOK';
                $isValidate='none';
            }
        }
                    
        //-- Ontainer qui va afficher les erreurs ---//
        $err=new Div();
        $err->setAttribute('id', 'contact_form_errorloc');
        $err->setAttribute('class', $er);
        $p_err=new P();
        $p_err->addElement(new Text($this->errors));
        $err->addElement($p_err);
        
        //----- Attributs utilisés par le formulaire ---//
        $form=new Form();
        $form->setAttribute('method', 'POST');
        $form->setAttribute('name', 'contact_form');
        $form->setAttribute('action', '?url='.$_GET['url'].'&'.$isValidate);
        //-----------------------------
        
        //---- Création des éléments du formulaure ------//
        $p_nom=new P();
        $lab_nom=new Label('name');
        $lab_nom->addElement(new Text('Nom société:'));
        $inp_name=new Input();
        $inp_name->setAttribute('name', 'name');
        $inp_name->setAttribute('type', 'text');
        $inp_name->setAttribute('class', 'zone');
        $inp_name->setAttribute('value', $this->name);
        $p_nom->addElements(Array($lab_nom,$inp_name));
        
        $p_mail=new P();
        $lab_mail=new Label('email');
        $lab_mail->addElement(new Text('Email de contact :'));
        $inp_mail=new Input();
        $inp_mail->setAttribute('name', 'email');
        $inp_mail->setAttribute('type', 'text');
        $inp_mail->setAttribute('class', 'zone');
        $inp_mail->setAttribute('value', $this->visitor_email);
        $p_mail->addElements(Array($lab_mail,$inp_mail));
        
        $p_tel=new P();
        $lab_tel=new Label('tel');
        $lab_tel->addElement(new Text('N° TEL :'));
        $inp_tel=new Input();
        $inp_tel->setAttribute('name', 'tel');
        $inp_tel->setAttribute('type', 'text');
        $inp_tel->setAttribute('class', 'zone');
        $inp_tel->setAttribute('value', $this->visitor_tel);
        $p_tel->addElements(Array($lab_tel,$inp_tel));
        
        $p_msg=new P();
        $lab_msg=new Label('message');
        $lab_msg->addElement(new Text('Message:'));
        $inp_msg=new Textarea();
        $inp_msg->setAttribute('name', 'message');
        $inp_msg->setAttribute('rows', '8');
        $inp_msg->setAttribute('cols', '30');
        //$inp_msg->addElement(new Text($this->user_message));
        $p_msg->addElements(Array($lab_msg,new Br(),$inp_msg));
        
        //--- Affichage du captcher -----//
        $p_captch=new P();
        $captch_img=new Img('../scripts/captcha_code_file.php?rand');
        $captch_img->setAttribute('id', 'captchaimg');
        
        $lab_captch=new Label('message');
        $lab_captch->addElement(new Text('Entrez le code c-dessus'));
        $inp_captch=new Input();
        $inp_captch->setAttribute('name', '6_letters_code');
        $inp_captch->setAttribute('id', '6_letters_code');
        
        $pas_lire=new Small();
        $relire=new Label('');
        $relire->addElement(new Text('cliquez ici'));
        $relire->setAttribute('class', 'refresh');
        $pas_lire->addElement(new Text('Vous ne pouvez pas lire l\'image? '.$relire->toHTML().' pour rafraichîr'));
        $p_captch->addElements(Array($captch_img,new Br(),$lab_captch,new Br(),$inp_captch,new Br(),$pas_lire));

        $wrapper=new Div();
        $wrapper->setAttribute('class', 'wrapper');
        $but_input=new Input();
        $but_input->setAttribute('type', 'submit');
        $but_input->setAttribute('name', 'submit');
        $but_input->setAttribute('value', 'Envoyer');
        $but_input->setAttribute('class', 'submit');
        $wrapper->addElements(Array($but_input));
        
        $fieldsel=new Fieldset('Nous contacter');
        $fieldsel->addElements(Array($err,$p_nom,$p_mail,$p_tel,$p_msg,$p_captch,$wrapper));
        $form->addElement($fieldsel);
        
        //-- Partie qui va contenir la map de la sociéte ----//
        $map_contact=new Div();
        $map_contact->setAttribute('class', 'map-contact');
        $map_infos=new Div();
        $map_infos->setAttribute('class', 'map-infos');
        $mes_infos=InfosQuery::create()->findOne();
        $infos="<h3>Nous contacter</>".
                "<p>".$mes_infos->getNumrue()." ".$mes_infos->getNomrue().", ".$mes_infos->getCodepostal()." ".strtoupper($mes_infos->getVille())."</br>".
                "Tél : ".$mes_infos->getTelephone()."</br>".
                "Email :".$mes_infos->getEmail()."</p>";
        $map_infos->addElement(new Text($infos));
        
        $map=new Div();
        $map->setAttribute('id', 'map');
        $map_contact->addElements(Array($map_infos,$map));
        
        $this->content->addElements(Array($form,$map_contact));
        
    }
    
    /*
     * Cette fonction retourne le formulaire tout construit au format HTML ---//
     * 
     */
    function getFormulaire() {
        return $this->content->toHTML();
    }
    
    //--- Fonction va faire le traitement des données soumises au formulaire ----//
    function traiterForm($name,$mail,$tel,$msg,$captc) {
        $this->name=$name;
        $this->visitor_email=$mail;
        $this->visitor_tel=$tel;
        $this->user_message=$msg;
        
        if(empty($this->name)||empty($this->visitor_email) || empty($this->user_message)){
            $this->errors.= "\n nom, mail et message requis.<br/>";	
	}
        if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $captc) != 0){
            $this->errors .= "\n Le code de confirmation que vous avez entré ne correspond pas à celui de l'image !";
	}
        
        IF(!$this->errors){
            $new_msg=new Message();
            $new_msg->setObjet('');
            $new_msg->setVisiteur($this->name);
            $new_msg->setEmail($this->visitor_email);
            $new_msg->setTelephone($this->visitor_tel);
            $new_msg->setMsg($this->user_message);
            $new_msg->setEtat(1);
            return $new_msg->save();
        }
    }
}
