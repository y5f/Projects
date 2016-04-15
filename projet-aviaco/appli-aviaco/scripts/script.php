<?php

//----- Classe de chargement  ---------
require_once '../vendor/autoload.php';
require_once '../generator/generated-conf/config.php';
$host=$_SERVER['HTTP_HOST'];
$control_redondence_certificat=[];
if(isset($_POST['menu-details'])){
    $rub=$_POST['menu-details'];
    
    //---- On fait la recherche dans Rubrique secondaires ---//
    $rub_prins=RubriqueQuery::create()->filterByURL($rub)->findOne();
    $str=0;
    if($rub_prins){
        foreach ($rub_prins->getRubriquesecondaires() as $rub_sec) {
            $str.=$rub_sec->getID().'@'.$rub_sec->getRubriqueCol().'@'.$rub_sec->getURL().'#';
        }
    }
    echo $str;
}
if(isset($_POST['itp'])){
    $rp=$_POST['itp'];
    
    $objet=new Accueil();
    if($rp==='societe'){
        $objet=new Filtre();
    }
    if($rp==='new-part'){
        $objet=new Helicocontact();
    }
    $objet->getForm();
}
//################### SCRIPT TRAITANT LA SAVE DES INFOS SOCIETE --//
//##################################################################
if(isset($_POST['save-infos'])){
    
    //--- On verifie si le pays saisi n'est pas déjà enregistré ---
    $isPays=MPaysQuery::create()->filterByPays('%'.$_POST['pays'].'%')->findOne();

    if($isPays){
        $pays=$isPays;
    }else{
        $pays=new MPays();
        $pays->setPays($_POST['pays']);
        $pays->save();
    }
    //--- On crée un objet societé --//
    $societe=new Societe();
    $societe->setSociete($_POST['ep-name']);
    $societe->setDirigeant($_POST['nom-dir']);
    $societe->setTelephone($_POST['phone']);
    $societe->setFax($_POST['fax']);
    $societe->setEmail($_POST['email']);
    $societe->setWebsite($_POST['websit']);
    $societe->setAdresses($_POST['adresse']);
    $societe->setCP($_POST['cp']);
    $societe->setVille($_POST['ville']);
    if($pays){
        $societe->setMPays($pays);
    }
    $societe->setNotes($_POST['note-soc']);
    $societe->setLogo($_POST['img-src']);
    $societe->setisFraude($_POST['f-zone']);
    $societe->setDateMAJSOC(date('Y-m-d G:i:s'));
    $societe->setDte_MAJACT(date('Y-m-d G:i:s'));
    $societe->setisACTIF(TRUE);
    $isOk=$societe->save(); 
    
    header('Location: http://appli-aviaco.org/?rub=new-part&soc='.$societe->getID());
    
}
if(isset($_POST['updt-infos'])){
    
    //--- On verifie si le pays saisi n'est pas déjà enregistré ---
    $isPays=MPaysQuery::create()->filterByPays('%'.$_POST['pays'].'%')->findOne();

    if($isPays){
        $pays=$isPays;
    }else{
        $pays=new MPays();
        $pays->setPays($_POST['pays']);
        $pays->save();
    }
    //--- On crée un objet societé --//
    $societe=SocieteQuery::create()->filterByID($_POST['num-soc'])->findOne();
    $societe->setSociete($_POST['ep-name']);
    $societe->setDirigeant($_POST['nom-dir']);
    $societe->setTelephone($_POST['phone']);
    $societe->setFax($_POST['fax']);
    $societe->setEmail($_POST['email']);
    $societe->setWebsite($_POST['websit']);
    $societe->setAdresses($_POST['adresse']);
    $societe->setCP($_POST['cp']);
    $societe->setVille($_POST['ville']);
    if($pays){
        $societe->setMPays($pays);
    }
    $societe->setNotes($_POST['note-soc']);
    $societe->setLogo($_POST['img-src']);
    $societe->setisFraude($_POST['f-zone']);
    $societe->setDateMAJSOC(date('Y-m-d G:i:s'));
    $societe->setDte_MAJACT(date('Y-m-d G:i:s'));
    $isOk=$societe->save(); 
    
    header('Location: http://appli-aviaco.org/?rub=new-part&soc='.$societe->getID());
    
}
if(isset($_POST['save-hist'])){
    
    $data=explode('#', $_POST['save-hist']);
    
    //--- On recupère la société ----
    $societe=SocieteQuery::create()->filterByID($data[0])->findOne();
    if($societe){
        //print_r($data);
        //--- On supprime les relation Societé-historique qui existe pour cette soc---
        SocietehistoriqueQuery::create()->filterBySociete($societe)->find()->delete();
    
        for($i=1;$i<count($data);$i++){
        
            //--- On recupère l'Historique en cours ---
            $hist=HistoriqueQuery::create()->filterByHistorique($data[$i])->findOne();
        
            $relation=new Societehistorique();
            $relation->setSociete_PK($societe->getSociete());
            $relation->setHistorique_PK($hist->getHistorique());
            $relation->save();
        }
    
        //header('Location: http://appli-aviaco.org/?rub=new-part&soc='.$societe->getID());
    }
    
}
if(isset($_POST['fraude-form'])){
    $form=new PlainteForm();
    $form->getForm();
}
if(isset($_POST['save-fraude'])){
    $data=explode('#', $_POST['save-fraude']);
    
    //--- On recupère la société ----
    $societe=SocieteQuery::create()->filterByID($data[0])->findOne();
    if($societe){
        $societe->setisFraude($data[1]);
        $societe->save();
        
        if($societe->getisFraude()){
            //-- On recupère la relation societe -fraude et on la supprime --
            $alert=SPartenaireQuery::create()->filterBySFraude($societe->getID())->findOne();
            if($alert){
                $alert->delete();
            }
        }
    }
}
if(isset($_POST['add-fraude'])){
    $data=explode('^', $_POST['add-fraude']);
    
    //-- On verifie si cette alerte existe deja : on netye --> une societé ne  ---
    //-------------- peut pas etre signalé deux fois -----------------------------
    $al=SPartenaireQuery::create()->filterBySFraude($data[0])->findOne();
    if($al){
        $al->delete();
    }
    $alert=new SPartenaire();
    $alert->setSFraude($data[0]);
    if($data[1]==='part'){
        $alert->setPPlaigante($data[2]);
    }else{
        $alert->setSPlaigante($data[2]);
    }
    $alert->setDatePlainte(date('Y-m-d G:i:s'));
    $alert->setPlaignat($data[3]);
    echo $alert->save();
}
if(isset($_POST['save-logo'])){
    $data=explode('#', $_POST['save-logo']);
    //--- On recupère la société ----
    $societe=SocieteQuery::create()->filterByID($data[0])->findOne();
    if($societe){
        $societe->setLogo($data[1]);
        $societe->save();
    }
}
if(isset($_POST['search-fraude'])){
    $val='%'.$_POST['search-fraude'].'%';
    $clause=Propel\Runtime\ActiveQuery\Criteria::LOGICAL_OR;
    $soc=SocieteQuery::create()->condition('c1', 'societe.societe LIKE ?',$val)
            ->condition('c2', 'societe.dirigeant LIKE ?',$val)->condition('c3', 'societe.cp LIKE ?',$val)
            ->condition('c4', 'societe.ville LIKE ?',$val)->condition('c5', 'societe.pays LIKE ?',$val)
            ->where(array('c1','c2','c3','c4','c5'), $clause)->find();
    $str='';
    foreach ($soc as $s) {
    
    //--- On verifie si cette société est signalée frauduleuse ---
    $sp=SPartenaireQuery::create()->filterBySocFraude($s)->findOne();
    if($sp){
        $tr=new Tr();
        $tr->setAttribute('class','init');
        $td1=new Td();$td2=new Td();$td3=new Td();$td4=new Td();$td5=new Td();$td6=new Td();$td7=new Td();$td8=new Td();$td9=new Td();$td10=new Td();
        $td1->addElement(new Text($sp->getSocFraude()->getSociete()));
        $td2->addElement(new Text($sp->getSocFraude()->getDateMAJSOC()->format('H:i:s')));
        $td3->addElement(new Text($sp->getSocFraude()->getDirigeant()));
        $td4->addElement(new Text($sp->getSocFraude()->getTelephone()));
        $td5->addElement(new Text($sp->getSocFraude()->getEmail()));
        $td6->addElement(new Text($sp->getSocFraude()->getWebsite()));
           
            if($sp->getPPlaigante()!==NULL){
                $td7->addElement(new Text($sp->getPartenaire()->getPartenaire()));
                $td9->addElement(new Text($sp->getPartenaire()->getmail()));
                $td10->addElement(new Text(''));
            }else{
                $td7->addElement(new Text($sp->getSocPlaignant()->getSociete()));
                $td9->addElement(new Text($sp->getSocPlaignant()->getEmail()));
                $td10->addElement(new Text($sp->getSocPlaignant()->getWebsite()));
            }
            $td8->addElement(new Text($sp->getPlaignat()));
            $tr->addElements(array($td1,$td2,$td3,$td4,$td5,$td6,$td7,$td8,$td9,$td10));
            $str.=$tr->toHTML();
        }
    }
    echo $str;
}
if(isset($_POST['save-cont'])){
    if(isset($_POST['ep-name'])){
        $societe=SocieteQuery::create()->filterBySociete($_POST['ep-name'])->findOne();
    }
    if($societe){
        $name_1=$_POST['cont-name-1'];
        $font_1=$_POST['cont-fonc-1'];
        $tel_1=$_POST['cont-tel-1'];
        $mail_1=$_POST['cont-mail-1'];
        $note_1=$_POST['cont-note-1'];
    
        $name_2=$_POST['cont-name-2'];
        $font_2=$_POST['cont-fonc-2'];
        $tel_2=$_POST['cont-tel-2'];
        $mail_2=$_POST['cont-mail-2'];
        $note_2=$_POST['cont-note-2'];
    
        $name_3=$_POST['cont-name-3'];
        $font_3=$_POST['cont-fonc-3'];
        $tel_3=$_POST['cont-tel-3'];
        $mail_3=$_POST['cont-mail-3'];
        $note_3=$_POST['cont-note-3'];
    
        //-- on crée l'objet contact --//
    
        //-- Contact -1- //
        //--- On teste si ce contact n'existe pas deja dans la base ---//
        $cont_1=ContactQuery::create()->filterBySociete($societe)->filterByOrdre(1)->findOne();
        if(!$cont_1){
            $cont_1=new Contact();
            $cont_1->setNom($name_1);
            $cont_1->setFonction($font_1);
            $cont_1->setTelephone($tel_1);
            $cont_1->setMail($mail_1);
            $cont_1->setNote($note_1);
            $cont_1->setsociete_FK($_POST['ep-name']);
            $cont_1->setOrdre(1);
            $cont_1->save();
        }else{
            $cont_1->setNom($name_1);
            $cont_1->setFonction($font_1);
            $cont_1->setTelephone($tel_1);
            $cont_1->setMail($mail_1);
            $cont_1->setNote($note_1);
            $cont_1->save();
        }  
        
        if($name_2!=='' && $tel_2!=='' && $mail_2!==''){
            //--- On teste si ce contact n'existe pas deja dans la base ---//
            $cont_2=ContactQuery::create()->filterBySociete($societe)->filterByOrdre(2)->findOne();
            if(!$cont_2){
                $cont_2=new Contact();
                $cont_2->setNom($name_2);
                $cont_2->setFonction($font_2);
                $cont_2->setTelephone($tel_2);
                $cont_2->setMail($mail_2);
                $cont_2->setNote($note_2);
                $cont_2->setsociete_FK($_POST['ep-name']);
                $cont_2->setOrdre(2);
                $cont_2->save();
            }else{
                $cont_2->setNom($name_2);
                $cont_2->setFonction($font_2);
                $cont_2->setTelephone($tel_2);
                $cont_2->setMail($mail_2);
                $cont_2->setNote($note_2);
                $cont_2->save();
            }
        }
        if($name_3!=='' && $tel_3!=='' && $mail_3!==''){
            //--- On teste si ce contact n'existe pas deja dans la base ---//
            $cont_3=ContactQuery::create()->filterBySociete($societe)->filterByOrdre(3)->findOne();
            if(!$cont_3){
                $cont_3=new Contact();
                $cont_3->setNom($name_3);
                $cont_3->setFonction($font_3);
                $cont_3->setTelephone($tel_3);
                $cont_3->setMail($mail_3);
                $cont_3->setNote($note_3);
                $cont_3->setsociete_FK($_POST['ep-name']);
                $cont_3->setOrdre(3);
                $cont_3->save();
            }else{
                $cont_3->setNom($name_3);
                $cont_3->setFonction($font_3);
                $cont_3->setTelephone($tel_3);
                $cont_3->setMail($mail_3);
                $cont_3->setNote($note_3);
                $cont_3->save();
            }
        }
        header('Location: http://appli-aviaco.org/?rub=new-part&soc='.$societe->getID());
    }else{
        header('Location: http://appli-aviaco.org/?rub=new-part');
    }
    
}

