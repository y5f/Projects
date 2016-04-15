<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Slider {

    private $slide_show;
    function __construct() {
        
        //--- Container principale du slider ----//
        $this->slide_show=new Hgroup();
        $this->slide_show->setAttribute('class', 'slide-show');
                
         //--- Contenaire de bas en positio absolu ---//
        $w_slide=new Div();
        $w_slide->setAttribute('class', 'w-slide');
        
        //-- On ajoute un ance afin de controler le scroll de la page ---
        $scroll=new Div();
        $scroll->setAttribute('class', 'scroll');
                
        $slide=new Hgroup();
        $slide->setAttribute('class', 'slide');
        
        //--- On ajoute le film transparent ----//
        $film=new Div();
        $film->setAttribute('class', 'film-tr');
        $slide->addElement($film);
        
        //--- Ajout d'un filtre ----
        $filtre=new Div();
        $filtre->setAttribute('class', 'filtre');
        $slide->addElement($filtre);
         
        //-- Les bouton de navigation ----
        $nav=new Hgroup();
        $prec=new Img('styles/img/prec.png');
        $prec->setAttribute('class', 'nav prec');
        $prec->setAttribute('name', 'prec');
            
        $suiv=new Img('styles/img/suiv.png');
        $suiv->setAttribute('class', 'nav suiv');
        $suiv->setAttribute('name', 'suiv');
            
        $nav->addElements(Array($prec,$suiv));
        $slide->addElement($nav);
        
        //--- Le bloc pour les commentaires du slider ---
        $coment=new Div();
        $coment->setAttribute('class', 'coment-slide');
        $slide->addElement($coment);
            
        $slider=new Div();
        $slider->setAttribute('class', 'slider');
        
        //--- On crée les images qui feront le slider ---
        
        //--- On recupère les articles postés à la Une ---//
        $mesSliders=PublicationQuery::create()->filterByEtat(1)->filterByisSlider(1)->limit(5)->find();
        
        //--- Calcul du nombre d'images à chercher pour completer le slider --//
        $nbr_img=5-count($mesSliders);
        //print_r($mesSliders);
        $cmpt=1;
        foreach ($mesSliders as $sld) {
            $fig=new Figure();
            $fig->setAttribute('class', 'fig');
            
            //--- Titre du slider -------
            $titre=new H1();
            $titre->setAttribute('class', 'titre coment');
            //$titre->addElement(new Text($sld->getArticle()->getTitre()));
            
            $desc=$sld->getArticle()->getResume();
            $capFig=new FigCaption($desc);
            $capFig->setAttribute('class', 'coment quot_'.$cmpt);
            
           
            $fig->addImg(Array('src'=>$sld->getArticle()->getImgLaune()));
            $fig->addCaption($capFig);
            $fig->addElement($titre);
            
            $cmpt++;
            //$url_sld=new A($fig, $sld->getArticle()->getURL());
            $slider->addElement($fig);
            
            //--- On rajoute des images si les article ne sont pas 5 ---//
            //echo $cmpt." -- ".count($mesSliders);
            if($cmpt>=count($mesSliders) && $cmpt<=5){
                //--- On recupère des photo à afficher ---//
                
                $mes_img=PhotoappareilQuery::create()->filterByEtat(1)->limit($nbr_img)->find();
                //print_r($mes_img);
                foreach ($mes_img as $value) {
                    
                    $fig=new Figure();
                    $fig->setAttribute('class', 'fig');
            
                    //--- Titre du slider -------
                    $titre=new H1();
                    $titre->setAttribute('class', 'titre coment');
                    //$titre->addElement(new Text($value->getTitre()));
            
                    $desc=$value->getCommentaire();
                    $capFig=new FigCaption($desc);
                    $capFig->setAttribute('class', 'coment quot_'.$cmpt++);
            
                    $fig->addImg(Array('src'=>$value->getPhoto()));
                    $fig->addCaption($capFig);
                    $fig->addElement($titre);
                    //echo $value->getURL();
                    //$url_slider=new A($fig, $value->getAppareil()->getURL());
                    $slider->addElement($fig);
                }
                
            }
        }
        
        $slide->addElement($slider);
        $w_slide->addElement($slide);
        $this->slide_show->addElements(Array($w_slide));
       // $this->slide->addElement($slider);
    }
    
    //--- Cette méthode retourne toutes les images crées ----
    function getSlider() {
        return $this->slide_show;
    }

}
