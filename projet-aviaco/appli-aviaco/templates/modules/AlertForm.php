<?php


class AlertForm extends Template {

    function __construct() {

        parent::__construct(new Div());
        $this->form->setAttribute('class','fraude');
        
        $h2=new H2();
        $h2->addElement(new Text('Alerte fraude'));
        
        $p_search=new P();
        $in_search=new Input();
        $in_search->setAttribute('type','search');
        $in_search->setAttribute('name','search');
        $in_search->setAttribute('placeholder','Recherche');
        $in_search->setAttribute('onkeyup',"find_fraude(this.value)");
        $p_search->addElement($in_search);
        
        $tab=new Table();
       
        
        $tr_title=new Tr();
        $th1=new Th();
        $th1->addElement(new Text('Nom société'));
        $th2=new Th();
        $th2->addElement(new Text('Date fraude'));
        $th3=new Th();
        $th3->addElement(new Text('Nom des dirigeants'));
        $th4=new Th();
        $th4->addElement(new Text('Téléphone'));
        $th5=new Th();
        $th5->addElement(new Text('Mail'));
        $th6=new Th();
        $th6->addElement(new Text('Site'));
        $th7=new Th();
        $th7->addElement(new Text('Source'));
        $th8=new Th();
        $th8->addElement(new Text('Nom plaignant'));
        $th9=new Th();
        $th9->addElement(new Text('Mail plaignant'));
        $th10=new Th();
        $th10->addElement(new Text('Site plaignat'));
        
        $tr_title->addElements(array($th1,$th2,$th3,$th4,$th5,$th6,$th7,$th8,$th9,$th10));
        
        $thead=new Thead();
        $thead->addElement($tr_title);
        
        $tbody=new Tbody();
        $tbody->setAttribute('id', 'list-fraude');
        foreach (SPartenaireQuery::create()->find() as $each){
           $tr=new Tr();
           $tr->setAttribute('class','init');
           $td1=new Td();$td2=new Td();$td3=new Td();$td4=new Td();$td5=new Td();$td6=new Td();$td7=new Td();$td8=new Td();$td9=new Td();$td10=new Td();
           $td1->addElement(new A(new Text($each->getSocFraude()->getSociete()),'?rub=new-part&soc='.$each->getSocFraude()->getID()));
           $td2->addElement(new Text($each->getDatePlainte()->format('d/m/y H:i:s')));
           $td3->addElement(new Text($each->getSocFraude()->getDirigeant()));
           $td4->addElement(new Text($each->getSocFraude()->getTelephone()));
           $td5->addElement(new Text($each->getSocFraude()->getEmail()));
           $td6->addElement(new Text($each->getSocFraude()->getWebsite()));
           
               if($each->getPPlaigante()!==NULL){
                   $td7->addElement(new Text($each->getPartenaire()->getPartenaire()));
                   $td9->addElement(new Text($each->getPartenaire()->getmail()));
                   $td10->addElement(new Text(''));
               }else{
                   $td7->addElement(new Text($each->getSocPlaignant()->getSociete()));
                   $td9->addElement(new Text($each->getSocPlaignant()->getEmail()));
                   $td10->addElement(new Text($each->getSocPlaignant()->getWebsite()));
               }
               $td8->addElement(new Text($each->getPlaignat()));
               
           $tr->addElements(array($td1,$td2,$td3,$td4,$td5,$td6,$td7,$td8,$td9,$td10));
           
           $tbody->addElement($tr);
       }
        $tab->addElements(array($thead,$tbody));

        //--- Le bouton retour ---
        $b_ret=new Input();
        $b_ret->setAttribute('type', 'button');
        $b_ret->setAttribute('value', 'Retour');
        $p_ret=new P();
        $p_ret->addElement($b_ret);
        
        // récupérer  les fraudes depuis la base 
        $this->form->addElements(array($h2,$p_search,$tab,$p_ret));    
    }
}
