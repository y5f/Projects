<?php

//----- Classe de chargement  ---------
require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';
/*
if(isset($_POST['rub'])){
    $rub=$_POST['rub'];
    
    //--- Si la rubrique catégorie qui est cliquée ---
    if($rub=='categorie'){
        $form=new CategorieForm();
        $form->getCatForm();
    }
    
    //--- Si c'est la rubruque Menu qui est cliquée --//
    if($rub=='menus'){
        $form=new MenuForm();
        $form->getMenu();
    }
    
    //--- Si c'est la rubruque Menu qui est cliquée --//
    if($rub=='new-user'){
        $form=new UserForm;
        $form->getUserForm();
    }
    
    //--- Si c'est la rubruque Menu qui est cliquée --//
    if($rub=='new-pub'){
        $form=new PublicationForm();
        $form->getPublictionForm();
    }
    
    //--- Si c'est la rubruque liste des articles qui est cliquée --//
    if($rub=='list-art'){
        $form=new ListArticle();
        $form->getlist();
    }
    //--- Si c'est la rubruque nouvel des articles qui est cliquée --//
    if($rub=='new-art'){
        $form=new ArticleForm(NULL);
        $form->getArticleForm();
    }
}
*/
if(isset($_POST['cat'])){
    $categ=$_POST['cat'];
    $cat=CategorieQuery::create()->filterByURL($categ)->filterByNIVEAU(1)->findOne();
    $parent='aucun';
    if(!$cat){
        $cat=SouscategorieQuery::create()->filterByURL($categ)->findOne();
        $parent=$cat->getCategorie_FK();
        $categ=$cat->getSouscategorie();
        $desc=$cat->getCommentaire();
    }else{
        $desc=$cat->getCommentaire();
        $categ=$cat->getCategorie();
    }
    
    echo $cat->getID().'#'.$parent."#".$categ."#".$cat->getURL()."#".$cat->getOrdre()."#".$desc;
    
}
if(isset($_POST['form'])){
    $data=$_POST['form'];
    $data=explode('#', $data);
    //echo $data[0];
    if($data[0]==='aucun' && $data[1]!=='aucun'){
       $new_cat=new Categorie();
       $new_cat->setCategorie($data[1]);
       $new_cat->setCommentaire($data[4]);
       $new_cat->setORDRE($data[3]);
       $new_cat->setURL($data[2]);
       $new_cat->setNIVEAU(1);
       echo $new_cat->save();
    }else{
       
       //--- On verifie si lacategorie envoyée ne correspond pas à unesous cat ----------
        //---- si c'est le cas, celle-ci devient une cat du niveau de son parent +1 ------
       //echo $data[0];
        $is_sous_cat=SouscategorieQuery::create()->filterBySouscategorie($data[0])->findOne();
        
        if($is_sous_cat && (!CategorieQuery::create()->filterByCategorie($data[0])->findOne())){
            //echo $is_sous_cat;
            $parent=$is_sous_cat->getCategorie();
            $new_cat=new Categorie();
            $new_cat->setCategorie($is_sous_cat->getSouscategorie());
            $new_cat->setCommentaire($is_sous_cat->getCommentaire());
            $new_cat->setORDRE($is_sous_cat->getORDRE());
            $new_cat->setNIVEAU($parent->getNIVEAU()+1);
            $new_cat->setURL($is_sous_cat->getURL());
            $new_cat->save();
        }
        $new_cat=new Souscategorie();
        $new_cat->setCategorie_FK($data[0]);
        $new_cat->setSouscategorie($data[1]);
        $new_cat->setCommentaire($data[4]);
        $new_cat->setORDRE($data[3]);
        $new_cat->setURL($data[2]);
        echo $new_cat->save();
    }
}
if(isset($_POST['form-mod'])){
    $data=$_POST['form-mod'];
    $data=explode('#', $data);
    //echo $data[0];
    
    if($data[1]==='aucun'){
        
       $new_cat=CategorieQuery::create()->filterByID($data[0])->findOne();
       $new_cat->setCategorie($data[2]);
       $new_cat->setURL($data[3]);
       $new_cat->setORDRE($data[4]);
       $new_cat->setCommentaire($data[5]);
       $new_cat->setNIVEAU(1);
       echo $new_cat->save();
    }else{
        $new_cat=SouscategorieQuery::create()->filterByID($data[0])->findOne();
        $new_cat->setSouscategorie($data[2]);
        //$new_cat->setCATEGORIE_FK($data[1]); --- On ne modifie pas le parent---
        $new_cat->setORDRE($data[4]);
        $new_cat->setURL($data[3]);
        $new_cat->setCommentaire($data[5]);
        echo $new_cat->save();
    }
    
}
if(isset($_POST['form-sup'])){
    $data=$_POST['form-sup'];
    $data=explode('#', $data);
    //echo $data[0];
    if($data[1]==='aucun'){
        $dele_cat=CategorieQuery::create()->filterByID($data[0])->findOne();
        
        //--- Opérationde nétoyage : tout cat de niveau sup à 1 et qui n'as pas
        //---- de parent dans categ est supprimé --------
        foreach ($dele_cat->getSouscategories() as $value) {
            if(CategorieQuery::create()->filterByCategorie($value->getSouscategorie())->findOne()){
                CategorieQuery::create()->filterByCategorie($value->getSouscategorie())->findOne()->delete();
            }
        }
        
    }else{
        $dele_cat=SouscategorieQuery::create()->filterByID($data[0])->findOne();
    }
    
    echo $dele_cat->delete();
}
if(isset($_POST['menu'])){
    $data=$_POST['menu'];
    $data=explode('#', $data);
    //echo $data[0];
    if($data[1]==='aucun'){
       $new_menu=new Menus();
       $new_menu->setMenu($data[2]);
       $new_menu->setCommentaire($data[5]);
       $new_menu->setOrdre($data[4]);
       $new_menu->setURL($data[2]);
       $new_menu->setNiveau(1);
       echo $new_menu->save();
    }else{
       
       //--- On verifie si lacategorie envoyée ne correspond pas à unesous cat ----------
        //---- si c'est le cas, celle-ci devient une cat du niveau de son parent +1 ------
       //echo $data[0];
        $is_sous_menu=SousmenuQuery::create()->filterBySousmenu($data[1])->findOne();
        
        if($is_sous_menu && (!MenusQuery::create()->filterByMenu($data[1])->findOne())){
            //echo $is_sous_cat;
            $parent=$is_sous_menu->getMenus();
            $new_menu=new Menus();
            $new_menu->setMenu($is_sous_menu->getSousmenu());
            $new_menu->setCommentaire($is_sous_menu->getCommentaire());
            $new_menu->setOrdre($is_sous_menu->getOrdre());
            $new_menu->setNiveau($parent->getNiveau()+1);
            $new_menu->setURL($is_sous_menu->getURL());
            $new_menu->save();
        }
        $new_menu=new Sousmenu();
        $new_menu->setmenu_FK($data[1]);
        $new_menu->setSousmenu($data[2]);
        $new_menu->setCommentaire($data[5]);
        $new_menu->setOrdre($data[4]);
        $new_menu->setURL($data[3]);
        echo $new_menu->save();
    }
}
if(isset($_POST['ad-m'])){
    $categ=$_POST['ad-m'];
    $cat=MenusQuery::create()->filterByURL($categ)->filterByNiveau(1)->findOne();
    $parent='aucun';
    if(!$cat){
        $cat=SousmenuQuery::create()->filterByURL($categ)->findOne();
        $parent=$cat->getMenus();
        $categ=$cat->getSousmenu();
        $desc=$cat->getCommentaire();
    }else{
        $desc=$cat->getCommentaire();
        $categ=$cat->getMenu();
    }
    
    echo $cat->getID().'#'.$parent."#".$categ."#".$cat->getURL()."#".$cat->getOrdre()."#".$desc;
    
}
if(isset($_POST['menu-mod'])){
    $data=$_POST['menu-mod'];
    $data=explode('#', $data);
    //echo $data[1];
    
    if($data[1]==='aucun'){
        
       $new_cat=MenusQuery::create()->filterByID($data[0])->findOne();
       $new_cat->setMenu($data[2]);
       $new_cat->setURL($data[3]);
       $new_cat->setOrdre($data[4]);
       $new_cat->setCommentaire($data[5]);
       $new_cat->setNiveau(1);
       echo $new_cat->save();
       //echo $new_cat->delete();
    }else{
        $new_cat=SousmenuQuery::create()->filterByID($data[0])->findOne();
        $new_cat->setSousmenu($data[2]);
        //$new_cat->setCATEGORIE_FK($data[1]); --- On ne modifie pas le parent---
        $new_cat->setOrdre($data[4]);
        $new_cat->setURL($data[3]);
        $new_cat->setCommentaire($data[5]);
        echo $new_cat->save();
    }
    
}
if(isset($_POST['menu-sup'])){
    $data=$_POST['menu-sup'];
    $data=explode('#', $data);
    //echo $data[1];
    if($data[0]==='aucun'){
        $dele_cat=MenusQuery::create()->filterByID($data[1])->findOne();
        
        //--- Opérationde nétoyage : tout cat de niveau sup à 1 et qui n'as pas
        //---- de parent dans categ est supprimé --------
        foreach ($dele_cat->getSousmenus() as $value) {
            if(MenusQuery::create()->filterByMenu($value->getSousmenu())->findOne()){
                MenusQuery::create()->filterByMenu($value->getSousmenu())->findOne()->delete();
            }
        }
        
    }else{
        $dele_cat=SousmenuQuery::create()->filterByID($data[1])->findOne();
    }
    
    echo $dele_cat->delete();
}

