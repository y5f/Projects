<?php


class PieceTemplate {
    private $div;
    public static $n=0;
     
    function __construct($vendeur=NULL,$pce=NULL) {
     $this->div=new Hgroup();
     $this->div->setAttribute('class','piece-temp fr');
     
     if($vendeur){
        //$vendeur=new COMVendeur();
        
        $fournisseur=$vendeur->getFournisseur();
        //$vendeur=COMVendeurQuery::create()->filterByFournisseur($fournisseur)->findOne();
            self::$n++;
            
            $lab=new Label($vendeur->getIDVendeur());
            $lab->setAttribute('class','sup-vte');
            $lab->setAttribute('title','Supprimer');
            $lab->addElement(new Text('X'));
            
            $updt_img=new Img('upload/edit.png');
            $updt_img->setAttribute('class', 'updt-img');
            $updt_img->setAttribute('title', 'Modifer');
            $updt_img->setAttribute('id', self::$n);
            $updt_img->setAttribute('value', $fournisseur->getID().'^'.$vendeur->getCommande()->getIDCommande());
            $p_bu=new P();
            $p_bu->addElements(Array($lab,$updt_img));
            
            $this->div->addElements(Array($p_bu));
            $soc=$fournisseur->getSociete();
     }
     else{
         $this->div->setAttribute('class','piece-temp fr0');
     }
        // $piece=new Piece();
           
        $sel_soc=new Select();
        $sel_soc->setAttribute('required','');
        
        $opt_soc=new Option();
        $opt_def=new Option();
        $opt_def->setAttribute('disabled','');
        $opt_def->addElement(new Text('Entreprise'));
        foreach (SocieteQuery::create()->orderBySociete('ASC')->find() as $el){
            $opt_soc=new Option();
            $opt_soc->setAttribute('value', $el->getID());
            $opt_soc->addElement(new Text($el->getSociete()));
            if(isset($soc) && ($soc->equals($el))){
                $opt_soc->setAttribute('selected', '');
            }
            $sel_soc->addElement($opt_soc);
        }
        if(!isset($soc)){
            $sel_soc->setAttribute('name', 'soc-name');
            $sel_soc->setAttribute('class', 'sel-soc load-app f-soc');
        }else{
            $sel_soc->setAttribute('class','id-pce-'.self::$n.' piece-form-'.self::$n);
        }
        
        $p_soc=new P();
        $l_soc=new Label('lab');
        $l_soc->addElement(new Text('Société :'));
        $p_soc->addElements(array($l_soc,$sel_soc));
                   
        $p_cont=new P();
        $lab_cont=new Label('lab');
        $lab_cont->addElement(new Text(('Contact :')));
        $in_cont=new Input();
        $in_cont->setAttribute('type','text');
        $in_cont->setAttribute('class','cont');
        if(isset($soc)){
            $cont=ContactQuery::create()->filterBySociete($soc)->filterByOrdre(1)->findOne();
            if($cont){
                $in_cont->setAttribute('value',$cont->getNom());
            }
        }else{
            $in_cont->setAttribute('name','soc-contact');
            $in_cont->setAttribute('class','cont f-cont');
        }
        $p_cont->addElements(array($lab_cont,$in_cont));
        
        $p_mail=new P();
        $lab_mail=new Label('lab');
        $lab_mail->addElement(new Text(('Mail :')));
        $in_mail=new Input();
        $in_mail->setAttribute('type','text');
        $in_mail->setAttribute('class','mail');
         if(isset($cont)){
            $in_mail->setAttribute('value',$cont->getMail());
         }else{
            $in_mail->setAttribute('name','soc-mail');
            $in_mail->setAttribute('class','mail f-mail');
         }
        $p_mail->addElements(array($lab_mail,$in_mail));  
        
        $p_ref=new P();
        $lab_ref=new Label('lab');
        $lab_ref->addElement(new Text(('N°série :')));
        $in_ref=new Input();
        $in_ref->setAttribute('type','text');
        $in_ref->setAttribute('list','p-liste');
        if(isset($fournisseur)){
            $in_ref->setAttribute('value',$fournisseur->getPiece()->getReference());
            $in_ref->setAttribute('class','piece-form-'.self::$n );
        }else{
            $in_ref->setAttribute('name','piece-serie');
            $in_ref->setAttribute('class','ref-piece f-ref-piece');
        }
        $datalist=new Datalist();
        $datalist->setAttribute('id', 'p-liste');
        foreach (PieceQuery::create()->find() as $p) {
            $opt=new Option();
            $opt->addElement(new Text($p->getReference()));
            $datalist->addElement($opt);
        }
        $p_ref->addElements(array($lab_ref,$in_ref,$datalist));
        
        $p_pn=new P();
        $lab_pn=new Label('lab');
        $lab_pn->addElement(new Text(('PN :')));
        $in_pn=new Input();
        $in_pn->setAttribute('type','text');
        //$in_pn->setAttribute('disabled','');
        if(isset($fournisseur)){
            $in_pn->setAttribute('class','piece-form-'.self::$n);
            $in_pn->setAttribute('value',$fournisseur->getPiece()->getPN());
        }elseif(isset($pce)){
            $in_pn->setAttribute('name','piece-ref');
            $in_pn->setAttribute('class','pn-piece f-pn-piece');
            $in_pn->setAttribute('value',$pce->getPN());
        }else{
           $in_pn->setAttribute('name','piece-ref'); 
           $in_pn->setAttribute('class','pn-piece f-pn-piece');
        }
        $p_pn->addElements(array($lab_pn,$in_pn));
        
        $p_pn_alt=new P();
        $lab_pn_alt=new Label('lab');
        $lab_pn_alt->addElement(new Text(('Alt PN:')));
        $in_pn_alt=new Input();
        $in_pn_alt->setAttribute('type','text');
        if(isset($fournisseur)){
            $in_pn_alt->setAttribute('class','piece-form-'.self::$n);
          $in_pn_alt->setAttribute('value',$fournisseur->getPiece()->getAltPN());
        }else{
            $in_pn_alt->setAttribute('name','piece-alt');
            $in_pn_alt->setAttribute('class','pn-alt-piece f-pn-alt-piece');
        }
        $p_pn_alt->addElements(array($lab_pn_alt,$in_pn_alt));
        
       /* $p_ref_cmd=new P();
        $lab_ref_cmd=new Label('lab');
        $lab_ref_cmd->addElement(new Text(('N° de commande:')));
        $in_ref_cmd=new Input();
        $in_ref_cmd->setAttribute('type','text');
        $in_ref_cmd->setAttribute('class','ref-cmd');
        $p_ref_cmd->addElements(array($lab_ref_cmd,$in_ref_cmd));
       */ 
        $p_ot=new P();
        $lab_ot=new Label('lab');
        $lab_ot->addElement(new Text(('OTAN :')));
        $in_ot=new Input();
        $in_ot->setAttribute('type','text');
         if(isset($fournisseur)){
             $in_ot->setAttribute('class','piece-form-'.self::$n);
          $in_ot->setAttribute('value',$fournisseur->getPiece()->getOtan());
        }else{
          $in_ot->setAttribute('name','piece-otan');
          $in_ot->setAttribute('class','ot-piece f-ot-piece');
        }
        $p_ot->addElements(array($lab_ot,$in_ot));
        
        $sel_cond=new Select();
        //$sel_cond->setAttribute('placeholder','Condition');
        $sel_cond->setAttribute('required','');
        
        if(!isset($fournisseur)){
            $sel_cond->setAttribute('name', 'piece-cond');
            $sel_cond->setAttribute('class','sel-cond f-sel-cond');
        }else{
            $sel_cond->setAttribute('class','piece-form-'.self::$n);
        }
        $opt_rp_def=new Option();
        $opt_rp_def->addElement(new Text('Condition'));
        $sel_cond->addElement($opt_rp_def);
        $cond=ConditionQuery::create()->find();
        foreach ($cond as $el){
            $op=new Option();
            $op->addElement(new Text($el->getCondition()));
            if(isset($fournisseur) && $fournisseur->getCondition()){
                if($fournisseur->getCondition()->equals($el)){
                    $op->setAttribute('selected', '');
                }
            }
            $sel_cond->addElement($op);
        }
        
        $p_cond=new P();
        $l_cond=new Label('lab');
        $p_cond->addElements(array($sel_cond));
        
        $div_doc=new Div();
        if(isset($fournisseur) && $fournisseur){
            $div_doc->setAttribute('value', $fournisseur->getID());
            $div_doc->setAttribute('class','doc');
            $div_doc->setAttribute('name', 'pp');
        }
        $im_doc=new Img('upload/folder.png');
        $div_doc->addElement($im_doc);
        $lab_doc=new Label('lab');
        $lab_doc->addElement(new Text('Documents'));
        $div_doc->addElement($lab_doc);
        
        $sel_trans=new Select();
        $opt_tr_def=new Option();
        $opt_tr_def->addElement(new Text('Transport'));
        $sel_trans->addElement($opt_tr_def);
        
        $transport= MTransportQuery::create()->find();
        foreach ($transport as $el){
            $opt=new Option();
            $opt->addElement(new Text($el->getMTransport()));
            if(isset($fournisseur) && $fournisseur->getMTransport()){
                if($fournisseur->getMTransport()->equals($el)){
                    $opt->setAttribute('selected', '');
                }
            }
            $sel_trans->addElement($opt);
        }
        if(!isset($fournisseur)){
            $sel_trans->setAttribute('name', 'piece-trans');
            $sel_trans->setAttribute('class','sel-trans f-sel-trans');
        }else{
            $sel_trans->setAttribute('class','piece-form-'.self::$n);
        }
        $p_trans=new P();
        $p_trans->addElements(array($sel_trans));
        
        $in_quant=new Input();
        $in_quant->setAttribute('type','number');
        $in_quant->setAttribute('required','');
        $in_quant->setAttribute('placeholder','Quantité');
        if(isset($fournisseur)){
            $in_quant->setAttribute('class','piece-form-'.self::$n);
            $in_quant->setAttribute('value',$fournisseur->getQuantite());
        }else{
            $in_quant->setAttribute('name', 'piece-qte');
            $in_quant->setAttribute('class','quant-piece f-quant-piece');
        }
        $p_qu=new P();
        $l_qu=new Label('lab');
        $l_qu->addElement(new Text('Quantité'));
        $p_qu->addElements(array($in_quant));
        
        $div_ph=new Div();
        if(isset($fournisseur) && $fournisseur){
            $div_ph->setAttribute('value', $fournisseur->getID());
            $div_ph->setAttribute('class','photo');
        }
        $im_ph=new Img('upload/folder.png');
        $div_ph->addElement($im_ph);
        $lab_ph=new Label('lab');
        $lab_ph->addElement(new Text('Photos'));
        $div_ph->addElement($lab_ph);
        
        $date=new Input();
        $date->setAttribute('class','maj-piece');
        $date->setAttribute('type','date');
        if(isset($fournisseur)){
            $date->setAttribute('value',$fournisseur->getDTESave('Y-m-d'));
        }else{
            $date->setAttribute('name', 'piece-maj');
            $date->setAttribute('class','maj-piece f-maj-piece');
        }
        $p_date=new P();
        $p_date->addElements(array($date));
        
        $p_prix=new P();
        $lab_prix=new Label('lab');
        $lab_prix->addElement(new Text(('Prix :')));
        $in_prix=new Input();
        $in_prix->setAttribute('type','double');
        $in_prix->setAttribute('required','');
        $in_prix->setAttribute('placeholder','Prix');
        if(isset($fournisseur)){
            $in_prix->setAttribute('class','piece-form-'.self::$n);
            $in_prix->setAttribute('value',$fournisseur->getPrixachat());
        }else{
            $in_prix->setAttribute('name','piece-prix');
            $in_prix->setAttribute('class','prix-piece f-prix-piece');
        }
        $p_prix->addElements(array($in_prix));
        
        $p_del=new P();
        $lab_del=new Label('lab');
        $lab_del->addElement(new Text(('Délai :')));
        $in_del=new Select();
        $def_opt=new Option();
        $def_opt->addElement(new Text('Délai'));
        $def_opt_1=new Option();
        $def_opt_1->addElement(new Text('stock'));
        if(isset($fournisseur)){
            $def_opt_1->setAttribute('selected', '');
        }
        $in_del->addElements(Array($def_opt,$def_opt_1));
        $in_del->setAttribute('type','number');
        $in_del->setAttribute('placeholder','Délai');
        for($i=1;$i<100;$i++){
            $opt=new Option();
            $opt->addElement(new Text($i));
            if(isset($fournisseur)){
                if($fournisseur->getDelai()==$i){
                    $opt->setAttribute('selected', '');
                }
            }
            $in_del->addElement($opt);
        }
        //$in_del->setAttribute('required','');
        $in_del->setAttribute('placeholder','Délai');
        if(isset($fournisseur)){
           $in_del->setAttribute('class','piece-form-'.self::$n);
        }else{
           $in_del->setAttribute('name','piece-delai');
           $in_del->setAttribute('class','del-piece f-del-piece');
        }
        $p_del->addElements(array($in_del));
        
        $sel_type=new Select();
        //$sel_type->setAttribute('placeholder','Condition');
        $sel_type->setAttribute('required','');
        
        if(!isset($fournisseur)){
            $sel_type->setAttribute('name', 'piece-type');
            $sel_type->setAttribute('class','sel-cond f-sel-type');
        }else{
            $sel_type->setAttribute('class','piece-form-'.self::$n);
        }
        $opt_type_def=new Option();
        $opt_type_def->addElement(new Text('Type de pièce'));
        $sel_type->addElement($opt_type_def);
        foreach (TypepieceQuery::create()->find() as $tp) {
            $opt=new Option();
            $opt->addElement(new Text($tp->getType()));
            if(isset($fournisseur) && $fournisseur->getPiece()->getTypepiece()){
                if($fournisseur->getPiece()->getTypepiece()->equals($tp)){
                    $opt->setAttribute('selected', '');
                }
            }
            $sel_type->addElement($opt);
        }
        $p_type=new P();
        $p_type->addElement($sel_type);
        
        $sel_fab=new Select();
        //$sel_fab->setAttribute('placeholder','Fabricant');
        $sel_fab->setAttribute('required','');
        
        if(!isset($fournisseur)){
            $sel_fab->setAttribute('name', 'piece-fab');
            $sel_fab->setAttribute('class','sel-cond f-sel-fab');
        }else{
            $sel_fab->setAttribute('class','piece-form-'.self::$n);
        }
        $opt_fab_def=new Option();
        $opt_fab_def->addElement(new Text('Fabricant'));
        $sel_fab->addElement($opt_fab_def);
        foreach (MarqueQuery::create()->find() as $fb) {
            $opt=new Option();
            $opt->addElement(new Text($fb->getMarque()));
            if(isset($fournisseur) && $fournisseur){
                if($fournisseur->getSociete()->getMarque()){
                    if($fournisseur->getSociete()->getMarque()->equals($fb)){
                        $opt->setAttribute('selected', '');
                    }
                }
            }
            $sel_fab->addElement($opt);
        }
        $p_fab=new P();
        $p_fab->addElement($sel_fab);
        
        $sel_app=new Select();
        //$sel_app->setAttribute('placeholder','Appareil');
        $sel_app->setAttribute('required','');
        
        if(!isset($fournisseur)){
            $sel_app->setAttribute('name', 'piece-app');
            $sel_app->setAttribute('class','sel-app-load f-sel-app');
        }else{
            $sel_app->setAttribute('class','piece-form-'.self::$n);
        }
        $opt_app_def=new Option();
        $opt_app_def->addElement(new Text('Appareils'));
        $sel_app->addElement($opt_app_def);
        foreach (AppareilQuery::create()->find() as $ap) {
            $opt=new Option();
            $opt->setAttribute('value', $ap->getIdAp());
            $opt->addElement(new Text($ap->getNomApp()));
            if(isset($vendeur) && $vendeur){
                
                if($vendeur->getPiece()){
                    $app=PieceAppQuery::create()->filterByPiece($vendeur->getPiece())->findOne();
                    if($app){
                        if($app->getAppareil()->equals($ap)){
                            $opt->setAttribute('selected', '');
                        }
                    }
                }           
            }
            $sel_app->addElement($opt);
        }
        $p_app=new P();
        $p_app->addElement($sel_app);
    
     $hg1=new Hgroup();
     $hg1->setAttribute('class','left');
     $div_left=new Div();
     $div_left->addElements(Array($p_soc,$p_cont,$p_mail));
     $div_rig=new Div();
     $div_rig->addElements(Array($p_pn,$p_pn_alt,$p_ot,$p_ref));
     $hg1->addElements(array($div_left,$div_rig));
     
     $hg2=new Hgroup();
     $hg2->setAttribute('class','right');
     
     $p_plus=new P();
     $e_plus=new Em();
     $e_plus->addElement(new Text('Plus'));
     $e_plus->setAttribute('class', 'add-plus');
     $e_plus->setAttribute('name', self::$n);
     $p_plus->addElement(new A($e_plus,'#'));
     
     $p_note=new P();
     $e_note=new Em();
     $e_note->addElement(new Text('Note'));
     $e_note->setAttribute('class', 'add-note');
     if($vendeur){
         $e_note->setAttribute('value', $vendeur->getIDVendeur());
     }
     
     $p_note->addElement(new A($e_note,'#'));
     
     $hg2->addElements(array($p_cond,$p_qu,$p_prix,$div_doc,$div_ph,$p_del,$p_trans,$p_type,$p_app,$p_date));
     if($vendeur!=NULL){
         $hg2->addElements(Array($p_plus,$p_note));
     }
    
    $this->div->addElements(array($hg1,$hg2));
    }
    function getModel(){
        return $this->div;
    }
    
}
