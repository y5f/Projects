<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Listmodel {

    private $section;
    private $form_details;
    function __construct() {
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
        $panneau->addElement($menu);
        
        $this->form_details=new Hgroup();
        $this->form_details->setAttribute('class', 'form-details');
        
        //-- On recupère la liste d'appareil liés à la ctégorie --//
        
        $cat=CategorieQuery::create()->filterByURL($_GET['url'])->findOne();
        if(!$cat){
            $cat=SouscategorieQuery::create()->filterByURL($_GET['url'])->findOne();
            $m_titre=$cat->getSouscategorie();
        }else{
            $m_titre=$cat->getCategorie();
        }
        
        //-- Le titre de l'affichage ---//
        $titre=new H3();
        $titre->addElement(new Text($m_titre));
        $this->form_details->addElement($titre);
        
        //--- On cherche la marque qui possède cette catégorie --//
        if($_GET['url']!='galerie'){
           $marque=MarqueQuery::create()->filterByMarque($m_titre)->findOne();
           $retour=$this->getAppareils($marque);
        }else{
           $retour=$this->getGalerie($cat);
        }
        $panneau->addElement($this->form_details);
        $main_pan->addElement($panneau);
        $this->section->addElement($main_pan);
    }
    
    function getList() {
        echo $this->section->toHTML();
    }
    function getAppareils(Marque $marque) {
        $cmpt=1;
        foreach ($marque->getAppareils() as $app) {
            
            $fig=new Figure();
            $fig->setAttribute('class', 'details');
            $fig->setAttribute('name', 'd-capt-'.$cmpt);
            
            //--- Le label qui affiche le nom de l'appareil --//
            $lab=new Label('titre');
            $lab->addElement(new Text($app->getNomApp()));
            $fig->addElement($lab);
            
            //--- L'image de l'appareil à afficher : sa derniere image --//
            $img_app=PhotoappareilQuery::create()->filterByAppareil($app)->filterByEtat(0)->findOne();
            
            if(!$img_app){
                $img='upload/no-img.jpg';
                $comment='Aucune image pour cette appareil';
            }else{
                $img=$img_app->getPhoto();
                $comment=$img_app->getCommentaire();
            }
            
            $p=new P();
            $p->addElement(new Text($comment));
            
            $capt=new FigCaption($p->toHTML());
            $capt->setAttribute('id', 'd-capt-'.$cmpt);
            
            $fig->addImg(Array('src'=>$img));
            $fig->addCaption($capt);
            $this->form_details->addElement($fig);
            $cmpt++;
        }
    }
    function getGalerie($categorie) {
        $cmpt=1;
        foreach ($categorie->getMedias()as $media) {
            //$media=new Media();
            $fig=new Figure();
            $fig->setAttribute('class', 'details');
            $fig->setAttribute('name', 'd-capt-'.$cmpt);
            
            //--- Le label qui affiche le nom de l'appareil --//
            $lab=new Label('titre');
            $lab->addElement(new Text($media->getDescription()));
            $fig->addElement($lab);
            
            $p=new P();
            $p->addElement(new Text($media->getCommentaire()));
            
            $capt=new FigCaption($p->toHTML());
            $capt->setAttribute('id', 'd-capt-'.$cmpt);
            
            $fig->addImg(Array('src'=>$media->getURL()));
            $fig->addCaption($capt);
            $this->form_details->addElement($fig);
            $cmpt++;
        }
    }
}
