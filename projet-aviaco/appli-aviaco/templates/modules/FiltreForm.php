
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listeEntrep
 *
 * @author méziane
 */
class FiltreForm extends Template{

    function __construct() {
        
        parent::__construct(new Div());
        $this->form->setAttribute('class', 'list-ep');
        
        /*---bloc liste entreprise---
         ce bloc contient un Hgroupe et 1 fourmulaire*/
                
        $b_new_liste=new Fieldset('liste  entreprise');
        $b_new_liste->setAttribute('class', 'b-liste');
        
        //--- On selectio  la liste des E/P ---//
        $ep_ul=new Ul();
        $ep_ul->setAttribute('id', 'liste-filtre');
        foreach (SocieteQuery::create()->orderBySociete('ASC')->find() as $ep) {
            $em=new Em();
            $em->setAttribute('class', 'item-ep');
            $em->setAttribute('value', $ep->getID());
            $em->addElement(new Text($ep->getSociete()));
            if($ep->getisACTIF()){
                $class='act';
            }else{
                $class='desact';
            }
            $li=new Li(new A($em,'?rub=new-part&soc='.$ep->getID()), $class);
            $ep_ul->addLi($li);
        }
        $b_new_liste->addElement($ep_ul);
        
        /*---bloc filtre---
         ce bloc contient un Hgroupe et 1 fourmulaire*/
        $b_new_filtre=new Fieldset('Filtre');
        $b_new_filtre->setAttribute('class', 'b-filtre');

        //<editor-fold defaultstate="collapsed" desc="---filtre---">
        $filtre_groupe=new Hgroup();
        
        //feildset  du bloc pays 
        $b_Pays=new Fieldset('Pays');
        $b_Pays->setAttribute('class', 'pays');
        
        //--- On selectionne les pays --//
        $ul_pays=new Ul();
        $em_all=new Em();
        $em_all->addElement(new Text('Tous'));
        $li_all=new Li($em_all, 'filtre item-pays');
        $li_all->setAttribute('name', 'all');
        $li_all->setAttribute('value', '');
        $ul_pays->addElement($li_all);
       
        foreach (MPaysQuery::create()->orderByPays('ASC')->find() as $pays) {
            $em=new Em();
            $em->addElement(new Text($pays->getPays()));
            $li=new Li($em, 'filtre item-pays');
            $li->setAttribute('value', $pays->getPays());
            $li->setAttribute('etat', '0');
            $ul_pays->addLi($li);
        }
        $b_Pays->addElement($ul_pays);
        
        //--Bloc Fabricant ---//
        $b_fabricant=new Fieldset('Fabricant');
        $ckbx_fab=new Div();
       
        $em=new Em();
        $chkbx=new Input();
        $chkbx->setAttribute('type', 'radio');
        $chkbx->setAttribute('name', 'f-list');
        $chkbx->setAttribute('class', 'filtre f-list');
        $chkbx->setAttribute('value', '');
        $em->addElements(Array($chkbx,new Text('Tous')));
        $ckbx_fab->addElement($em);
        
        foreach (MarqueQuery::create()->find() as $fab) {
            $em=new Em();
            $chkbx=new Input();
            $chkbx->setAttribute('type', 'radio');
            $chkbx->setAttribute('name', 'f-list');
            $chkbx->setAttribute('class', 'filtre f-list');
            $chkbx->setAttribute('value', $fab->getMarque());
            $em->addElements(Array($chkbx,new Text($fab->getMarque())));
            $ckbx_fab->addElement($em);
        }
        $b_fabricant->addElement($ckbx_fab);
        
        //---Bloc Activité---/
        $b_activite=new Fieldset('Activité');
        $b_activite->setAttribute('class', 'triple');
        $ckbx_act=new Div();
       
        foreach (MetierQuery::create()->orderByMetier('ASC')->find() as $act) {
            $em=new Em();
            $chkbx=new Input();
            $chkbx->setAttribute('type', 'checkbox');
            $chkbx->setAttribute('class', 'filtre act-list');
            $chkbx->setAttribute('value', $act->getMetier());
            $em->addElements(Array($chkbx,new Text($act->getMetier())));
            $ckbx_act->addElement($em);
        }
        $b_activite->addElement($ckbx_act);
        
        //-- Bloc Appareil --//
        $b_appareil=new Fieldset('Appareil');
        $b_appareil->setAttribute('class', 'triple');
        $ul_app=new Ul();
       
        foreach (AppareilQuery::create()->find() as $app) {
            $em=new Em();
            $chkbx=new Input();
            $chkbx->setAttribute('type', 'checkbox');
            $chkbx->setAttribute('class', 'filtre app-list');
            $chkbx->setAttribute('value', $app->getIdAp());
            $em->addElements(Array($chkbx,new Text($app->getNomApp())));
            $li=new Li($em, 'item-appareils');
            $ul_app->addLi($li);
        }
        $b_appareil->addElement($ul_app);
        
        //-- Bloc Flotte --//
        $b_flotte=new Fieldset('Flotte');
        $b_flotte->setAttribute('class', 'triple');
        $ul_flote=new Ul();
        foreach (AppareilQuery::create()->find() as $app) {
            $em=new Em();
            $chkbx=new Input();
            $chkbx->setAttribute('type', 'checkbox');
            $chkbx->setAttribute('class', 'filtre app-f-list');
            $chkbx->setAttribute('value', $app->getIdAp());
            $em->addElements(Array($chkbx,new Text($app->getNomApp())));
            $li=new Li($em, 'item-appareils');
            $ul_flote->addLi($li);
        }
        $b_flotte->addElement($ul_flote);
        
        //---- Bouton valider la recherche --//
        $seach_b=new Input();
        $seach_b->setAttribute('type', 'submit');
        $seach_b->setAttribute('id', 'b-filtre');
        $seach_b->setAttribute('value', 'Resultats');
        
        $em_seach=new Em();
        $em_seach->addElement($seach_b);
        $filtre_groupe->addElements(Array($b_Pays,$b_fabricant,$b_activite,$b_appareil,$b_flotte,$em_seach));

        $b_new_filtre->addElement($filtre_groupe);
        $retour_but=new Input();
        $retour_but->setAttribute('type','submit');
        $retour_but->setAttribute('name','Retour');
        $retour_but->setAttribute('value','Retour');
       $this->form->addElements(Array($b_new_liste,$b_new_filtre,$retour_but));
                
    }
}
