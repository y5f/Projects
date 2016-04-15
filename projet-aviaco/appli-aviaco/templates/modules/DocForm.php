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
class DocForm extends Template{
    
    function __construct($fr,$n_cmd,$url) {
        
        parent::__construct(new Form());
        $this->form->setAttribute('id','page-src');
        $this->form->setAttribute('enctype', 'multipart/form-data');
        $this->form->setAttribute('method','post');
        $hg_src=new Hgroup();
        
        $p_desc=new P();
        $lab_desc=new Label('lab');
        $lab_desc->addElement(new Text('Nom document :'));
        $input_desc=new Input();
        $input_desc->setAttribute('type','text');
        $input_desc->setAttribute('id','desc-doc');
        $input_desc->setAttribute('name','desc-doc');
        $p_desc->addElements(Array($lab_desc,$input_desc));
        
        $p=new P();
        $lab=new Label('lab');
        $lab->addElement(new Text('Chemin vers doc :'));
        $input=new Input();
        $input->setAttribute('type','file');
        $input->setAttribute('id','src-doc');
        $input->setAttribute('name','src-doc');
        
        $url_return=new Input();
        $url_return->setAttribute('type','hidden');
        $url_return->setAttribute('name','url-return');
        $url_return->setAttribute('value', $url);
        
        $but=new Input();
        $but->setAttribute('type','submit');
        $but->setAttribute('class','add-doc');
        $but->setAttribute('name','add-doc');
        $but->setAttribute('value','Ajouter');
        
        $p->addElements(array($lab,$input,$url_return,$but));
        $em=new Em();
        $em->addElement(new A(new Text('X'), ''));
        
        $field_src=new Fieldset('Liste des documents associés');
        //$field_src->setAttribute('id','add-src');
        $ul=new Ul();
        $ul->setAttribute('id','add-src');
        if($fr){
            $query=DocumentQuery::create()->filterByFournisseur($fr)->find();
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
            $l_del->setAttribute('class', 'del-doc');
            $l_del->setAttribute('value', $el->getDocnumber().'^'.$fr->getID());
            $pl->addElements(Array(new A(new Text($el->getNDoc()),$el->getDoc()),$l_del));
            $li=new Li($pl,'');
            $ul->addElement($li);
        }
        $field_src->addElement($ul);
        
        $hg_src->addElements(Array($em,$p_desc,$num_doc,$num_cmd,$p,$field_src));
        
        $this->form->addElement($hg_src);
    }
}
