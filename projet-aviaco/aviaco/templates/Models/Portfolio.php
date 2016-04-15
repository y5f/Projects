<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Portfolio {

    private $fig_portofolio;
    private $section;
    
    function __construct() {
        
    }
    function load_content() {
        
        $this->section=new Section();
        //-- 
        $main_pan=new Div();
        $main_pan->setAttribute('class', 'main-pane');

        $menu=new Div();
        $menu->setAttribute('class', 'main-menu row');
        $recue_menu=new Menu();
        $menu->addElement($recue_menu->getTop_menu());
        $panneau=new Div();
        $panneau->setAttribute('class', 'f-panneau');
        
        $trans_folio=new Div();
        $trans_folio->setAttribute('class', 'trans-folio');
        
        $filtre=new Div();
        $filtre->setAttribute('class', 'filtre');
        
        $this->fig_portofolio=new Figure();
        $this->fig_portofolio->setAttribute('class', 'portfolio');
        
        $this->fig_portofolio->addElement($filtre);
        $this->fig_portofolio->addElement($trans_folio);
        
        $isSous_cat=false;
        //--- On teste si un ID est defini --//
        if(isset($_GET['id'])){
            $current_art=$_GET['id'];
            //-- On recupère l'article lié à cet ID --//
            $art=ArticleQuery::create()->filterByNumart($current_art)->findOne();
            
        }else{
            $current_art=$_GET['url'];
            $art=ArticleQuery::create()->filterByUrl($current_art)->findOne();
            $cat=MenusQuery::create()->filterByURL($current_art)->findOne();
            //print_r($cat);
            
            if(!$cat){
               //$cat=SousmenuQuery::create()->filterByURL($current_art)->findOne();  
               $isSous_cat=true;
            }
        }
        
        //--- Si l'article existe on appel le contenu, sinon on teste s'il ---//
        //---- s'agit d'un formulaire de contatc, sinon on retourne à la page home--//
        if($art){
            $this->getContent($art,$isSous_cat);
        }elseif($_GET['url']=='contact' || $_GET['url']=='formulaire-de-demande'){
            $contact=new Contactform();
            $this->getContactform($contact->getFormulaire());
        }elseif($_GET['url']!='qualite'){
            $this->getConstruct();
        }
        
        $panneau->addElements(Array($menu,$this->fig_portofolio));
        $main_pan->addElements(Array($panneau));
        $this->section->addElement($main_pan);
    }
    function getPortfolio() {
        $this->load_content();
        echo $this->section->toHTML();
    }
    function getContactform($param) {
        $this->fig_portofolio->addImg(Array('src'=>'upload/actu-aviaco.jpg'));
        $capt=new FigCaption($param);
        $capt->setAttribute('class', 'contact-form');
        $this->fig_portofolio->addCaption($capt);
    }
    function getContent($art,$isSous_cat) {
        //--- On liste les sous-catégories liées à cette sous-catégorie ---//
        //-- On verifie si la sous-cat possède des ous-cat ---//
        $bloc_ul=new Ul();
        $bloc_ul->setAttribute('class', 'bloc');
          
        if(!$isSous_cat){
            $sous_categ=$art->getCategorie()->getSouscategories();
            foreach ($sous_categ as $s_cat) {
                if($s_cat->getSouscategorie()!='autre'){
                    $li=new Li(new Text($s_cat->getSouscategorie()), $s_cat->getURL());
                    $a_li=new A($li, '?url='.$s_cat->getURL().'&'.$s_cat->getCommentaire());
                    $bloc_ul->addElement($a_li);
                }
            }
            
        }
        $this->fig_portofolio->addElement($bloc_ul);
        $this->fig_portofolio->addImg(Array('src'=>$art->getImgLaune()));
        $capt=new FigCaption($art->getContenu());
        $capt->setAttribute('class', 'capt-folio');
        $this->fig_portofolio->addCaption($capt);
      
    }
    function getConstruct() {
        $this->fig_portofolio->addImg(Array('src'=>'upload/construct.jpg'));
        $capt=new FigCaption('<-- Page en construction -->');
        $capt->setAttribute('class', 'capt-folio');
        $this->fig_portofolio->addCaption($capt);
    }

}