//##################### SCRIPT TRAITANT LE FORMULAURE EMPLOYE #################
///////////////////////////////////////////////////////////////////////////////

if(isset($_POST['user-add'])){
    $data=$_POST['user-add'];
    $data=explode('#', $data);
    
    //---- On genère le code employé --//
    $code=new DateTime('now');
    $jour=$code->format('j');
    $mois=$code->format('n');
    $annee=$code->format('y');
    $id='AV-'.$annee.'EM'.$mois.'-'.$jour.rand(1,50);
    
    $emp=new Employe();
    $emp->setIdEmploye($id);
    $emp->setNom($data[0]);
    $emp->setPrenoom($data[1]);
    $emp->setAdresses($data[2]);
    $emp->setCodepostal($data[3]);
    $emp->setFonction($data[4]);
    $emp->setNiveaAcces($data[5]);
    $emp->setTelephone($data[6]);
    $emp->setEmail($data[7]);
    $emp->setPasse(password_hash($data[8], PASSWORD_BCRYPT));
    echo $emp->save();
    //print_r($data);
    
}
if(isset($_POST['user-mod'])){
    $data=$_POST['user-mod'];
    $data=explode('#', $data);
    //print_r($data);
    //--- On cherche l'objet concerné par la modif --//
    $emp=EmployeQuery::create()->filterByIdEmploye($data[0])->findOne();
    if($emp){
        $emp->setNom($data[1]);
        $emp->setPrenoom($data[2]);
        $emp->setAdresses($data[3]);
        $emp->setCodepostal($data[4]);
        $emp->setFonction($data[5]);
        $emp->setEtat($data[6]);
        $emp->setTelephone($data[7]);
        $emp->setEmail($data[8]);
        $emp->setPasse(password_hash($data[9], PASSWORD_BCRYPT));
        $emp->setNiveaAcces($data[10]);
        echo $emp->save();
    }
    //print_r($data);
    
}
if(isset($_POST['user-select'])){
    
    $id=$_POST['user-select'];
    //--- On cherche l'objet selectionné --//
    $emp=EmployeQuery::create()->filterByIdEmploye($id)->findOne();
    $str='';
    if($emp){
        $str=$emp->getIdEmploye().'#'.
            $emp->getNom().'#'.
            $emp->getPrenoom().'#'.
            $emp->getAdresses().'#'.
            $emp->getCodepostal().'#'.
            $emp->getFonction().'#'.
            $emp->getEtat().'#'.
            $emp->getTelephone().'#'.
            $emp->getEmail().'#'.
            $emp->getPasse().'#'.
            $emp->getNiveaAcces();
    }
    echo $str;
}
if(isset($_POST['user-delete'])){
    $id=$_POST['user-delete'];
    $emp=EmployeQuery::create()->filterByIdEmploye($id)->findOne();
    
    if($emp){
        $emp->delete();
    }
    
}
//###############################################################
//############## FONCTIONS TRAITANT LA PUBLICATION ART ##########

