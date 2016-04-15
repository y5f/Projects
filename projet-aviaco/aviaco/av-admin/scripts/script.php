<?php session_start();

//----- Classe de chargement  ---------
require_once '../../vendor/autoload.php';
require_once '../../generated-conf/config.php';
$host='http://aviaco.com';
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
    $categ=explode('^',$_POST['cat']);
    $cat=CategorieQuery::create()->filterByID($categ[0])->filterByURL($categ[1])->filterByNIVEAU(1)->findOne();
    $parent='aucun';
    if(!$cat){
        $cat=SouscategorieQuery::create()->filterByID($categ[0])->filterByURL($categ[1])->findOne();
        $parent=$cat->getCategorie()->getCategorie();
        $ca=$cat->getSouscategorie();
        $desc=$cat->getCommentaire();
    }else{
        $desc=$cat->getCommentaire();
        $ca=$cat->getCategorie();
    }
    
    echo $cat->getID().'#'.$parent."#".$ca."#".$cat->getURL()."#".$cat->getOrdre()."#".$desc;
    
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
        $is_sous_cat=SouscategorieQuery::create()->filterByID($data[0])->filterBySouscategorie($data[1])->findOne();
        
        if($is_sous_cat && (!CategorieQuery::create()->filterByCategorie($is_sous_cat
                ->getSouscategorie())->filterByNiveau($is_sous_cat
                        ->getCategorie()->getNiveau()+1)->exists())){
            $parent=$is_sous_cat->getCategorie();
            $new_cat=new Categorie();
            $new_cat->setCategorie($is_sous_cat->getSouscategorie());
            $new_cat->setCommentaire($is_sous_cat->getCommentaire());
            $new_cat->setORDRE($is_sous_cat->getORDRE());
            $new_cat->setNIVEAU($parent->getNIVEAU()+1);
            $new_cat->setURL($is_sous_cat->getURL());
            $new_cat->save();
            $is_parent=$new_cat;
        }elseif($is_sous_cat){
            $is_parent=CategorieQuery::create()->filterByCategorie($is_sous_cat
                ->getSouscategorie())->filterByNiveau($is_sous_cat
                        ->getCategorie()->getNiveau()+1)->findOne();
        }else{
            $is_parent=CategorieQuery::create()->filterByID($data[0])->findOne();
        }
        
        $new_cat=new Souscategorie();
        $new_cat->setCategorie($is_parent);
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
        if($data[6]!=='aucun'){
            $is_sous_menu=SousmenuQuery::create()->filterByID($data[6])->findOne();
        }else{
            $is_sous_menu=SousmenuQuery::create()->filterByID($data[0])->filterBySousmenu($data[1])->findOne();
        }
        if($is_sous_menu && (!MenusQuery::create()->filterByMenu($is_sous_menu
                ->getSousmenu())->filterByNiveau($is_sous_menu
                        ->getMenus()->getNiveau()+1)->exists())){
            //echo $is_sous_cat;
            $parent=$is_sous_menu->getMenus();
            $new_menu=new Menus();
            $new_menu->setMenu($is_sous_menu->getSousmenu());
            $new_menu->setCommentaire($is_sous_menu->getCommentaire());
            $new_menu->setOrdre($is_sous_menu->getOrdre());
            $new_menu->setNiveau($parent->getNiveau()+1);
            $new_menu->setURL($is_sous_menu->getURL());
            $new_menu->save();
            $parent_menu=$new_menu;
        }elseif($is_sous_menu){
            $parent_menu=MenusQuery::create()->filterByMenu($is_sous_menu
                ->getSousmenu())->filterByNiveau($is_sous_menu
                        ->getMenus()->getNiveau()+1)->findOne();
        }else{
            $parent_menu=MenusQuery::create()->filterByID($data[0])->findOne();
        }
        $new_menu=new Sousmenu();
        $new_menu->setMenus($parent_menu);
        $new_menu->setSousmenu($data[2]);
        $new_menu->setCommentaire($data[5]);
        $new_menu->setOrdre($data[4]);
        $new_menu->setURL($data[3]);
        echo $new_menu->save();
    }
}
if(isset($_POST['ad-m'])){
    $categ=explode('^',$_POST['ad-m']);
    $cat=MenusQuery::create()->filterByID($categ[0])->filterByURL($categ[1])->filterByNiveau(1)->findOne();
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
if(isset($_POST['get-s-menu'])){
    $menu=MenusQuery::create()->filterByMenu($_POST['get-s-menu'])->findOne();
    $opt_def=new Option();
    $opt_def->addElement(new Text('aucun'));
    $str=$opt_def->toHTML();
    foreach (SousmenuQuery::create()->filterByMenus($menu)->find() as $s_menu) {
        $opt=new Option();
        $opt->setAttribute('value', $s_menu->getID());
        $opt->addElement(new Text($s_menu->getSousmenu()));
        $str.=$opt->toHTML();
    }
    echo $str;
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
        header('Location: '.$host.'./av-admin/?rub=article&list-art');
        exit();
    }else{
        echo 0;
    }
}
if(isset($_POST['edit-cat'])){
    $cat=$_POST['edit-cat'];
    //-- On selection les sous-catégories liées à cette categ --//
    $m_cat=CategorieQuery::create()->filterByURL($cat)->findOne();
    $str='aucun#';
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
    //--- On recupère la categ et la sous-categ correspondant aux url passés --//
    $categ=CategorieQuery::create()->filterByCategorie($_POST['categ'])->findOne();
    
    $isSave=0;
    if( $categ){
        
        //--- On recupère l'utilisateur ---
        if(isset($_SESSION['aviaco']['usr'])){
            $usr=EmployeQuery::create()->filterByEmail($_SESSION['aviaco']['usr'])->findOne();
            if($usr){
                //--- Création de l'objet article ---//
                $art=new Article();
    
                $art->setTitre($_POST['titre']);
                $art->setEmploye($usr);
                $art->setDateEdit(date('Y-m-d G:i:s'));
                $art->setContenu($_POST['zone']);
                $art->setResume($_POST['edit-resume']);
                $art->setImgLaune($src_img);
                $art->setUrl($_POST['url']);
                $art->setCategorie_FK($categ->getCategorie());
                
                if($_POST['s-categ']!=='aucun'){
                    $s_categ=SouscategorieQuery::create()->filterBySouscategorie($_POST['s-categ'])->findOne();
                    $art->setSouscategorie_FK($s_categ->getSouscategorie());
                }
                
                $isSave=$art->save();
                
                header('Location: '.$host.'/av-admin/?rub=article&edit='.$art->getNumart());
            }
        }
    }
    
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
        $categ=CategorieQuery::create()->filterByCategorie($_POST['categ'])->findOne();
    
        if( $categ){
            $art->setTitre($_POST['titre']);
            //$art->setIdEmpFk('1');
            $art->setDateEdit(date('Y-m-d G:i:s'));
            $art->setContenu($_POST['zone']);
            $art->setResume($_POST['edit-resume']);
            if($src_img){
                $art->setImgLaune($src_img);
            }
            $art->setUrl($_POST['url']);
            $art->setCategorie_FK($categ->getCategorie());
            
            if($_POST['s-categ']!=='aucun'){
                $s_categ=SouscategorieQuery::create()->filterBySouscategorie($_POST['s-categ'])->findOne();
                $art->setSouscategorie_FK($s_categ->getSouscategorie());
            }else{
                $art->setSouscategorie_FK();
            }
            
            $isSave=$art->save();
        }
        
         header('Location: '.$host.'/av-admin/?rub=article&edit='.$art->getNumart());
    }
}

