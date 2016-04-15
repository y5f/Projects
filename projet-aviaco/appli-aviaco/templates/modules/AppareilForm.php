<?php


class AppareilForm extends Template{
    function __construct() {
        
        parent::__construct(new Div());
        $this->form->setAttribute('id','appareil');
        
        $hg=new Hgroup();
        $hg->setAttribute('class','hg-app');
        
        $titre=new H2();
        $titre->addElement(new Text('Ajouter un apareil'));
        
        $b_new_app=new Fieldset('Nouvel Appareil');
        $p_imat=new P();
        $l_imat=new Label('lab');
        $l_imat->addElement(new Text('Immatriculation :'));
        $in_imat=new Input();
        $in_imat->setAttribute('required','');
        $in_imat->setAttribute('type','text');
        $in_imat->setAttribute('id','app-imat');
        $p_imat->addElements(array($l_imat,$in_imat));
        
        $p_nom=new P();
        $l_nom=new Label('lab');
        $l_nom->addElement(new Text('Nom :'));
        $in_nom=new Input();
        $in_nom->setAttribute('required','');
        $in_nom->setAttribute('type','text');
        $in_nom->setAttribute('id','app-nom');
        $p_nom->addElements(array($l_nom,$in_nom));
        
        $p_mark=new P();
        $l_mark=new P();
        $l_mark->addElement(new Text('Choisir un fabricant :'));
        $sel_mark=new Select();
        $sel_mark->setAttribute('id','sel-mark');
        $opt_mark=new Option();
        $opt_mark->setAttribute('disabled','');
        $opt_mark->setAttribute('selected','');
        $opt_mark->addElement(new Text('Sélectionner  un fabricant'));
        
        $opt_mark_autre=new Option();
        $opt_mark_autre->addElement(new Text('autre'));
        
        
        $sel_mark->addElement($opt_mark);
        
        $list_mark=MarqueQuery::create()->find();
        foreach ($list_mark as $el){
            $opt=new Option();
            //$opt->setAttribute('value',$el->getID());
            $opt->setAttribute('value',$el->getMarque());
            $opt->addElement(new Text($el->getMarque()));
            $sel_mark->addElement($opt);
        }
        
        $sel_mark->addElements(array($opt_mark_autre));

        $sel_mod=new Select();
        $sel_mod->setAttribute('id','sel-mod');
        $opt_mod=new Option();
        $opt_mod->setAttribute('disabled','');
        $opt_mod->setAttribute('selected','');
        $opt_mod->addElement(new Text('Sélectionner  un modèle'));
        $sel_mod->addElement($opt_mod);
        
        $p_mark->addElements(Array($l_mark,$sel_mark,$sel_mod));
         
        $in_app=new Input();
        $in_app->setAttribute('type','submit');
        $in_app->setAttribute('id','add-app');
        $in_app->setAttribute('name','add-app');
       
        $b_new_app->addElements(Array($p_imat,$p_nom,$p_mark,$in_app));
        
        $b_list_app=new Fieldset('Appareils existants');
        $b_list_app->setAttribute('class', 'list-app');
        $ul_app=new Ul();
        $ul_app->setAttribute('id', 'list-app');
        foreach (AppareilQuery::create()->orderByNomApp('ASC')->find() as $app) {
            $em=new Label('');
            $em->setAttribute('value', $app->getIdAp());
            $em->setAttribute('class', 'del-app');
            $em->addElement(new Text('X'));
            $li=new Li(new Text($app->getNomApp()), '');
            $li->addElement($em);
            $ul_app->addLi($li);
        }
        $b_list_app->addElement($ul_app);
        
        $close=new Em();
        $close->addElement(new A(new Text('X'),''));
        $close->setAttribute('class', 'close-win-app');
        
        $hg->addElements(Array($close,$b_new_app,$b_list_app));
        
        $this->form->addElements(array($titre,$hg));
    }
}
