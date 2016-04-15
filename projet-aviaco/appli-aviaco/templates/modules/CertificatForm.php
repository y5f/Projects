<?php

class CertificatForm extends Template{
    function __construct() {
        parent::__construct(new Div());
        $this->form->setAttribute('id','new-certificat');
    
        // formulaire de saisie 
        $form=new Form();
        $form->setAttribute('name', 'certificat');
        //$form->setAttribute('action','#');
        $form->setAttribute('method','post');
        $form->setAttribute('class', 'certificat');
    
        $hg_saisie=new Hgroup();
        $p_agr=new P();
        $l_agr=new Label('lab');
        $l_agr->addElement(new Text('Agrément:'));
        $in_agr=new Input();
        $in_agr->setAttribute('name','agrement');
        $in_agr->setAttribute('type', 'text');
        $in_agr->setAttribute('id', 'agrement');
        $in_agr->setAttribute('required','');
        $p_agr->addElements(Array($l_agr,$in_agr));
    
        $p_src=new P();
        $l_src=new Label('lab');
        $l_src->addElement(new Text('Source Web:'));
        $in_src=new Input();
        $in_src->setAttribute('name','src');
        $in_src->setAttribute('type', 'text');
        $in_src->setAttribute('id', 'src-cert');
        $in_src->setAttribute('required', '');
        $p_src->addElements(Array($l_src,$in_src));
    
        $in_but=new Input();
        $in_but->setAttribute('name','add-cert');
        $in_but->setAttribute('type','submit');
        $in_but->setAttribute('class','add-cert');
        
        // liste des certificats
        $ul=new Ul();
        $ul->setAttribute('id', 'list-cert');
        
        $ctfs=CertificatQuery::create()->find();
        foreach ($ctfs as  $ctf){
            $li=new Li(new Text($ctf->getAgrement()),'item-cert');
            $li->setAttribute('value',$ctf->getID());
            $ul->addElement($li);
        }
    
        $field_ul=new Fieldset('Liste des certificats');
        
        $supp=new Input();
        $supp->setAttribute('value','supprimer');
        $supp->setAttribute('type','button');
        $supp->setAttribute('class','supcert');
        $field_ul->addElements(Array($ul,$supp));
    
        $in_id=new Input();
        $in_id->setAttribute('type', 'hidden');
        $in_id->setAttribute('id', 'id-cert');
        
        $hg_saisie->addElements(Array($p_agr,$p_src,$in_id,$in_but,$field_ul));  
    
        // liste des appareils
        $hg1=new Hgroup();
        $hg1->setAttribute('class','list-ap');
        $field1=new Fieldset('Liste des Appareils');
        $div_field=new Div();
        $div_field->setAttribute('class','div-list-ap');
        $apps=AppareilQuery::create()->find();
        $i=0;
        foreach($apps as $app){
       
            $input=new Input();
            $input->setAttribute('type','checkbox');
            //$input->setAttribute('name','ids['.$i.']');
            $input->setAttribute('class','ids');
            $input->setAttribute('value',$app->getIdAp());
            $em=new Em();
            $em->addElements(Array($input,new Text($app->getNomApp())));
            $div_field->addElement($em);
            $i++;
        }
        $field1->addElement($div_field);
        $hg1->addElements(Array(new A(new Text('X'), ''),$field1));
    
        $hr=new Hr();
        $form->addElements(Array($hg_saisie,$hr,$hg1));
        $this->form->addElements(Array($form));     
    }
}