//########################SCRIPT TRAITANT LES ACTIVITES#########################
//##############################################################################
if(isset($_POST['save-metier'])){
    $data=explode(',',$_POST['save-metier']);
    //---- On netoie ce qui existait dejà -----
    $soc=SocieteQuery::create()->filterByID($data[0])->findOne();
    if($soc){
        foreach ($soc->getSocietemetiers() as $rel) {
            $rel->delete();
        }
    
        //-- On met la date ajour --//
        $soc->setDte_MAJACT(date('Y-m-d'));
        $soc->save();
        
        //--- On re-ecrit les nouvelles relations --//
        for ($i=1;$i<count($data);$i++) {
            $soc_metier=new Societemetier();
            $soc_metier->setMetier_PK($data[$i]);
            $soc_metier->setSociete_PK($soc->getSociete());
            $soc_metier->save();
        }
    }
}
if(isset($_POST['save-tp'])){
    $data=explode(',',$_POST['save-tp']);
    //---- On netoie ce qui existait dejà -----
    $soc=SocieteQuery::create()->filterByID($data[0])->findOne();
    if($soc){
        foreach ($soc->getSocietetypepieces() as $rel) {
            $rel->delete();
        }
    
        //-- On met la date ajour --//
        $soc->setDte_MAJACT(date('Y-m-d'));
        $soc->save();
        
        //--- On re-ecrit les nouvelles relations --//
        for ($i=1;$i<count($data);$i++) {
            $soc_tp=new Societetypepiece();
            $soc_tp->setType_PK($data[$i]);
            $soc_tp->setSociete_PK($soc->getSociete());
            $soc_tp->save();
        }
    }
}
if(isset($_POST['save-stk'])){
    $data=explode(',',$_POST['save-stk']);
    //---- On netoie ce qui existait dejà -----
    $soc=SocieteQuery::create()->filterByID($data[0])->findOne();
    if($soc){
        foreach ($soc->getSocieteappareils() as $rel) {
            if(!$rel->getisFlotte()){
                $rel->delete();
            }
        }
    
        //-- On met la date ajour --//
        $soc->setDte_MAJACT(date('Y-m-d'));
        $soc->save();
    
        //--- On re-ecrit les nouvelles relations --//
        for ($i=1;$i<count($data);$i++) {
        
            if(!SocieteappareilQuery::create()->filterBySociete($soc)->filterByIdAppareil_FK($data[$i])->exists()){
                $soc_app=new Societeappareil();
                $soc_app->setIdAppareil_FK($data[$i]);
                $soc_app->setSociete_FK($soc->getSociete());
                $soc_app->setisFlotte(FALSE);
                echo $soc_app->save();
            }
        }
    }
}
if(isset($_POST['save-flotte'])){
    $data=explode(',',$_POST['save-flotte']);
    //---- On netoie ce qui existait dejà -----
    $soc=SocieteQuery::create()->filterByID($data[0])->findOne();
    if($soc){
        foreach ($soc->getSocieteappareils() as $rel) {
            $rel->setisFlotte(FALSE);
            $rel->save();
        }
    
        //-- On met la date ajour --//
        $soc->setDte_MAJACT(date('Y-m-d'));
        $soc->save();
    
        //--- On re-ecrit les nouvelles relations --//
        for ($i=1;$i<count($data);$i++) {
            $soc_app=SocieteappareilQuery::create()->filterBySociete($soc)->filterByIdAppareil_FK($data[$i])->findOne();
            if($soc_app){
                $soc_app->setisFlotte(TRUE);
                echo $soc_app->save();
            }
        }
    }
}
if(isset($_POST['save-fbr'])){
    $data=explode(',',$_POST['save-fbr']);
    
    //---- On netoie ce qui existait dejà -----
    $soc=SocieteQuery::create()->filterByID($data[0])->findOne();
    if($soc){
        
        //--- On recupere le fabricant ---
        $fab=MarqueQuery::create()->filterByID($data[1])->findOne();
        //print_r($fab);
        if($fab){
            $soc->setMarque($fab);

            //-- On met la date ajour --//
            $soc->setDte_MAJACT(date('Y-m-d'));
            $soc->save();
        }
        
    }
}
if(isset($_POST['save-note'])){
    $data=explode('#',$_POST['save-note']);
    //---- On netoie ce qui existait dejà -----
    $soc=SocieteQuery::create()->filterByID($data[0])->findOne();
    $soc->setNotesactivite($data[1]);
    echo $soc->save();
}
if(isset($_POST['d-cert'])){
    $data=explode('#',$_POST['d-cert']);
    //print_r($data);
    //---- On netoie ce qui existait dejà -----
    $soc=SocieteQuery::create()->filterByID($data[0])->findOne();
    $cert=CertificatQuery::create()->filterByID($data[2])->findOne();
    if($soc && $cert){
        //--- On recupère la relation Societecetificat ---//
        SocietecertificatQuery::create()->filterBySociete($soc)->filterByCertificat($cert)->find()->delete();
        foreach ($cert->getAppareilcertificats() as $r) {
            if($data[1]!=='0'){
                
                $soc_cert=new Societecertificat();
                $soc_cert->setAgrement_PK($cert->getAgrement());
                $soc_cert->setsociete_PK($soc->getSociete());
                $soc_cert->setisMRO(FALSE);
                $soc_cert->setIdAppareil($r->getAppareil()->getIdAp());
                $soc_cert->save();
            }
        }
    
        //-- On met la date ajour --//
        $soc->setDte_MAJACT(date('Y-m-d'));
        $soc->save();
    }
}
if(isset($_POST['save-app-cert'])){
    
    $data=explode('#',$_POST['save-app-cert']);

    //--On recupère la relation société-certificat concernéee --//
    $soc_cert=SocietecertificatQuery::create()->filterByID($data[0])->findOne();
    
    if($soc_cert){
        $soc_cert->setisMRO($data[1]);
        $isOK=$soc_cert->save();
    }
    if($isOK){
        //-- On met la date ajour --//
        $soc->setDte_MAJACT(date('Y-m-d'));
        $soc->save();
    }
    
}
if(isset($_POST['save-mro'])){
    $data=explode('#', $_POST['save-mro']);
    
    //-- On recupère les sociétés concernées par les ID passés en param --//
    $soc=SocieteQuery::create()->filterByID($data[0])->findOne();
    $mro=SocieteQuery::create()->filterByID($data[1])->findOne();
    
    //--- On crée la relation societe-societe --//
    if($soc && $mro){
        $soc_soc=new MROCentre();
        $soc_soc->setSociete_FK($soc->getSociete());
        $soc_soc->setMRO($mro->getSociete());
        $isOK=$soc_soc->save();
    }
    
    if($isOK){
        //-- On met la date ajour --//
        $soc->setDte_MAJACT(date('Y-m-d'));
        $soc->save();
    }
}
if(isset($_POST['save-mro-cert'])){
    
    $data=explode('#',$_POST['save-mro-cert']);
    
    //--- on recupère la relation centre-mro dont l'ID est passée en param --//
    $mro_center=MROCentreQuery::create()->filterByID($data[0])->findOne();
    if($mro_center){
        $mro_center->setisACTIF($data[1]);
        $isOK=$mro_center->save();
    }
    
    if(isset($isOK)){
        //-- On met la date ajour --//
        $soc=$mro_center->getSociete();
        $soc->setDte_MAJACT(date('Y-m-d'));
        $soc->save();
    }
    echo $data[0];
}
if(isset($_POST['open-cert'])){
    $cert=new CertificatForm();
    echo $cert->getForm();
}
//####################### SCRIPT POUR LA CERTIFICATION #########################
//##############################################################################
if(isset($_POST['ids'])){

    $data=$_POST['ids'];
    $data_arr=explode('^',$data);
    //print_r($data_arr);
    
    //-- On verifie si ce certificat n'est pas deja enregistré --//
    $certificat=CertificatQuery::create()->filterByID($data_arr[0])->findOne();
    if($certificat){
        $certificat->setAgrement($data_arr[1]);
        $certificat->setWeb($data_arr[2]);
        $certificat->save();
        $is_ok=TRUE;
    }else{
        $certificat=new Certificat();
        $certificat->setAgrement($data_arr[1]);
        $certificat->setWeb($data_arr[2]);
        $is_ok=$certificat->save();
    }
    
    
    if($is_ok){
        //--- On fait le netoyage des appareils lié à ce certificat --
        AppareilcertificatQuery::create()->filterByCertificat($certificat)->find()->delete();
        for($i=3;$i<count($data_arr);$i++){
            $cert=new Appareilcertificat();
            $cert->setAgrement($certificat->getAgrement());
            $cert->setIdAppareil($data_arr[$i]);
            $cert->save();
        }
    }
}
if(isset($_POST['get-cert'])){
    $id=$_POST['get-cert'];
    $cert=CertificatQuery::create()->filterByID($id)->findOne();
    $str='';
    if($cert){
        $str=$cert->getID().'^'.$cert->getAgrement().'^'.$cert->getWeb();
        
        //---- On selectionne tous les appareils et on checke ceux appartenant à ce certificat --//
        $ap='';
        foreach (AppareilQuery::create()->find() as $app) {
            $input=new Input();
            $input->setAttribute('type','checkbox');
            //$input->setAttribute('name','ids['.$i.']');
            $input->setAttribute('class','ids');
            $input->setAttribute('value',$app->getIdAp());
            if(AppareilcertificatQuery::create()->filterByAppareil($app)->filterByCertificat($cert)->exists()){
                $input->setAttribute('checked', '');
            }
            $em=new Em();
            $em->addElements(Array($input,new Text($app->getNomApp())));
            $ap.=$em->toHTML();
        }
        $str.='#'.$ap;
    }
    echo $str;
}
if(isset($_POST['del-cert'])){
    $cert=CertificatQuery::create()->filterByID($_POST['del-cert'])->findOne();
    $str='';
    if($cert){
        $cert->delete();
        
        //--- On recupère la liste mise à jour ---
        $str='';
        foreach (CertificatQuery::create()->find() as $c) {
            $li=new Li(new Text($c->getAgrement()), 'item-cert');
            $li->setAttribute('value', $c->getID());
            $str.=$li->toHTML();
        }
    }
    echo $str;
}
//######################## SCRIPT TRAITANT LA SOCIETE:FINANCES ###########################
//###############################################################################

