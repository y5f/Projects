<?php

 class Certification {
private $div;
function __construct() {
    $this->div=new Div();
    $this->div->setAttribute('id','content');
    
    // formulaire de saisie 
    $form=new Hgroup();
    $form->setAttribute('name', 'certificat');
    //$form->setAttribute('action','#');
    //$form->setAttribute('method','post');
    $form->setAttribute('class', 'certificat');
    
    $p_agr=new P();
    $l_agr=new Label('lab');
    $l_agr->addElement(new Text('Agrément:'));
    $in_agr=new Input();
    $in_agr->setAttribute('name','agrement');
    $in_agr->setAttribute('type', 'text');
    $in_agr->setAttribute('required','');
    $p_agr->addElements(Array($l_agr,$in_agr));
    
    $p_src=new P();
    $l_src=new Label('lab');
    $l_src->addElement(new Text('Source Web:'));
    $in_src=new Input();
    $in_src->setAttribute('name','src');
    $in_src->setAttribute('type', 'text');
    $in_src->setAttribute('required', '');
    $p_src->addElements(Array($l_src,$in_src));
    
    $in_but=new Input();
    $in_but->setAttribute('name','add-cert');
    $in_but->setAttribute('type','submit');
    $in_but->setAttribute('class','add-cert');
    $form->addElements(Array($p_agr,$p_src,$in_but));  
    
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
      $input->setAttribute('name','ids['.$i.']');
      $input->setAttribute('class','ids');
      $input->setAttribute('value',$app->getIdAppareil());
      $em=new Em();
      $em->addElements(Array($input,new Text($app->getIdAppareil())));
      $div_field->addElement($em);
      $i++;
    }
    $field1->addElement($div_field);
    $hg1->addElement($field1);

    $h1=new H1();
    $h1->addElement(new Text('Ajouter un agrément'));
    echo $h1->toHTML();
    
    $hr=new Hr();
    $this->div->addElements(Array($form,$hr,$hg1)); 
}
function getFormCert(){
    echo $this->div->toHTML();
}
}

