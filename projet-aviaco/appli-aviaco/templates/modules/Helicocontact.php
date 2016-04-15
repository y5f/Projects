<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Helocontact
 *
 * @author méziane
 */
class Helicocontact extends Template{
    
    private $infosoc;
    private $finance;
    private $activite;
    private $contact;

    function __construct() {

        parent::__construct(new Form());
        $this->form->setAttribute('method', 'post');
        $this->form->setAttribute('class', 'new-part');
        $this->form->setAttribute('id', 'new-part');
        
        $this->infosoc=new Div();
        //$this->infosoc->setAttribute('method', 'post');
        $this->infosoc->setAttribute('id', 'b-cordon');
        $this->infosoc->setAttribute('class', 'b-cordon');
        // construction de formulaire //
        
        //---  On verifie si un objet soc; representant une société a été declaré --//
        if(isset($_GET['soc'])){
            $id=$_GET['soc'];
            $soc=SocieteQuery::create()->filterByID($id)->findOne();
        };
        $hg_soc=new Hgroup();
        
        $b_new_cordon=new Hgroup();
        $cordon_titre=new H2();
        $cordon_titre->addElement(new Text('info entreprise'));
        
        //<editor-fold defaultstate="collapsed" desc="---info entreprise---">

        $numsoc=new Input();
        $numsoc->setAttribute('type', 'hidden');
        $numsoc->setAttribute('name', 'num-soc');
        $numsoc->setAttribute('id', 'num-soc');
        if(isset($soc)){
            $numsoc->setAttribute('value',$soc->getID());
        }else{
            $numsoc->setAttribute('value','');
        }
        
        $entrep_nom_p=new P();
        $l_ep=new Label('');
        $l_ep->setAttribute('class', 'lab');
        $l_ep->addElement(new Text('Nom de l\'entrprise :*'));
        
        $entrep_input_p=new Input();
        $entrep_input_p->setAttribute('type', 'text');
        $entrep_input_p->setAttribute('name', 'ep-name');
        if(isset($soc)){
            $entrep_input_p->setAttribute('value', $soc->getSociete());
        }else{
            $entrep_input_p->setAttribute('value', '');
        }
        $entrep_input_p->setAttribute('required', '');
        $entrep_input_p->setAttribute('id', 'ep-name');
        $entrep_nom_p->addElements(Array($l_ep,$entrep_input_p));
        
        /*champs nom  deregent de la societé*/
        $entrep_NomDir_p=new P();
        $l_NomDir=new Label('');
        $l_NomDir->setAttribute('class', 'lab');
        $l_NomDir->addElement(new Text('Nom du dirigeant :'));
        
        $entrep_input_NomDer=new Input();
        $entrep_input_NomDer->setAttribute('type', 'text');
        $entrep_input_NomDer->setAttribute('name', 'nom-dir');
        if(isset($soc)){
            $entrep_input_NomDer->setAttribute('value', $soc->getDirigeant());
        }else{
            $entrep_input_NomDer->setAttribute('value', '');
        }
        $entrep_input_NomDer->setAttribute('id', 'nom-dir');
        $entrep_NomDir_p->addElements(Array($l_NomDir,$entrep_input_NomDer));
        
        /*champs numero de telephon de la societé*/
        $entrep_phon_p=new P();
        $l_phon=new Label('');
        $l_phon->setAttribute('class', 'lab');
        $l_phon->addElement(new Text('Téléphone :*'));
        
        $entrep_input_phon=new Input();
        $entrep_input_phon->setAttribute('type', 'tel');
        $entrep_input_phon->setAttribute('name', 'phone');
        if(isset($soc)){
            $entrep_input_phon->setAttribute('value', $soc->getTelephone());
        }else{
            $entrep_input_phon->setAttribute('value', '');
        }
        $entrep_input_phon->setAttribute('id', 'phone');
        $entrep_phon_p->addElements(Array($l_phon,$entrep_input_phon));
        
        /*champs numero de fax de la societé*/
        $entrep_Fax_p=new P();
        $l_fax=new Label('');
        $l_fax->setAttribute('class', 'lab');
        $l_fax->addElement(new Text('Fax :'));
        
        $entrep_input_Fax=new Input();
        $entrep_input_Fax->setAttribute('type', 'tel');
        $entrep_input_Fax->setAttribute('name', 'fax');
        if(isset($soc)){
            $entrep_input_Fax->setAttribute('value', $soc->getFax());
        }else{
            $entrep_input_Fax->setAttribute('value', '');
        }
        $entrep_input_Fax->setAttribute('id', 'fax');
        $entrep_Fax_p->addElements(Array($l_fax,$entrep_input_Fax));
        
        /*champs adresse email de la societé*/
        $entrep_email_p=new P();
        $l_email=new Label('');
        $l_email->setAttribute('class', 'lab');
        $l_email->addElement(new Text('Mail :*'));
        
        $entrep_input_email=new Input();
        $entrep_input_email->setAttribute('type', 'email');
        $entrep_input_email->setAttribute('name', 'email');
        if(isset($soc)){
            $entrep_input_email->setAttribute('value', $soc->getEmail());
        }else{
            $entrep_input_email->setAttribute('value', '');
        }
        $entrep_input_email->setAttribute('required', '');
        $entrep_input_email->setAttribute('id', 'email');
        $entrep_email_p->addElements(Array($l_email,$entrep_input_email));
        
        /*champs site web de la societé*/
        $entrep_WebSit_p=new P();
        $l_site=new Label('');
        $l_site->setAttribute('class', 'lab');
        $l_site->addElement(new Text('Site web :'));
        
        $entrep_input_WebSit=new Input();
        $entrep_input_WebSit->setAttribute('type', 'text');
        $entrep_input_WebSit->setAttribute('name', 'websit');
        if(isset($soc)){
            $entrep_input_WebSit->setAttribute('value', $soc->getWebsite());
        }else{
            $entrep_input_WebSit->setAttribute('value', '');
        }
        $entrep_input_WebSit->setAttribute('id', 'websit');
        $entrep_WebSit_p->addElements(Array($l_site,$entrep_input_WebSit));
        
        /*feidset du bloc  hestorique societé avec des checkbox*/
        
        $hestorique_feild=new Fieldset('Historique');
        $hestorique_feild->setAttribute('class', 'liste-hist');
        
        $ul_liste_hist=new Ul();
        foreach (HistoriqueQuery::create()->find() as $hist) {
            $chkbx=new Input();
            $chkbx->setAttribute('type', 'checkbox');
            $chkbx->setAttribute('name', 'hist');
            $chkbx->setAttribute('class', 'hist-sel');
            $chkbx->setAttribute('value', $hist->getHistorique());
            if(isset($soc)){
                if(SocietehistoriqueQuery::create()->filterBySociete($soc)->filterByHistorique($hist)->findOne()){
                    $chkbx->setAttribute('checked', '');
                }
            }
            $p_hist=new P();
            $p_hist->addElements(Array($chkbx,new Text($hist->getHistorique())));
            $li=new Li($p_hist, '');
            $ul_liste_hist->addLi($li);
        }
        $hestorique_feild->addElement($ul_liste_hist);
        
        $b_new_cordon->addElements(Array($numsoc,$entrep_nom_p,$entrep_NomDir_p,$entrep_phon_p,$entrep_Fax_p,$entrep_email_p,$entrep_WebSit_p, $hestorique_feild));
        //bloc adresse 
        $b_new_adr=new Hgroup();

        $entrep_adresse_p=new P();
        $l_addr=new Label('');
        $l_addr->setAttribute('class', 'lab');
        $l_addr->addElement(new Text('Adresses :'));
        
        $entrep_input_adresse=new Input();
        $entrep_input_adresse->setAttribute('type', 'text');
        $entrep_input_adresse->setAttribute('name', 'adresse');
        if(isset($soc)){
            $entrep_input_adresse->setAttribute('value', $soc->getAdresses());
        }else{
            $entrep_input_adresse->setAttribute('value', '');
        }
        $entrep_input_adresse->setAttribute('id', 'adresse');
        $entrep_adresse_p->addElements(Array($l_addr,$entrep_input_adresse));
        
        /*champs code postal societé*/
        $entrep_code_cp_p=new P();
        $l_cp=new Label('');
        $l_cp->setAttribute('class', 'lab');
        $l_cp->addElement(new Text('CP :'));
        
        $entrep_input_codeP=new Input();
        $entrep_input_codeP->setAttribute('type', 'text');
        $entrep_input_codeP->setAttribute('name', 'cp');
        if(isset($soc)){
            $entrep_input_codeP->setAttribute('value', $soc->getCP());
        }else{
            $entrep_input_codeP->setAttribute('value', '');
        }
        
        $entrep_input_codeP->setAttribute('id', 'cp');
        $entrep_code_cp_p->addElements(Array($l_cp,$entrep_input_codeP));
        
        //-- Ville --//
        $entrep_ville_p=new P();
        $l_ville=new Label('');
        $l_ville->setAttribute('class', 'lab');
        $l_ville->addElement(new Text('Ville :'));
        
        $entrep_input_ville=new Input();
        $entrep_input_ville->setAttribute('type', 'text');
        $entrep_input_ville->setAttribute('name', 'ville');
        if(isset($soc)){
            $entrep_input_ville->setAttribute('value', $soc->getVille());
        }else{
            $entrep_input_ville->setAttribute('value', '');
        }
        $entrep_input_ville->setAttribute('id', 'ville');
        $entrep_ville_p->addElements(Array($l_ville,$entrep_input_ville));
        
        //--- Pays --//
        $entrep_pays_p=new P();
        $l_pays=new Label('');
        $l_pays->setAttribute('class', 'lab');
        $l_pays->addElement(new Text('Pays :'));
        
        $entrep_input_pays=new Input();
        $entrep_input_pays->setAttribute('type', 'text');
        $entrep_input_pays->setAttribute('name', 'pays');
        $entrep_input_pays->setAttribute('list', 'list-pays');
        //---- Liste d'auto-completion ---//
        $data_list=new Datalist();
        $data_list->setAttribute('id', 'list-pays');
        foreach (MPaysQuery::create()->orderByPays('ASC')->find() as $pays) {
            $dat_opt=new Option();
            $dat_opt->setAttribute('value', $pays->getPays());
            $data_list->addElement($dat_opt);
        }
        
        if(isset($soc)){
            $entrep_input_pays->setAttribute('value', $soc->getPays());
        }else{
            $entrep_input_pays->setAttribute('value', '');
        }
        
        //$entrep_input_pays->setAttribute('id', 'pays');
        $entrep_pays_p->addElements(Array($l_pays,$entrep_input_pays,$data_list));
        
        //--- La note --//
        $entrep_note_fs=new Fieldset('Note');
        $entrep_note=new Textarea();
        $entrep_note->setAttribute('name', 'note-soc');
        $entrep_note->setAttribute('id', 'note-soc');
        if(isset($soc)){
            $entrep_note->addElement(new Text($soc->getNotes()));
        }
        
        //---- Note vendeur --//
        $note_vend_p=new P();
        $link_vend=new A(new Text('Lien vers'), '');
        $note_vend_p->addElements(Array(new Text('S\'il ya des notes dans la fiche vendeur '),$link_vend));
        
        $entrep_note_fs->addElements(Array($entrep_note,$note_vend_p));
        
        
        
        //</editor-fold>
   
        $b_new_adr->addElements(Array($entrep_adresse_p,$entrep_code_cp_p,$entrep_ville_p,$entrep_pays_p,$entrep_note_fs));
        
        //<editor-fold defaultstate="collapsed" desc="---Logo/Alerte fraude---">
        
        //--- Affichage de la date de MAJ ---//
        $date_maj=new Input();
        $date_maj->setAttribute('type', 'date');
        $date_maj->setAttribute('class', 'dte-maj');
        $date_maj->setAttribute('id', 'dte-maj-cord');
        if(isset($soc)){
            $date_maj->setAttribute('value', $soc->getDateMAJSOC()->format('Y-m-d'));
        }
        
        //--- Bloc pour logo et alerte fraude --//
        $b_logo_fraude=new Hgroup();
        $b_logo_fraude->setAttribute('class', 'b-fraude');
        $div_f_1=new Div();
        $p_fraude=new P();
        $p_fraude->setAttribute('class', 'f-alert');
        
        //--- On rajoute deux em qui feront offic de magnetique aux extreme du bolc P--//
        $em_g=new Em();
        $em_g->setAttribute('class', 'mg magn-g');
        $em_d=new Em();
        $em_d->setAttribute('class', 'mg magn-d');
        
        $bouton_on_off=new Label('');
        if(isset($soc)){
            if($soc->getisFraude()){
               $bouton_on_off->setAttribute('id', 'b-on');
               $bouton_on_off->setAttribute('etat', '1');
            }else{
               $bouton_on_off->setAttribute('id', 'b-off');
               $bouton_on_off->setAttribute('etat', '0');
            }
        }else{
            $bouton_on_off->setAttribute('id', 'b-on');
            $bouton_on_off->setAttribute('etat', '1');
        }
        
        $bouton_on_off->setAttribute('class', 'b-on-off');
        
        $p_fraude->addElements(Array($bouton_on_off));
        
        $div_f_1->addElement($p_fraude);
        
        $div_f_2=new Div();
        $div_f_2->setAttribute('id', 'logo-soc');
        if(isset($soc)){
            $im_log=new Img($soc->getLogo());
        }else{
            $im_log=new Img('upload/logo.jpg');
        }
        
        $img_src=new Input();
        $img_src->setAttribute('type', 'hidden');
        if(isset($soc)){
            $img_src->setAttribute('value', $soc->getLogo());
        }else{
            $img_src->setAttribute('value', '');
        }
        $img_src->setAttribute('id', 'img-src');
        $img_src->setAttribute('name', 'img-src');
        
        $isFraud=new Input();
        $isFraud->setAttribute('type', 'hidden');
        $isFraud->setAttribute('id', 'f-zone');
        $isFraud->setAttribute('name', 'f-zone');
        if(isset($soc)){
            if($soc->getisFraude()){
                $isFraud->setAttribute('value', 'TRUE');
            }else{
                $isFraud->setAttribute('value', 'FALSE');
            }
        }else{
            $isFraud->setAttribute('value', 'TRUE');
        }
        
        $div_f_2->addElements(Array($im_log));
        $b_logo_fraude->addElements(Array($div_f_1,$div_f_2,$img_src,$isFraud));
        
        $hg_soc->addElements(Array($b_new_cordon,$b_logo_fraude,$b_new_adr));
        
        //--- Le bouton permettant la sauvegarde --//
        $b_save_infos=new Input();
        $b_save_infos->setAttribute('type', 'submit');
        $b_save_infos->setAttribute('value', 'Sauegarder');
        if(isset($soc)){
            $b_save_infos->setAttribute('id', 'updt-infos');
            $b_save_infos->setAttribute('name', 'updt-infos');
        }else{
            $b_save_infos->setAttribute('id', 'save-infos');
            $b_save_infos->setAttribute('name', 'save-infos');
        }
        
        //</editor-fold>
        
        if(isset($soc)){
            if(!$soc->getisACTIF()){
                $im=new Img('upload/nan.png');
                $im->setAttribute('class', 'img-desact');
                $this->infosoc->addElement($im);
            }
        }
        $this->infosoc->addElements(Array($date_maj,$hg_soc,$b_save_infos));
        
       // construcrion de fourmulaire//
       
        //<editor-fold defaultstate="collapsed" desc="---contacts---">
        
        //--- Bloc d'infos relatives au deferent contacts de l entreprise ---//

        $this->contact=new Div();
        //$this->contact->setAttribute('method', 'post');
        $this->contact->setAttribute('class', 'div-cont');
        $this->contact->setAttribute('id', 'div-cont');
        
        $hg_cont=new Hgroup();
        
        $l_contact_name=new Label('');
        $l_contact_name->setAttribute('class', 'lab');
        $l_contact_name->addElement(new Text('Nom :'));
        $l_contact_fonc=new Label('');
        $l_contact_fonc->setAttribute('class', 'lab');
         $l_contact_fonc->addElement(new Text('Fonction :'));
        $l_contact_tel=new Label('');
        $l_contact_tel->setAttribute('class', 'lab');
        $l_contact_tel->addElement(new Text('Téléphone :'));
        $l_contact_mail=new Label('');
        $l_contact_mail->setAttribute('class', 'lab');
        $l_contact_mail->addElement(new Text('Mail :'));
        
        $b_new_conta_1=new Hgroup();
        $b_new_conta_1->setAttribute('class', 'b-cont');
        
        //--- Titre --//
        $titre_1=new H2();
        $titre_1->addElement(new Text('Contact-1'));
        $b_new_conta_1->addElement($titre_1);
        
        if(isset($soc)){
            $cont_1= ContactQuery::create()->filterBySociete($soc)->filterByOrdre(1)->findOne();
        }
        $contact_nom_1=new P();
        $nom_in_contact_1=new Input();
        $nom_in_contact_1->setAttribute('type','Text');
        //$nom_in_contact_1->setAttribute('required','');
        $nom_in_contact_1->setAttribute('name', 'cont-name-1');
        $nom_in_contact_1->setAttribute('id','cont n-name-1');
        if(isset($cont_1)){
            $nom_in_contact_1->setAttribute('value',$cont_1->getNom());
        }

        $contact_nom_1->addElements(Array($l_contact_name,$nom_in_contact_1));
        
        $contact_fonc_1=new P();
        $fonc_in_contact_1=new Input();
        $fonc_in_contact_1->setAttribute('type','Text');
        $fonc_in_contact_1->setAttribute('name','cont-fonc-1');
        $fonc_in_contact_1->setAttribute('id','cont-fonc-1');
        if(isset($cont_1)){
            $fonc_in_contact_1->setAttribute('value',$cont_1->getFonction());
        }
        $contact_fonc_1->addElements(Array($l_contact_fonc,$fonc_in_contact_1));
        
        $contact_tel_1=new P();
        $tel_in_contact_1=new Input();
        $tel_in_contact_1->setAttribute('type','tel');
        //$tel_in_contact_1->setAttribute('required','');
        $tel_in_contact_1->setAttribute('name','cont-tel-1');
        $tel_in_contact_1->setAttribute('id','cont-tel-1');
        if(isset($cont_1)){
            $tel_in_contact_1->setAttribute('value',$cont_1->getTelephone());
        }
        $contact_tel_1->addElements(Array($l_contact_tel,$tel_in_contact_1));
        
        
        $contact_email_1=new P();
        $email_in_contact_1=new Input();
        $email_in_contact_1->setAttribute('type','email');
        //$email_in_contact_1->setAttribute('required','');
        $email_in_contact_1->setAttribute('name','cont-mail-1');
        $email_in_contact_1->setAttribute('id','cont-mail-1');
        if(isset($cont_1)){
            $email_in_contact_1->setAttribute('value',$cont_1->getMail());
        }
        $contact_email_1->addElements(Array($l_contact_mail,$email_in_contact_1));
        
        
        $contact_note_1=new Fieldset('Note');
        $contact_note_input_1=new Textarea();
        $contact_note_input_1->setAttribute('name', 'cont-note-1');
        $contact_note_input_1->setAttribute('id', 'cont-note-1');
        if(isset($cont_1)){
            $contact_note_input_1->addElement(new Text($cont_1->getNote()));
        }
        $contact_note_1->addElement($contact_note_input_1);
        
        

        $b_new_conta_1->addElements(Array($contact_nom_1,$contact_fonc_1,$contact_tel_1,$contact_email_1,$contact_note_1));
        
        //---------- Deuxième contact ----//
        $b_new_conta_2=new Hgroup();
        $b_new_conta_2->setAttribute('class', 'cont-2 b-cont');
        
        //--- Titre --//
        $titre_2=new H2();
        $titre_2->addElement(new Text('Contact-2'));
        $b_new_conta_2->addElement($titre_2);
        
        if(isset($soc)){
            $cont_2= ContactQuery::create()->filterBySociete($soc)->filterByOrdre(2)->findOne();
        }
        
        $contact_nom_2=new P();
        $nom_in_contact_2=new Input();
        $nom_in_contact_2->setAttribute('type','Text');
        $nom_in_contact_2->setAttribute('name', 'cont-name-2');
        $nom_in_contact_2->setAttribute('id','cont-name-2');
        if(isset($cont_2)){
            $nom_in_contact_2->setAttribute('value',$cont_2->getNom());
        }
        
        $contact_nom_2->addElements(Array($l_contact_name,$nom_in_contact_2));
        
        $contact_fonc_2=new P();
        $fonc_in_contact_2=new Input();
        $fonc_in_contact_2->setAttribute('type','text');
        $fonc_in_contact_2->setAttribute('name','cont-fonc-2');
        $fonc_in_contact_2->setAttribute('id','cont-fonc-2');
        if(isset($cont_2)){
            $fonc_in_contact_2->setAttribute('value',$cont_2->getFonction());
        }
        $contact_fonc_2->addElements(Array($l_contact_fonc,$fonc_in_contact_2));
        
        $contact_tel_2=new P();
        $tel_in_contact_2=new Input();
        $tel_in_contact_2->setAttribute('type','telephone');
        $tel_in_contact_2->setAttribute('name','cont-tel-2');
        $tel_in_contact_2->setAttribute('id','cont-tel-2');
        if(isset($cont_2)){
            $tel_in_contact_2->setAttribute('value',$cont_2->getTelephone());
        }
        $contact_tel_2->addElements(Array($l_contact_tel,$tel_in_contact_2));
        
        $contact_email_2=new P();
        $email_in_contact_2=new Input();
        $email_in_contact_2->setAttribute('type','email');
        $email_in_contact_2->setAttribute('name','cont-mail-2');
        $email_in_contact_2->setAttribute('id','cont-mail-2');
        if(isset($cont_2)){
            $email_in_contact_2->setAttribute('value',$cont_2->getMail());
        }
        $contact_email_2->addElements(Array($l_contact_mail,$email_in_contact_2));
        
        $contact_note_2=new Fieldset('Note');
        $contact_note_input_2=new Textarea();
        $contact_note_input_2->setAttribute('name', 'cont-note-2');
        $contact_note_input_2->setAttribute('id', 'cont-note-2');
        if(isset($cont_2)){
            $contact_note_input_2->addElement(new Text($cont_2->getNote()));
        }
        $contact_note_2->addElement($contact_note_input_2);

        $b_new_conta_2->addElements(Array($contact_nom_2,$contact_fonc_2,$contact_tel_2,$contact_email_2,$contact_note_2));
        
        //--- Toisième contact --//
        $b_new_conta_3=new Hgroup();
        $b_new_conta_3->setAttribute('class', 'cont-3 b-cont');
        
        //--- Titre --//
        $titre_3=new H2();
        $titre_3->addElement(new Text('Contact-3'));
        $b_new_conta_3->addElement($titre_3);
        
        if(isset($soc)){
            $cont_3= ContactQuery::create()->filterBySociete($soc)->filterByOrdre(3)->findOne();
        }
        
        $contact_nom_3=new P();
        $nom_in_contact_3=new Input();
        $nom_in_contact_3->setAttribute('type','text');
        $nom_in_contact_3->setAttribute('name', 'cont-name-3');
        $nom_in_contact_3->setAttribute('id','cont-name-3');
        if(isset($cont_3)){
            $nom_in_contact_3->setAttribute('value',$cont_3->getNom());
        }
        $contact_nom_3->addElements(Array($l_contact_name,$nom_in_contact_3));
        
        $contact_fonc_3=new P();
        $fonc_in_contact_3=new Input();
        $fonc_in_contact_3->setAttribute('type','Text');
        $fonc_in_contact_3->setAttribute('name','cont-fonc-3');
        $fonc_in_contact_3->setAttribute('id','cont-fonc-3');
        if(isset($cont_3)){
            $fonc_in_contact_3->setAttribute('value',$cont_3->getFonction());
        }
        $contact_fonc_3->addElements(Array($l_contact_fonc,$fonc_in_contact_3));
        
        $contact_tel_3=new P();
        $tel_in_contact_3=new Input();
        $tel_in_contact_3->setAttribute('type','telephone');
        $tel_in_contact_3->setAttribute('name','cont-tel-3');
        $tel_in_contact_3->setAttribute('id','cont-tel-3');
        if(isset($cont_3)){
            $tel_in_contact_3->setAttribute('value',$cont_3->getTelephone());
        }
        $contact_tel_3->addElements(Array($l_contact_tel,$tel_in_contact_3));
        
        $contact_email_3=new P();
        $email_in_contact_3=new Input();
        $email_in_contact_3->setAttribute('type','email');
        $email_in_contact_3->setAttribute('name','cont-mail-3');
        $email_in_contact_3->setAttribute('id','cont-mail-3');
        if(isset($cont_3)){
            $email_in_contact_3->setAttribute('value',$cont_3->getMail());
        }
        $contact_email_3->addElements(Array($l_contact_mail,$email_in_contact_3));
        
        $contact_note_3=new Fieldset('Note');
        $contact_note_input_3=new Textarea();
        $contact_note_input_3->setAttribute('name', 'cont-note-3');
        $contact_note_input_3->setAttribute('id', 'cont-note-3');
        if(isset($cont_3)){
            $contact_note_input_3->addElement(new Text($cont_3->getNote()));
        }
        $contact_note_3->addElement($contact_note_input_3);

        $b_new_conta_3->addElements(Array($contact_nom_3,$contact_fonc_3,$contact_tel_3,$contact_email_3,$contact_note_3));
        
        $hg_cont->addElements(Array($b_new_conta_1,$b_new_conta_2,$b_new_conta_3));
        
        //--- Le bouton permettant la sauvegarde --//
        $b_save_cont=new Input();
        $b_save_cont->setAttribute('type', 'submit');
        $b_save_cont->setAttribute('value', 'Sauegarder');

        $b_save_cont->setAttribute('id', 'save-cont');
        $b_save_cont->setAttribute('name', 'save-cont');
        
        //</editor-fold>
       
        $this->contact->addElements(Array($hg_cont,$b_save_cont));
        
       
        //<editor-fold defaultstate="collapsed" desc="---info activite---">
        
         //---le contenu du 3em contenaire---//
        $this->activite=new Div();
        $this->activite->setAttribute('class', 'b-act');
        $b_new_activete=new Hgroup();
        
        
        //--- Ce div va contenir la liste des activités de la societé --//
        $div_br=new Div();
        $div_br->setAttribute('class', 'div-act');
        
        $activ_act=new Fieldset('Activité');
        $activite=new Ul();
        foreach (MetierQuery::create()->find() as $met) {
            $chkbx=new Input();
            $chkbx->setAttribute('type', 'checkbox');
            //$chkbx->setAttribute('id', $met->getMetier());
            $chkbx->setAttribute('class', 'act-sel');
            $chkbx->setAttribute('value', $met->getMetier());
            if(isset($soc)){
                $soc_met=SocietemetierQuery::create()->filterBySociete($soc)->filterByMetier($met)->findOne();
                if($soc_met){
                    $chkbx->setAttribute('checked', '');
                }
            }
            $p_act=new P();
            $p_act->addElements(Array($chkbx,new Text($met->getMetier())));
            $li=new Li($p_act,'act-set');
            $activite->addLi($li);
        }
        $activ_act->addElement($activite);
        
        $activ_type_piece=new Fieldset('Type de pièce');
        $typePiece=new Ul();
        $typePiece->setAttribute('class', 'flotte-ul');
        foreach (TypepieceQuery::create()->find() as $tp) {
            $chkbx=new Input();
            $chkbx->setAttribute('type', 'checkbox');
            //$chkbx->setAttribute('id', $tp->getType());
            $chkbx->setAttribute('class', 'tp-sel');
            $chkbx->setAttribute('value', $tp->getType());
            if(isset($soc)){
                $soc_tp=SocietetypepieceQuery::create()->filterBySociete($soc)->filterByTypepiece($tp)->findOne();
                if($soc_tp){
                    $chkbx->setAttribute('checked', '');
                }
            }
            $p_tp=new P();
            $p_tp->addElements(Array($chkbx,new Text($tp->getType())));
            $li=new Li($p_tp,'tp-set');
            $typePiece->addLi($li);
        }
        
        //--- Les appareils qui vole ---//
        $activ_flotte=new Fieldset('Flotte');
        $activ_flotte->setAttribute('class', 'f-ul');
        $ul_list_flotte=new Ul();
        $ul_list_flotte->setAttribute('class', 'flotte-ul flotte');
        if(isset($soc)){
            foreach (SocieteappareilQuery::create()->filterBySociete($soc)->orderByIdAppareil_FK()->find() as $rel) {
                $ch_stk=new Input();
                $ch_stk->setAttribute('type', 'checkbox');
                $ch_stk->setAttribute('value', $rel->getAppareil()->getIdAp());
                $ch_stk->setAttribute('class', 'it-flotte');
                $ch_stk->setAttribute('name', $rel->getAppareil()->getNomApp());
                if(isset($soc)){
                    if($rel->getisFlotte()){
                        $ch_stk->setAttribute('checked', '');
                    }
                }
                $li=new Li($ch_stk, '');
                $li->addElement(new Text($rel->getAppareil()->getNomApp()));
                $ul_list_flotte->addLi($li);
            }
        }
        
        $activ_flotte->addElement($ul_list_flotte);
        
        $activ_type_piece->addElements(Array($typePiece,$activ_flotte));
        
        $activ_stock=new Fieldset('Stock disponible');
        $ul_list_app=new Ul();
        $ul_list_app->setAttribute('class', 'stk-ul');
        foreach (AppareilQuery::create()->find() as $app) {
            $ch_stk=new Input();
            $ch_stk->setAttribute('type', 'checkbox');
            $ch_stk->setAttribute('value', $app->getIdAp());
            $ch_stk->setAttribute('class', 'it-stk');
            $ch_stk->setAttribute('name', $app->getNomApp());
            if(isset($soc)){
                $soc_app=SocieteappareilQuery::create()->filterBySociete($soc)->filterByAppareil($app)->findOne();
                if($soc_app){
                    $ch_stk->setAttribute('checked', '');
                }
            }
            $li=new Li($ch_stk, '');
            $li->addElement(new Text($app->getNomApp()));
            $ul_list_app->addLi($li);
        }
        $vers_stck=new Label('');
        $vers_stck->setAttribute('class', 'lab');
        $vers_stck->addElement(new A(new Text('vers stock'),'?rub=stock'));
        
        $activ_stock->addElements(Array($ul_list_app,$vers_stck));
        
        //--- On ajoute les trsois fieldset dans le div principal --//
        $div_br->addElements(Array($activ_act,$activ_type_piece,$activ_stock));
        
        //--- Ce div va contenir les notes sur les activités de la soc --//
        $div_note=new Div();
        $div_note->setAttribute('class', 'div-note');
        $f_note=new Fieldset('Notes');
        $note=new Textarea();
        $note->setAttribute('class', 'note-act');
        if(isset($soc)){
            $note->addElement(new Text($soc->getNotesactivite()));
        }
        $f_note->addElement($note);
        
        $b_fabricant=new Fieldset('Fabricants');
        $b_fabricant->setAttribute('class', 'f-fabr');
        $ul_fabr=new Ul();
        foreach (MarqueQuery::create()->orderByMarque('ASC')->find() as $fab) {
            $ch_stk=new Input();
            $ch_stk->setAttribute('type', 'radio');
            $ch_stk->setAttribute('value', $fab->getID());
            $ch_stk->setAttribute('class', 'it-fbr');
            $ch_stk->setAttribute('name', 'f-fabr');
            if(isset($soc)){
                if($fab->getMarque()===$soc->getFabricant()){
                  $ch_stk->setAttribute('checked', '');
                }
            }
            $li=new Li($ch_stk, '');
            $li->addElement(new Text($fab->getMarque()));
            $ul_fabr->addLi($li);
        }
        $b_fabricant->addElement($ul_fabr);
        
        //--- Le bouton permettant la sauvegarde --//
        $b_save_act=new Input();
        $b_save_act->setAttribute('type', 'submit');
        $b_save_act->setAttribute('id', 'save-note');
        $b_save_act->setAttribute('name', 'save-note');
        $b_save_act->setAttribute('value', '+');
        
        $div_note->addElements(Array($b_fabricant,$f_note,$b_save_act));
        
        //-- Ce div va contenir les certificats pour la soc ---//
        $div_cert=new Div();
        $div_cert->setAttribute('class', 'div-cert');
        $f_certif=new Hgroup();
        
        $div_cert_det=new Div();
        $app_list=new Select();
        $app_list->setAttribute('id', 'list-app');
        $cert_add=new Input();
        $cert_add->setAttribute('type', 'button');
        $cert_add->setAttribute('id', 'cert-add');
        $cert_add->setAttribute('value', '+');
        if(!isset($soc)){
            $cert_add->setAttribute('disabled', '');
        }
        $ul_cert_det=new Ul();
        $ul_cert_det->setAttribute('id', 'ul-cert-det');
        $ul_cert_det->setAttribute('class', 'ul-cert');
        if(isset($soc)){
            foreach (SocietecertificatQuery::create()->filterBySociete($soc)->orderByAgrement_PK()->find() as $soc_cert) {
                        
                $p_cert=new Em();
                
                //---- On verifie si l'appareil lié à cette relation ---
                //--- n'est supprimé dans sa collection de certificat ----
                $is_exist=AppareilcertificatQuery::create()->filterByAppareil($soc_cert->getAppareil())->exists();
                if($is_exist){
                    $ch_cert=new Input();
                    $ch_cert->setAttribute('type', 'checkbox');
                    $ch_cert->setAttribute('value', $soc_cert->getID());
                    $ch_cert->setAttribute('class', 'it-cert');
              
                    if($soc_cert->getisMRO()){
                        $ch_cert->setAttribute('checked', '');
                    }
                    
                    $p_cert->addElements(Array($ch_cert,new Text($soc_cert->getAppareil()->getNomApp())));
                    $li=new Li($p_cert, '');
                    $ul_cert_det->addLi($li);
                
                }else{
                    //--- Si cet appareil a été supprimée, on la supprime ici aussi --
                    $soc_cert->delete();
                }
            }
        }
        
        $div_cert_det->addElements(Array($ul_cert_det));
        
        $div_cert_selec=new Div();
        $ul_cert_sel=new Ul();
        $ul_cert_sel->setAttribute('class', 'ul-cert list-cert');
        foreach (CertificatQuery::create()->find() as $cert) {
            $p_cert=new Em();
            $ch_cert=new Input();
            $ch_cert->setAttribute('type', 'checkbox');
            $ch_cert->setAttribute('value', $cert->getID());
            $ch_cert->setAttribute('class', 'it-agr');
            if(isset($soc)){
                //---- On recupère la relation societe certificat --//
                $rel_cert=SocietecertificatQuery::create()->filterBySociete($soc)->filterByCertificat($cert)->findOne();
                if($rel_cert){
                    $ch_cert->setAttribute('checked', '');
                }
            }
            $p_cert->addElements(Array($ch_cert,new Text($cert->getAgrement())));
            $li=new Li($p_cert, '');
            $ul_cert_sel->addLi($li);
        }
        $p_fold=new P();
        $p_fold->setAttribute('class', 'l-browse');
        $p_fold->setAttribute('id', 'file-browser');
        $im_fold=new Img('upload/folder.png');
        $p_fold->addElements(Array($im_fold,new Text('Dépot Certificat')));
        $div_cert_selec->addElements(Array($ul_cert_sel,$p_fold));
        
        $f_certif->addElements(Array($div_cert_det,$div_cert_selec));
        
        $f_atelier=new Hgroup();
        $div_at_sel=new Div();
        $titre=new H3();
        $titre->addElement(new Text('Centre MRO'));
        $l_atelier=new Label('');
        $l_atelier->setAttribute('class', 'lab');
        $l_atelier->addElement(new Text('(qui entretient leurs appareils)'));
        $ul_mro=new Ul();
        $ul_mro->setAttribute('class', 'ul-mro');
        //--on selection toute société dont le MRO a été coché lors de son insertion --//
        $metier=MetierQuery::create()->filterByMetier('MRO')->findOne();
        foreach (SocietemetierQuery::create()->filterByMetier($metier) as $rel) {
            $ch_mro=new Input();
            $ch_mro->setAttribute('type', 'checkbox');
            $ch_mro->setAttribute('value', $rel->getSociete()->getID());
            $ch_mro->setAttribute('class', 'it-mro');
            $em_mro=new Em();
            $em_mro->addElements(Array($ch_mro,new Text($rel->getSociete()->getSociete())));
            $li=new Li($em_mro, '');
            $ul_mro->addLi($li);
        }
        $mro_add=new Input();
        $mro_add->setAttribute('type', 'button');
        $mro_add->setAttribute('id', 'mro-add');
        $mro_add->setAttribute('value', '+');
        if(!isset($soc)){
            $mro_add->setAttribute('disabled', '');
        }
        $div_at_sel->addElements(Array($titre,$l_atelier,$ul_mro,$mro_add));
        
        $div_at_det=new Div();
        $ul_mro_det=new Ul();
        if(isset($soc)){
            foreach (MROCentreQuery::create()->filterBySociete($soc)->find() as $mro) {
                $ch_mro=new Input();
                $ch_mro->setAttribute('type', 'checkbox');
                $ch_mro->setAttribute('value', $mro->getID());
                $ch_mro->setAttribute('class', 'it-mro-det');
                if($mro->getisACTIF()){
                    //--- On verifie si la société liée est toujours considérée entant que MRO --//
                    //--- On recupère la relation Societe-Metier --//
                    $soc_metier=SocietemetierQuery::create()->filterBySociete($mro->getMROSociete())->filterByMetier_PK('MRO')->findOne();
                    //print_r($mro->getSociete());
                    if($soc_metier){
                        $ch_mro->setAttribute('checked', '');
                    }else{
                        $mro->setisACTIF(FALSE);
                        $mro->save();
                    }
                }
                $em_det_mro=new Em();
                $em_det_mro->addElements(Array($ch_mro,new Text($mro->getMRO())));
                $li=new Li($em_det_mro, '');
                $ul_mro_det->addLi($li);
            }
        }
        
        $div_at_det->addElement($ul_mro_det);
        
        $f_atelier->addElements(Array($div_at_sel,$div_at_det));
        
        $div_cert->addElements(Array($f_certif,$f_atelier));
        
        $b_new_activete->addElements(Array($div_br,$div_note,$div_cert));
        
       //</editor-fold>
        
        //--- Affichage de la date de MAJ ---//
        $dte_maj_act=new Input();
        $dte_maj_act->setAttribute('type', 'date');
        $dte_maj_act->setAttribute('class', 'dte-maj');
        $dte_maj_act->setAttribute('id', 'dte-maj-act');
        if(isset($soc)){
            $dte_maj_act->setAttribute('value', $soc->getDte_MAJACT()->format('Y-m-d'));
        }
        
        $this->activite->addElements(array($dte_maj_act,$b_new_activete));
		
        //---bloc informattion financiere---//
        $this->finance=new Div();
        $this->finance->setAttribute('class', 'b-infos-fin');
        
        /*bloc infofinalité*/
        $b_new_infofina=new Hgroup();
        
       
        //<editor-fold defaultstate="collapsed" desc="---info infofinarise---">
       
        $finance_info=new Fieldset('Informations financières');
        
        if(isset($soc)){
            $finance=FinanciereQuery::create()->filterBySociete($soc)->findOne();
        }
        //----Bloc infos -----//
        $b_infos_fin=new Hgroup();
        /*champs numéro matricule*/
        $infofina_matri=new P();
        $l_imm=new Label('');
        $l_imm->setAttribute('class', 'lab');
        $l_imm->addElement(new Text('N° immatriculation :'));
        $infofina_input_matri=new Input();
        $infofina_input_matri->setAttribute('type', 'text');
        $infofina_input_matri->setAttribute('name', 'numimm');
        $infofina_input_matri->setAttribute('id', 'numimm');
        if(isset($finance)){
            $infofina_input_matri->setAttribute('value', $finance->getImmatricule());
        }
        $infofina_matri->addElements(Array($l_imm,$infofina_input_matri));
        
        $infofina_cap=new P();
        $l_cap=new Label('');
        $l_cap->setAttribute('class', 'lab');
        $l_cap->addElement(new Text('Capital :'));
        $infofina_input_cap=new Input();
        $infofina_input_cap->setAttribute('type', 'text');
        $infofina_input_cap->setAttribute('name', 'f-capital');
        $infofina_input_cap->setAttribute('id', 'f-capital');
        if(isset($finance)){
            $infofina_input_cap->setAttribute('value', $finance->getCapital());
        }
        $infofina_cap->addElements(Array($l_cap,$infofina_input_cap));
        
        $infofina_form=new P();
        $l_form=new Label('');
        $l_form->setAttribute('class', 'lab');
        $l_form->addElement(new Text('Forme :'));
        $infofina_input_form=new Input();
        $infofina_input_form->setAttribute('type', 'text');
        $infofina_input_form->setAttribute('name', 'f-form');
        $infofina_input_form->setAttribute('id', 'f-form');
        if(isset($finance)){
            $infofina_input_form->setAttribute('value', $finance->getForm());
        }
        $infofina_form->addElements(Array($l_form,$infofina_input_form));
        
        $infofina_dte=new P();
        $l_dte=new Label('');
        $l_dte->setAttribute('class', 'lab');
        $l_dte->addElement(new Text('Date de création :'));
        $infofina_input_dte=new Input();
        $infofina_input_dte->setAttribute('type', 'date');
        $infofina_input_dte->setAttribute('name', 'f-dte');
        $infofina_input_dte->setAttribute('id', 'f-dte');
        if(isset($finance) && $finance->getDtecreation()){
            $infofina_input_dte->setAttribute('value', $finance->getDtecreation()->format('Y-m-d'));
        }
        $infofina_dte->addElements(Array($l_dte,$infofina_input_dte));
        
        //--- Numero permettant d'identifier une instance finace --//
        $num_fin=new Input();
        $num_fin->setAttribute('type', 'hidden');
        $num_fin->setAttribute('name', 'num-fin');
        if(isset($finance)){
            $num_fin->setAttribute('value', $finance->getID());
        }
        $b_infos_fin->addElements(Array($num_fin,$infofina_matri,$infofina_cap,$infofina_form,$infofina_dte));
        
        //----- Bloc CA ---//
        $b_ca_fin=new Hgroup();
        $b_ca_fin->setAttribute('class', 'ca-group');
        $tab_fin=new Table();
        $th=new Thead();
        $tr_h=new Tr();
        $th_1=new Th();
        $th_1->addElement(new Text('Année'));
        $th_2=new Th();
        $th_2->addElement(new Text('CA'));
        $th_3=new Th();
        $th_3->addElement(new Text('Employés'));
        $th_4=new Th();
        $th_4->addElement(new Text('Filiale'));
        $tr_h->addElements(Array($th_1,$th_2,$th_3,$th_4));
        $th->addElement($tr_h);
        $tb=new Tbody();
        if(isset($soc)){
            foreach (ChiffredaffaireQuery::create()->filterBySociete($soc)->find() as $ca) {
                $b_tr=new Tr();
                $b_td_an=new Td();
                $b_td_an->addElement(new Text($ca->getAnnee()));
                $b_td_ca=new Td();
                $b_td_ca->addElement(new Text($ca->getChiffre()));
                $b_td_emp=new Td();
                $b_td_emp->addElement(new Text($ca->getNbremployes()));
                $b_td_fil=new Td();
                $em_fil=new Em();
                $inp_fil=new Input();
                $inp_fil->setAttribute('type', 'checkbox');
                if($ca->getisFiliale()){
                    $inp_fil->setAttribute('checked','');
                }
                $em_fil->addElements(Array($inp_fil));
                $b_td_fil->addElement($em_fil);
                $b_tr->addElements(Array($b_td_an,$b_td_ca,$b_td_emp,$b_td_fil));
                $tb->addElement($b_tr);
            }
        }
        
        $tab_fin->addElements(Array($th,$tb));
        
        //--- Bouton permettant l'ajout d'un CA ---//
        $ca_bouton=new Input();
        $ca_bouton->setAttribute('type', 'button');
        $ca_bouton->setAttribute('id', 'add-ca');
        $ca_bouton->setAttribute('value', '+');
        
        $b_ca_fin->addElements(Array($tab_fin,$ca_bouton));
        
        //----- Blo RIB ---//
        $b_rib_fin=new Hgroup();
         $b_rib_fin->setAttribute('class', 'b-rib');
        
        $p_titre=new P();
        $p_titre->addElement(new Text('Lien pour données financières'));
        
        $div_rib_1=new Div();
        $div_rib_1->setAttribute('class', 'lien-web');
        $ul_rib=new Ul();
        if(isset($soc)){
            foreach (WebsourceQuery::create()->filterBySociete($soc)->find() as $web) {
                $a=new A(new Text($web->getDescription()), $web->getLienweb());
                $li=new Li($a, '');
                $ul_rib->addLi($li);
            }
        }
        
        $p_img=new P();
        $p_img->setAttribute('id', 'add-src-web');
        $p_img->setAttribute('class', 'l-browse');
        $im_rib=new Img('upload/folder.png');
        $p_img->addElements(Array($im_rib,new Text('dépot nouveau lien')));
        $div_rib_1->addElements(Array($ul_rib,$p_img));
        
        $div_rib_2=new Div();
        $l_rib=new P();
        $l_rib->setAttribute('class', 'p-rib');
        if(isset($soc)){
           $l_rib->addElement(new A(new Text('Lire RIB'), $soc->getSourceRIB())); 
        }else{
            $l_rib->addElement(new A(new Text('Lire RIB'), '#'));
        }
        
        $open_rib=new P();
        $open_rib->setAttribute('class', 'l-browse');
        $open_rib->setAttribute('id', 'add-rib');
        $im_open_rib=new Img('upload/folder.png');
        $open_rib->addElements(Array($im_open_rib,new Text('dépot RIB')));
        $div_rib_2->addElements(Array($l_rib,$open_rib));
        
        $b_rib_fin->addElements(Array($p_titre,$div_rib_1,$div_rib_2));
        
        //--- Affichage de la date de MAJ ---//
        $dte_maj_fin=new Input();
        $dte_maj_fin->setAttribute('type', 'date');
        $dte_maj_fin->setAttribute('class', 'dte-maj');
        $dte_maj_fin->setAttribute('id', 'dte-maj-fin');
        if(isset($finance)){
            $dte_maj_fin->setAttribute('value', $finance->getDte_MAJ('Y-m-d'));
        }
      
        $finance_note=new Fieldset('Notes');
        $finance_input_note=new Textarea();
        $finance_input_note->setAttribute('name', 'f-note');
        $finance_input_note->setAttribute('id', 'f-note');
        if(isset($finance)){
            $finance_input_note->addElement(new Text($finance->getNotes()));
        }
        $finance_note->addElement($finance_input_note);
        
        $finance_info->addElements(array($b_infos_fin,$b_ca_fin,$b_rib_fin,$finance_note));
        $b_new_infofina->addElements(Array($finance_info));
        
        //--- Le bouton permettant la sauvegarde --//
        $b_save_fin=new Input();
        $b_save_fin->setAttribute('type', 'submit');
        $b_save_fin->setAttribute('id', 'save-fin');
        $b_save_fin->setAttribute('name', 'save-fin');
        $b_save_fin->setAttribute('value', 'Sauegarder');
        
        //</editor-fold>
        
        $this->finance->addElements(array($dte_maj_fin,$b_new_infofina,$b_save_fin));
        
        //--- Bouton action ---
        $b_action=new Div();
        $b_action->setAttribute('class', 'bloc-act');
        
        $act=new Input();
        $act->setAttribute('type', 'submit');
        $act->setAttribute('class', 'act-soc');
        if(isset($soc)){
            if($soc->getisACTIF()){
                $act->setAttribute('name', 'desact');
                $act->setAttribute('value', 'Désactiver');
            }else{
                $act->setAttribute('name', 'act');
                $act->setAttribute('value', 'Activer');
            }
        }
        $del=new Input();
        $del->setAttribute('type', 'submit');
        $del->setAttribute('class', 'act-soc');
        $del->setAttribute('name', 'del');
        $del->setAttribute('value', 'Supprimer');
        
        $b_action->addElements(Array($del,$act));
        
        $this->form->addElements(Array($this->infosoc,$this->contact, $this->activite,  $this->finance,$b_action));
    }
}