if(isset($_POST['save-fin'])){
    if(isset($_POST['ep-name'])){
        $societe=SocieteQuery::create()->filterBySociete($_POST['ep-name'])->findOne();
        
        
        $num_imm=$_POST['numimm'];
        $capital=$_POST['f-capital'];
        $form=$_POST['f-form'];
        $dte_create=$_POST['f-dte'];
        $note=$_POST['f-note'];
        
        if(isset($_POST['num-fin']) && $_POST['num-fin']!==''){
            //--- On fait la mise à jour des infos fincières --//
            $fin=FinanciereQuery::create()->filterByID($_POST['num-fin'])->findOne();
            $fin->setImmatricule($num_imm);
            $fin->setSociete($societe);
            $fin->setCapital($capital);
            $fin->setForm($form);
            $fin->setDtecreation($dte_create);
            $fin->setNotes($note);
            $fin->setDte_MAJ(date('Y-m-d'));
            $fin->save();
        }else{
            //-- On crée un objet Financière --//
            $fin=new Financiere();
            $fin->setImmatricule($num_imm);
            $fin->setSociete($societe);
            $fin->setCapital($capital);
            $fin->setForm($form);
            $fin->setDtecreation($dte_create);
            $fin->setNotes($note);
            $fin->setDte_MAJ(date('Y-m-d'));
            $fin->save();
        }
       header('Location: http://appli-aviaco.org/?rub=new-part&soc='.$societe->getID()); 
    }else{
        header('Location: http://appli-aviaco.org/?rub=new-part&soc');
    }
    
}
if(isset($_POST['add-ca'])){
    $url=$_POST['add-ca'];
    $ca=new ChiffreAffaire();
    echo $ca->getForm();
}
if(isset($_POST['new-ca'])){
    $arr=$_POST['new-ca'];
    
    $rows=explode('#',$arr);
    $societe=SocieteQuery::create()->filterByID(trim($rows[0]))->findOne();
    if($societe){
        $n_rows=count($rows)-1;
        for($i=1;$i<$n_rows;$i++){
            $col= explode('@',$rows[$i]);
            $insert_chiff=new Chiffredaffaire();
            $insert_chiff->setAnnee($col[0]);
            $insert_chiff->setChiffre($col[1]);
            $insert_chiff->setNbremployes($col[2]);
            $insert_chiff->setisFiliale($col[3]);
            $insert_chiff->setSociete($societe);
            $insert_chiff->save();
       
        }
        
        //--- On cherche l'infos financiere concernée et modifie la date --//
        $fin=FinanciereQuery::create()->filterBySociete($societe)->findOne();
        if(!$fin){
            $fin=new Financiere();
            $fin->setSociete($societe);
            $fin->setDtecreation(date('Y-m-d'));
        }
        $fin->setDte_MAJ(date('Y-m-d'));
        $fin->save();
        
    }
    
}
if(isset($_POST['add-src-web'])){
    $soc=SocieteQuery::create()->filterByID($_POST['add-src-web'])->findOne();
    
    $src=new SrcWeb($soc);
    return $src->getForm();
}
if(isset($_POST['add-src'])){
    $data=explode('#',$_POST['add-src']);
    
    //--- la societé ssociée --//
    $societe=SocieteQuery::create()->filterByID(trim($data[0]))->findOne();
    if($societe){
        $scr=new Websource();
        $scr->setSociete($societe);
        $scr->setDescription($data[1]);
        $scr->setLienweb($data[2]);
        $scr->save();

         //--- On recupère la liste des source web restante --//
        $str='';
        foreach (WebsourceQuery::create()->filterBySociete($societe) as $el) {
            $pl=new P();
            $l_del=new Label('');
            $l_del->addElement(new Text('X'));
            $l_del->setAttribute('class', 'del-web');
            $l_del->setAttribute('value', $el->getID());
            $pl->addElements(Array(new A(new Text($el->getDescription()),$el->getLienweb()),$l_del));
            $li=new Li($pl,'');
            $str.=$li->toHTML();
        }
        
        //--- On cherche l'infos financiere concernée et modifie la date --//
        $fin=FinanciereQuery::create()->filterBySociete($societe)->findOne();
        if(!$fin){
            $fin=new Financiere();
            $fin->setSociete($societe);
            $fin->setDtecreation(date('Y-m-d'));
        }
        $fin->setDte_MAJ(date('Y-m-d'));
        $fin->save();
        
        echo $str;
    }
    
}
if(isset($_POST['del-web'])){
    $data=  explode('#',$_POST['del-web']);
    $src=WebsourceQuery::create()->filterByID($data[1])->findOne();
    $soc=SocieteQuery::create()->filterByID($data[0])->findOne();
    
    if($src){
        $src->delete();
    }
    
    $str='';
    if($soc){
         //--- On recupère la liste des source web restante --//
        foreach (WebsourceQuery::create()->filterBySociete($soc) as $el) {
            $pl=new P();
            $l_del=new Label('');
            $l_del->addElement(new Text('X'));
            $l_del->setAttribute('class', 'del-web');
            $l_del->setAttribute('value', $el->getID());
            $pl->addElements(Array(new A(new Text($el->getDescription()),$el->getLienweb()),$l_del));
            $li=new Li($pl,'');
            $str.=$li->toHTML();
        }
    
        //--- On cherche l'infos financiere concernée et modifie la date --//
        $fin=FinanciereQuery::create()->filterBySociete($soc)->findOne();
        if(!$fin){
            $fin=new Financiere();
            $fin->setSociete($soc);
            $fin->setDtecreation(date('Y-m-d'));
        }
        $fin->setDte_MAJ(date('Y-m-d'));
        $fin->save();
        
    }
    echo $str;
}
if(isset($_POST['add-rib-form'])){
    $id=$_POST['add-rib-form'];
    $rib=new SrcRIB($id);
    return $rib->getForm();
}
if(isset($_POST['but-rib'])){
    $id=$_POST['src-rib'];
    
    //----Societé ---//
    $soc=SocieteQuery::create()->filterByID($id)->findOne();
    
    //---- On recupère le fichier ---//
    $file=$_FILES['load-rib']['name'];
    
    if($soc && $file){
        
        $indx=new TBINDEX();
        $indx->save();
        
        $ext=  explode('.',$_FILES['load-rib']['name']);
        $to='upload/pdfFile/RIB'.$indx->getIndx().'.'.$ext[1];
        
        move_uploaded_file($_FILES['load-rib']['tmp_name'], '../'.$to);
        
        $soc->setSourceRIB($to);
        if($soc->save()){
            //--- On cherche l'infos financiere concernée et modifie la date --//
            $fin=FinanciereQuery::create()->filterBySociete($soc)->findOne();
            if(!$fin){
                $fin=new Financiere();
                $fin->setSociete($soc);
                $fin->setDtecreation(date('Y-m-d'));
            }
            $fin->setDte_MAJ(date('Y-m-d'));
            $fin->save();
        }
        
        header('Location: http://appli-aviaco.org/?rub=new-part&soc='.$soc->getID());
    }else{
        header('Location: http://appli-aviaco.org/?rub=new-part&soc');
    }
}
//########## SCRIPT TRAITANT LA LISTE DE PAYS #########################
//#####################################################################
if(isset($_POST['open-pays'])){
    $pays=new PaysForm();
    return $pays->getForm();
}
if(isset($_POST['add-pays'])){
    $pays=$_POST['add-pays'];
    
    $new_pays=new MPays();
    $new_pays->setPays($pays);
    $new_pays->save();
}
//####################### SCRIPT TRAITANT LA FENETRE RESULTATS ################
//#############################################################################

if(isset($_POST['search-soc'])){
    $data=explode('#', $_POST['search-soc']);
    //print_r($data);
    //--- On selection la societe selon le pays et le fablicat ---//
    if($data[0]!=='' && $data[1]!==''){
        $soc=SocieteQuery::create()->filterByPays($data[0])->filterByFabricant($data[1])->find();   
    }
    if($data[0]===''){
            $soc=SocieteQuery::create()->filterByFabricant($data[1])->find();
    }
    if($data[1]===''){
        $soc=SocieteQuery::create()->filterByPays($data[0])->find();
    }
    if($data[0]==='' && $data[1]===''){
        $soc=SocieteQuery::create()->find();
    }
    $societes=filterTable($soc,$data);
    $str='';
    foreach ($societes as $v) {
        $em=new Em();
        $em->setAttribute('class', 'item-ep');
        $em->setAttribute('value', $v->getID());
        $em->addElement(new Text($v->getSociete()));
        if($v->getisACTIF()){
            $class='act';
        }else{
            $class='desact';
        }
        $li=new Li(new A($em, '?rub=new-part&soc='.$v->getID()), $class);
        $str.=$li->toHTML();
    }
    //print_r($societes);
    echo $str;
}
if(isset($_POST['search-list'])){
    $ids=$_POST['search-list'];
    $result=new Resultat($ids);
    $result->getForm();
}
if(isset($_POST['op-soc'])){
    $ids=explode('^',$_POST['op-soc']);
    if(count($ids)>0){
        for ($i=1;$i<count($ids);$i++) {
            $soc=SocieteQuery::create()->filterByID($ids[$i])->findOne();
            if($ids[0]==='del'){
                $soc->delete();
            }
            if($ids[0]==='act'){
                $soc->setisACTIF(TRUE);
                $soc->save();
            }
            if($ids[0]==='desact'){
                $soc->setisACTIF(FALSE);
                $soc->save();
            }
        }
    }
    echo $_POST['op-soc'];
}

//##################### SCRIPT TRAITANT LA FENETRE ANNONCEURS #################
////###########################################################################
if(isset($_POST['add-annonceur'])){
    $temp=  explode('#', $_POST['add-annonceur']);
    $data=explode('^', $temp[0]);
    //print_r($data);
    //--- On verifie si la société annonceur existe deja ----
    $partenaire=PartenaireQuery::create()->filterByID($data[0])->findOne();
    if($partenaire){
        $partenaire->setPartenaire($data[2]);
        $partenaire->setLienweb($data[3]);
        $partenaire->setIDPartenaire($data[4]);
        $partenaire->setCode($data[5]);
        $partenaire->setmail($data[6]);
        if(isset($data[7])){
            $ann=AnnonceurQuery::create()->filterByPartenaire($partenaire)->findOne();
            if($ann){
                $ann->setisStock($data[7]);
                $ann->save();
            }
        }
        $partenaire->save();
        
        if(isset($temp[1]) && $temp[1]!==''){
            $data_cont=explode('^', $temp[1]);
            
            //--- On cherche l'entité finance-partenaire --
            $finance=FPartenaireQuery::create()->filterByPartenaire($partenaire)->findOne();
            if($finance){
                $finance->setNotes($data_cont[5]);
                $finance->setDateMAJ(date('Y-m-d G:i:s'));
                $finance->save();
            
                //--- on cherche le contact associé --
                $contact=ContactQuery::create()->filterByFPartenaire($finance)->findOne();
                if($contact){
                    $contact->setNom($data_cont[0]);
                    $contact->setFonction($data_cont[1]);
                    $contact->setTelephone($data_cont[2]);
                    $contact->setMail($data_cont[3]);
                    $contact->setNote($data_cont[4]);
                    $contact->save();
                }
            }
        }
    }else{
        //--- On verifie si le noù de cette société n'est pas deja enregistrée --
        $is_exist=PartenaireQuery::create()->filterByPartenaire($data[2])->exists();
        if(!$is_exist){
            $partenaire=new Partenaire();
            $partenaire->setPartenaire($data[2]);
            $partenaire->setLienweb($data[3]);
            $partenaire->setIDPartenaire($data[4]);
            $partenaire->setCode($data[5]);
            $partenaire->setmail($data[6]);
            $partenaire->setTypePart($data[1]);
            $ok=$partenaire->save();
            if(isset($data[7])){
                if($ok){
                    $ann=new Annonceur();
                    $ann->setIDPart($partenaire->getID());
                    $ann->setisStock($data[7]);
                    $ann->save();
                }
            }
            if(isset($temp[1]) && $temp[1]!==''){
                $data_cont=explode('^', $temp[1]);
                //--- on crée le contact associé au partenaire --
                //--- On verifie si le contact n'existe pas deja dans la base --
                //$contact=ContactQuery::create()->filterByNom($data_cont[0])->filterByMail($data_cont[3])->filterByTelephone($data_cont[2])->findOne();
                //if(!$contact){
                    $contact=new Contact();
                    $contact->setNom($data_cont[0]);
                    $contact->setFonction($data_cont[1]);
                    $contact->setTelephone($data_cont[2]);
                    $contact->setMail($data_cont[3]);
                    $contact->setNote($data_cont[4]);
                    $contact->save();
                //}
                if($contact){
                    //---- On crée l'entité finance-partenaire ---
                    $finance=new FPartenaire();
                    $finance->setIDContact($contact->getID());
                    $finance->setIDPart($partenaire->getID());
                    $finance->setNotes($data_cont[5]);
                    $finance->setisAbonnement(FALSE);
                    $finance->setDateMAJ(date('Y-m-d G:i:s'));
                    $finance->save();
                }
            }
        }
        
    }
    if($partenaire){
        if($data[1]==='base'){
            $rub='base-de-donnees-helicoptere';
        }elseif($data[1]==='finance'){
            $rub='informations-financieres';
        }else{
            $rub='annonceurs';
        }
        echo '?rub=informations&s-rub='.$rub.'&id='.$partenaire->getID();
    }
    
}
if(isset($_POST['del-annonceur'])){
    $id=$_POST['del-annonceur'];
    $part=PartenaireQuery::create()->filterByID($id)->findOne();
    if($part){
        echo $part->delete();
    }
}
if(isset($_POST['ch-type-infos'])){
    $data=explode('^', $_POST['ch-type-infos']);
    
    //--- On cherche le partenaire concerné ---
    $part=PartenaireQuery::create()->filterByID($data[0])->findOne();
    
    //--- On cherche l'infos de base concerné ---
    $type_infos=BaseInfosQuery::create()->filterByID($data[1])->findOne();
    
    if($type_infos && $part){
        //--- On cherche la relation entre les deux entités ---
        $relation=BPartenaireQuery::create()->filterByPartenaire($part)->filterByBaseInfos($type_infos)->findOne();
        
        //--Si la relation existe, on la modifie, sinon on crée une nouvelle ----
        if(!$relation){
            $relation=new BPartenaire();
            $relation->setBaseInfos($type_infos);
            $relation->setPartenaire($part);
            $relation->setisDisponible(TRUE);
            $relation->save();
        }else{
            $relation->setBaseInfos($type_infos);
            $relation->setPartenaire($part);
            $relation->setisDisponible(!$relation->getisDisponible());
            $relation->save();
        }
    }
}
if(isset($_POST['ch-abonnement'])){
    $id=$_POST['ch-abonnement'];
    //--- On verifie si la relatio existe --
    $fp=FPartenaireQuery::create()->filterByIDPart($id)->findOne();
    if($fp){
        $fp->setisAbonnement(!$fp->getisAbonnement());
        $fp->setDateMAJ(date('Y-m-d G:i:s'));
        $fp->save();
    }
}
if(isset($_POST['ch-pays'])){
    
    $data=explode('^',$_POST['ch-pays']);
    
    //-- On verifie si la relation existe --
    $fpp=IConcernePaysQuery::create()->filterByIDInfos($data[1])->filterByIDPays($data[0])->findOne();
    if($fpp){
        $fpp->delete();
    }else{
        $fpp=new IConcernePays();
        $fpp->setIDPays($data[0]);
        $fpp->setIDInfos($data[1]);
        $fpp->save();
    }
    
}
if(isset($_POST['search'])){
    $data=  explode('^', $_POST['search']);
    $motif='%'.$data[0].'%';
    $clause=Propel\Runtime\ActiveQuery\Criteria::LOGICAL_OR;
    $parts = PartenaireQuery::create()->filterByTypePart($data[1])->condition('c1','partenaire.partenaire LIKE ?', $motif)
            ->condition('c2','partenaire.id_part LIKE ?', $motif)
            ->condition('c3','partenaire.code LIKE ?', $motif)
            ->condition('c4','partenaire.mail LIKE ?', $motif)
            ->where(array('c1','c2','c3','c4'),$clause)->find();
    
    
    $str='';
    if($data[1]==='base'){
        $rub='base-de-donnees-helicoptere';
    }else{
        $rub='annonceurs';
    }
    if($parts){
        $tb=new Tbody();
        foreach ($parts as $p) {
            $tr_b=new Tr();
            $td=new Td();
            $td->addElement(new A(new Text($p->getPartenaire()), '?rub=informations&s-rub='.$rub.'&id='.$p->getID()));
            $tr_b->addElement($td);
            $tb->addElement($tr_b);
            $str.=$tb->toHTML();
        }
    } 
    echo $str;
}
//------------------ SCRIPT TRAITANT LES STOCKS --------------------//
if(isset($_POST['search-stock'])){
    $val='%'.$_POST['search-stock'].'%';
    $clause=Propel\Runtime\ActiveQuery\Criteria::LOGICAL_OR;
    $piece=PieceQuery::create()->condition('c1', 'piece.reference LIKE ?',$val)
            ->condition('c2', 'piece.type_FK LIKE ?',$val)->condition('c3', 'piece.description LIKE ?',$val)
            ->condition('c4', 'piece.pn LIKE ?',$val)->condition('c5', 'piece.alt_pn LIKE ?',$val)->condition('c6', 'piece.otan',$val)
            ->where(array('c1','c2','c3','c4','c5'), $clause)->find();
    $str='';
    foreach ($piece as $pc) {
        //-- On recupère la relation piece-societe --
        $piece_soc=FournisseurQuery::create()->filterByPiece($pc)->findOne();
        if(!$piece_soc){
            $pc->delete();
            continue;
        }
        //--- On recupère aussi la relation piece-appareil --
        $piece_app=PieceAppQuery::create()->filterByPiece($pc)->findOne();
        if(!$piece_app){
            $app='non spécifié';
            $mark='non spécifié';
        }else{
            $app=$piece_app->getAppareil()->getNomApp();
            $mark=$piece_app->getAppareil()->getMarque_PK();
        }
        //---On recupère le stock ---
        $stock=StockQuery::create()->filterByPiece($pc)->findOne();
        if($stock){
            $tr=new Tr();
            $tr->setAttribute('class','init');
            $td1=new Td();$td2=new Td();$td3=new Td();$td4=new Td();$td5=new Td();$td6=new Td();$td7=new Td();
            $td1->addElement(new Text($pc->getPN()));
            $td2->addElement(new Text($pc->getDescription()));
            $td3->addElement(new Text($pc->getAltPN()));
            $td4->addElement(new Text($piece_soc->getSociete()->getSociete()));
            $td5->addElement(new Text($stock->getDatedepart('d/m/y')));
            $td6->addElement(new Text($mark));
            $td7->addElement(new Text($app));
            $tr->addElements(array($td1,$td2,$td3,$td4,$td5,$td6,$td7));
            $str.=$tr->toHTML();
        }
            
    }
    echo $str;
}

