<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImgForm
 *
 * @author Nicolas
 */
class ImgForm extends Template {
    function __construct($fr,$n_cmd) {
        parent::__construct(new Form());
        $this->form->setAttribute('id','page-src');
        $this->form->setAttribute('enctype', 'multipart/form-data');
        $this->form->setAttribute('method','post');
        $hg_src=new Hgroup();
        
        $p_desc=new P();
        $lab_desc=new Label('lab');
        $lab_desc->addElement(new Text('Nom de l\'image :'));
        $input_desc=new Input();
        $input_desc->setAttribute('type','text');
        $input_desc->setAttribute('id','desc-img');
        $input_desc->setAttribute('name','desc-img');
        $p_desc->addElements(Array($lab_desc,$input_desc));
        
        $p=new P();
        $lab=new Label('lab');
        $lab->addElement(new Text('Chemin vers image :'));
        $input=new Input();
        $input->setAttribute('type','file');
        $input->setAttribute('id','src-img');
        $input->setAttribute('name','src-img');
        $p->addElements(array($lab,$input));
        
        $p_com=new P();
        $lab_com=new Label('lab');
        $lab_com->addElement(new Text('Commentaires :'));
        $input_com=new Textarea();
        //$input_com->setAttribute('type','');
        $input_com->setAttribute('name','comment');
        
        
        $but=new Input();
        $but->setAttribute('type','submit');
        $but->setAttribute('class','add-img');
        $but->setAttribute('name','add-img');
        $but->setAttribute('value','Ajouter');
        $p_com->addElements(Array($lab_com,$input_com,$but));
        
        $em=new Em();
        $em->addElement(new A(new Text('X'), ''));
        
        $field_src=new Fieldset('Liste des documents associés');
        //$field_src->setAttribute('id','add-src');
        $ul=new Ul();
        $ul->setAttribute('id','add-src');
        if($fr){
            $query=PhotopieceQuery::create()->filterByFournisseur($fr)->find();
            $num_doc=new Input();
            $num_doc->setAttribute('type', 'hidden');
            $num_doc->setAttribute('id', 'num-frs');
            $num_doc->setAttribute('name', 'num-frs');
            $num_doc->setAttribute('value', $fr->getID());
            
            $num_cmd=new Input();
            $num_cmd->setAttribute('type', 'hidden');
            $num_cmd->setAttribute('id', 'num-cmd');
            $num_cmd->setAttribute('name', 'num-cmd');
            $num_cmd->setAttribute('value', $n_cmd);
            
        }else{
            $query=DocumentQuery::create()->find();
        }
        
        foreach ($query as $el){
            $pl=new P();
            $l_del=new Label('');
            $l_del->addElement(new Text('X'));
            $l_del->setAttribute('class', 'del-img');
            $l_del->setAttribute('value', $el->getID().'^'.$fr->getID());
            $pl->addElements(Array(new A(new Text($el->getTitre()),$el->getPiecephoto()),$l_del));
            $li=new Li($pl,'');
            $ul->addElement($li);
        }
        $field_src->addElement($ul);
        
        $hg_src->addElements(Array($em,$p_desc,$num_doc,$num_cmd,$p,$p_com,$field_src));
        
        $this->form->addElement($hg_src);
    }
}
