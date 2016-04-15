<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PNForm
 *
 * @author Nicolas
 */
class PNForm extends Template{
    function __construct() {
        parent::__construct(new Div());
        $this->form->setAttribute('class','paper-pn');
        
        //-- On recupère la pièce concerné ----//
        $pce=PieceQuery::create()->filterByID($_GET['pce'])->findOne();
        
        //--- On cherche la dernière instance de cette pièce dans la table piece_cmd:
        //-------  ce qui correspond à ce qui a été ajouté dans le paperboard ----
        $last_trade=CMDPieceQuery::create()->filterByPiece($pce)->orderByDTEProposition('ASC')->findOne();
        //print_r($last_trade);
        $frs=FournisseurQuery::create()->filterByID($_GET['frs'])->findOne();
        
        $h2=new H2();
        $h2->addElement(new Text('Fiche PN : détailles d\'une pièce ['.$frs->getSociete()->getSociete().']'));
        
        $hg_haut=new Hgroup();
        $hg_haut->setAttribute('class', 'hg-haut');
        
        //-- Bloc de gauche ----
        $f_left=new Fieldset('');
        $f_left->setAttribute('class', 'f-left');
        
        $div_bloc_num=new Div();
        $div_bloc_num->setAttribute('class', 'div-title');
        $num_pn=new H1();
        if($pce){
            $num_pn->addElement(new Text($pce->getPN()));
        }
        $div_bloc_num->addElement($num_pn);
        $div_bloc_type=new Div();
        $div_bloc_type->setAttribute('class', 'div-title');
        $p_paper=new P();
        $em_paper=new Em();
        $em_paper->addElement(new Text('Paperboard'));
        $chbx_paper=new Input();
        $chbx_paper->setAttribute('type', 'checkbox');
        if(isset($_GET['paper'])){
            $chbx_paper->setAttribute('checked', '');
        }
        $p_paper->addElements(Array($em_paper,$chbx_paper));
        $p_devis=new P();
        $em_devis=new Em();
        $em_devis->addElement(new Text('Dévis'));
        $chbx_devis=new Input();
        $chbx_devis->setAttribute('type', 'checkbox');
        if(isset($_GET['devis'])){
            $chbx_devis->setAttribute('checked', '');
        }
        $p_devis->addElements(Array($em_devis,$chbx_devis));
        $p_fact=new P();
        $em_fact=new Em();
        $em_fact->addElement(new Text('Facture'));
        $chbx_fact=new Input();
        $chbx_fact->setAttribute('type', 'checkbox');
        if(isset($_GET['fact'])){
            $chbx_fact->setAttribute('checked', '');
        }
        $p_fact->addElements(Array($em_fact,$chbx_fact));
        $div_bloc_type->addElements(Array($p_paper,$p_fact,$p_devis));
        
        $f_bloc_doc=new Fieldset('Liste documents');
        $div_bloc_doc=new Div();
        $tab=new Table();
        $tbody=new Tbody();
        if($frs){
            foreach (DocumentQuery::create()->filterByFournisseur($frs)->find() as $doc) {
                $tr=new Tr();
                $td_desc=new Td();
                $td_desc->addElement(new Text($doc->getNDoc()));
                $td_url=new Td();
                $td_url->addElement(new A(new Text('Link'),$doc->getDoc()));
                $tr->addElements(Array($td_desc,$td_url));
                $tbody->addElement($tr);
            }
        }
        $tab->addElement($tbody);
        $div_bloc_doc->addElement($tab);
        $f_bloc_doc->addElement($div_bloc_doc);
        $f_left->addElements(Array($div_bloc_num,$div_bloc_type,$f_bloc_doc));
        
        //-- Bloc de Droite -----
        $f_right=new Fieldset('');
        $p_dte_first_search=new P();
        $lab_first_search=new Label('');
        $lab_first_search->addElement(new Text('Date début recherche'));
        $in_first_search=new Input();
        $in_first_search->setAttribute('type', 'text');
        $p_dte_first_search->addElements(Array($lab_first_search,$in_first_search));
        $p_dte_first_devis=new P();
        $lab_first_devis=new Label('');
        $lab_first_devis->addElement(new Text('Date 1er devis'));
        $in_first_devis=new Input();
        $in_first_devis->setAttribute('type', 'text');
        $p_dte_first_devis->addElements(Array($lab_first_devis,$in_first_devis));
        $p_dte_first_fatc=new P();
        $lab_first_fact=new Label('');
        $lab_first_fact->addElement(new Text('Date Facture'));
        $in_first_fact=new Input();
        $in_first_fact->setAttribute('type', 'text');
        $p_dte_first_fatc->addElements(Array($lab_first_fact,$in_first_fact));
        $p_mailè_responsable=new P();
        $lab_mail_respon=new Label('');
        $lab_mail_respon->addElement(new Text('Mail du correspondant'));
        $mail='';
        if($frs){
            $mail='mailto:'.$frs->getSociete()->getEmail();
        }
        $p_mailè_responsable->addElements(Array($lab_mail_respon,new A(new Text('a link'), $mail)));
        if($last_trade){
            $in_first_search->setAttribute('value', $last_trade->getDTEProposition('d/m/Y G:i:s'));
        }
        $div_dates=new Div();
        $div_dates->addElements(Array($p_dte_first_search,$p_dte_first_devis,$p_dte_first_fatc,$p_mailè_responsable));
        $f_duree_vie=new Fieldset('Estimation durée de vie');
        $f_duree_vie->setAttribute('class', 'f-dree-vie');
        $zone_saisie=new Textarea();
        $zone_saisie->setAttribute('class', 'pn-comment');
        $zone_saisie->setAttribute('name', $pce->getID());
        $zone_saisie->addElement(new Text($pce->getCommentaire()));
        $f_duree_vie->addElement($zone_saisie);
        $f_right->addElements(Array($div_dates,$f_duree_vie));
        
        $hg_haut->addElements(Array($f_left,$f_right));
        
        //--- Bloc du bas -----
        $hg_bas=new Hgroup();
        $hg_bas->setAttribute('class', 'hg-bas');
        $f_condi=new Fieldset('');
        $lab_info=new Label('');
        $lab_info->addElement(new Text('Données techniques de la pièce :'));
        $f_condi->addElement($lab_info);
        foreach (ConditionQuery::create()->find() as $cond) {
            $em=new Em();
            $em->addElement(new Text($cond->getCondition()));
            $in_cond=new Input();
            $in_cond->setAttribute('type', 'checkbox');
            //$frs=FournisseurQuery::create()->filterByPiece($pce)->filterBySociete($frs)->findOne();
            if($frs){
                $vte=COMVendeurQuery::create()->filterByPiece($pce)->filterByFournisseur($frs)->findOne();
                foreach (COMConditionQuery::create()->filterByPiece($pce)->filterByCommande($vte->getCommande())->find() as $cd) {
                    if($cond->equals($cd->getCondition())){
                        $in_cond->setAttribute('checked', '');
                    }
                }
            }
            $p_cond=new P();
            $p_cond->addElements(Array($em,$in_cond));
            $f_condi->addElement($p_cond);
        }
        
        $p_ann_fab=new P();
        $lab_ann_fab=new Label('lab');
        $lab_ann_fab->addElement(new Text('Année de fabrication :'));
        $input_ann_fab=new Input();
        $input_ann_fab->setAttribute('type','text');
        if($frs){
            $input_ann_fab->setAttribute('value', $frs->getFABAnnee());
        }
        $input_ann_fab->setAttribute('class','src-doc');
        $p_ann_fab->addElements(Array($lab_ann_fab,$input_ann_fab));
        
        $p_tmp=new P();
        $lab_tmp=new Label('lab');
        $lab_tmp->addElement(new Text('Temps restant :'));
        $input_tmp=new Input();
        $input_tmp->setAttribute('type','type');
        if($frs){
            $input_tmp->setAttribute('value', $frs->getTRestant());
        }
        $input_tmp->setAttribute('class','src-doc');
        $p_tmp->addElements(Array($lab_tmp,$input_tmp));
        
        $p_tmp_to=new P();
        $lab_tmp_to=new Label('lab');
        $lab_tmp_to->addElement(new Text('Temps total :'));
        $input_tmp_to=new Input();
        $input_tmp_to->setAttribute('type','type');
        if($frs){
            $input_tmp_to->setAttribute('value', $frs->getTTotal());
        }
        $input_tmp_to->setAttribute('class','src-doc');
        $p_tmp_to->addElements(Array($lab_tmp_to,$input_tmp_to));
        
        $p_d_vie=new P();
        $lab_d_vie=new Label('lab');
        $lab_d_vie->addElement(new Text('Durée de vie :'));
        $input_d_vie=new Input();
        $input_d_vie->setAttribute('type','type');
        if($frs){
            $input_d_vie->setAttribute('value', $frs->getDVie());
        }
        $input_d_vie->setAttribute('class','src-doc');
        $p_d_vie->addElements(Array($lab_d_vie,$input_d_vie));
        
        $p_an_app=new P();
        $lab_an_app=new Label('lab');
        $lab_an_app->addElement(new Text('Ancien appareil :'));
        $input_an_app=new Input();
        $input_an_app->setAttribute('type','type');
        if($frs){
            $input_an_app->setAttribute('value', $frs->getOLDApp());
        }
        $input_an_app->setAttribute('class','src-doc');
        $p_an_app->addElements(Array($lab_an_app,$input_an_app));
        
        $p_nw_app=new P();
        $lab_nw_app=new Label('lab');
        $lab_nw_app->addElement(new Text('Nouvel appareil :'));
        $input_nw_app=new Input();
        $input_nw_app->setAttribute('type','type');
        if($frs){
            $input_nw_app->setAttribute('value', $frs->getNApp());
        }
        $input_nw_app->setAttribute('class','src-doc');
        $p_nw_app->addElements(Array($lab_nw_app,$input_nw_app));
        
        $p_oh=new P();
        $lab_oh=new Label('lab');
        $lab_oh->addElement(new Text('Nombre d\'OH :'));
        $input_oh=new Input();
        $input_oh->setAttribute('type','type');
        if($frs){
            $input_oh->setAttribute('value', $frs->getNBROh());
        }
        $p_oh->addElements(Array($lab_oh,$input_oh));
        $p_mro=new P();
        $lab_mro=new Label('lab');
        $lab_mro->addElement(new Text('Centre MRO :'));
        $input_mro=new Input();
        $input_mro->setAttribute('type','type');
        if($frs){
            $mro=MROCentreQuery::create()->filterBySociete($frs->getSociete())->findOne();
            if($mro){
                $input_mro->setAttribute('value', $mro->getMRO());
            }else{
                $input_mro->setAttribute('value', '##MRO inconnu##');
            }
        }
        
        $input_mro->setAttribute('class','src-doc');
        $p_mro->addElements(Array($lab_mro,$input_mro));
        $div_one=new Div();
        $div_one->addElements(Array($p_ann_fab,$p_tmp,$p_tmp_to,$p_d_vie,$p_an_app));
        $div_two=new Div();
        $div_two->addElements(Array($p_nw_app,$p_oh,$p_mro));
        $hg_bas->addElements(Array($f_condi,$div_one,$div_two));
        $this->form->addElements(Array($h2,$hg_haut,$hg_bas));
    }
}