//------------------ SCRIPT TRAITANT LA RECHERCHE PAPERBOARD --------------------//
if(isset($_POST['search-board'])){
    $val='%'.$_POST['search-board'].'%';
    $clause=Propel\Runtime\ActiveQuery\Criteria::LOGICAL_OR;
    $piece=PieceQuery::create()->condition('c1', 'piece.reference LIKE ?',$val)
            ->condition('c2', 'piece.type_FK LIKE ?',$val)->condition('c3', 'piece.description LIKE ?',$val)
            ->condition('c4', 'piece.pn LIKE ?',$val)->condition('c5', 'piece.alt_pn LIKE ?',$val)->condition('c6', 'piece.otan',$val)
            ->where(array('c1','c2','c3','c4','c5'), $clause)->find();

    $str='';
    
    if($_POST['search-board']===''){
        foreach(SocieteQuery::create()->find() as $pc){
            $nbr_cmd=CommandeQuery::create()->filterBySociete($pc)->count();
            if($nbr_cmd>0) {
                $cmde=CommandeQuery::create()->filterBySociete($pc)->find();
                $chbx=new Input();
                $chbx->setAttribute('type', 'checkbox');
                $chbx->setAttribute('value', '');
                foreach ($cmde as $c) {
                    if(CMDPieceQuery::create()->filterByCommande($c)->exists()){
                        $chbx->setAttribute('checked', '');
                    }
                }
                $tr=new Tr();
                $tr->setAttribute('class','init');
                $td1=new Td();$td2=new Td();$td3=new Td();
                $td1->addElement(new A(new Text($pc->getSociete()),'?rub=liste&s-rub=fiche-par-societe&soc='.$pc->getID()));
                $td2->addElement(new Text($nbr_cmd));
                $td3->addElement($chbx);
                $tr->addElements(array($td1,$td2,$td3));
                $str.=$tr->toHTML();
            }        
        }
    }else{
        foreach ($piece as $pc) {
            //-- On recupère la relation piece-societe -- 
            $piece_soc=FournisseurQuery::create()->filterByPiece($pc)->find();
            if(!$piece_soc){
                $pc->delete();
                continue;
            }
            foreach ($piece_soc as $frs) {
                //---- On verifie s'il ya eu une commande de cette pièce ----
                $vte_frs=COMVendeurQuery::create()->filterByFournisseur($frs)->findOne();
                if($vte_frs){
                    $cmd_pc=CMDPieceQuery::create()->filterByCommande($vte_frs->getCommande())->filterByPiece($vte_frs->getPiece())->findOne();
                    //-- Itération de contro; et de netoyage -----
                    if(!$cmd_pc){
                        $vte_frs->delete();
                        continue;
                    }
                    $nbr_cmd=CommandeQuery::create()->filterBySociete($cmd_pc->getCommande()->getSociete())->count();
                    $tr=new Tr();
                    $tr->setAttribute('class','init');
                    $td1=new Td();$td2=new Td();$td3=new Td();
                    $td1->addElement(new A(new Text($cmd_pc->getCommande()->getSociete()->getSociete()),'?rub=liste&s-rub=fiche-par-societe&soc='.$cmd_pc->getCommande()->getSociete()->getID()));
                    $td2->addElement(new Text($nbr_cmd));
                    $td3->addElement(new Text($cmd_pc->getCommande()->getRFCommande()));
                    $tr->addElements(array($td1,$td2,$td3));
                    $str.=$tr->toHTML();
                }
            }  
        }
        $cmd=CommandeQuery::create()->condition('c1', 'commande.reference LIKE ?',$val)
            ->condition('c2', 'commande.soc_id_FK LIKE ?',$val)
            ->where(array('c1','c2'), $clause)->find();
        foreach($cmd as $pc){
            $nbr_cmd=CommandeQuery::create()->filterBySociete($pc->getSociete())->count();
            $chbx=new Input();
            $chbx->setAttribute('type', 'checkbox');
            $chbx->setAttribute('value', '');
            if(CMDPieceQuery::create()->filterByCommande($pc)->exists()){
                $chbx->setAttribute('checked', '');
            }
            $tr=new Tr();
            $tr->setAttribute('class','init');
            $td1=new Td();$td2=new Td();$td3=new Td();
            $td1->addElement(new A(new Text($pc->getSociete()->getSociete()),'?rub=liste&s-rub=fiche-par-societe&soc='.$pc->getSociete()->getID()));
            $td2->addElement(new Text($nbr_cmd));
            $td3->addElement($chbx);
            $tr->addElements(array($td1,$td2,$td3));
            $str.=$tr->toHTML();
        }
        $soc=SocieteQuery::create()->condition('c1', 'societe.societe LIKE ?',$val)
            ->condition('c2', 'societe.dirigeant LIKE ?',$val)->condition('c3', 'societe.ville LIKE ?',$val)->condition('c4', 'societe.pays LIKE ?',$val)
            ->condition('c5', 'societe.cp LIKE ?',$val)->where(array('c1','c2','c3','c4','c5'), $clause)->find();
    
        foreach($soc as $pc){
            $nbr_cmd=CommandeQuery::create()->filterBySociete($pc)->count();
            if($nbr_cmd>0) {
                $cmde=CommandeQuery::create()->filterBySociete($pc)->find();
                $chbx=new Input();
                $chbx->setAttribute('type', 'checkbox');
                $chbx->setAttribute('value', '');
                foreach ($cmde as $c) {
                    if(CMDPieceQuery::create()->filterByCommande($c)->exists()){
                        $chbx->setAttribute('checked', '');
                    }
                }
                $tr=new Tr();
                $tr->setAttribute('class','init');
                $td1=new Td();$td2=new Td();$td3=new Td();
                $td1->addElement(new A(new Text($pc->getSociete()),'?rub=liste&s-rub=fiche-par-societe&soc='.$pc->getID()));
                $td2->addElement(new Text($nbr_cmd));
                $td3->addElement($chbx);
                $tr->addElements(array($td1,$td2,$td3));
                $str.=$tr->toHTML();
            }        
        }
    }
    
    echo $str;
}
if(isset($_POST['search-pn'])){
    $val='%'.$_POST['search-pn'].'%';
    $clause=Propel\Runtime\ActiveQuery\Criteria::LOGICAL_OR;
    $piece=PieceQuery::create()->condition('c1', 'piece.reference LIKE ?',$val)
            ->condition('c2', 'piece.type_FK LIKE ?',$val)->condition('c3', 'piece.description LIKE ?',$val)
            ->condition('c4', 'piece.pn LIKE ?',$val)->condition('c5', 'piece.alt_pn LIKE ?',$val)->condition('c6', 'piece.otan',$val)
            ->where(array('c1','c2','c3','c4','c5'), $clause)->find();
    $str='';
    //print_r($piece);
    foreach ($piece as $pce) {
        foreach (COMVendeurQuery::create()->filterByPiece($pce)->orderByIDVendeur('DESC')->find() as $each) {
            $tr=new Tr();
            $tr->setAttribute('class','init');
            $td1=new Td();$td2=new Td();$td3=new Td();
            $td1->addElement(new A(new Text($each->getPiece()->getPN()),'?rub=pn&paper&pce='.$each->getPiece()->getID()));
            $td2->addElement(new A(new Text($each->getPiece()->getAltPN()),'?rub=pn&paper&pce='.$each->getPiece()->getID()));
            $td3->addElement(new A(new Text($each->getFournisseur()->getSociete()->getSociete()),'?rub=new-part&soc='.$each->getFournisseur()->getSociete()->getID()));
            $tr->addElements(array($td1,$td2,$td3));
            $str.=$tr->toHTML();
        }
    }
    $societe=SocieteQuery::create()->orderBySociete('ASC')->condition('c1', 'societe.societe LIKE ?',$val)->condition('c2','societe.ville LIKE ?', $val)
            ->condition('c3','societe.pays LIKE ?', $val)->where(array('c1','c2','c3'),$clause)->find();
    foreach ($societe as $soc) {
        foreach (FournisseurQuery::create()->filterBySociete($soc)->find() as $frs) {
            foreach (COMVendeurQuery::create()->filterByFournisseur($frs)->find() as $each) {
            $tr=new Tr();
            $tr->setAttribute('class','init');
            $td1=new Td();$td2=new Td();$td3=new Td();
            $td1->addElement(new A(new Text($each->getPiece()->getPN()),'?rub=pn&paper&pce='.$each->getPiece()->getID()));
            $td2->addElement(new A(new Text($each->getPiece()->getAltPN()),'?rub=pn&paper&pce='.$each->getPiece()->getID()));
            $td3->addElement(new A(new Text($each->getFournisseur()->getSociete()->getSociete()),'?rub=new-part&soc='.$each->getFournisseur()->getSociete()->getID()));
            $tr->addElements(array($td1,$td2,$td3));
            $str.=$tr->toHTML();
        }
        }
    }
    
    echo $str;
}
//########## SCRIPT TRAITANT L4AJOUT DES APPAREILS #######################
//########################################################################
if(isset($_POST['mark'])){
       
       $mark=$_POST['mark'];
       $data='';
       $query=ModelQuery::create()->filterByMarque_FK($mark)->find();
       foreach ($query as $el){
           $op=new Option();
           $op->addElement(new Text($el->getModele()));
           $op->setAttribute('value',$el->getModele());
           $data.=$op->toHTML();
       }
      echo $data;
   }
