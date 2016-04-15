<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MarqueForm
 *
 * @author Nicolas
 */
class MarqueForm extends Template {
    function __construct() {
        parent::__construct(new Div());
        $this->form->setAttribute('id','marque-form');
        
        // ajouter une marque
        $div_add=new Hgroup();
        $div_add->setAttribute('method','post');
        $div_add->setAttribute('id','app-box');
        $p_add=new P();
        $l_add=new Label('lab');
        $l_add->addElement(new Text('Ajouter un fabricant :'));
        $in_add=new Input();
        $in_add->setAttribute('required','');
        $in_add->setAttribute('type','text');
        $in_add->setAttribute('class','input-app');
        $in_add->setAttribute('name','input-app');
        $p_add->addElements(array($l_add,$in_add));
        $but_add=new Input();
        $but_add->setAttribute('value','Ajouter');
        $but_add->setAttribute('type','submit');
        $but_add->setAttribute('class','mark-add');
        $div_add->addElements(array($p_add,$but_add));
        
        // supprimer une marque
        $f_fabricant=new Fieldset('Liste des fabricants');
        
        $sel_mark_s=new Ul();
        $sel_mark_s->setAttribute('class','sel-mark-s');
        //$sel_mark_s->addElement($opt_mark);
        
        $list_mark_s=MarqueQuery::create()->find();
        foreach ($list_mark_s as $el){
            $em=new Em();
            $em->setAttribute('value', $el->getID());
            $em->setAttribute('class', 'del-fab');
            $em->addElement(new Text('X'));
            $chbx=new Input();
            $chbx->setAttribute('type', 'checkbox');
            $chbx->setAttribute('value', $el->getID());
            $chbx->setAttribute('class', 'chbx-mark');
            $opt=new Li(new Text($chbx->toHTML().$el->getMarque().$em->toHTML()),'');
            $sel_mark_s->addLi($opt);
        }
        $div_fab=new Div();
        $div_fab->addElement($sel_mark_s);
        $f_fabricant->addElements(array($div_fab));
        $div_add->addElement($f_fabricant);
        
        // ajouter un modele
        $mod_add=new Hgroup();
        $mod_add->setAttribute('method','post');
        $mod_add->setAttribute('id','app-box-m');
        $p_add_m=new P();
        $l_add_m=new Label('lab');
        $l_add_m->addElement(new Text('Ajouter un modèle'));
        $in_add_m=new Input();
        $in_add_m->setAttribute('required','');
        $in_add_m->setAttribute('type','text');
        $in_add_m->setAttribute('class','input-app-m');
        $in_add_m->setAttribute('name','input-app-m');
        $p_add_m->addElements(array($l_add_m,$in_add_m));
        $but_add_m=new Input();
        $but_add_m->setAttribute('value','Ajouter');
        $but_add_m->setAttribute('type','submit');
        $but_add_m->setAttribute('class','mark-add-m');
        
        // supprimer un modele
        $f_fabricant_m=new Fieldset('Liste des modèles');
        
        $sel_mark_s_m=new Ul();
        $sel_mark_s_m->setAttribute('id','list-model');
        $div_model=new Div();
        $div_model->addElement($sel_mark_s_m);
        $f_fabricant_m->addElements(array($div_model));
        
        $close=new Em();
        $close->addElement(new A(new Text('X'),''));
        $close->setAttribute('class', 'close-win-app');
        
        $mod_add->addElements(array($close,$p_add_m,$but_add_m,$f_fabricant_m));
        
        $this->form->addElements(Array($div_add,$mod_add));
    }
}