if(isset($_POST['pub-art'])){
    $id=$_POST['pub-art'];
    //--- On recupère les détails de l'articles concernée --//
    $art=ArticleQuery::create()->filterByNumart($id)->findOne();
    //print_r($art);
    $str='';
    if($art){
        $str=$art->getNumart().'#'.$art->getTitre().'#'.$art->getEmploye()->getPrenoom().' '.$art->getEmploye()->getNom();
    }
    echo $str;
}
if(isset($_POST['mod-pub'])){
    $data=$_POST['mod-pub'];
    $data=  explode('#', $data);
    //print_r($data);
    //--- On recupère l'article concernée pas la modif --//
    $art=ArticleQuery::create()->filterByNumart($data[0])->findOne();
    if($art){
        $art->setTitre($data[1]);
        echo $art->save();
    }
}
if(isset($_POST['pub-pub'])){
    $data=$_POST['pub-pub'];
    $data=  explode('#', $data);
    //print_r($data);
    
    $etat='0';
    if($data[2]==='actif'){
        $etat='1';
    }
    $slide='0';
    if($data[3]==='actif'){
        $slide='1';
    }
    //--- On recupère l'article concernée pas la modif --//
    $new_pub=new Publication();
    $new_pub->setDatepublication($data[1]);
    $new_pub->setEtat($etat);
    $new_pub->setisSlider($slide);
    $new_pub->setArt_num_PK($data[0]);
    echo $new_pub->save();
  
}
if(isset($_POST['pub-select'])){
    $id=$_POST['pub-select'];
    
    //-- On recupère la publication concernée par la selection --//
    $pub=PublicationQuery::create()->filterByID($id)->findOne();
    $str='';
    if($pub){
        $etat='inactif';
        if($pub->getEtat()){
            $etat='actif';
        }
        $slide='inactif';
        if($pub->getisSlider()){
            $slide='actif';
        }
        $str=$pub->getID().'#'.$pub->getArticle()->getDateEdit()->format('Y-m-d').'#'.$pub->getDatepublication()->format('Y-m-d').'#'.
                $pub->getArticle()->getEmploye()->getPrenoom().' '.$pub->getArticle()->getEmploye()->getNom().'#'.
                $etat.'#'.$slide;
    }
    echo $str;
}
if(isset($_POST['dep-valider'])){
    $data=$_POST['dep-valider'];
    $data=  explode('#', $data);
    
    //print_r($data);
    $etat='0';
    if($data[4]==='actif'){
        $etat='1';
    }
    $slide='0';
    if($data[5]==='actif'){
        $slide='1';
    }
    //---- IOn recupère la publication concerné pas la modification ---
    $pub=PublicationQuery::create()->filterByID($data[0])->findOne();
    $pub->getArticle()->setDateEdit($data[1]);
    $pub->setDatepublication($data[2]);
    //$pub->getArticle()->getEmploye()->setPrenoom($data[3]);
    $pub->setEtat($etat);
    $pub->setisSlider($slide);
    echo $pub->save();
}

