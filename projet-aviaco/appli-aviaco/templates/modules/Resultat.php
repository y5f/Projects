<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Resultat
 *
 * @author Nicolas
 */
class Resultat extends Template{
    function __construct($l) {
        parent::__construct(new Hgroup());
        $this->form->setAttribute('class','search-list');
        
        //---b Fieldset qui va contenir le tableau ----//
        $list=new Fieldset('Resultats');
        
        //--- La table contenant la liste ----
        $tab=new Table();
        $th=new Thead();
        $tb=new Tbody();
        
        $tr_h=new Tr();
        
        $th_name=new Th();
        $chkbx_soc=new Input();
        $chkbx_soc->setAttribute('type', 'checkbox');
        $chkbx_soc->setAttribute('class', 'del-soc-all');
        $th_name->addElements(Array($chkbx_soc,new Text('Nom société')));
        
        $th_mail=new Th();
        $chkbx=new Input();
        $chkbx->setAttribute('type', 'checkbox');
        $chkbx->setAttribute('name', 'hist');
        $chkbx->setAttribute('class', 'all-mail');
        $th_mail->addElements(Array($chkbx,new Text('Mail société')));
        
        $th_tel=new Th();
        $th_tel->addElement(new Text('Téléphone'));
        
        $th_conct=new Th();
        $th_conct->addElement(new Text('Contact'));
        
        $th_mail_conct=new Th();
        $chkbx_c=new Input();
        $chkbx_c->setAttribute('type', 'checkbox');
        $chkbx_c->setAttribute('name', 'hist');
        $chkbx_c->setAttribute('class', 'c-all-mail');
        $th_mail_conct->addElements(Array($chkbx_c,new Text('Mail contact')));
        
        $th_pays=new Th();
        $th_pays->addElement(new Text('Pays'));
        
        $th_ville=new Th();
        $th_ville->addElement(new Text('Ville'));
        
        $tr_h->addElements(Array($th_name,$th_mail,$th_tel,$th_conct,$th_mail_conct,$th_pays,$th_ville));
        $th->addElement($tr_h);
        
        //---- On recupère la liste des société passées en param ---
        $lis=explode('#', $l);
        if(count($lis)>0){
            
            foreach ($lis as $id) {
                
                //--- On recupère la société liés à cet ID ----
                $soc=SocieteQuery::create()->filterByID($id)->findOne();
                if($soc){
                    $tr_b=new Tr();
                    $tr_b->setAttribute('id', 'tr-'.$soc->getID());
                    if(!$soc->getisACTIF()){
                        $tr_b->setAttribute('class', 'desact');
                    }else{
                        $tr_b->setAttribute('class', 'act');
                    }
                    
                    $td_name=new Td();
                    $chkbx_soc=new Input();
                    $chkbx_soc->setAttribute('type', 'checkbox');
                    $chkbx_soc->setAttribute('name', 'hist');
                    $chkbx_soc->setAttribute('class', 'del-soc');
                    $chkbx_soc->setAttribute('value', $soc->getID());
                    $td_name->addElement(new A(new Text($chkbx_soc->toHTML().$soc->getSociete()),'?rub=new-part&soc='.$soc->getID()));
        
                    $td_mail=new Td();
                    if($soc->getEmail()!==''){
                        $chkbx=new Input();
                        $chkbx->setAttribute('type', 'checkbox');
                        $chkbx->setAttribute('name', $soc->getEmail());
                        $chkbx->setAttribute('class', 'mail mail-sel');
                        $p_mail_soc=new P();
                        $p_mail_soc->addElement(new Text($soc->getEmail()));
                        $chkbx->setAttribute('value', $p_mail_soc->toHTML());
                        $td_mail->addElement(new A(new Text($chkbx->toHTML().$soc->getEmail()),'mailto:'.$soc->getEmail().';'.$soc->getEmail()));
                    }
                    
                    $td_tel=new Td();
                    $td_tel->addElement(new A(new Text($soc->getTelephone()),'?rub=new-part&soc='.$soc->getID()));
        
                    $td_conct=new Td();
                
                    //--- On cherche dans les relation s contact et on prendr le premier contact --
                    $contact=ContactQuery::create()->filterBySociete($soc)->filterByOrdre(1)->findOne();
                    if($contact){
                        $td_conct->addElement(new A(new Text($contact->getNom()),'?rub=new-part&soc='.$soc->getID()));
                    }
                
                    $td_mail_conct=new Td();
                    if($contact){
                        if($contact->getMail()!==''){
                            $chkbx_c=new Input();
                            $chkbx_c->setAttribute('type', 'checkbox');
                            $chkbx_c->setAttribute('name', $contact->getMail());
                            $chkbx_c->setAttribute('class', 'mail c-mail-sel');
                            $p_mail_cont=new P();
                            $p_mail_cont->addElement(new Text($contact->getMail()));
                            $chkbx_c->setAttribute('value', $p_mail_cont->toHTML());
                            $td_mail_conct->addElement(new A(new Text($chkbx_c->toHTML().$contact->getMail()),'mailto:'.$contact->getMail()));
                        }
                    }
        
                    $td_pays=new Td();
                    $td_pays->addElement(new A(new Text($soc->getPays()),'?rub=new-part&soc='.$soc->getID()));
        
                    $td_ville=new Td();
                    $td_ville->addElement(new A(new Text($soc->getVille()),'?rub=new-part&soc='.$soc->getID()));
            
                    $tr_b->addElements(Array($td_name,$td_mail,$td_tel,$td_conct,$td_mail_conct,$td_pays,$td_ville));
                    $tb->addElement($tr_b);
                }
                
            }
            
        }
        $tab->addElements(Array($th,$tb));
        $list->addElement($tab);
        
        //-- bloc action groupé ----
        $p_action=new P();
        $em=new Em();
        $sel_act=new Select();
        $sel_act->setAttribute('id', 'result-act');
        $op_1=new Option();
        $op_1->setAttribute('value', 'aucun');
        $op_1->setAttribute('id', 'default-opt');
        $op_1->addElement(new Text('aucun'));
        
        $op_2=new Option();
        $op_2->setAttribute('value','mailing');
        $op_2->addElement(new Text('Envoyer mail'));
        
        $op_3=new Option();
        $op_3->setAttribute('value', 'desact');
        $op_3->addElement(new Text('Desactiver'));
        
        $op_4=new Option();
        $op_4->setAttribute('value', 'activ');
        $op_4->addElement(new Text('Activer'));
        
        $op_5=new Option();
        $op_5->setAttribute('value', 'del');
        $op_5->addElement(new Text('Supprimer'));
        $sel_act->addElements(Array($op_1,$op_2,$op_3,$op_4,$op_5));
        $em->addElements(Array(new Text('Action groupée'),$sel_act));
        
        
        //--- Bouton retour ----
        $b_return=new Input();
        $b_return->setAttribute('type', 'submit');
        $b_return->setAttribute('class', 'itp');
        $b_return->setAttribute('name', 'societe');
        $b_return->setAttribute('value', 'Retour');

        $p_action->addElements(Array($em,$b_return));
        
        $this->form->addElements(Array($list,$p_action));
    }
}
