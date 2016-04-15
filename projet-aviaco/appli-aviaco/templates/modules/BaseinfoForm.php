<?php


class BaseinfoForm extends Template{
    
    public function __construct() {

        parent::__construct(new Div());
        $this->form->setAttribute('class','annonceurs-form');
        
        if(isset($_GET['id'])){
            $base_infos=PartenaireQuery::create()->filterByID($_GET['id'])->findOne();
        }
        
        // titre 
        $h_titre=new H1();
        $h_titre->addElement(new Text('Base d\'informations sur les hélicopteres'));
        
        //  hgroup rechercher une  société
        $hg1=new Hgroup();
        $hg1->setAttribute('class','find-soc');
        $input_find=new Input();
        $input_find->setAttribute('type','search');
        $input_find->setAttribute('name','base');
        $input_find->setAttribute('placeholder','Recherche');
        $input_find->setAttribute('id','search-motor');
        $input_find->setAttribute('oninput','go_search(this.id)');
        
        //--- Le Ul qui va contenir la liste des sociétés annonceurs ---
        $tb_annonce=new Table();
        $tb=new Tbody();
        $tb_annonce->setAttribute('id', 'ann-list');
        foreach (PartenaireQuery::create()->filterByTypePart('base')->find() as $ann) {
            $tr_b=new Tr();
            $td=new Td();
            $td->addElement(new A(new Text($ann->getPartenaire()), '?rub=informations&s-rub=base-de-donnees-helicoptere&id='.$ann->getID()));
            $tr_b->addElement($td);
            $tb->addElement($tr_b);
        }
        $tb_annonce->addElement($tb);
        
        $field_soc=new Fieldset('Accès rapide');
        $field_soc->setAttribute('class','field-soc');
        
        $div_scrol=new Div();
        $div_scrol->addElement($tb_annonce);
        $field_soc->addElements(Array($input_find,$div_scrol));
     
        // hgroup infos société
        $field_det=new Fieldset('Détails');
        $field_det->setAttribute('class','infos-soc');
        $p_nom=new P();
        $l_nom=new Label('lab');
        $l_nom->addElement(new Text('Nom :'));
        $input_nom=new Input();
        $input_nom->setAttribute('type','text');
        $input_nom->setAttribute('class', 'annonce-form');
        if(isset($base_infos)){
            $input_nom->setAttribute('value', $base_infos->getPartenaire());
        }
        $p_nom->addElements(Array($l_nom,$input_nom));
        
        $p_lien=new P();
        $l_lien=new Label('lab');
        $l_lien->addElement(new Text('Lien :'));
        $link='#';
        if(isset($base_infos)){
            $link=$base_infos->getLienweb();
        }
        if(!preg_match('#http#', $link)){
            $link='http://'.$link;
        }
        $input_lien=new A(new Text('link'),$link);
        $input_lien->setAttribute('class','lien-soc');
        
        $input_l=new Input();
        $input_l->setAttribute('type', 'text');
        $input_l->setAttribute('class', 'annonce-form');
        if(isset($base_infos)){
            $input_l->setAttribute('value', $base_infos->getLienweb());
        }
        $p_lien->addElements(Array($l_lien,$input_lien,$input_l));
        
        $p_id=new P();
        $l_id=new Label('lab');
        $l_id->addElement(new Text('ID :'));
        $input_id=new Input();
        $input_id->setAttribute('type', 'text');
        $input_id->setAttribute('class', 'annonce-form');
        if(isset($base_infos)){
            $input_id->setAttribute('value', $base_infos->getIDPartenaire());
        }
        $p_id->addElements(Array($l_id,$input_id));
        
        $p_code=new P();
        $l_code=new Label('lab');
        $l_code->addElement(new Text('Code :'));
        $input_code=new Input();
        $input_code->setAttribute('class', 'annonce-form');
        $input_code->setAttribute('type', 'text');
        if(isset($base_infos)){
            $input_code->setAttribute('value', $base_infos->getCode());
        }
        $p_code->addElements(Array($l_code,$input_code));
        
        $p_mail=new P();
        $l_mail=new Label('lab');
        $l_mail->addElement(new Text('Mail :'));
        $input_mail=new Input();
        $input_mail->setAttribute('class', 'annonce-form');
        $input_mail->setAttribute('type', 'mail');
        if(isset($base_infos)){
            $input_mail->setAttribute('value', $base_infos->getmail());
        }
        $p_mail->addElements(Array($l_mail,$input_mail));
        
        $p_add=new P();
        $b_add=new Input();
        $b_add->setAttribute('type', 'submit');
        $b_add->setAttribute('name', 'base');
        if(isset($base_infos)){
            $b_del=new Input();
            $b_del->setAttribute('type', 'submit');
            $b_del->setAttribute('value', 'Supprimer');
            $b_del->setAttribute('id', 'del-annonce');
            $b_add->setAttribute('value', 'Valider');
        }else{
            $b_add->setAttribute('value', 'Ajouter');
        }
        $b_add->setAttribute('id', 'add-annonce');
        if(isset($base_infos)){
            $p_add->addElements(Array($b_add,$b_del));
        }else{
            $p_add->addElement($b_add);
        }
        
        //--- Un numero annonceur permettant de savoir l'annonceur en cours --
        $num_ann=new Input();
        $num_ann->setAttribute('type', 'hidden');
        $num_ann->setAttribute('id', 'num-ann');
        if(isset($base_infos)){
            $num_ann->setAttribute('value', $base_infos->getID());
        }
        
        $field_det->addElements(Array($num_ann,$p_nom,$p_lien,$p_id,$p_code,$p_mail,$p_add));
        
        //---type infos ---
        $type_info=new Fieldset('Type d\'informations');
        foreach (BaseInfosQuery::create()->filterByUsage('base')->find() as $bf) {
            $chbx=new Input();
            $chbx->setAttribute('type', 'checkbox');
            $chbx->setAttribute('class', 'ch-type-infos');
            $chbx->setAttribute('value', $bf->getID());
            
            if(isset($base_infos)){
                //--- On cherche la relation base-infos et partenaire ---
                $part_base= BPartenaireQuery::create()->filterByBaseInfos($bf)->filterByPartenaire($base_infos)->findOne();
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
            $type_info->addElement($p_infos);
        }
        $hg1->addElements(Array($field_soc,$field_det,$type_info));
        $this->form->addElements(Array($h_titre,$hg1));
    }
}





