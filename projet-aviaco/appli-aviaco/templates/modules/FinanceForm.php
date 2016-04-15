<?php

class FinanceForm extends Template {

    public function __construct() {
        parent::__construct(new Div());
        $this->form->setAttribute('class','finance-form');
        
        if(isset($_GET['id'])){
            $finance=PartenaireQuery::create()->filterByID($_GET['id'])->findOne();
                if(isset($finance)){
                    $fp=FPartenaireQuery::create()->filterByPartenaire($finance)->findOne();
                if(isset($fp)){
                    $contact=ContactQuery::create()->filterByFPartenaire($fp)->findOne();
                }
            }
        }
        
        //---- Date des derniere modifications ---
        $p_dte=new P();
        $date_modif=new Input();
        $date_modif->setAttribute('type', 'date');
        if(isset($fp)){
            $date_modif->setAttribute('value', $fp->getDateMAJ()->format('Y-m-d'));
        }
        $p_dte->addElement($date_modif);
        
        // titre 
        $h_titre=new H1();
        $h_titre->addElement(new Text('Informations financières'));
        
        // -- hgroup  left -- //
        $hg1=new Hgroup();
        $hg1->setAttribute('class','find-soc');
    
        $input_find=new Input();
        $input_find->setAttribute('type','search');
        $input_find->setAttribute('name','finance');
        $input_find->setAttribute('placeholder','Recherche');
        $input_find->setAttribute('id','search-motor');
        $input_find->setAttribute('oninput','go_search(this.id)');
        
        $field_soc=new Fieldset('Accès rapide');
        $field_soc->setAttribute('class','field-soc');
        
        //--- Ul contenant la liste des sociétés ---
        $list_soc=new Table();
        $tb=new Tbody();
        $list_soc->setAttribute('id', 'ann-list');
        foreach (PartenaireQuery::create()->filterByTypePart('finance')->find() as $fin) {
            $tr_b=new Tr();
            $td=new Td();
            $td->addElement(new A(new Text($fin->getPartenaire()), '?rub=informations&s-rub=informations-financieres&id='.$fin->getID()));
            $tr_b->addElement($td);
            $tb->addElement($tr_b);
        }
        $list_soc->addElement($tb);
        
        $div_scrol=new Div();
        $div_scrol->addElement($list_soc);
        
        $field_soc->addElements(Array($input_find,$div_scrol));
        $hg1->addElements(Array($field_soc));
        
        // hgroup middle 
        $hg2=new Hgroup();
        $hg2->setAttribute('clss','info-soc');
        $field_infos=new Fieldset('Détails');
        $field_infos->setAttribute('class','field-det');
        $p_nom=new P();
        $l_nom=new Label('lab');
        $l_nom->addElement(new Text('Nom'));
        $input_nom=new Input();
        $input_nom->setAttribute('type','text');
        $input_nom->setAttribute('class', 'annonce-form');
        if(isset($finance)){
            $input_nom->setAttribute('value', $finance->getPartenaire());
        }
        $p_nom->addElements(Array($l_nom,$input_nom));
        
        $p_lien=new P();
        $l_lien=new Label('lab');
        $l_lien->addElement(new Text('Lien :'));
        $link='#';
        if(isset($finance)){
            $link=$finance->getLienweb();
        }
        if(!preg_match('#http#', $link)){
            $link='http://'.$link;
        }
        $input_lien=new A(new Text('link'),$link);
        $input_lien->setAttribute('class','lien-soc');
        
        $input_l=new Input();
        $input_l->setAttribute('type', 'text');
        $input_l->setAttribute('class', 'annonce-form');
        if(isset($finance)){
            $input_l->setAttribute('value', $finance->getLienweb());
        }
        
        $p_lien->addElements(Array($l_lien,$input_lien,$input_l));
        $p_abon=new P();
        $l_abon=new Label('lab');
        $l_abon->addElement(new Text('Abonnement'));
        $input_abon=new Input();
        $input_abon->setAttribute('type', 'checkbox');
        $input_abon->setAttribute('class', 'abon-chck');
        if(isset($fp)){
            if($fp->getisAbonnement()){
                $input_abon->setAttribute('checked', '');
            }
        }else{
            $input_abon->setAttribute('disabled', '');
        }
        $p_abon->addElements(Array($input_abon,$l_abon));
        $p_pays=new P();
        $l_pays=new Label('lab');
        $l_pays->addElement(new Text('Pays concerné'));
        $ul_pays=new Ul();
        $ul_pays->setAttribute('class','ul-pays');
        if(isset($fp)){
            foreach (MPaysQuery::create()->orderByPays('ASC')->find() as $py) {
                $input_pays=new Input();
                $input_pays->setAttribute('type', 'checkbox');
                $input_pays->setAttribute('class', 'chkbx-pays');
                $input_pays->setAttribute('value', $py->getID().'^'.$fp->getIDPart());
                
                //--- On verifie si ce pays existe dans la relation part-finance/pays--
                $fpp=IConcernePaysQuery::create()->filterByFPartenaire($fp)->filterByIDPays($py->getID())->findOne();
                if($fpp){
                    $input_pays->setAttribute('checked','');
                }
                $p_p=new P();
                $em=new Em();
                $em->addElement(new Text($py->getPays()));
                $p_p->addElements(Array($input_pays,$em));
                $li=new Li($p_p, '');
                $ul_pays->addLi($li);
            }
        }
        
        $p_pays->addElements(Array($l_pays));
        
        //-- un peti bouton permettant l'ajout d'un pays ---
        $p_add_pays=new P();
        $in_pays=new Input();
        $in_pays->setAttribute('type', 'submit');
        $in_pays->setAttribute('class', 'new-pays');
        $in_pays->setAttribute('value', '+');
        $p_add_pays->addElement($in_pays);
        
        $field_infos->addElements(Array($p_nom,$p_lien,$p_abon,$p_pays,$ul_pays,$p_add_pays));
        
        $field_type_inf=new Fieldset('Types d\'informations');
        $field_type_inf->setAttribute('class', 'finance-type');
        foreach (BaseInfosQuery::create()->filterByUsage('finance')->find() as $bf) {
            $chbx=new Input();
            $chbx->setAttribute('type', 'checkbox');
            $chbx->setAttribute('class', 'ch-type-infos');
            $chbx->setAttribute('value', $bf->getID());

            if(isset($finance)){
                //--- On cherche la relation base-infos et partenaire ---
                $part_base= BPartenaireQuery::create()->filterByBaseInfos($bf)->filterByPartenaire($finance)->findOne();
                if($part_base){
                    if($part_base->getisDisponible()){
                        $chbx->setAttribute('checked', '');
                    }
                }
            }

            $p_infos=new P();
            $em=new Em();
            $em->addElement(new Text($bf->getTypeInfos()));
            $p_infos->addElements(Array($chbx,$em));
            $field_type_inf->addElement($p_infos);
        }
        $field_type_inf->addElements(Array());
        
        $hg2->addElements(Array($field_infos,$field_type_inf));
        
        // Hgroup right
        $hg3=new Hgroup();
        $hg3->setAttribute('class','');
        
        $p_id=new P();
        $l_id=new Label('lab');
        $l_id->addElement(New Text('ID'));
        $input_id=new Input();
        $input_id->setAttribute('type','text');
        $input_id->setAttribute('class', 'annonce-form');
        if(isset($finance)){
            $input_id->setAttribute('value', $finance->getIDPartenaire());
        }
        $p_id->addElements(Array($l_id,$input_id));
        
        $p_code=new P();
        $l_code=new Label('lab');
        $l_code->addElement(new Text('Code'));
        $input_code=new Input();
        $input_code->setAttribute('type','text');
        $input_code->setAttribute('class', 'annonce-form');
        if(isset($finance)){
            $input_code->setAttribute('value', $finance->getCode());
        }
        $p_code->addElements(Array($l_code,$input_code));
        
        $p_mail=new P();
        $l_mail=new Label('lab');
        $l_mail->addElement(new Text('Mail'));
        $input_mail=new Input();
        $input_mail->setAttribute('type','text');
        $input_mail->setAttribute('class', 'annonce-form');
        if(isset($finance)){
            $input_mail->setAttribute('value', $finance->getmail());
        }
        $p_mail->addElements(Array($l_mail,$input_mail));
        
        $field_cont=new Fieldset('Contact');
        
        $p_nom_c=new P();
        $l_nom_c=new Label('lab');
        $l_nom_c->addElement(new Text('Nom'));
        $input_nom_c=new Input();
        $input_nom_c->setAttribute('type','text');
        $input_nom_c->setAttribute('class', 'contact-form');
        if(isset($contact)){
            $input_nom_c->setAttribute('value', $contact->getNom());
        }
        $p_nom_c->addElements(Array($l_nom_c,$input_nom_c));
        
        $p_fun=new P();
        $l_fun=new Label('lab');
        $l_fun->addElement(new Text('Fonction'));
        $input_fun=new Input();
        $input_fun->setAttribute('type','text');
        $input_fun->setAttribute('class', 'contact-form');
        if(isset($contact)){
            $input_fun->setAttribute('value', $contact->getFonction());
        }
        $p_fun->addElements(Array($l_fun,$input_fun));
        
        $p_tel=new P();
        $l_tel=new Label('lab');
        $l_tel->addElement(new Text('Tel'));
        $input_tel=new Input();
        $input_tel->setAttribute('type','text');
        $input_tel->setAttribute('class', 'contact-form');
        if(isset($contact)){
            $input_tel->setAttribute('value', $contact->getTelephone());
        }
        $p_tel->addElements(Array($l_tel,$input_tel));
        
        $p_mail_c=new P();
        $l_mail_c=new Label('lab');
        $l_mail_c->addElement(new Text('Mail'));
        $input_mail_c=new Input();
        $input_mail_c->setAttribute('type','text');
        $input_mail_c->setAttribute('class', 'contact-form');
        if(isset($contact)){
            $input_mail_c->setAttribute('value', $contact->getMail());
        }
        $p_mail_c->addElements(Array($l_mail_c,$input_mail_c));
        
        $input_note_c=new Textarea();
        //$input_note_c->addElement(new Text('Note'));
        $input_note_c->setAttribute('class', 'contact-form');
        if(isset($contact)){
            $input_note_c->addElement(new Text($contact->getNote()));
        }
        
        $field_cont->addElements(Array($p_nom_c,$p_fun,$p_tel,$p_mail_c,$input_note_c));
        $div_cont=new Div();
        $div_cont->setAttribute('class', 'field-cont');
        $div_cont->addElement($field_cont);
        
        $input_note=new Textarea();
        //$input_note->addElement(new Text('Note'));
        $input_note->setAttribute('class', 'contact-form');
        if(isset($fp)){
            $input_note->addElement(new Text($fp->getNotes()));
        }
        
        $hg3->addElements(Array($p_id,$p_code,$p_mail,$div_cont,$input_note));
        
        
        $input_re2=new Input();
        $input_re2->setAttribute('type','button');
        $input_re2->setAttribute('class', 'retour');
        $input_re2->setAttribute('value', 'retour');
        
        $p_add=new P();
        $b_add=new Input();
        $b_add->setAttribute('type', 'button');
        $b_add->setAttribute('name', 'finance');
        if(isset($finance)){
            $b_del=new Input();
            $b_del->setAttribute('type', 'button');
            $b_del->setAttribute('value', 'Supprimer');
            $b_del->setAttribute('id', 'del-annonce');
            $b_add->setAttribute('value', 'Valider');
        }else{
            $b_add->setAttribute('value', 'Ajouter');
        }
        $b_add->setAttribute('id', 'add-annonce');
        if(isset($finance)){
            $p_add->addElements(Array($input_re2,$b_add,$b_del));
        }else{
            $p_add->addElements(Array($input_re2,$b_add));
        }
        
        //--- Un numero annonceur permettant de savoir l'annonceur en cours --
        $num_ann=new Input();
        $num_ann->setAttribute('type', 'hidden');
        $num_ann->setAttribute('id', 'num-ann');
        if(isset($finance)){
            $num_ann->setAttribute('value', $finance->getID());
        }
        
        $this->form->addElements(Array($num_ann,$p_dte,$h_titre,$hg1,$hg2,$hg3,$p_add));
    }

}





