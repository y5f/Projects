<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FicheGP
 *
 * @author Nicolas
 */
class FicheGP extends Template {
    function __construct() {
        parent::__construct(new Div());
        $this->form->setAttribute('class','piece-page');
        $this->form->setAttribute('action','scripts/script.php');
        $this->form->setAttribute('method','post');
        $this->form->setAttribute('id','piece-form');
        
        $p_titre=new P();
        $titre=new H1();
        $titre->addElement(new Text('Fiche groupe pièce'));
        $img=new Img('upload/edit.png');
        $img->setAttribute('id', 'add-gp');
        $p_titre->addElements(Array($titre,$img));
        $this->form->addElements(Array($titre,$img));
        
        //$cmd='';
        if(isset($_GET['ref'])){
            $ref=$_GET['ref'];
            //$cmd=CommandeQuery::create()->filterByIDCommande($ref)->find();
            $cmd_one=CommandeQuery::create()->filterByIDCommande($ref)->findOne();
            if(isset($cmd_one) && $cmd_one){
                $soc=$cmd_one->getSociete();
                //--- On recupère l'utilisaeur finale ----
                $enduser=COMEnduserQuery::create()->filterByCommande($cmd_one)->findOne();
                
                $ref_zone=new Input();
                $ref_zone->setAttribute('type', 'hidden');
                $ref_zone->setAttribute('name', 'num-cmd');
                $ref_zone->setAttribute('class', 'num-cmd form');
                $ref_zone->setAttribute('value', $cmd_one->getIDCommande());
                
                $ref_pce=new Input();
                $ref_pce->setAttribute('type', 'hidden');
                $ref_pce->setAttribute('name', 'num-pce');
                $ref_pce->setAttribute('class', 'num-pce form');
                $ref_pce->setAttribute('value', $cmd_one->getIDCommande());
                
                $this->form->addElements(Array($ref_zone,$ref_pce));
            }
            
        }
        $p_ref=new P();
        $l_ref=new Label('lab');
        $in_ref=new Input();
        $in_ref->setAttribute('class','ref-cmd form');
        $in_ref->setAttribute('required','');
        $in_ref->setAttribute('type','text');
        $in_ref->setAttribute('name','achat-ref');
        $in_ref->setAttribute('placeholder','Référence');
        if(isset($cmd_one) && $cmd_one){
            $in_ref->setAttribute('value',$cmd_one->getRFCommande());
        }
        
        $p_ref->addElements(array($l_ref,$in_ref));
        
        $p_entr=new P();
        $l_entr=new Label('lab');
        $l_entr->addElement(new Text('Entreprise'));
        $in_entr=new Select();
        $in_entr->setAttribute('type','text');
        $in_entr->setAttribute('name','achat-soc');
        $in_entr->setAttribute('class','gp-cmd form');
        $in_entr->setAttribute('required','');
        $opt_def=new Option();
        if(isset($_GET['soc'])){
            $societe=SocieteQuery::create()->filterByID($_GET['soc'])->findOne();
            $opt_def->addElement(new Text($societe->getSociete()));
            $opt_def->setAttribute('value', $societe->getID());
        }else{
            $opt_def->addElement(new Text('selectionnez'));
        }
        $in_entr->addElement($opt_def);
        foreach (SocieteQuery::create()->orderBySociete()->find() as $s) {
            $opt=new Option();
            $opt->setAttribute('value', $s->getID());
            $opt->addElement(new Text($s->getSociete()));
            if(isset($soc) && $soc->equals($s)){
                $opt->setAttribute('selected', '');
            }
            $in_entr->addElement($opt);
        }
        if(isset($soc)){
            $in_entr->setAttribute('value',$soc->getID());
        }
        $p_entr->addElements(array($l_entr,$in_entr));
        
        $p_con=new P();
        $l_con=new Label('lab');
        $l_con->addElement(new Text('Contact'));
        $in_con=new Input();
        $in_con->setAttribute('class','con-cmd');
        $in_con->setAttribute('type','text');
        $in_con->setAttribute('name','achat-cont');
        if(isset($soc)){
            $cont=ContactQuery::create()->filterBysociete_FK($soc->getSociete())->filterByOrdre(1)->findOne();
            if($cont){
                $in_con->setAttribute('value',$cont->getNom());
            }
        }
        $p_con->addElements(array($l_con,$in_con));
        
        $p_tel=new P();
        $l_tel=new Label('lab');
        $l_tel->addElement(new Text('Tel du Contact'));
        $in_tel=new Input();
        $in_tel->setAttribute('class','tel-cmd');
        $in_tel->setAttribute('type','text');
        $in_tel->setAttribute('name','achat-tel');
        if(isset($cont)){
            $in_tel->setAttribute('value', $cont->getTelephone());
         }
        $p_tel->addElements(array($l_tel,$in_tel));
        
        $p_mail=new P();
        $l_mail=new Label('lab');
        $l_mail->addElement(new Text('Mail'));
        $in_mail=new Input();
        $in_mail->setAttribute('class','mail-cmd');
        $in_mail->setAttribute('type','mail');
        $in_mail->setAttribute('name','achat-mail');
        if(isset($cont)){
            $in_mail->setAttribute('value', $cont->getMail());
        }
        $p_mail->addElements(array($l_mail,$in_mail));
        
        $p_dt=new P();
        $l_dt=new Label('lab');
        $in_dt=new Input();
        $in_dt->setAttribute('type','date');
        $in_dt->setAttribute('name','achat-date');
        $in_dt->setAttribute('class','date-cmd');
        $in_dt->setAttribute('value',date('Y-m-d'));
        if(isset($cmd_one) && $cmd_one){
            $in_dt->setAttribute('value',$cmd_one->getDTECommande()->format('Y-m-d'));
        }
        $p_dt->addElements(array($l_dt,$in_dt));
        /*
        $p_del=new P();
        $l_del=new Label('lab');
        $l_del->addElement(new Text('Délai'));
        $in_del=new Input();
        $in_del->setAttribute('class','delai-cmd form');
        $in_del->setAttribute('value','0');
        $in_del->setAttribute('type','text');
        $in_del->setAttribute('name','achat-delai');
        if(isset($cmd_one)){
            $in_del->setAttribute('value',$cmd_one->getADelai());
        }
        $p_del->addElements(array($l_del,$in_del));
        
        $p_prix=new P();
        $l_prix=new Label('lab');
        $l_prix->addElement(new Text('Prix'));
        $in_prix=new Input();
        $in_prix->setAttribute('class','prix-cmd form');
        $in_prix->setAttribute('value','0.00');
        $in_prix->setAttribute('type','text');
        $in_prix->setAttribute('name','achat-prix');
        if(isset($cmd_one)){
            $in_prix->setAttribute('value',$cmd_one->getAPrix());
        }
        $p_prix->addElements(array($l_prix,$in_prix));
        
        $p_qt=new P();
        $l_qt=new Label('lab');
        $l_qt->addElement(new Text('Quantité'));
        $in_qt=new Input();
        $in_qt->setAttribute('class','qt-cmd form');
        $in_qt->setAttribute('value','0');
        $in_qt->setAttribute('type','text');
        $in_qt->setAttribute('name','achat-qte');
        if(isset($cmd_one)){
        $in_qt->setAttribute('value',$cmd_one->getQuantite());
        }
        $p_qt->addElements(array($l_qt,$in_qt));
        
        $p_li=new P();
        $l_li=new Label('lab');
        $in_li=new Input();
        $in_li->setAttribute('class','lieu-cmd form');
        $in_li->setAttribute('type','text');
        $in_li->setAttribute('name','end-user-dest');
        $in_li->setAttribute('placeholder','Adresses de destination');
        if(isset($enduser)){
            $in_li->setAttribute('value', $enduser->getEUser()->getEUAdresses());
        }
        $p_li->addElements(array($l_li,$in_li));
        
        $p_eu=new P();
        $l_eu=new Label('lab');
        $in_eu=new Input();
        $in_eu->setAttribute('class','eu-cmd form');
        $in_eu->setAttribute('type','text');
        $in_eu->setAttribute('type','text');
        $in_eu->setAttribute('name','end-user');
        $in_eu->setAttribute('placeholder','Utilisateur final');
        if(isset($enduser)){
            $in_eu->setAttribute('value', $enduser->getEUser()->getUSERName());
        }
        $p_eu->addElements(array($l_eu,$in_eu));
        */
        
        $left= new Hgroup();
        $left->setAttribute('class','left-cmd');
        $left->addElements(array($p_ref,$p_entr,$p_con,$p_tel,$p_mail,$p_dt));
        
        $right= new Hgroup();
        $right->setAttribute('class','right-cmd');
        $f_note=new Fieldset('Note');
        $tex_note=new Textarea();
        $tex_note->setAttribute('class', 'form');
        if(isset($cmd_one) && $cmd_one){
            $tex_note->addElement(new Text($cmd_one->getCMDNote()));
        }
        $f_note->addElement($tex_note);
        $right->addElements(array($f_note));
        
        $hg_cond=new Hgroup();
        $hg_cond->setAttribute('class', 'hg-cond');
        $f_set_cond=new Fieldset('Type de documents');
        $ul_cond=new Ul();
        foreach (TDocQuery::create()->find() as $doc) {
            $chbx=new Input();
            $chbx->setAttribute('type', 'checkbox');
            $chbx->setAttribute('class', 'cmd-gp');
            if(isset($cmd_one) && $cmd_one){
                $chbx->setAttribute('value', $cmd_one->getIDCommande().'^'.$doc->getTDoc());
                $cmd_cond=CMDTDocQuery::create()->filterByTDoc($doc)->filterByCommande($cmd_one)->findOne();
                if($cmd_cond){
                    $chbx->setAttribute('checked', '');
                }
            }
            $em=new Em();
            $em->addElement(new Text($doc->getTDoc()));
            $li=new Li($chbx, '');
            $li->addElement($em);
            $ul_cond->addLi($li);
        }
        $f_set_cond->addElement($ul_cond);
        $hg_cond->addElement($f_set_cond);
        
        $hg_acht=new Hgroup();
        $hg_acht->setAttribute('class','acheteur');
        $hg_acht->addElements(array($left,$hg_cond,$right));
        
        ///--- Tableau des commandes ----
        $hg_cmd=new Hgroup();
        $hg_cmd->setAttribute('class', 'hg-table');
        
        $tab=new Table(); 
        $tr_title=new Tr();
        $th1=new Th();
        $th1->addElement(new Text('Item'));
        $th2=new Th();
        $th2->addElement(new Text('N°_PN'));
        $th3=new Th();
        $th3->addElement(new Text('Alt_PN'));
        $th4=new Th();
        $th4->addElement(new Text('Descrip'));
        $th5=new Th();
        $th5->addElement(new Text('Quantité'));
        $th6=new Th();
        $th6->addElement(new Text('Appareil'));
        $th7=new Th();
        $th7->addElement(new Text('Prix N.'));
        $th8=new Th();
        $th8->addElement(new Text('Délai'));
        $th9=new Th();
        //---- Création du tableau vendeurs ----------
        //$tab_v=new Table();
        $th_v=new Thead();
        $tr_hv=new Tr();
        $th_v_1=new Th();
        $th_v_1->addElement(new Text('Vendeur'));
        $th_v_2=new Th();
        $th_v_2->addElement(new Text('Condit.'));
        //$th_v_3=new Th();
        //$th_v_3->addElement(new Text('Certif.'));
        $th_v_4=new Th();
        $th_v_4->addElement(new Text('Qté disp.'));
        $th_v_5=new Th();
        $th_v_5->addElement(new Text('Délai'));
        $th_v_6=new Th();
        $th_v_6->addElement(new Text('MO'));
        $th_v_7=new Th();
        $th_v_7->addElement(new Text('Prix Ach.'));
        $th_v_8=new Th();
        $th_v_8->addElement(new Text('Docs'));
        $th_v_9=new Th();
        $th_v_9->addElement(new Text('Prix vte.'));
        $th_v_10=new Th();
        $th_v_10->addElement(new Text('Note'));
        $th_v_11=new Th();
        $th_v_11->addElement(new Text('Propose'));
        $tr_hv->addElements(Array($th_v_1,$th_v_2,$th_v_4,$th_v_5,$th_v_6,$th_v_7,$th_v_9,$th_v_8,$th_v_10,$th_v_11));
        $th_v->addElement($tr_hv);
        //$tab_v->addElements(Array($th_v));
        //$th9->addElement($tab_v);
        $tr_title->addElements(array($th1,$th2,$th3,$th4,$th5,$th6,$th7,$th8));
        
        $thead=new Thead();
        $thead->addElement($tr_title);
        
        $tbody=new Tbody();
        $tbody->setAttribute('id', 'list-stock');
        //--- On charge les pieces -----
        if(isset($cmd_one) && $cmd_one){
            $i=0;
            //foreach (PieceQuery::create()->find() as $pc) {
                //$f =FournisseurQuery::create()->filterByPiece($pc)->find();
                foreach (CMDPieceQuery::create()->filterByCommande($cmd_one)->find() as $cmd_pc) {
                        //--- On recupère la commade concerné
                        $i++;
                        $tr=new Tr();
                        $tr->setAttribute('class','init');
                        $td1=new Td();$td2=new Td();$td3=new Td();$td4=new Td();$td5=new Td();$td6=new Td();$td7=new Td();$td8=new Td();$td9=new Td();
                        $em_1=new Em();
                        $em_1->addElement(new Text($i));
                        $lab_del=new Label($cmd_pc->getIDPiece().'^'.$cmd_pc->getIDCommande_FK());
                        $lab_del->setAttribute('class', 'sup-piece');
                        $lab_del->addElement(new Text('X'));
                            
                        $em_2=new Em();
                        $em_2->addElement(new A(new Text($cmd_pc->getPiece()->getPN()),'?rub=liste&s-rub=fiche-par-piece&pce='.$cmd_pc->getIDPiece().'&ref='.$cmd_one->getIDCommande()));
                        $em_3=new Em();
                        $em_in_3=new Input();
                        $em_in_3->setAttribute('type', 'text');
                        $em_in_3->setAttribute('class', 'set-updt-pce');
                        $em_in_3->setAttribute('name', 'alt^'.$cmd_pc->getIDPiece().'^'.$cmd_pc->getIDCommande_FK());
                        $em_in_3->setAttribute('value', $cmd_pc->getPiece()->getAltPN());
                        $em_3->addElement($em_in_3);
                        $em_4=new Em();
                        $em_in_4=new Input();
                        $em_in_4->setAttribute('type', 'text');
                        $em_in_4->setAttribute('class', 'set-updt-pce');
                        $em_in_4->setAttribute('name', 'desc^'.$cmd_pc->getIDPiece().'^'.$cmd_pc->getIDCommande_FK());
                        $em_in_4->setAttribute('value', $cmd_pc->getPiece()->getDescription());
                        $em_4->addElement($em_in_4);
                        $em_5=new Em();
                        $em_in_5=new Input();
                        $em_in_5->setAttribute('type', 'text');
                        $em_in_5->setAttribute('class', 'set-updt-pce');
                        $em_in_5->setAttribute('name', 'qte^'.$cmd_pc->getIDPiece().'^'.$cmd_pc->getIDCommande_FK());
                        $em_in_5->setAttribute('value', $cmd_pc->getQuantite());
                        $em_5->addElement($em_in_5);
                        $em_7=new Em();
                        $em_in_7=new Input();
                        $em_in_7->setAttribute('type', 'text');
                        $em_in_7->setAttribute('class', 'set-updt-pce');
                        $em_in_7->setAttribute('name', 'prix^'.$cmd_pc->getIDPiece().'^'.$cmd_pc->getIDCommande_FK());
                        $em_in_7->setAttribute('value', $cmd_pc->getCPrix());
                        $em_7->addElement($em_in_7);
                        $em_8=new Em();
                        $em_in_8=new Input();
                        $em_in_8->setAttribute('type', 'text');
                        $em_in_8->setAttribute('class', 'set-updt-pce');
                        $em_in_8->setAttribute('name', 'del^'.$cmd_pc->getIDPiece().'^'.$cmd_pc->getIDCommande_FK());
                        $em_in_8->setAttribute('value', $cmd_pc->getADelai());
                        $em_8->addElement($em_in_8);
                        $td1->addElements(Array($em_1,$lab_del));
                        $td2->addElement($em_2);
                        $td3->addElement($em_3);
                        $td4->addElement($em_4);
                        $td5->addElement($em_5);
                        $em_6=new Em();
                        $app=PieceAppQuery::create()->filterByPiece($cmd_pc->getPiece())->findOne();
                        $list_app=new Select();
                        $list_app->setAttribute('class', 'set-updt-pce');
                        $list_app->setAttribute('name', 'app^'.$cmd_pc->getIDPiece().'^'.$cmd_pc->getIDCommande_FK());
                        foreach (AppareilQuery::create()->find() as $ap) {
                            $opt=new Option();
                            $opt->setAttribute('value', $ap->getIdAp());
                            $opt->addElement(new Text($ap->getNomApp()));
                            if($app){
                                if($ap->equals($app->getAppareil())){
                                    $opt->setAttribute('selected', '');
                                }
                            }
                            $list_app->addElement($opt);
                        }
                        $em_6->addElement($list_app);
                        $td6->addElement($em_6);
                        $td7->addElement($em_7);
                        $td8->addElement($em_8);
                        $tab_b_v=new Table();
                        $tb_v=new Tbody();
                        $tb_v->setAttribute('class', 'new-vte-'.$cmd_pc->getIDPiece());
                        $j=0;
                        foreach (COMVendeurQuery::create()->filterByCommande($cmd_one)->filterByPiece($cmd_pc->getPiece())->find() as $vte) {
                            
                            //--- On recupère le certificat lié à cette société -----
                            $cert=SocietecertificatQuery::create()->filterBySociete($vte->getFournisseur()->getSociete())->findOne();
                            $tr_bv=new Tr();
                            $td_bv_1=new Td();
                            $td_bv_1->addElement(new A(new Text($vte->getFournisseur()->getSociete()->getSociete()),''));
                            $td_bv_2=new Td();
                            $list_cond=new Select();
                            $list_cond->setAttribute('class', 'set-updt');
                            $list_cond->setAttribute('name', 'cond^'.$vte->getIDVendeur());
                            foreach (ConditionQuery::create()->find() as $cond) {
                                $opt=new Option();
                                $opt->addElement(new Text($cond->getCondition()));
                                if($cond->equals($vte->getFournisseur()->getCondition())){
                                    $opt->setAttribute('selected', '');
                                }
                                $list_cond->addElement($opt);
                            }
                            $td_bv_2->addElement($list_cond);
                            $td_bv_3=new Td();
                            if($cert){
                                //$td_bv_3->addElement(new Text($cert->getCertificat()->getAgrement()));
                            } 
                            $td_bv_4=new Td();
                            $td_in_4=new Input();
                            $td_in_4->setAttribute('type', 'text');
                            $td_in_4->setAttribute('class', 'set-updt');
                            $td_in_4->setAttribute('name', 'qte^'.$vte->getIDVendeur());
                            $td_in_4->setAttribute('value',$vte->getFournisseur()->getQuantite());
                            $td_bv_4->addElement($td_in_4);
                            $td_bv_5=new Td();
                            $td_in_5=new Input();
                            $td_in_5->setAttribute('type', 'text');
                            $td_in_5->setAttribute('class', 'set-updt');
                            $td_in_5->setAttribute('name', 'delais^'.$vte->getIDVendeur());
                            $td_in_5->setAttribute('value', $vte->getFournisseur()->getDelai());
                            $td_bv_5->addElement($td_in_5);
                            $td_bv_6=new Td();
                            $td_in_6=new Input();
                            $td_in_6->setAttribute('type', 'text');
                            $td_in_6->setAttribute('class', 'set-updt');
                            $td_in_6->setAttribute('name', 'min^'.$vte->getIDVendeur());
                            $td_in_6->setAttribute('value',$vte->getPMinimum());
                            $td_bv_6->addElement($td_in_6);
                            $td_bv_7=new Td();
                            $td_in_7=new Input();
                            $td_in_7->setAttribute('type', 'text');
                            $td_in_7->setAttribute('class', 'set-updt');
                            $td_in_7->setAttribute('name', 'pach^'.$vte->getIDVendeur());
                            $td_in_7->setAttribute('value',$vte->getFournisseur()->getPrixachat());
                            $td_bv_7->addElement($td_in_7);
                            $td_bv_8=new Td();
                            $td_in_8=new Input();
                            $td_in_8->setAttribute('type', 'text');
                            $td_in_8->setAttribute('class', 'set-updt');
                            $td_in_8->setAttribute('name', 'pvte^'.$vte->getIDVendeur());
                            $td_in_8->setAttribute('value',$vte->getFournisseur()->getPrixvente());
                            $td_bv_8->addElement($td_in_8);
                            $td_bv_9=new Td();
                            $img=new Img('upload/folder.png');
                            $img->setAttribute('class', 'doc');
                            $img->setAttribute('name', 'gp');
                            $img->setAttribute('value', $vte->getIDFournisseur());
                            $td_bv_9->addElement($img);
                            $td_bv_10=new Td();
                            $td_bv_10->setAttribute('class', 'add-note');
                            $td_bv_10->setAttribute('value', $vte->getIDVendeur());
                            $td_bv_10->addElement(new A(new Text('......'),'#'));
                            $td_bv_11=new Td();
                            $prop_but=new Em();
                            //$prop_but->setAttribute('type', 'submit');
                            $prop_but->addElement(new A(new Text('......'),'#'));
                            $prop_but->setAttribute('class', 'view-propose');
                            $prop_but->setAttribute('value', $vte->getIDVendeur());
                            $lab_del=new Label($vte->getIDVendeur());
                            $lab_del->setAttribute('class', 'sup-vte');
                            $lab_del->addElement(new Text('X'));
                            $td_bv_11->addElements(Array($prop_but,$lab_del));
                            $tr_bv->addElements(Array($td_bv_1,$td_bv_2,$td_bv_4,$td_bv_5,$td_bv_6,$td_bv_7,$td_bv_8,$td_bv_9,$td_bv_10,$td_bv_11));
                            
                            $tb_v->addElement($tr_bv); 
                            $j++;
                        }
                        $add_pce=new Input();
                        $add_pce->setAttribute('type', 'button');
                        $add_pce->setAttribute('class', 'add-pce');
                        $add_pce->setAttribute('id', $cmd_one->getIDCommande().'^'.$cmd_pc->getIDPiece());
                        $add_pce->setAttribute('value', '+');
                        $add_pce->setAttribute('onclick', 'don_saisie(this.id)');
                        $tfoot=new Tfoot();
                        $tr_f=new Tr();
                        $td_f=new Td();
                        $td_f->addElement($add_pce);
                        $tr_f->addElement($td_f);
                        $tfoot->addElement($tr_f);
                        $tab_b_v->addElements(Array($th_v,$tfoot,$tb_v));
                        //$td9->addElement($tab_b_v);
                        
                        $tr_det=new Tr();
                        $tr_det->setAttribute('class', 'init');
                        $td_det=new Td();
                        $td_det->setAttribute('colspan', 8);
                        $td_det->addElement($tab_b_v);
                        $tr_det->addElement($td_det);
                        
                        $tr->addElements(Array($td1,$td2,$td3,$td4,$td5,$td6,$td7,$td8,$tr_det));
                        $tbody->addElement($tr);
                } 
            //}
        }
        $tfoot=new Tfoot();
        if(isset($cmd_one) && $cmd_one){
            $add_pce=new Input();
            $add_pce->setAttribute('type', 'button');
            $add_pce->setAttribute('class', 'add-pce');
            $add_pce->setAttribute('id', $cmd_one->getIDCommande());
            $add_pce->setAttribute('onclick', 'don_saisie(this.id)');
            $add_pce->setAttribute('value', '+');
        
            $tr_f=new Tr();
            $td_f=new Td();
            $td_f->addElement($add_pce);
            $tr_f->addElement($td_f);
            $tfoot->addElement($tr_f);
        }
        
        $tab->addElements(Array($thead,$tfoot,$tbody));
        $hg_cmd->addElements(Array($tab));
        $this->form->addElements(Array($hg_acht,$hg_cmd));
    }
}
