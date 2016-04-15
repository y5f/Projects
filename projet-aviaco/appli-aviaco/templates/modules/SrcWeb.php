<?php


class SrcWeb extends Template{
    
    function __construct($soc) {
        
        parent::__construct(new Div());
        $this->form->setAttribute('id','page-src');
        $hg_src=new Hgroup();
        
        $p_desc=new P();
        $lab_desc=new Label('lab');
        $lab_desc->addElement(new Text('Description :'));
        $input_desc=new Input();
        $input_desc->setAttribute('type','text');
        $input_desc->setAttribute('id','desc-web');
        $p_desc->addElements(Array($lab_desc,$input_desc));
        
        $p=new P();
        $lab=new Label('lab');
        $lab->addElement(new Text('Source Web :'));
        $input=new Input();
        $input->setAttribute('type','text');
        $input->setAttribute('id','src-web');
        
        $but=new Input();
        $but->setAttribute('type','submit');
        $but->setAttribute('class','but-src');
        $but->setAttribute('value','Ajouter');
        
        $p->addElements(array($lab,$input,$but));
        $em=new Em();
        $em->addElement(new A(new Text('X'), ''));
        
        $field_src=new Fieldset('Liste des sources web');
        //$field_src->setAttribute('id','add-src');
        $ul=new Ul();
        $ul->setAttribute('id','add-src');
        if($soc){
            $query=WebsourceQuery::create()->filterBySociete($soc)->find();
        }else{
            $query=WebsourceQuery::create()->find();
        }
        
        foreach ($query as $el){
            $pl=new P();
            $l_del=new Label('');
            $l_del->addElement(new Text('X'));
            $l_del->setAttribute('class', 'del-web');
            $l_del->setAttribute('value', $el->getID());
            $pl->addElements(Array(new A(new Text($el->getDescription()),$el->getLienweb()),$l_del));
            $li=new Li($pl,'');
            $ul->addElement($li);
        }
        $field_src->addElement($ul);
        
        $hg_src->addElements(Array($em,$p_desc,$p,$field_src));
        
        $this->form->addElement($hg_src);
    }
}