if(isset($_POST['sel-app'])){
    $id=$_POST['sel-app'];
    $model=ModelQuery::create()->filterByModele($id)->findOne();
    $str='';
    if($model){
        foreach ($model->getAppareils() as $app) {
            $em=new Label('');
            $em->setAttribute('value', $app->getIdAp());
            $em->setAttribute('class', 'del-app');
            $em->addElement(new Text('X'));
            $li=new Li(new Text($app->getNomApp()), '');
            $li->addElement($em);
            $str.=$li->toHTML();
        }
    }
    echo $str;
}
if(isset($_POST['add-app'])){
    $data=  explode('^', $_POST['add-app']);
    
    //--- On recupère la marque ---
    $mark=MarqueQuery::create()->filterByMarque($data[0])->findOne();
    $model=ModelQuery::create()->filterByModele($data[1])->findOne();
    if($mark && $model){
        $appareil=new Appareil();
        $appareil->setImmatriculation($data[2]);
        $appareil->setNomApp($data[3]);
        $appareil->setMarque($mark);
        $appareil->setModele($model);
        $appareil->save();
    
        $app=new AppareilForm();
        $app->getForm();
    }
    
}
if(isset($_POST['mark-add'])){
    $mque=$_POST['mark-add'];
    $marque=new Marque();
    $marque->setMarque($mque);
    $marque->save();
    $new_mark=new MarqueForm();
    $new_mark->getForm();
}
if(isset($_POST['mark-add-m'])){
    $data=explode('^',$_POST['mark-add-m']);
    //-- On selctionne la marque associée ---
    $mq=MarqueQuery::create()->filterByID($data[0])->findOne();
    //--- On verifie si ce model n'est pas deja enregistré ---
    if(!ModelQuery::create()->filterByModele($data[1])->exists()){
        $model=new Model();
        $model->setMarque($mq);
        $model->setModele($data[1]);
        $model->save();
        $new_mark=new MarqueForm();
        $new_mark->getForm();
    }
}
if(isset($_POST['del-app'])){
    //--- On recupère l'appareil concernée ---
    $app=AppareilQuery::create()->filterByIdAp($_POST['del-app'])->findOne();
    if($app){
        $app->delete();
        $app=new AppareilForm();
        $app->getForm();
    }
}
if(isset($_POST['sel-model'])){
    $id=$_POST['sel-model'];
    $mark=MarqueQuery::create()->filterByID($id)->findOne();
    $str='';
    if($mark){
        foreach ($mark->getModeles() as $models) {
            $em=new Em();
            $em->setAttribute('value', $models->getID());
            $em->setAttribute('class', 'del-model');
            $em->addElement(new Text('X'));
            $li=new Li(new Text($models->getModele().$em->toHTML()), '');
            $str.=$li->toHTML();
        }
    }
    echo $str;
}
if(isset($_POST['del-fab'])){
    $id=$_POST['del-fab'];
    $mark=MarqueQuery::create()->filterByID($id)->findOne();
    if($mark){
        $mark->delete();
        $new_mark=new MarqueForm();
        $new_mark->getForm();
    }
    
}
if(isset($_POST['del-model'])){
    $id=$_POST['del-model'];
    $model=ModelQuery::create()->filterByID($id)->findOne();
    if($model){
        $model->delete();
        $new_mark=new MarqueForm();
        $new_mark->getForm();
    }
    
}
if(isset($_POST['open-app'])){
    $app=new AppareilForm();
    $app->getForm();
}
 if(isset($_POST['new-mark'])){
     $new_mark=new MarqueForm();
     $new_mark->getForm();
 }  
 
