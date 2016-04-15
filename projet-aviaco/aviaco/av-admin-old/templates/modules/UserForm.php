<?php

class UserForm {

    private $form;
    function __construct() {
        
        $this->form=new Div();
        $this->form->setAttribute('class', 'user-form');
        
        // Premier bloc : Détails utilisateur //
        $b_details=new Hgroup();
        $b_details->setAttribute('class','details');
        $bloc_details=new Fieldset('Details-Utilisateur'); 
        
        $p_id=new P();
        $p_id->setAttribute('class', 'align-input');
        $l_id=new Label('');
        $l_id->setAttribute('class', 'lab');
        $l_id->addElement(New Text('Code Emp :'));
        $input_id=new Input();
        $input_id->setAttribute('type', 'text');
        $input_id->setAttribute('disabled', '');
        $input_id->setAttribute('id', 'user-id');
        $p_id->addElements(Array($l_id,$input_id));
        
        $p_nom=new P();
        $p_nom->setAttribute('class', 'align-input');
        $l_nom=new Label('');
        $l_nom->setAttribute('class', 'lab');
        $l_nom->addElement(New Text('Nom :'));
        $input_nom=new Input();
        $input_nom->setAttribute('id','user-name');
        $input_nom->setAttribute('type', 'text');
        $p_nom->addElements(Array($l_nom,$input_nom));
        
        $p_prenom=new P();
        $p_prenom->setAttribute('class', 'align-input');
        $l_prenom=new Label('');
        $l_prenom->setAttribute('class', 'lab');
        $l_prenom->addElement(New Text('Prénom :'));
        $input_prenom=new Input();
        $input_prenom->setAttribute('id', 'user-pren');
        $input_prenom->setAttribute('type', 'text');
        $p_prenom->addElements(Array($l_prenom,$input_prenom));
        
        $p_adr=new P();
        $p_adr->setAttribute('class', 'align-input');
        $l_adr=new Label('');
        $l_adr->setAttribute('class', 'lab');
        $l_adr->addElement(New Text('Adresses :'));
        $input_adr=new Input();
        $input_adr->setAttribute('id', 'user-adr');
        $input_adr->setAttribute('type', 'text');
        $p_adr->addElements(Array($l_adr,$input_adr));
        
        $p_postal_fonc=new P();
        $p_postal_fonc->setAttribute('class', 'align-input');
        $l_postal=new Label('');
        $l_postal->setAttribute('class', 'lab');
        $l_fonc=new Label('');
        $l_fonc->setAttribute('class', 'lab');
        $l_postal->addElement(New Text('Code postal'));
        $l_fonc->addElement(New Text('Fonction'));
        $input_postal=new Input();
        $input_postal->setAttribute('id', 'user-post');
        $input_fonc=new Input();
        $input_fonc->setAttribute('id', 'user-fonc');
        $input_fonc->setAttribute('id', 'user-fonc');
        $input_postal->setAttribute('type', 'text');
        $input_fonc->setAttribute('type', 'text');
        $p_postal_fonc->addElements(Array($l_postal,$input_postal,$l_fonc,$input_fonc));
        
        $p_etat=new P();
        $p_etat->setAttribute('class', 'align-input');
        $l_etat=new Label('');
        $l_etat->setAttribute('class', 'lab');
        $l_etat->addElement(New Text('Etat'));
        $input_etat=new Select();
        $input_etat->setAttribute('id', 'user-etat');
        $opt_etat_1=new Option();
        $opt_etat_1->addElement(new Text('0'));
        $opt_etat_2=new Option();
        $opt_etat_2->addElement(new Text('1'));
        $input_etat->addElements(Array($opt_etat_1,$opt_etat_2));

        $l_mail=new Label('');
        $l_mail->addElement(new Text('Email :'));
        $l_mail->setAttribute('class', 'lab');
        $email=new Input();
        $email->setAttribute('id', 'user-mail');
        $email->setAttribute('type', 'email');
        //$p_mail->addElements(Array());
        
        $p_pass=new P();
        $l_pass=new Label('');
        $l_pass->addElement(new Text('Mot de passe :'));
        $l_pass->setAttribute('class', 'lab');
        $pass=new Input();
        $pass->setAttribute('id', 'user-pass');
        $pass->setAttribute('type', 'password');
        $p_pass->addElements(Array($l_pass,$pass));
        
        $p_etat->addElements(Array($l_mail,$email,$l_etat,$input_etat));
        
        $p_tel_access=new P();
        $p_tel_access->setAttribute('class', 'align-input');
        $l_tel=new Label('');
        $l_tel->setAttribute('class', 'lab');
        $l_access=new Label('');
        $l_access->setAttribute('class', 'lab');
        $l_tel->addElement(New Text('Tél'));
        $l_access->addElement(New Text('Accès'));
        $input_tel=new Input();
        $input_tel->setAttribute('id', 'user-tel');
        $input_tel->setAttribute('type', 'telephon');
        
        $input_access=new Select();
        $input_access->setAttribute('id', 'user-acc');
        $opt_acc_1=new Option();
        $opt_acc_1->addElement(new Text('U'));
        $opt_acc_2=new Option();
        $opt_acc_2->addElement(new Text('A'));
        $input_access->addElements(Array($opt_acc_1,$opt_acc_2));
        
        $p_tel_access->addElements(Array($l_tel,$input_tel,$l_access,$input_access));
        
        //$p_bout=new P();
        $input_bout_m=new Input();
        $input_bout_m->setAttribute('id', 'user-mod');
        $input_bout_m->setAttribute('type', 'submit');
        $input_bout_m->setAttribute('value', 'Modifier');
        $input_bout_s=new Input();
        $input_bout_s->setAttribute('id', 'user-sup');
        $input_bout_s->setAttribute('type', 'submit');
        $input_bout_s->setAttribute('value', 'Supprimer');
        //$p_bout->addElements(Array($input_bout_s,$input_bout_m));
        $bloc_details->addElements(Array($p_id,$p_nom,$p_prenom,$p_adr,$p_postal_fonc,$p_etat,$p_pass,$p_tel_access,$input_bout_s,$input_bout_m));

        // deuxième bloc list user//
        $b_list_user=new Hgroup();
        $b_list_user->setAttribute('class', 'list-user');
        
        $table=new Table();
        $table->setAttribute('class','user-tab');
        
        $thead=new Thead();
        $titre=new Caption();
        $titre->addElement(new Text('Liste des utilisateurs'));
        
        $tr=new Tr();
        $th_pren=new Th();
        $th_pren->addElement(new Text('Prénoms'));
        
        $th_name=new Th();
        $th_name->addElement(new Text('Nom'));
        
        $th_tel=new Th();
        $th_tel->addElement(new Text('Téléphone'));
        
        $th_etat=new Th();
        $th_etat->addElement(new Text('Connexion'));
        
        $tr->addElements(Array($th_pren,$th_name,$th_tel,$th_etat));
        $thead->addElements(Array($titre,$tr));
        $tbody=new Tbody();
        
        foreach (EmployeQuery::create()->orderByPrenoom('ASC')->find() as $emp) {
            $tr_b=new Tr();
            $tr_b->setAttribute('class', 'user-select');
            $tr_b->setAttribute('id', $emp->getIdEmploye());
            $td_pren=new Td();
            $td_pren->addElement(new Text($emp->getPrenoom()));
            $td_b_name=new Td();
            $td_b_name->addElement(new Text($emp->getNom()));
            $td_b_tel=new Td();
            $td_b_tel->addElement(new Text($emp->getTelephone()));
            $td_b_etat=new Td();
            $etat='hors ligne';
            if($emp->getEtat()){
                $etat='en ligne';
            }
            $td_b_etat->addElement(new Text($etat));
            $tr_b->addElements(Array($td_pren,$td_b_name,$td_b_tel,$td_b_etat));
            $tbody->addElement($tr_b);
        }
        $table->addElements(Array($thead,$tbody));
        $b_list_user->addElement($table);
        
        // troisième bloc Nouvel utilisateur  //
        
       $b_new_user=new Hgroup();
       $b_new_user->setAttribute('class', 'nouv-user');
       $bloc_new_user=new Fieldset('Nouvel utilisateur');
       
        $p_nom_prenom_n=new P();
        $l_nom_n=new Label('');
        $l_nom_n->setAttribute('class', 'lab');
        $l_prenom_n=new Label('');
        $l_prenom_n->setAttribute('class', 'lab');
        $l_nom_n->addElement(New Text('Nom :'));
        $l_prenom_n->addElement(New Text('Prénom :'));
        $input_nom_n=new Input();
        $input_nom_n->setAttribute('id', 'user-name-n');
        $input_prenom_n=new Input();
        $input_prenom_n->setAttribute('id', 'user-pren-n');
        $input_nom_n->setAttribute('type', 'text');
        $input_prenom_n->setAttribute('type', 'text');
        $p_nom_prenom_n->addElements(Array($l_nom_n,$input_nom_n,$l_prenom_n,$input_prenom_n));
        
        $p_adr_postal_n=new P();
        $input_adr_n=new Input();
        $input_adr_n->setAttribute('id', 'user-adr-n');
        $input_adr_n->setAttribute('type', 'text');
        $l_adr_n=new Label('');
        $l_adr_n->setAttribute('class', 'lab');
        $l_adr_n->addElement(New Text('Adresses :'));
        $p_adr_postal_n->addElements(Array($l_adr_n,$input_adr_n));
        
        $p_postal_n=new P();
        $l_postal_n=new Label('');
        $l_postal_n->setAttribute('class', 'lab');
        $l_postal_n->addElement(New Text('Code postale :'));
        $input_postal_n=new Input();
        $input_postal_n->setAttribute('id', 'user-post-n');
        $input_postal_n->setAttribute('type', 'text');
        $p_postal_n->addElements(Array($l_postal_n,$input_postal_n));
 
        $p_fonc_tel_n=new P();
        $l_fonc_n=new Label('');
        $l_fonc_n->setAttribute('class', 'lab');
        $l_tel_n=new Label('');
        $l_tel_n->setAttribute('class', 'lab');
        $l_fonc_n->addElement(New Text('Fonction :'));
        $l_tel_n->addElement(New Text('Téléphone :'));
        
        $p_mail_n=new P();
        $l_mail_n=new Label('');
        $l_mail_n->addElement(new Text('Email :'));
        $l_mail_n->setAttribute('class', 'lab');
        $email_n=new Input();
        $email_n->setAttribute('id', 'user-mail-n');
        $email_n->setAttribute('type', 'email');
        $p_mail_n->addElements(Array($l_mail_n,$email_n));
        
        $p_pass_n=new P();
        $l_pass_n=new Label('');
        $l_pass_n->addElement(new Text('Mot de passe :'));
        $l_pass_n->setAttribute('class', 'lab');
        $pass_n=new Input();
        $pass_n->setAttribute('id', 'user-pass-n');
        $pass_n->setAttribute('type', 'password');
        $p_pass_n->addElements(Array($l_pass_n,$pass_n));
        
        $input_fonc_n=new Input();
        $input_fonc_n->setAttribute('id', 'user-fonc-n');
        $input_tel_n=new Input();
        $input_tel_n->setAttribute('id', 'user-tel-n');
        $input_fonc_n->setAttribute('type', 'text');
        $input_tel_n->setAttribute('type', 'text');
        $p_fonc_tel_n->addElements(Array($l_fonc_n,$input_fonc_n,$l_tel_n,$input_tel_n,$p_mail_n,$p_pass_n));
        
        $p_niv_access=new P();
        $l_niv_access=new Label('');
        $l_niv_access->setAttribute('class', 'lab');
        $l_niv_access->addElement(new Text('Niv. Access :'));
        $input_niv_access=new Select();
        $input_niv_access->setAttribute('id', 'user-acc-n');
        $opt_acc_n_1=new Option();
        $opt_acc_n_1->addElement(new Text('U'));
        $opt_acc_n_2=new Option();
        $opt_acc_n_2->addElement(new Text('A'));
        $input_niv_access->addElements(Array($opt_acc_n_1,$opt_acc_n_2));
        $p_niv_access->addElements(Array($l_niv_access,$input_niv_access));
        //$p_bout_access=new P();
        $input_bout_access_a=new Input();
        $input_bout_access_a->setAttribute('id', 'user-add');
        $input_bout_access_a->setAttribute('type', 'submit');
        $input_bout_access_a->setAttribute('value', 'Inserer');
        $input_bout_access_r=new Input();
        $input_bout_access_r->setAttribute('id', 'user-reset');
        $input_bout_access_r->setAttribute('type', 'submit');
        $input_bout_access_r->setAttribute('value', 'Reset');
        //$p_bout_access->addElements(Array($input_bout_access_a,$input_bout_access_r));
        $bloc_new_user->addElements(Array($p_nom_prenom_n,$p_adr_postal_n,$p_postal_n,$p_fonc_tel_n,$p_niv_access,$input_bout_access_a,$input_bout_access_r));
        
        $b_details->addElements(Array($bloc_new_user,$bloc_details));
        $this->form->addElements(Array($b_details,$b_list_user,));
    }
    
    function getForm()
    {
        return $this->form;
    }
    
}
