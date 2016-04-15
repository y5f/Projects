<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DocForm
 *
 * @author Nicolas
 */
class MoreForm extends Template{
    
    function __construct(Fournisseur $frs) {
        
        parent::__construct(new Div());
        $this->form->setAttribute('id','page-src');
        //$this->form->setAttribute('enctype', 'multipart/form-data');
        //$this->form->setAttribute('method','post');
        
        $titre=new H2();
        $titre->addElement(new Text('Données suplémentaires'));
        
        $hg_src=new Hgroup();
        $hg_src->setAttribute('class', 'hg-plus');
        
        $p_ann_fab=new P();
        $lab_ann_fab=new Label('lab');
        $lab_ann_fab->addElement(new Text('Année de fabrication :'));
        $input_ann_fab=new Input();
        $input_ann_fab->setAttribute('type','text');
        if($frs){
            $input_ann_fab->setAttribute('value', $frs->getFABAnnee());
        }
        $input_ann_fab->setAttribute('class','src-doc');
        $p_ann_fab->addElements(Array($lab_ann_fab,$input_ann_fab));
        
        $p_tmp=new P();
        $lab_tmp=new Label('lab');
        $lab_tmp->addElement(new Text('Temps restant :'));
        $input_tmp=new Input();
        $input_tmp->setAttribute('type','type');
        if($frs){
            $input_tmp->setAttribute('value', $frs->getTRestant());
        }
        $input_tmp->setAttribute('class','src-doc');
        $p_tmp->addElements(Array($lab_tmp,$input_tmp));
        
        $p_tmp_to=new P();
        $lab_tmp_to=new Label('lab');
        $lab_tmp_to->addElement(new Text('Temps total :'));
        $input_tmp_to=new Input();
        $input_tmp_to->setAttribute('type','type');
        if($frs){
            $input_tmp_to->setAttribute('value', $frs->getTTotal());
        }
        $input_tmp_to->setAttribute('class','src-doc');
        $p_tmp_to->addElements(Array($lab_tmp_to,$input_tmp_to));
        
        $p_d_vie=new P();
        $lab_d_vie=new Label('lab');
        $lab_d_vie->addElement(new Text('Durée de vie :'));
        $input_d_vie=new Input();
        $input_d_vie->setAttribute('type','type');
        if($frs){
            $input_d_vie->setAttribute('value', $frs->getDVie());
        }
        $input_d_vie->setAttribute('class','src-doc');
        $p_d_vie->addElements(Array($lab_d_vie,$input_d_vie));
        
        $p_an_app=new P();
        $lab_an_app=new Label('lab');
        $lab_an_app->addElement(new Text('Ancien appareil :'));
        $input_an_app=new Input();
        $input_an_app->setAttribute('type','type');
        if($frs){
            $input_an_app->setAttribute('value', $frs->getOLDApp());
        }
        $input_an_app->setAttribute('class','src-doc');
        $p_an_app->addElements(Array($lab_an_app,$input_an_app));
        
        $p_nw_app=new P();
        $lab_nw_app=new Label('lab');
        $lab_nw_app->addElement(new Text('Nouvel appareil :'));
        $input_nw_app=new Input();
        $input_nw_app->setAttribute('type','type');
        if($frs){
            $input_nw_app->setAttribute('value', $frs->getNApp());
        }
        $input_nw_app->setAttribute('class','src-doc');
        $p_nw_app->addElements(Array($lab_nw_app,$input_nw_app));
        
        $p_oh=new P();
        $lab_oh=new Label('lab');
        $lab_oh->addElement(new Text('Nombre d\'OH :'));
        $input_oh=new Input();
        $input_oh->setAttribute('type','type');
        if($frs){
            $input_oh->setAttribute('value', $frs->getNBROh());
        }
        $input_oh->setAttribute('class','src-doc');
        $p_oh->addElements(Array($lab_oh,$input_oh));
        
        $id_frs=new Input();
        $id_frs->setAttribute('type', 'hidden');
        $id_frs->setAttribute('value', $frs->getID());
        $id_frs->setAttribute('class', 'id-frs');
        $p_but=new P();
        $but=new Input();
        $but->setAttribute('type','submit');
        $but->setAttribute('class','add-more');
        $but->setAttribute('name','add-more');
        $but->setAttribute('value','Valider');
        $p_but->addElement($but);
        
        $f_left=new Fieldset('');
        $f_left->setAttribute('class', 'f-plus');
        $f_left->addElements(Array($p_ann_fab,$p_tmp,$p_tmp_to,$p_d_vie));
        
        $f_right=new Fieldset('');
        $f_right->setAttribute('class', 'f-plus');
        $f_right->addElements(Array($p_an_app,$p_nw_app,$p_oh,$id_frs));
        $em=new Em();
        $em->addElement(new A(new Text('X'), ''));
        
        $hg_src->addElements(Array($em,$f_left,$f_right,$p_but));
        
        $this->form->addElement($hg_src);
    }
}
