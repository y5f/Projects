<?php

class FicheForm extends Template{
    function __construct() {
        parent::__construct(new Form());
        $this->form->setAttribute('class','piece-page');
        $this->form->setAttribute('action','scripts/script.php');
        $this->form->setAttribute('method','post');
        $this->form->setAttribute('id','piece-form');
        
        $p_titre=new P();
        $titre=new H1();
        $titre->addElement(new Text('Fiche pièce par pièce'));
        $img=new Img('upload/edit.png');
        $img->setAttribute('id', 'updt-cmd');
        $p_titre->addElements(Array($titre,$img));
        $this->form->addElements(Array($titre,$img));
        
        $cmd_pc=NULL;
        if(isset($_GET['ref'])){
            $ref=$_GET['ref'];
            //$cmd=CommandeQuery::create()->filterByIDCommande($ref)->find();
            $cmd_one=CommandeQuery::create()->filterByIDCommande($ref)->findOne();
            if(isset($cmd_one)){
                $soc=$cmd_one->getSociete();
                if(isset($_GET['pce'])){
                    $cmd_pc=CMDPieceQuery::create()->filterByIDPiece($_GET['pce'])->filterByCommande($cmd_one)->findOne();
                    //--- On recupère l'utilisaeur finale ----
                    if($cmd_pc){
                        $enduser=COMEnduserQuery::create()->filterByCommande($cmd_one)->filterByPiece($cmd_pc->getPiece())->findOne();
                        //print_r($enduser);
                    }
                }else{
                    $cmd_pc=CMDPieceQuery::create()->filterByCommande($cmd_one)->findOne();
                }
                
                
                
                $ref_zone=new Input();
                $ref_zone->setAttribute('type', 'hidden');
                $ref_zone->setAttribute('name', 'num-cmd');
                $ref_zone->setAttribute('class', 'num-cmd form');
                $ref_zone->setAttribute('value', $cmd_one->getIDCommande());
                $ref_pce=new Input();
                $ref_pce->setAttribute('type', 'hidden');
                $ref_pce->setAttribute('class', 'num-pce form');
                if($cmd_pc){
                    $ref_pce->setAttribute('name', 'num-pce');
                    $ref_pce->setAttribute('value', $cmd_pc->getIDPiece());
                }
                
                $this->form->addElements(Array($ref_zone,$ref_pce));
            }
            
        }
        $p_ref=new P();
        $l_ref=new Label('lab');
        $in_ref=new Input();
        $in_ref->setAttribute('class','ref-cmd form');
        //$in_ref->setAttribute('required','');
        $in_ref->setAttribute('type','text');
        $in_ref->setAttribute('name','achat-ref');
        $in_ref->setAttribute('placeholder','Référence');
        if(isset($cmd_one)){
            $in_ref->setAttribute('value',$cmd_one->getRFCommande());
        }
        
        $p_ref->addElements(array($l_ref,$in_ref));
        
        $p_entr=new P();
        $l_entr=new Label('lab');
        $l_entr->addElement(new Text('Entreprise'));
        $in_entr=new Select();
        $in_entr->setAttribute('type','text');
        $in_entr->setAttribute('name','achat-soc');
        $in_entr->setAttribute('class','pc-cmd form');
        //$in_entr->setAttribute('required','');
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
        if(isset($cmd_one)){
            $in_dt->setAttribute('value',$cmd_one->getDTECommande()->format('Y-m-d'));
        }
        $p_dt->addElements(array($l_dt,$in_dt));
        
        $p_del=new P();
        $l_del=new Label('lab');
        $l_del->addElement(new Text('Délai'));
        $in_del=new Input();
        $in_del->setAttribute('class','delai-cmd form');
        $in_del->setAttribute('value','0');
        $in_del->setAttribute('type','text');
        $in_del->setAttribute('name','achat-delai');
        if(isset($cmd_pc)){
            $in_del->setAttribute('value',$cmd_pc->getADelai());
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
        if($cmd_pc){
            $in_prix->setAttribute('value',$cmd_pc->getCPrix());
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
        if(isset($cmd_pc)){
            $in_qt->setAttribute('value',$cmd_pc->getQuantite());
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
        
        if(isset($cmd_pc) && $cmd_pc){
            $app_cmd=CMDTAppareilQuery::create()->filterByPiece($cmd_pc->getPiece())->filterByCommande($cmd_one)->findOne();
        }
        $p_app=new P();
        $in_app=new Input();
        $in_app->setAttribute('class','app-cmd form');
        $in_app->setAttribute('type','text');
        $in_app->setAttribute('type','text');
        $in_app->setAttribute('name','app-pce');
        $in_app->setAttribute('list','list-app');
        if(isset($app_cmd) && $app_cmd){
            $in_app->setAttribute('value', $app_cmd->getAppareil()->getNomApp());
        }else{
            $in_app->setAttribute('placeholder','Appareil');
        }
        $list_app=new Datalist();
        $list_app->setAttribute('id', 'list-app');
        foreach (AppareilQuery::create()->find() as $app) {
            $opt=new Option();
            $opt->setAttribute('value', $app->getNomApp());
            //$opt->addElement(new Text($app->getNomApp()));
            $list_app->addElement($opt);
        }
        $p_app->addElements(Array($in_app,$list_app));
        
        $p_imm=new P();
        $l_imm=new Label('lab');
        $l_imm->addElement(new Text('Immatriculation '));
        $in_imm=new Input();
        $in_imm->setAttribute('class','app-imm form');
        $in_imm->setAttribute('type','text');
        $in_imm->setAttribute('type','text');
        $in_imm->setAttribute('name','app-imm');
        if(isset($app_cmd) && $app_cmd){
            $in_imm->setAttribute('value', $app_cmd->getAppareil()->getImmatriculation());
        }
        $p_imm->addElements(Array($l_imm,$in_imm));
        
        $p_clt=new P();
        $l_clt=new Label('lab');
        //$l_clt->addElement(new Text('PN_Client '));
        $in_clt=new Input();
        $in_clt->setAttribute('class','pn_clt form');
        $in_clt->setAttribute('type','hidden');
        //$in_clt->setAttribute('type','text');
        $in_clt->setAttribute('name','pn-clt');
        if(isset($cmd_pc) && $cmd_pc){
            $in_clt->setAttribute('value', $cmd_pc->getPNClient());
        }
        $p_clt->addElements(Array($l_clt,$in_clt));
        
        $p_pce=new P();
        $l_pce=new Label('lab');
        $l_pce->addElement(new Text('PN_Client '));
        $in_pce=new Input();
        $in_pce->setAttribute('class','pn-pce form');
        $in_pce->setAttribute('type','text');
        $in_pce->setAttribute('required','');
        $in_pce->setAttribute('list','pce-list');
        $in_pce->setAttribute('name','pn-pce');
        if(isset($cmd_pc) && $cmd_pc){
            $in_pce->setAttribute('value', $cmd_pc->getPiece()->getPN());
        }
        
        $list_pce=new Datalist();
        $list_pce->setAttribute('id', 'pce-list');
        foreach (PieceQuery::create()->find() as $pce) {
            $opt=new Option();
            $opt->setAttribute('value', $pce->getPN());
            $list_pce->addElement($opt);
        }
        
        $p_pce->addElements(Array($l_pce,$in_pce,$list_pce));
        
        $left= new Hgroup();
        $left->setAttribute('class','left-cmd');
        $left->addElements(array($p_ref,$p_entr,$p_con,$p_tel,$p_mail,$p_dt));
        
        $right= new Hgroup();
        $right->setAttribute('class','right-cmd');
        $right->addElements(array($p_del,$p_prix,$p_qt,$p_li,$p_eu,$p_app,$p_imm,$p_clt,$p_pce));
        
        $hg_cond=new Hgroup();
        $hg_cond->setAttribute('class', 'hg-cond');
        $f_set_cond=new Fieldset('Conditions');
        $ul_cond=new Ul();
        foreach (ConditionQuery::create()->find() as $cd) {
            $chbx=new Input();
            $chbx->setAttribute('type', 'checkbox');
            $chbx->setAttribute('class', 'cmd-cond');
            if((isset($cmd_one) && $cmd_one) && (isset($cmd_pc) && $cmd_pc)){
                $chbx->setAttribute('value', $cmd_one->getIDCommande().'^'.$cd->getCondition().'^'.$cmd_pc->getIDPiece());
                $cmd_cond=COMConditionQuery::create()->filterByCondition($cd)->filterByCommande($cmd_one)->filterByPiece($cmd_pc->getPiece())->findOne();
                if($cmd_cond){
                    $chbx->setAttribute('checked', '');
                }
            }
            $em=new Em();
            $em->addElement(new Text($cd->getCondition()));
            $li=new Li($chbx, '');
            $li->addElement($em);
            $ul_cond->addLi($li);
        }
        $f_set_cond->addElement($ul_cond);
        
        $f_note=new Fieldset('Note');
        $txt=new Textarea();
        $txt->setAttribute('class', 'note-piece');
        $txt->setAttribute('name', 'note-piece');
        $txt->setAttribute('class', 'note-piece form');
        if(isset($cmd_pc) && $cmd_pc){
            $txt->addElement(new Text(trim($cmd_pc->getPCENote())));
        }
        $f_note->addElement($txt);
        $hg_cond->addElements(Array($f_set_cond,$f_note));
        
        $hg_acht=new Hgroup();
        $hg_acht->setAttribute('class','acheteur');
        $hg_acht->addElements(array($left,$right,$hg_cond));
        $this->form->addElement($hg_acht);
        $i=0;
        if(isset($cmd_one)){
            if($cmd_pc){
                //print_r($cmd_pc);
                $nbr_vte=COMVendeurQuery::create()->filterByCommande($cmd_one)->filterByPiece($cmd_pc->getPiece())->count();
                foreach (COMVendeurQuery::create()->filterByCommande($cmd_one)->filterByPiece($cmd_pc->getPiece())->find() as $vte){
                    $disp_pp=new PieceTemplate($vte);
                    $this->form->addElement($disp_pp->getModel());
                    $i++;
                }
                if($nbr_vte<1){
                    $this->getNewForm($cmd_pc);
                }
            }
        }
    }
    function getNewForm($cmd_pc=NULL) {
         // Ajout d'une nouvelle Piece //
                $arg=null;
                $temp=new PieceTemplate($arg,$cmd_pc->getPiece());
                $this->form->addElement($temp->getModel());
                
                $p_add=new P();
                $l_add=new Label('');
                $l_add->addElement(new Text('Nouvelle offre'));
                $add=new Input();
                $add->setAttribute('class','add-piece');
                $add->setAttribute('name','add-piece');
                $add->setAttribute('type','submit');
                $add->setAttribute('value','+'); 
                $p_add->addElements(Array($add,$l_add));
                $this->form->addElement($p_add);
    }
}