//############ SCRIPT POUR LES WIDGETS ############################
if(isset($_POST['load-panneau'])){
    $data=explode('^', $_POST['load-panneau']);
    
    //--- On recupère l'article  -----
    $art=ArticleQuery::create()->filterByNumart($data[0])->findOne();
    
    //---On verifie si ce bloc n'existe pas deja ---
    $widg=WidgetQuery::create()->filterByNumbloc($data[1])->findOne();
    if($widg){
        $widg->setArticle($art);
        $isOK=$widg->save();
    }else{
        $widg=new Widget();
        $widg->setArticle($art);
        $widg->setNumbloc($data[1]);
        $isOK=$widg->save();
    }
    
    if($isOK){
        if($art->getImgLaune()){
            $img=new Img('/'.$art->getImgLaune());
        }else{
            $img=new Img('/upload/img_1.jpg');
        }
    
        $p_txt=new H1();
        $p_txt->addElement(new Text($art->getTitre()));
        $str=$data[1].'^'.$p_txt->toHTML().$img->toHTML();
        echo $str;
    }       
}
if(isset($_POST['search'])){
    $val='%'.$_POST['search'].'%';
    $logic=Propel\Runtime\ActiveQuery\Criteria::LOGICAL_OR;
    $search=ArticleQuery::create()->condition('c1', 'article.art_num LIKE ?', $val)->condition('c6', 'article.titre LIKE ?', $val)
            ->condition('c2', 'article.contenu LIKE ?', $val)
            ->condition('c3', 'article.resume LIKE ?', $val)->condition('c4', 'article.categorie_FK LIKE ?', $val)
            ->condition('c5', 'article.sous_categorie_FK LIKE ?', $val)
            ->where(array('c1','c6','c2','c3','c4','c5'), $logic)->find();
    $str='';
    foreach ($search as $art) {
        $pub=PublicationQuery::create()->filterByArticle($art)->findOne();
        if($pub){
            if($pub->getEtat()){
                $li=new Li(new Text($art->getTitre()), 'li-widget');
                $li->setAttribute('value', $art->getNumart());
                $str.=$li->toHTML();
            }
        }
    }
    echo $str;
}