//##################### SCRIPT TRAITANT LES ARTICLES ##########################
///////////////////////////////////////////////////////////////////////////////
if(isset($_POST['art-del'])){
    $id=$_POST['art-del'];
    $art=  ArticleQuery::create()->filterByNumart($id)->findOne();
    if($art){
        $art->delete();
        header('Location: http://aviaco.com/av-admin/?rub=article&list-art');
        exit();
    }else{
        echo 0;
    }
}
if(isset($_POST['edit-cat'])){
    $cat=$_POST['edit-cat'];
    //-- On selection les sous-catégories liées à cette categ --//
    $m_cat=CategorieQuery::create()->filterByURL($cat)->findOne();
    $str='';
    foreach ($m_cat->getSouscategories() as $s_cat) {
        $str.=$s_cat->getSouscategorie().'&'.$s_cat->getURL().'#';
    }
    echo $str;
}
if(isset($_POST['edit-save'])){
    //-- On recupère la première image --//
    $acces_html=new simple_html_dom();
    $acces_html->load($_POST['zone']);
    $src_img='';
    if($acces_html->find('img',0)){
        $src_img=$acces_html->find('img',0)->src;
    }
    echo $_POST['s-categ'];
    //--- On recupère la categ et la sous-categ correspondant aux url passés --//
    $categ=CategorieQuery::create()->filterByURL($_POST['categ'])->findOne();
    $s_categ=SouscategorieQuery::create()->filterByURL($_POST['s-categ'])->findOne();
    
    $isSave=0;
    if( $categ && $s_categ){
        //--- Création de l'objet article ---//
        $art=new Article();
    
        $art->setTitre($_POST['titre']);
        $art->setIdEmpFk('1');
        $art->setDateEdit(date('Y-m-d G:i:s'));
        $art->setContenu($_POST['zone']);
        $art->setResume($_POST['edit-resume']);
        $art->setImgLaune($src_img);
        $art->setUrl($_POST['url']);
        $art->setCategorie_FK($categ->getCategorie());
        $art->setSouscategorie_FK($s_categ->getSouscategorie());
        $isSave=$art->save();
    }
    echo $isSave;
}

