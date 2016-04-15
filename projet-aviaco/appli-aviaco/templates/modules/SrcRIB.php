<?php


class SrcRIB extends Template {

    function __construct($id_soc) {
        parent::__construct(new Form());
        $this->form->setAttribute('enctype', 'multipart/form-data');
        $this->form->setAttribute('method', 'post');
        $this->form->setAttribute('action', 'scripts/script.php');
        $this->form->setAttribute('id','page-src');
        $hg_src=new Hgroup();
        
        if($id_soc!==null){
            $soc=SocieteQuery::create()->filterByID($id_soc)->findOne();
        }
        $p=new P();
        $lab=new Label('lab');
        $lab->addElement(new Text('Source RIB :'));
        $input=new Input();
        $input->setAttribute('type','hidden');
        $input->setAttribute('name','src-rib');
        if(isset($soc)){
            $input->setAttribute('value', $soc->getID());
        }
        
        $but=new Input();
        $but->setAttribute('type','submit');
        $but->setAttribute('class','but-rib');
        $but->setAttribute('name','but-rib');
        $but->setAttribute('value','Ajouter');
        
        //--- Bouton pour parcourir le disk --//
        $browser=new Input();
        $browser->setAttribute('type', 'file');
        $browser->setAttribute('name', 'load-rib');
        $browser->setAttribute('value', '');
        
        $p->addElements(array($lab,$input,$browser,$but));
        $em=new Em();
        $em->addElement(new A(new Text('X'), ''));
        $hg_src->addElements(Array($em,$p));
        $this->form->addElement($hg_src);
    }
}
