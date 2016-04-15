<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FichePS
 *
 * @author Nicolas
 */
class FichePS extends Template{
    function __construct() {
        parent::__construct(new Div());
        $this->form->setAttribute('class','fiche-par-societe');
        $p_br=new Br();
        
        //--- On recupère la société à afficher ---
        if(isset($_GET['soc'])){
            $soc=SocieteQuery::create()->filterByID($_GET['soc'])->findOne();
            $cont1=ContactQuery::create()->filterBySociete($soc)->filterByOrdre(1)->findOne();
            $cont2=ContactQuery::create()->filterBySociete($soc)->filterByOrdre(2)->findOne();
            $cont3=ContactQuery::create()->filterBySociete($soc)->filterByOrdre(3)->findOne();
        }
        
        $p_search=new P();
        $in_search=new Input();
        $in_search->setAttribute('type','search');
        $in_search->setAttribute('name','search');
        $in_search->setAttribute('placeholder','Recherche');
        $in_search->setAttribute('onkeyup',"find_stock(this.value)");
        $p_search->addElement($in_search);
        
        $hg_soc=new Hgroup();
        $f_left=new Fieldset('');
        $p_entr=new P();
        $l_entr=new Label('lab');
        $l_entr->addElement(new Text('Entreprise'));
        $in_entr=new Select();
        $in_entr->setAttribute('type','text');
        $in_entr->setAttribute('name','achat-soc');
        $in_entr->setAttribute('class','entr-cmd');
        $in_entr->setAttribute('required','');
        foreach (SocieteQuery::create()->orderBySociete('ASC')->find() as $s) {
            
            $opt=new Option();
            $opt->setAttribute('value', $s->getID());
            $opt->addElement(new Text($s->getSociete()));
            if(isset($soc) && $soc->equals($s)){
                $opt->setAttribute('selected', '');
            }
            $in_entr->addElement($opt);
        }
        /*
        if(isset($soc)){
            $in_entr->setAttribute('value', $soc->getSociete());
        }
        */
        $p_entr->addElements(array($l_entr,$in_entr));
        
        $p_con=new P();
        $l_con=new Label('lab');
        $l_con->addElement(new Text('Contact'));
        $in_con=new Input();
        $in_con->setAttribute('class','con-cmd');
        $in_con->setAttribute('type','text');
        $in_con->setAttribute('name','achat-cont');
        if(isset($cont1)){
            $in_con->setAttribute('value',$cont1->getNom());
        }
        $p_con->addElements(array($l_con,$in_con));
        
        $p_tel=new P();
        $l_tel=new Label('lab');
        $l_tel->addElement(new Text('Tel du Contact 1'));
        $in_tel=new Input();
        $in_tel->setAttribute('class','tel-cmd');
        $in_tel->setAttribute('type','text');
        $in_tel->setAttribute('name','achat-tel');
        if(isset($cont1)){
            $in_tel->setAttribute('value', $cont1->getTelephone());
         }
        $p_tel->addElements(array($l_tel,$in_tel));
        
        $p_mail=new P();
        $l_mail=new Label('lab');
        $l_mail->addElement(new Text('Mail'));
        $in_mail=new Input();
        $in_mail->setAttribute('class','mail-cmd');
        $in_mail->setAttribute('type','mail');
        $in_mail->setAttribute('name','achat-mail');
        if(isset($cont1)){
            $in_mail->setAttribute('value', $cont1->getMail());
        }
        $p_mail->addElements(array($l_mail,$in_mail));
        $f_left->addElements(Array($p_entr,$p_con,$p_br,$p_tel,$p_mail));
        
        //----- Contact  2-----
        $p_tel_2=new P();
        $l_tel_2=new Label('lab');
        $l_tel_2->addElement(new Text('Tel du Contact 2'));
        $in_tel_2=new Input();
        $in_tel_2->setAttribute('class','tel-cmd');
        $in_tel_2->setAttribute('type','text');
        $in_tel_2->setAttribute('name','achat-tel');
        if(isset($cont2)){
            $in_tel_2->setAttribute('value', $cont2->getTelephone());
         }
        $p_tel_2->addElements(array($l_tel_2,$in_tel_2));
        
        $p_mail_2=new P();
        $l_mail_2=new Label('lab');
        $l_mail_2->addElement(new Text('Mail'));
        $in_mail_2=new Input();
        $in_mail_2->setAttribute('class','mail-cmd');
        $in_mail_2->setAttribute('type','mail');
        $in_mail_2->setAttribute('name','achat-mail');
        if(isset($cont2)){
            $in_mail_2->setAttribute('value', $cont2->getMail());
        }
        $p_mail_2->addElements(array($l_mail_2,$in_mail_2));
        
        //----- Contact  3-------
        $p_tel_3=new P();
        $l_tel_3=new Label('lab');
        $l_tel_3->addElement(new Text('Tel du Contact 3'));
        $in_tel_3=new Input();
        $in_tel_3->setAttribute('class','tel-cmd');
        $in_tel_3->setAttribute('type','text');
        $in_tel_3->setAttribute('name','achat-tel');
        if(isset($cont3)){
            $in_tel_3->setAttribute('value', $cont3->getTelephone());
         }
        $p_tel_3->addElements(array($l_tel_3,$in_tel_3));
        
        $p_mail_3=new P();
        $l_mail_3=new Label('lab');
        $l_mail_3->addElement(new Text('Mail'));
        $in_mail_3=new Input();
        $in_mail_3->setAttribute('class','mail-cmd');
        $in_mail_3->setAttribute('type','mail');
        $in_mail_3->setAttribute('name','achat-mail');
        if(isset($cont3)){
            $in_mail_3->setAttribute('value', $cont3->getMail());
        }
        $p_mail_3->addElements(array($l_mail_3,$in_mail_3));
        
        $f_right=new Fieldset('');
        $f_right->addElements(Array($p_tel_2,$p_mail_2,$p_br,$p_tel_3,$p_mail_3));
        $hg_soc->addElements(Array($f_left,$f_right));
        
        //-- Liste des res commande passées par la société ---
        $tab=new Table(); 
        $tr_title=new Tr();
        $th1=new Th();
        $th1->addElement(new Text('N°Référence'));
        $th2=new Th();
        $th2->addElement(new Text('Date de la demande'));
        $th3=new Th();
        $th3->addElement(new Text('Offres'));
        $th4=new Th();
        $th4->addElement(new Text('Opérations'));
        $tr_title->addElements(array($th1,$th2,$th3,$th4));
        
        $thead=new Thead();
        $thead->addElement($tr_title);
        
        $tbody=new Tbody();
        $tbody->setAttribute('id', 'list-stock');
        if(isset($soc)){
            foreach (CommandeQuery::create()->filterBySociete($soc)->find() as $cmd) {
                $tr=new Tr();
                $tr->setAttribute('class','init');
                $td1=new Td();$td2=new Td();$td3=new Td();$td4=new Td();
                $td1->addElement(new A(new Text($cmd->getRFCommande()),'?rub=liste&s-rub=fiche-par-groupe-de-pieces&ref='.$cmd->getIDCommande()));
                $td2->addElement(new A(new Text($cmd->getDTECommande('d/m/y')),'?rub=liste&s-rub=fiche-par-groupe-de-pieces&ref='.$cmd->getIDCommande()));
            
                //--- On verifie si cette commande possède des pièces rentrées ---
                $pce_cmd=CMDPieceQuery::create()->filterByCommande($cmd)->count();
            
                $chbx=new Input();
                $chbx->setAttribute('type', 'checkbox');
                $chbx->setAttribute('value', '');
                if($pce_cmd>0){
                    $chbx->setAttribute('checked', '');
                }
                $td3->addElement($chbx);
            
                $push=new Input();
                $push->setAttribute('type', 'button');
                $push->setAttribute('value', 'Archiver');
                $push->setAttribute('class', 'add-archive');
                $push->setAttribute('id', $cmd->getIDCommande());
            
                $del=new Input();
                $del->setAttribute('type', 'button');
                $del->setAttribute('value', 'supprimer');
                $del->setAttribute('class', 'del-cmd');
                $del->setAttribute('id', $cmd->getIDCommande());
                $td4->addElements(Array($push,$del));
            
                $tr->addElements(array($td1,$td2,$td3,$td4));
                $tbody->addElement($tr);
            }
        }
        $tab->addElements(array($thead,$tbody));
        
        $hg_tab=new Hgroup();
        $hg_tab->addElement($tab);
        
        $titre=new H1();
        $titre->addElement(new Text('Fiche pièce par société'));
        
        $this->form->addElements(Array($titre,$hg_soc,$hg_tab));
    }
}
