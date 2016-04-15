<?php

class ChiffreAffaire extends Template{

   function __construct() {
       
       parent::__construct(new Div());
       $this->form->setAttribute('id','add-chiffre');
    
    // formulaire de saisie 
    $form=new Hgroup();
    //$form->setAttribute('name', 'certificat');
    //$form->setAttribute('action','script.php');
    //$form->setAttribute('method','post');
    $form->setAttribute('class', 'chiff-aff');
    
    $p_year=new P();
    $l_year=new Label('lab');
    $l_year->addElement(new Text('Année:'));
    $in_year=new Input();
    $in_year->setAttribute('name','a0');
    $in_year->setAttribute('type', 'number');
    $in_year->setAttribute('id', 'a0');
    $in_year->setAttribute('required','');
    $p_year->addElements(Array($l_year,$in_year));
    
    $p_ch=new P();
    $l_ch=new Label('lab');
    $l_ch->addElement(new Text('Chiffre d\'affaire:'));
    $in_ch=new Input();
    $in_ch->setAttribute('name','c0');
    $in_ch->setAttribute('type','number');
    $in_ch->setAttribute('id', 'c0');
    $in_ch->setAttribute('required','');
    $p_ch->addElements(Array($l_ch,$in_ch));
    
    $p_nb_p=new P();
    $l_nb_p=new Label('lab');
    $l_nb_p->addElement(new Text('Nombre d\'employés:'));
    $in_nb_p=new Input();
    $in_nb_p->setAttribute('name','n0');
    $in_nb_p->setAttribute('type','number');
    $in_nb_p->setAttribute('id', 'n0');
    $in_nb_p->setAttribute('required','');
    $p_nb_p->addElements(Array($l_nb_p,$in_nb_p));
    
     $p_fil=new P();
    $l_fil=new Label('lab');
    $l_fil->addElement(new Text('Filiale'));
    $in_fil=new Input();
    $in_fil->setAttribute('name','f0');
    $in_fil->setAttribute('type','checkbox');
    $in_fil->setAttribute('id', 'f0');
    $p_fil->addElements(Array($l_fil,$in_fil));
    
    $tab=new Table();
    $td1=new Td();
    $td1->addElement($p_year);
    $td2=new Td();
    $td2->addElement($p_ch);
    $td3=new Td();
    $td3->addElement($p_nb_p);
    $td4=new Td();
    $td4->addElement($p_fil);
    
    $td5=new Td();
    $but=new Input();
    $but->setAttribute('type', 'button');
    $but->setAttribute('value', '+');
    $but->setAttribute('class', 'addButton');
    $td5->addElement($but);
    //$td5->setAttribute(('title'),'ajouter une nouvelle entrée');
    
    $tr=new Tr();
    $tr->setAttribute('id','first-tr');
    $tr->setAttribute('class','tr');
    $tr->addElements(Array($td1,$td2,$td3,$td4,$td5));
 
    $tab->addElements(Array($tr));
    
    $submit=new Input();
    $submit->setAttribute('type','submit');
    $submit->setAttribute('value','Envoyer');
    $submit->setAttribute('class','sub-chiffre');

    
   
    //----- Lien de fermeture de cette fenetre --//
    $close=new Input();
    $close->setAttribute('type', 'submit');
    $close->setAttribute('value', 'Fermer');
    $close->setAttribute('id', 'ca-close');
    
    $form->addElements(Array($tab,$submit,$close));
    
    $this->form->addElements(Array($form)); 

   } 
}
    