//################ SRIPTS TRAITANT LA GESTION PIECE/CMD ############################
if(isset($_POST['add-piece'])){
   
    //--- On crée d'abord la pièce -------
    $serie_piece=$_POST['piece-serie'];
    $pn_piece=$_POST['piece-ref'];
    $alt_piece=$_POST['piece-alt'];
    $otan_piece=$_POST['piece-otan'];
    $soc_piece=$_POST['soc-name'];
    $cond_piece=$_POST['piece-cond'];
    $qte_piece=$_POST['piece-qte'];
    $prix_piece=$_POST['piece-prix'];
    $delai_piece=$_POST['piece-delai'];
    $trans_piece=$_POST['piece-trans'];
    $type_piece=$_POST['piece-type'];
    $app_piece=$_POST['piece-app'];
    $maj_piece=$_POST['piece-maj'];
    
    if($type_piece==='Type de pièce'){
        $type=TypepieceQuery::create()->findOne();
        if($type){
            $type_piece=$type->getType();
        }else{
            $type_piece=NULL;
        }
    }
    if($app_piece==='Appareils'){
        $app_piece=NULL;
    }
    
    //---- Si le numéro de série de cette pièce est enregistré, on ne la met pas ___
    $piece=PieceQuery::create()->filterByPN('%'.trim($pn_piece).'%')->findOne();
    
    //---- On crée la relation fournisseur ----
    if($piece){
        if($app_piece){
            $ap=AppareilQuery::create()->filterByIdAp($app_piece)->findOne();
            if($ap){
                $pc_app=new PieceApp();
                $pc_app->setPiece($piece);
                $pc_app->setAppareil($ap);
                $pc_app->save();
            }
        }
        if($cond_piece==='Condition'){
            if(ConditionQuery::create()->findOne()){
                $cond_piece=ConditionQuery::create()->findOne()->getCondition();
            }else{
                $cond_piece=NULL;
            }
        }
        if($trans_piece==='Transport'){
            if(MTransportQuery::create()->findOne()){
                $trans_piece=  MTransportQuery::create()->findOne()->getMTransport();
            }else{
                $trans_piece=NULL;
            }
        }
        $fournisseur=new Fournisseur();
        $fournisseur->setQuantite($qte_piece);
        $fournisseur->setPrixachat($prix_piece);
        $fournisseur->setDTESave(date('Y-m-d G:i:s'));
        $fournisseur->setisProd(TRUE);
        $fournisseur->setDelai($delai_piece);
        $fournisseur->setIDPiece_PK($piece->getID());
        $fournisseur->setVCondition($cond_piece);
        $fournisseur->setTMode($trans_piece);
        $fournisseur->setIDSoc_FK($soc_piece);
        //echo $cond_piece;
        $fournisseur_ok=$fournisseur->save();
        
        //--- On crée le stock de cette pièce ----
        $stock=new Stock();
        $stock->setPiece($piece);
        $stock->setDatedepart(date('Y-m-d'));
        $stock->save();
    }

    if(isset($_POST['num-cmd'])){
        $acheteur=CommandeQuery::create()->filterByIDCommande($_POST['num-cmd'])->findOne();
    }
    if((isset($acheteur) && $acheteur)&& (isset($fournisseur_ok) && $fournisseur_ok)){
        //--- on verifie si cette commnde n'existe pas ____
        $cmd_piece=CMDPieceQuery::create()->filterByCommande($acheteur)->filterByPiece($fournisseur->getPiece())->findOne();
        if($cmd_piece){
            //--- On ajoute la société fournisseur parmi les vendeurs ----
            $trade=new COMVendeur();
            $trade->setCommande($acheteur);
            $trade->setPiece($piece);
            $trade->setFournisseur($fournisseur);
            $trade->setDTEProposition(date('Y-m-d G:i:s'));
            $trade->save();
        }
        header('Location: http://appli-aviaco.org/?rub=liste&s-rub=fiche-par-piece&pce='.$piece->getID().'&ref='.$acheteur->getIDCommande());
    }else{
        header('Location: http://appli-aviaco.org/?rub=liste&s-rub=fiche-par-piece');
    }   
}
//---------- Modification des informations d'une piece -------
if(isset($_POST['updt-piece'])){
    $data=explode('^', $_POST['updt-piece']);
    //print_r($data);
    //---- On recupère l'occurence fournisseur concerné par cette entréee ----
    $cmd=CommandeQuery::create()->filterByIDCommande($data[1])->findOne();
    $fournis=FournisseurQuery::create()->filterByID($data[0])->findOne();
    
    if($data[7]==='Condition'){
            if(ConditionQuery::create()->findOne()){
                $data[7]=ConditionQuery::create()->findOne()->getCondition();
            }else{
                $data[7]=NULL;
            }
    }
    if($data[11]==='Transport'){
            if(MTransportQuery::create()->findOne()){
                $data[11]=MTransportQuery::create()->findOne()->getMTransport();
            }else{
                $data[11]=NULL;
            }
    }
    if($fournis){
        $fournis->setQuantite($data[8]);
        $fournis->setPrixachat($data[9]);
        $fournis->setDTESave(date('Y-m-d G:i:s'));
        $fournis->setisProd(TRUE);
        $fournis->setDelai($data[10]);
        $fournis->setVCondition($data[7]);
        $fournis->setTMode($data[11]);
        //$fournis->setIDSoc_FK($data[3]);
        $fournis->save();
    }
    
    //----On modifie la pièce ----
    if($data[12]==='Type de pièce'){
        $type=TypepieceQuery::create()->findOne();
        if($type){
            $data[12]=$type->getType();
        }else{
            $data[12]=NULL;
        }
    }
    if($fournis && $fournis->getPiece()){
        $piece=$fournis->getPiece();
        $piece->setReference($data[6]);
        $piece->setPN($data[3]);
        $piece->setAltPN($data[4]);
        $piece->setOtan($data[5]);
        $piece->setType($data[12]);
        $piece->save();
    }
    
    //---- Si la société envoyé par la requete != de la société fournisseur; cequ'il s'agit d'une nouvelle
    // ---- relation fournisseur -------- et on l'ajoute dans la table des fournisseurs ----sion, il s'agit
    // --- d'une simple modification de certaines infos de la pièce ----
    if($fournis->getIDSoc_FK()!=trim($data[2])){        
        $fournis=new Fournisseur();
        $fournis->setQuantite($data[8]);
        $fournis->setPrixachat($data[9]);
        $fournis->setDTESave(date('Y-m-d G:i:s'));
        $fournis->setisProd(TRUE);
        $fournis->setDelai($data[10]);
        $fournis->setIDPiece_PK($piece->getID());
        $fournis->setVCondition($data[7]);
        $fournis->setTMode($data[11]);
        $fournis->setIDSoc_FK($data[2]);
        $fournis->save();
    }
    
    //---- On modifie également le type de pièce et l'appareill auquel la piece appartient ---
    //--- Si la combinaison piece/appareil existe, on la laisse, sion il s'agit d'une nouvelle
    // ---affectation d'une pièce à un appareil ------
    $appareil=AppareilQuery::create()->filterByIdAp($data[13])->findOne();
    if($appareil && (isset($piece) && $piece)){
        if(!PieceAppQuery::create()->filterByAppareil($appareil)->filterByPiece($piece)->exists()){
            $pc_app=new PieceApp();
            $pc_app->setPiece($piece);
            $pc_app->setAppareil($appareil);
            $isPcapp=$pc_app->save();   
        }
    }
    
    //--- On recupère l'element concerné par cette commande et ce fournisseur ---
    if($cmd && $fournis){
        $element=COMVendeurQuery::create()->filterByCommande($cmd)->filterByFournisseur($fournis)->findOne();
        if(!$element){
            $element=new COMVendeur();
        }
        $element->setFournisseur($fournis);
        $element->setCommande($cmd);    
        $element->setPiece($piece);
        $element->setDTEProposition(date('Y-m-d G:i:s'));
        $element->save();
    }
    
}
if(isset($_POST['del-piece'])){
    $data=explode('^', $_POST['del-piece']);
    $cmd=CommandeQuery::create()->filterByIDCommande($data[1])->findOne();
    if($cmd){
        //print_r($data);
        $piece=CMDPieceQuery::create()->filterByCommande($cmd)->filterByIDPiece($data[0])->findOne();
        if($piece){
            $piece->delete();
        }
    }
}
if(isset($_POST['plus-form'])){
    
    //-- On cerche la piece à passer en paramètre --
    $frs=FournisseurQuery::create()->filterByIDSoc_FK($_POST['plus-form'])->findOne();
    if($frs){
        $form=new MoreForm($frs);
        $form->getForm();
    }else{
        echo 'Aucune pièce sélectionnée, veillez enregistrer la pièce d\'abord';
    }
}
if(isset($_POST['add-more'])){
    $data=explode('^',$_POST['add-more']);
    //--- On recupère la pièce correspondant àa la valeur du premier element du tableau --
    $piece=FournisseurQuery::create()->filterByID($data[0])->findOne();
    if($piece){
        //-- On applique les modification à cette pièce ---
        $piece->setFABAnnee($data[1]);
        $piece->setTRestant($data[2]);
        $piece->setTTotal($data[3]);
        $piece->setDVie($data[4]);
        $piece->setOLDApp($data[5]);
        $piece->setNApp($data[6]);
        $piece->setNBROh($data[7]);
        $piece->save();
    }
}
if(isset($_POST['del-vte'])){
    $id=$_POST['del-vte'];
    $vte=COMVendeurQuery::create()->filterByIDVendeur($id)->findOne();
    if($vte){
        $vte->delete();
    }
}
if(isset($_POST['load-piece'])){
    $ref=$_POST['load-piece'];
    $str='';
    $piece=PieceQuery::create()->filterByReference('%'.$ref.'%')->findOne();
    
    if($piece){
        $fournisseur=FournisseurQuery::create()->filterByPiece($piece)->findOne();
        $pc_app=PieceAppQuery::create()->filterByPiece($piece)->findOne();
        $str=$piece->getReference().'^'.$piece->getPN().'^'.$piece->getAltPN().'^'
            .$piece->getOtan().'^'.$piece->getType();
    }
    if(isset($fournisseur) && $fournisseur){
        $contact=ContactQuery::create()->filterBySociete($fournisseur->getSociete())->findOne();
        $str.='^'.$fournisseur->getSociete()->getSociete().'^'
            .$fournisseur->getCondition()->getCondition().'^'.$fournisseur->getTMode().'^'
            .$fournisseur->getQuantite().'^'.$fournisseur->getPrixachat().'^'.$fournisseur->getDTESave('Y-m-d');
    }
    if(isset($contact) && $contact){
        $str.='^'.$contact->getNom().'^'.$contact->getMail();
    }
    if(isset($pc_app) && $pc_app){
        $str.='^'.$pc_app->getAppareil()->getIdAp().'^'.$pc_app->getAppareil()->getMarque_PK();
    }
    echo $str;
}
if(isset($_POST['add-cond'])){
    $data=explode('^', $_POST['add-cond']);
    $cmd=CommandeQuery::create()->filterByIDCommande($data[0])->findOne();
    $cond=COMConditionQuery::create()->filterByCommande($cmd)->filterByCondition_FK($data[1])->filterByIDPiece_FK($data[2])->findOne();
    if($cond){
        $cond->delete();
    }else{
        $cond=new COMCondition();
        $cond->setCommande($cmd);
        $cond->setCondition_FK($data[1]);
        $cond->setIDPiece_FK($data[2]);
        $cond->save();
    }
}
if(isset($_POST['updt-cmd'])){
    $data=explode('^',$_POST['updt-cmd']);
    //print_r($data);
    $p='';
    //--- On recupère la commande  concernér ---
    $cmd=CommandeQuery::create()->filterByIDCommande($data[0])->findOne();
    if($cmd){
        $soc=SocieteQuery::create()->filterByID($data[3])->findOne();
        if($soc){
            $cmd->setRFCommande($data[2]);
            $cmd->setSociete($soc);
            $cmd->save();
        }
        
        //--- On modifie la qté et le prix ----
        $cmd_pce=CMDPieceQuery::create()->filterByCommande($cmd)->filterByIDPiece($data[1])->findOne();
        //--- On recupère la pièce du champ au cas ou celle-ci serait modifiée ----
        $pce=PieceQuery::create()->filterByPN(trim($data[12]))->findOne();
        if($cmd_pce){
            if(!$cmd_pce->getPiece()->equals($pce)){
                $cmd_pce->delete();
                $cmd_pce=new CMDPiece();
                $cmd_pce->setCommande($cmd);
                $cmd_pce->setPiece($pce);
                $cmd_pce->save();
            }
        }else{
            $cmd_pce=new CMDPiece();
            $cmd_pce->setCommande($cmd);
            $cmd_pce->setPiece($pce);
            $cmd_pce->save();
        }
        
        if($cmd_pce){
            $cmd_pce->setADelai($data[4]);
            $cmd_pce->setCPrix($data[5]);
            $cmd_pce->setQuantite($data[6]);
            $cmd_pce->setPNClient($data[11]);
            $cmd_pce->setPCENote($data[13]);
            $cmd_pce->setDTEProposition(date('Y-m-d G:i:s'));
            $cmd_pce->save();
            $p='&pce='.$cmd_pce->getIDPiece();
        }
        
        //--- On modifie egaleùment l'appareil cité par le client ---
        $app_clt=CMDTAppareilQuery::create()->filterByCommande($cmd)->filterByIDPiece_FK($data[1])->findOne();
        if($app_clt){
            if($app_clt->getAppareil()->getNomApp()!==trim($data[9])){
                //print_r($app_clt);
                $app_clt->delete();
                $app_clt_1=AppareilQuery::create()->filterByNomApp($data[9])->findOne();
                $mark=MarqueQuery::create()->findOne();
                if($mark && (!$app_clt_1)){
                        $model=ModelQuery::create()->filterByModele('%'.$data[9].'%')->findOne();
                        if(!$model){
                            $model=new Model();
                            $model->setModele($data[9]);
                        }
                        $app_clt_1=new Appareil();
                        $app_clt_1->setNomApp($data[9]);
                        $app_clt_1->setModele($model);
                        $app_clt_1->setMarque($mark);
                        $app_clt_1->setImmatriculation($data[10]);
                        $app_clt_1->save();
                }
                if($app_clt_1){
                    $cmd_app=new CMDTAppareil();
                    $cmd_app->setCommande($cmd);
                    $cmd_app->setPiece($cmd_pce->getPiece());
                    $cmd_app->setAppareil($app_clt_1);
                    $cmd_app->save();
                }
            }else{
                $app_clt->getAppareil()->setImmatriculation($data[10]);
                $app_clt->getAppareil()->save();
                //$app_clt->setPiece($cmd_pce->getPiece());
                //$app_clt->save();
            }
        }else{
            //--- On créer la relation Appareil/piece pour cette commande ---
            //---- Ces references sont donnée par le vendeur ----
            if($data[9]!==''){
                $app_clt=AppareilQuery::create()->filterByNomApp('%'.$data[9].'%')->findOne();
                $mark=MarqueQuery::create()->findOne();
                if(!$app_clt){ // Si l'appareil n'existe pas, on le crée --
                    if($mark){
                        $model=ModelQuery::create()->filterByModele('%'.$data[9].'%')->findOne();
                        if(!$model){
                            $model=new Model();
                            $model->setModele($_POST['app-pce']);
                        }
                        $app_clt=new Appareil();
                        $app_clt->setNomApp($_POST['app-pce']);
                        $app_clt->setModele($model);
                        $app_clt->setMarque($mark);
                        $app_clt->setImmatriculation($_POST['app-imm']);
                        $app_clt->save();
                    } 
                }else{
                   //$app_clt->setImmatriculation($_POST['app-imm']); //-- On met la nvelle valeur de l'immatriculatio de l'appareil
                   //$app_clt->save();
                }
                if($app_clt){
                    $cmd_app=new CMDTAppareil();
                    $cmd_app->setCommande($cmd);
                    $cmd_app->setPiece($cmd_pce->getPiece());
                    $cmd_app->setAppareil($app_clt);
                    $cmd_app->save();
                }
            }
        }
            
        //---- On recupère le end-user concerné ---
        $endUsr=COMEnduserQuery::create()->filterByCommande($cmd)->filterByIDPiece_FK($data[1])->findOne();
        if($endUsr){
            $tab_end_usr=$endUsr->getEUser();
            //print_r($endUsr);
            if($tab_end_usr){
                $tab_end_usr->setEUAdresses($data[7]);
                $tab_end_usr->setUSERName($data[8]);
                $tab_end_usr->save();
            }
            $endUsr->setPiece($cmd_pce->getPiece());
            $endUsr->save();
        }else{
            $tab_end_usr=new EUser();
            $tab_end_usr->setEUAdresses($data[7]);
            $tab_end_usr->setUSERName($data[8]);
            $tab_end_usr->save();
            
            $cmd_end_usr=new COMEnduser();
            $cmd_end_usr->setCommande($cmd);
            $cmd_end_usr->setEUser($tab_end_usr);
            $cmd_end_usr->setPiece($cmd_pce->getPiece());
            $cmd_end_usr->save();
        }
        echo '?rub=liste&s-rub=fiche-par-piece'.$p.'&ref='.$cmd->getIDCommande();
    }
}
if(isset($_POST['add-cmd'])){
    $data=explode('^',$_POST['add-cmd']);
    //print_r($data);
    //--- On recupère la commande  concernér ---
    $cmd=new Commande();
    $cmd->setRFCommande($data[0]);
    $cmd->setIDSociete_FK($data[1]);
    $cmd->setADelai($data[2]);
    //$cmd->setAPrix($data[3]);
    //$cmd->setQuantite($data[4]);
    $cmd->setDTECommande(date('Y-m-d G:i:s'));
    $is_cmd=$cmd->save(); 
    //---- On recupère le end-user concerné ---
    if($is_cmd){
        //--- On cherche la pièce demandé par le client ---
        $piece=PieceQuery::create()->filterByPN($data[10])->findOne();
        if($piece){
            //--- On crée la pièce demandée par l'acheteur ----
            $cmd_piece=new CMDPiece();
            $cmd_piece->setCommande($cmd);
            $cmd_piece->setADelai($data[2]);
            $cmd_piece->setCPrix($data[3]);
            $cmd_piece->setQuantite($data[4]);
            $cmd_piece->setPNClient($data[9]);
            $cmd_piece->setPCENote($data[11]);
            $cmd_piece->setPiece($piece);
            $cmd_piece->setDTEProposition(date('Y-m-d G:i:s'));
            $cmd_piece->save();
            
            if($data[6]!==''){
                $endUsr=new EUser();
                $endUsr->setEUAdresses($data[5]);
                $endUsr->setUSERName($data[6]);
        
                if($endUsr->save()){
                    $tab_end_usr=new COMEnduser();
                    $tab_end_usr->setCommande($cmd);
                    $tab_end_usr->setEUser($endUsr);
                    $tab_end_usr->setPiece($piece);
                    $tab_end_usr->save();
                }
            }
        }
        //-----
        
            //--- On créer la relation Appareil/piece pour cette commande ---
            //---- Ces references sont donnée par le vendeur ----
            if($data[7]!==''){
                $app_clt=AppareilQuery::create()->filterByNomApp('%'.$data[7].'%')->findOne();
                $mark=MarqueQuery::create()->findOne();
                if(!$app_clt){ // Si l'appareil n'existe pas, on le crée --
                    if($mark){
                        $model=ModelQuery::create()->filterByModele('%'.$data[7].'%')->findOne();
                        if(!$model){
                            $model=new Model();
                            $model->setModele($_POST['app-pce']);
                        }
                        $app_clt=new Appareil();
                        $app_clt->setNomApp($_POST['app-pce']);
                        $app_clt->setModele($model);
                        $app_clt->setMarque($mark);
                        $app_clt->setImmatriculation($_POST['app-imm']);
                        $app_clt->save();
                    } 
                }else{
                   //$app_clt->setImmatriculation($_POST['app-imm']); //-- On met la nvelle valeur de l'immatriculatio de l'appareil
                   //$app_clt->save();
                }
                if($app_clt){
                    $cmd_app=new CMDTAppareil();
                    $cmd_app->setCommande($cmd);
                    $cmd_app->setPiece($piece);
                    $cmd_app->setAppareil($app_clt);
                    $cmd_app->save();
                }
            }
        echo '?rub=liste&s-rub=fiche-par-piece&pce='.$piece->getID().'&ref='.$cmd->getIDCommande();
    }
}
if(isset($_POST['pce-exist'])){
    $pn=$_POST['pce-exist'];
    $piece=PieceQuery::create()->filterByPN($pn)->findOne();
    if($piece){
         echo 1;   
    }else{
        echo 'La pièce demandée n\'existe pas, voulez-vous l\'ajouter ?';
    }
}
if(isset($_POST['del-cmd'])){
    $id=$_POST['del-cmd'];
    //print_r($id);
    $cmd=CommandeQuery::create()->filterByIDCommande($id)->findOne();
    if($cmd){
        $cmd->delete();
    }
}
if(isset($_POST['other-pce'])){// Ce code est appelé lorsque la piece demandée par le client n'existe pas et qu'on veut qd meme l'ajouter
    //print_r($_POST['other-pce']);
    $pce=new Piece();
    $pce->setPN(trim($_POST['other-pce']));
    echo $pce->save();
}
if(isset($_POST['load-app'])){
    $id=$_POST['load-app'];
    $soc=SocieteQuery::create()->filterByID($id)->findOne();
    if($soc){
        //--- On recupère tous les appareils du fabricant ----
        $str='';
        if($soc->getMarque()){
            foreach ($app=AppareilQuery::create()->filterByMarque($soc->getMarque())->find() as $a) {
                $opt=new Option();
                $opt->setAttribute('value', $a->getIdAp());
                $opt->addElement(new Text($a->getNomApp()));
                $str.=$opt->toHTML();
            }
        }
        echo $str;
    }
}