if(isset($_POST['edit-mod'])){
    
    //-- On recupère l'article à modifier ---//
    $id=$_POST['id-art'];
    $art= ArticleQuery::create()->filterByNumart($id)->findOne();
    $isSave=0;
    if($art){
        //-- On recupère la première image --//
        $acces_html=new simple_html_dom();
        $acces_html->load($_POST['zone']);
        $src_img=null;
        if($acces_html->find('img',0)){
            $src_img=$acces_html->find('img',0)->src;
        }
        //echo $_POST['s-categ'];
        //--- On recupère la categ et la sous-categ correspondant aux url passés --//
        $categ=CategorieQuery::create()->filterByURL($_POST['categ'])->findOne();
        $s_categ=SouscategorieQuery::create()->filterByURL($_POST['s-categ'])->findOne();
    
        if( $categ && $s_categ){
            $art->setTitre($_POST['titre']);
            $art->setIdEmpFk('1');
            $art->setDateEdit(date('Y-m-d G:i:s'));
            $art->setContenu($_POST['zone']);
            $art->setResume($_POST['edit-resume']);
            if($src_img){
                $art->setImgLaune($src_img);
            }
            $art->setUrl($_POST['url']);
            $art->setCategorie_FK($categ->getCategorie());
            $art->setSouscategorie_FK($s_categ->getSouscategorie());
            $isSave=$art->save();
        }
    }
    echo $isSave;
}