if(isset($_POST['load-docs'])){
    $data=explode('^',$_POST['load-docs']);
    $frs=FournisseurQuery::create()->filterByID($data[0])->findOne();
    $doc=new DocForm($frs,$data[1],$data[2]);
    echo $doc->getForm();  
}
if(isset($_POST['add-doc'])){
    
    $frs=FournisseurQuery::create()->filterByID(trim($_POST['num-frs']))->findOne();
    //print_r($frs);
    if($frs){
        //---On charge le fichier sur le serveur ------
        
        if(isset($_FILES['src-doc'])){
            $indx=new TBINDEX();
            $indx->save();
            
            $ext=explode('.',$_FILES['src-doc']['name']);
            $to='upload/pdfFile/DOC'.$indx->getIndx().'.'.$ext[1];
        
            $is_move=move_uploaded_file($_FILES['src-doc']['tmp_name'], '../'.$to);

            if($is_move){
                $scr=new Document();
                $scr->setFournisseur($frs);
                $scr->setNDoc($_POST['desc-doc']);
                $scr->setDoc($to);
                $scr->setDTESave_FK(date('Y-m-d G:i:s'));
                $scr->save();
            }
        }
        if(isset($_POST['url-return'])){
            if($_POST['url-return']==='pp'){
                header('Location: http://appli-aviaco.org/?rub=liste&s-rub=fiche-par-piece&pce='.$frs->getIDPiece_PK().'&ref='.$_POST['num-cmd']);
            }else{
                header('Location: http://appli-aviaco.org/?rub=liste&s-rub=fiche-par-groupe-de-pieces&pce='.$frs->getIDPiece_PK().'&ref='.$_POST['num-cmd']);
            }
        }
    }
}
if(isset($_POST['del-doc'])){
    $data=explode('^',$_POST['del-doc']);
    $doc=DocumentQuery::create()->filterByDocnumber($data[0])->findOne();
    $frs=FournisseurQuery::create()->filterByID($data[1])->findOne();
    if($doc){
        $doc->delete();
    }
    $str='';
    if($frs){
         //--- On recupère la liste des source web restante --//
        foreach (DocumentQuery::create()->filterByFournisseur($frs)->find() as $el) {
            $pl=new P();
            $l_del=new Label('');
            $l_del->addElement(new Text('X'));
            $l_del->setAttribute('class', 'del-doc');
            $l_del->setAttribute('value', $el->getDocnumber().'^'.$frs->getID());
            $pl->addElements(Array(new A(new Text($el->getNDoc()),$el->getDoc()),$l_del));
            $li=new Li($pl,'');
            $str.=$li->toHTML();
        }
    }
    echo $str;
}
if(isset($_POST['load-imgs'])){
    $data=explode('^',$_POST['load-imgs']);
    $frs=FournisseurQuery::create()->filterByID($data[0])->findOne();
    $doc=new ImgForm($frs,$data[1]);
    echo $doc->getForm();  
}
if(isset($_POST['add-img'])){
    
    $frs=FournisseurQuery::create()->filterByID(trim($_POST['num-frs']))->findOne();
    //print_r($frs);
    if($frs){
        //---On charge le fichier sur le serveur ------
        
        if(isset($_FILES['src-img'])){
            $indx=new TBINDEX();
            $indx->save();
            
            $ext=explode('.',$_FILES['src-img']['name']);
            $to='upload/imgFile/PHTOTO'.$indx->getIndx().'.'.$ext[1];
        
            $is_move=move_uploaded_file($_FILES['src-img']['tmp_name'], '../'.$to);

            if($is_move){
                $scr=new Photopiece();
                $scr->setFournisseur($frs);
                $scr->setTitre($_POST['desc-img']);
                $scr->setPiecephoto($to);
                $scr->setDatephoto(date('Y-m-d G:i:s'));
                $scr->setCommentaire($_POST['comment']);
                $scr->save();
            }
        }
       header('Location: http://appli-aviaco.org/?rub=liste&s-rub=fiche-par-piece&pce='.$frs->getIDPiece_PK().'&ref='.$_POST['num-cmd']);
    }
}
if(isset($_POST['del-img'])){
    $data=explode('^',$_POST['del-img']);
    $img=PhotopieceQuery::create()->filterByID($data[0])->findOne();
    $frs=FournisseurQuery::create()->filterByID($data[1])->findOne();
    if($img){
        $img->delete();
    }
    $str='';
    if($frs){
         //--- On recupère la liste des source web restante --//
        foreach (PhotopieceQuery::create()->filterByFournisseur($frs)->find() as $el) {
            $pl=new P();
            $l_del=new Label('');
            $l_del->addElement(new Text('X'));
            $l_del->setAttribute('class', 'del-img');
            $l_del->setAttribute('value', $el->getID().'^'.$frs->getID());
            $pl->addElements(Array(new A(new Text($el->getTitre()),$el->getPiecephoto()),$l_del));
            $li=new Li($pl,'');
            $str.=$li->toHTML();
        }
    }
    echo $str;
}
if(isset($_POST['add-gp'])){
    $data=explode('^',$_POST['add-gp']);
    //print_r($data);
    //--- On recupère la commande  concernér ---
    $cmd=new Commande();
    $cmd->setRFCommande($data[0]);
    $cmd->setIDSociete_FK($data[1]);
    //$cmd->setADelai(0);
    //$cmd->setAPrix('$0.00');
    //$cmd->setQuantite(0);
    $cmd->setCMDNote($data[2]);
    $cmd->setDTECommande(date('Y-m-d G:i:s'));
    $is_cmd=$cmd->save(); 
    if($is_cmd){
        echo '?rub=liste&s-rub=fiche-par-groupe-de-pieces&ref='.$cmd->getIDCommande();
    } 
}
if(isset($_POST['updt-gp'])){
    $data=explode('^',$_POST['updt-gp']);
    //--- On recupère la commande  concernér ---
    $cmd=CommandeQuery::create()->filterByIDCommande($data[0])->findOne();
    if($cmd){
        $cmd->setRFCommande($data[2]);
        $cmd->setIDSociete_FK($data[3]);
        //$cmd->setADelai(0);
        //$cmd->setAPrix('$0.00');
        //$cmd->setQuantite(0);
        $cmd->setCMDNote($data[4]);
        $cmd->setDTECommande(date('Y-m-d G:i:s'));
        $cmd->save(); 
    }
    echo '?rub=liste&s-rub=fiche-par-groupe-de-pieces&ref='.$data[0];
}
if(isset($_POST['add-type-doc'])){
    $data=explode('^', $_POST['add-type-doc']);
    $cmd=CommandeQuery::create()->filterByIDCommande($data[0])->findOne();
    $type_doc=CMDTDocQuery::create()->filterByCommande($cmd)->filterByTDoc_FK($data[1])->findOne();
    if($type_doc){
        $type_doc->delete();
    }else{
        $type_doc=new CMDTDoc();
        $type_doc->setCommande($cmd);
        $type_doc->setTDoc_FK($data[1]);
        echo $type_doc->save();
    }
}
if(isset($_POST['new-pce'])){
    $str=explode('#',$_POST['new-pce']);
    $ids=explode('^',$str[0]);
    $data=explode('^',$str[1]);
    
    //--- On cherche la commande lié à cette pice ;
    $cmd=CommandeQuery::create()->filterByIDCommande($ids[0])->findOne(); 
    if($cmd){
         if(!isset($ids[1])){ //---- On vient de rajouter une pièce ----
             //--- On crée la pièce dans la base, s'elle existe on l'ajoute pas ---
            $piece=PieceQuery::create()->filterByPN($data[0])->filterByAltPN($data[1])->findOne();
            if(!$piece){
                $piece=new Piece();
                $piece->setPN($data[0]);
                $piece->setAltPN($data[1]);
                $piece->setDescription($data[2]);
            
                if($piece->save()){
                    $stock=new Stock();
                    $stock->setPiece($piece);
                    $stock->setDatedepart(date('Y-m-d G:i:s'));
                    $stock->save();
                }
                if($data[4]!==''){
                    //--- On cherche l'appareil lié- ----
                    $app=AppareilQuery::create()->filterByNomApp($data[4])->findOne();
                    if($app){
                        $app_pce=new PieceApp();
                        $app_pce->setAppareil($app);
                        $app_pce->setPiece($piece);
                        $app_pce->save();
                    }
                }
            }
            //
            $pce_cmd=new CMDPiece();
            $pce_cmd->setCommande($cmd);
            $pce_cmd->setPiece($piece);
            $pce_cmd->setCPrix($data[5]);
            $pce_cmd->setQuantite($data[3]);
            $pce_cmd->setADelai($data[6]);
            $pce_cmd->setDTEProposition(date('Y-m-d G:i:s'));
            $pce_cmd->save();
        }else{ //--- On vient de rajouter un vendeur ----
            $soc=SocieteQuery::create()->filterBySociete('%'.$data[0].'%')->findOne();
            
            if($soc){
                //--- On crée la relation fournisseur ---
                $frs=new Fournisseur();
                $frs->setSociete($soc);
                $frs->setIDPiece_PK($ids[1]);
                $frs->setVCondition($data[1]);
                $frs->setDTESave(date('Y-m-d G:i:s'));
                $frs->setisProd(TRUE);
                $frs->setQuantite($data[2]);
                $frs->setDelai($data[3]);
                $frs->setPrixachat($data[5]);
                $frs->setPrixvente($data[6]);
                if($frs->save()){
                    $vte=new COMVendeur();
                    $vte->setCommande($cmd);
                    $vte->setIDPiece_FK($ids[1]);
                    $vte->setFournisseur($frs);
                    $vte->setPMinimum($data[4]);
                    $vte->setDTEProposition(date('Y-m-d G:i:s'));
                    $vte->save();
                }
            }
        }
    }
}
if(isset($_POST['updt-vte'])){
    $data=explode('^',$_POST['updt-vte']);
    //print_r($data);
    //--- On recupère la ligne de la table vente concerné ---
    $vte=COMVendeurQuery::create()->filterByIDVendeur($data[1])->findOne();
    if($vte){
        switch ($data[0]) {
            case 'cond':
                $vte->getFournisseur()->setVCondition($data[2]);
                break;
            case 'qte':
                $vte->getFournisseur()->setQuantite($data[2]);
                break;
            case 'delais':
                $vte->getFournisseur()->setDelai($data[2]);
                break;
            case 'min':
                $vte->setPMinimum($data[2]);
                break;
            case 'pach':
                $vte->getFournisseur()->setPrixachat($data[2]);
                break;
            case 'pvte':
                $vte->getFournisseur()->setPrixvente($data[2]);
            default:
                break;
        }
        $vte->getFournisseur()->save();
        $vte->save();
    }
}
if(isset($_POST['updt-pce-cell'])){
    $data=explode('^',$_POST['updt-pce-cell']);
    //print_r($data);
    //--- On recupère la ligne de la table vente concerné ---
    $cmd=CMDPieceQuery::create()->filterByIDPiece($data[1])->filterByIDCommande_FK($data[2])->findOne();
    if($cmd){
        switch ($data[0]) {
            case 'alt':
                $cmd->getPiece()->setAltPN($data[3]);
                break;
            case 'desc':
                $cmd->getPiece()->setDescription($data[3]);
                break;
            case 'qte':
                $cmd->setQuantite($data[3]);
                break;
            case 'app':
                $pce_cmd=PieceAppQuery::create()->filterByIDPiece_FK($data[1])->findOne();
                if($pce_cmd){
                    $pce_cmd->setIdAp_PK($data[3]);
                    $pce_cmd->save();
                }else{
                    $pce_cmd=new PieceApp();
                    $pce_cmd->setIdAp_PK($data[3]);
                    $pce_cmd->setIDPiece_FK($data[1]);
                    $pce_cmd->save();
                }
                //print_r($data);
                
                break;
            case 'prix':
                $cmd->setCPrix($data[3]);
                break;
            case 'del':
                $cmd->setADelai($data[3]);
            default:
                break;
        }
        $cmd->getPiece()->save();
        $cmd->setDTEProposition(date('Y-m-d G:i:s'));
        $cmd->save();
    }
}
//---- Model de chargement de formulaire générique ---
if(isset($_POST['gen-form'])){
    $val=explode('^',$_POST['gen-form']);
    //print_r($val);
    $tr=new Tr();
    if(!isset($val[1])){
        $td_0=new Td();
        $td_1=new Td();
        $td_1->setAttribute('class', 'z-new');
        $in_1=new Input();
        $in_1->setAttribute('type', 'text');
        $in_1->setAttribute('id', $_POST['gen-form']);
        $in_1->setAttribute('class', 'pce');
        $in_1->setAttribute('list', 'list-pn');
        $lis_pn=new Datalist();
        $lis_pn->setAttribute('id', 'list-pn');
        foreach (PieceQuery::create()->find() as $pn) {
            $opt=new Option();
            $opt->addElement(new Text($pn->getPN()));
            $lis_pn->addElement($opt);
        }
        $td_1->addElements(Array($in_1,$lis_pn));
        $tr->addElements(Array($td_0,$td_1));
        for($i=0;$i<3;$i++){
            $td_2=new Td();
            $td_2->setAttribute('class', 'z-new');
            $in_2=new Input();
            $in_2->setAttribute('type', 'text');
            $in_2->setAttribute('id', $_POST['gen-form']);
            $in_2->setAttribute('class', 'pce');
            $td_2->addElement($in_2);
            $tr->addElement($td_2);
        }
        $td_2=new Td();
        $td_2->setAttribute('class', 'z-new');
        $in_2=new Input();
        $in_2->setAttribute('type', 'text');
        $in_2->setAttribute('id', $_POST['gen-form']);
        $in_2->setAttribute('class', 'pce');
        $in_2->setAttribute('list', 'list-app');
        $td_2->addElement($in_2);
        
        $td_3=new Td();
        $td_3->setAttribute('class', 'z-new');
        $in_3=new Input();
        $in_3->setAttribute('type', 'text');
        $in_3->setAttribute('id', $_POST['gen-form']);
        $in_3->setAttribute('class', 'pce');
        $td_3->addElement($in_3);
        
        $td_4=new Td();
        $td_4->setAttribute('class', 'z-new');
        $in_4=new Input();
        $in_4->setAttribute('type', 'text');
        $in_4->setAttribute('id', $_POST['gen-form']);
        $in_4->setAttribute('class', 'pce');
        $td_4->addElement($in_4);
        
        $list_app=new Datalist();
        $list_app->setAttribute('id', 'list-app');
        foreach (AppareilQuery::create()->find() as $ap) {
            $opt=new Option();
            $opt->addElement(new Text($ap->getNomApp()));
            $list_app->addElement($opt);
        }
        $td_2->addElement($list_app);
        $tr->addElements(Array($td_2,$td_3,$td_4));
        
    }else{
        $td_0=new Td();
        $td_0->setAttribute('class', 'z-new');
        $in_0=new Input();
        $in_0->setAttribute('type', 'text');
        $in_0->setAttribute('id', $_POST['gen-form']);
        $in_0->setAttribute('class', 'vte');
        $in_0->setAttribute('list', 'list-vte');
        $lis_vte=new Datalist();
        $lis_vte->setAttribute('id', 'list-vte');
        foreach (SocieteQuery::create()->find() as $soc) {
            $opt=new Option();
            $opt->addElement(new Text($soc->getSociete()));
            $lis_vte->addElement($opt);
        }
        $td_0->addElements(Array($in_0,$lis_vte));
        $td_1=new Td();
        $td_1->setAttribute('class', 'z-new');
        $in_1=new Input();
        $in_1->setAttribute('type', 'text');
        $in_1->setAttribute('id', $_POST['gen-form']);
        $in_1->setAttribute('class', 'vte');
        $in_1->setAttribute('list', 'list-cd');
        $lis_cd=new Datalist();
        $lis_cd->setAttribute('id', 'list-cd');
        foreach (ConditionQuery::create()->find() as $cd) {
            $opt=new Option();
            $opt->addElement(new Text($cd->getCondition()));
            $lis_cd->addElement($opt);
        }
        $td_1->addElements(Array($in_1,$lis_cd));
        $td_cer=new Td();
        $tr->addElements(Array($td_0,$td_1,$td_cer));
        for($i=0;$i<5;$i++){
            $td_2=new Td();
            $td_2->setAttribute('class', 'z-new');
            $in_2=new Input();
            $in_2->setAttribute('type', 'text');
            $in_2->setAttribute('id', $_POST['gen-form']);
            $in_2->setAttribute('class', 'vte');
            $td_2->addElement($in_2);
            $tr->addElement($td_2);
        }
        $td_doc=new Td();
        $td_note=new Td();
        $td_prop=new Td();
        /*
        $prop_but=new Input();
        $prop_but->setAttribute('type', 'buttom');
        $prop_but->setAttribute('value', '...');
        $prop_but->setAttribute('class', 'view-propose');
         * 
         */
        $tr->addElements(Array($td_doc,$td_note,$td_prop));
    }
    echo $tr->toHTML();
}
if(isset($_POST['new-note'])){
    $id=$_POST['new-note'];
    $vte=COMVendeurQuery::create()->filterByIDVendeur($id)->findOne();
    if($vte){
        $form_note=new Div();
        $form_note->setAttribute('id', 'page-src');
        $hg=new Hgroup();
        $f_content=new Fieldset('Notes vendeurs');
        $txt=new Textarea();
        $txt->setAttribute('class', 'vte-note');
        $txt->addElement(new Text($vte->getVNDNote()));
        
        $but_add=new Input();
        $but_add->setAttribute('type', 'submit');
        $but_add->setAttribute('class', 'new-note');
        $but_add->setAttribute('value', 'Ajouter');
        
        $num_vte=new Input();
        $num_vte->setAttribute('type', 'hidden');
        $num_vte->setAttribute('class', 'vte-note');
        $num_vte->setAttribute('value', $vte->getIDVendeur());
        $f_content->addElements(Array($txt,$num_vte,$but_add));
        
        $em=new Em();
        $em->addElement(new A(new Text('X'), ''));
        $hg->addElements(Array($em,$f_content));
        $form_note->addElement($hg);
        echo $form_note->toHTML();
    }
}
if(isset($_POST['add-note'])){
    $data=explode('^',$_POST['add-note']);
    $vte=COMVendeurQuery::create()->filterByIDVendeur($data[1])->findOne();
    if($vte){
        $vte->setVNDNote($data[0]);
        $vte->save();
    }
}
if(isset($_POST['view-propose'])){
    $id=$_POST['view-propose'];
    $vte=COMVendeurQuery::create()->filterByIDVendeur($id)->findOne();
    if($vte){
        $form_note=new Div();
        $form_note->setAttribute('id', 'page-src');
        
        $p_search=new P();
        $in_search=new Input();
        $in_search->setAttribute('type','search');
        $in_search->setAttribute('name','search');
        $in_search->setAttribute('placeholder','Recherche');
        $in_search->setAttribute('onkeyup',"find_vte(this.value)");
        $p_search->addElement($in_search);
        
        $hg=new Hgroup();
        $hg->setAttribute('class', 'vte-prop');
        $f_content=new Fieldset('Propositions de vente de la société "'.$vte->getFournisseur()->getSociete()->getSociete().'"');
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
        $tr_title->addElements(array($th1,$th2,$th3,$th4,$th5,$th6,$th7,$th8));
        
        $thead=new Thead();
        $thead->addElement($tr_title);
        $tbody=new Tbody();
        $tbody->setAttribute('id', 'list-stock');
        foreach (FournisseurQuery::create()->filterByCOMVendeur($vte)->orderByDTESave()->find() as $frs) {
            $tr_b=new Tr();
            $td1=new Td();$td2=new Td();$td3=new Td();$td4=new Td();$td5=new Td();$td6=new Td();$td7=new Td();$td8=new Td();$td9=new Td();$td10=new Td();
            $td1->addElement(new Text($frs->getPiece()->getPN()));
            $td2->addElement(new Text($frs->getPiece()->getAltPN()));
            $td3->addElement(new Text($frs->getPiece()->getDescription()));
            $td4->addElement(new Text($frs->getQuantite()));
            $app=PieceAppQuery::create()->filterByPiece($frs->getPiece())->findOne();
            if($app){
                $td5->addElement(new Text($app->getAppareil()->getNomApp()));
            }else{
                $td5->addElement(new Text('--'));
            }
            $td6->addElement(new Text($frs->getPrixachat()));
            $td7->addElement(new Text($frs->getPrixvente()));
            $td8->addElement(new Text($frs->getDelai()));
            $tr_b->addElements(Array($td1,$td2,$td3,$td4,$td5,$td6,$td7,$td8));
            $tbody->addElement($tr_b);
        }
        $tab->addElements(Array($thead,$tbody));
        $f_content->addElements(Array($tab));
        
        $em=new Em();
        $em->addElement(new A(new Text('X'), ''));
        $num_vte=new Input();
        $num_vte->setAttribute('type', 'hidden');
        $num_vte->setAttribute('class', 'num-vte');
        $num_vte->setAttribute('value', $vte->getIDVendeur());
        $hg->addElements(Array($p_search,$em,$f_content,$num_vte));
        $form_note->addElement($hg);
        echo $form_note->toHTML();
    }
}
if(isset($_POST['search-vte'])){
    $data=explode('^',$_POST['search-vte']);
    $val='%'.$data[1].'%';
    $clause=Propel\Runtime\ActiveQuery\Criteria::LOGICAL_OR;
    $piece=PieceQuery::create()->condition('c1', 'piece.reference LIKE ?',$val)
            ->condition('c2', 'piece.type_FK LIKE ?',$val)->condition('c3', 'piece.description LIKE ?',$val)
            ->condition('c4', 'piece.pn LIKE ?',$val)->condition('c5', 'piece.alt_pn LIKE ?',$val)->condition('c6', 'piece.otan',$val)
            ->where(array('c1','c2','c3','c4','c5'), $clause)->find();
    $str='';
    foreach ($piece as $pc) {
        $vte=COMVendeurQuery::create()->filterByIDVendeur($data[0])->find();
        if($vte){
            foreach (FournisseurQuery::create()->filterByCOMVendeur($vte)->filterByPiece($pc)->orderByDTESave()->find() as $frs) {
                $tr_b=new Tr();
                $td1=new Td();$td2=new Td();$td3=new Td();$td4=new Td();$td5=new Td();$td6=new Td();$td7=new Td();$td8=new Td();$td9=new Td();$td10=new Td();
                $td1->addElement(new Text($frs->getPiece()->getPN()));
                $td2->addElement(new Text($frs->getPiece()->getAltPN()));
                $td3->addElement(new Text($frs->getPiece()->getDescription()));
                $td4->addElement(new Text($frs->getQuantite()));
                $app=PieceAppQuery::create()->filterByPiece($frs->getPiece())->findOne();
                if($app){
                    $td5->addElement(new Text($app->getAppareil()->getNomApp()));
                }else{
                    $td5->addElement(new Text('--'));
                }
                $td6->addElement(new Text($frs->getPrixachat()));
                $td7->addElement(new Text($frs->getPrixvente()));
                $td8->addElement(new Text($frs->getDelai()));
                $tr_b->addElements(Array($td1,$td2,$td3,$td4,$td5,$td6,$td7,$td8));
                $str.=$tr_b->toHTML();
            }
            echo $str;
        }
    }

    
}
if(isset($_POST['pn-comment'])){
    $data=explode('^',$_POST['pn-comment']);
    $piece=PieceQuery::create()->filterByID($data[0])->findOne();
    if($piece){
        $piece->setCommentaire($data[1]);
        $piece->save();
    }
}
//---------------- Mes fonctions -----//
function filterTable($soc,$data){
    //print_r($data);
    //------------------
    $tab_act= explode(',', $data[2]);
    $tab_app= explode(',', $data[3]);
    $tab_app_f= explode(',', $data[4]);
    
    //print_r($soc);
    //--- Tableau de societé temporaire --
    $soc_tmp=[];
    
    if(count($tab_act)>0 && $tab_act[0]!==''){
        foreach ($soc as $ss) {
            //---- Filtre selon le secteur d'activité --//
            foreach ($tab_act as $act) {
                $s=SocietemetierQuery::create()->filterBySociete($ss)->filterByMetier_PK($act)->findOne();
                if($s){
                    if(!isset($soc_tmp[$s->getSociete()->getID()])){
                        $soc_tmp[$s->getSociete()->getID()]=$s->getSociete();
                        break;
                    }
                }
            }
        }
    
        $soc=$soc_tmp;
        $soc_tmp=[];
    }
    //print_r($soc);
     
    //--- On verifie s'il ya au moins un des appareils est lié à la societé ---//
    //------------------- en cours -------------------------
    //print_r($soc->getSociete());
    if(count($tab_app)>0 && $tab_app[0]!==''){
        foreach ($soc as $s) {
            foreach($tab_app as $app){
                $s_app=SocieteappareilQuery::create()->filterBySociete($s)->filterByIdAppareil_FK($app)->findOne();
                if($s_app){
                    if(!isset($soc_tmp[$s_app->getSociete()->getID()])){
                        $soc_tmp[$s_app->getSociete()->getID()]=$s_app->getSociete();
                        break;
                    }
                }
            }
        }
    
        $soc=$soc_tmp;
        $soc_tmp=[];
    }
    //print_r($soc);   
    //--- On verifie s'il ya au moins un des appareils est lié à la societé flotte ---//
    //------------------- en cours -------------------------
    if(count($tab_app_f)>0 && $tab_app_f[0]!==''){
        foreach ($soc as $s) {
            foreach($tab_app_f as $app){
                $s_app_f=SocieteappareilQuery::create()->filterBySociete($s)->filterByIdAppareil_FK($app)->findOne();
                if($s_app_f && $s_app_f->getisFlotte()){
                    if(!isset($soc_tmp[$s_app_f->getSociete()->getID()])){
                        $soc_tmp[$s_app_f->getSociete()->getID()]=$s_app_f->getSociete();
                        break;
                    }
                }
            }
        }
        
        $soc=$soc_tmp;
    }
    
    return $soc;
}