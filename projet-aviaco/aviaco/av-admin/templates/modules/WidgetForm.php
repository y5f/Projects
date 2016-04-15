<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class WidgetForms {

    private $form;
    function __construct() {
        $this->form=new Div();
        $this->form->setAttribute('class', 'widget-form');
        
        $w_bloc=new Fieldset('Gestion du Panneau');
        $w_bloc->setAttribute('class', 'b-widget');
        
        $hg_la_une=new Hgroup();
        $hg_la_une->setAttribute('class', 'b-la-une');
        
        $hg_stock=new Hgroup();
        $hg_stock->setAttribute('id', '3');
        $hg_stock->setAttribute('class', 'b-pann');
        $num_art_sck=WidgetQuery::create()->filterByNumbloc(3)->findOne();
        if($num_art_sck){
            $art=ArticleQuery::create()->filterByNumart($num_art_sck->getNumarticle())->findOne();
            $img=new Img('/'.$art->getImgLaune());
            $p_txt=new H1();
            $p_txt->addElement(new Text($art->getTitre()));
            $hg_stock->addElements(Array($p_txt,$img));
        }
        $hg_inst=new Hgroup();
        $hg_inst->setAttribute('id', '4');
        $hg_inst->setAttribute('class', 'b-pann');
        $num_art_inst=WidgetQuery::create()->filterByNumbloc(4)->findOne();
        if($num_art_inst){
            $art=ArticleQuery::create()->filterByNumart($num_art_inst->getNumarticle())->findOne();
            $img=new Img('/'.$art->getImgLaune());
            $p_txt=new H1();
            $p_txt->addElement(new Text($art->getTitre()));
            $hg_inst->addElements(Array($p_txt,$img));
        }
        
        $hg_qualite=new Hgroup();
        $hg_qualite->setAttribute('id', '2');
        $hg_qualite->setAttribute('class', 'b-pann');
        $num_art_qte=WidgetQuery::create()->filterByNumbloc(2)->findOne();
        if($num_art_qte){
            $art=ArticleQuery::create()->filterByNumart($num_art_qte->getNumarticle())->findOne();
            $img=new Img('/'.$art->getImgLaune());
            $p_txt=new H1();
            $p_txt->addElement(new Text($art->getTitre()));
            $hg_qualite->addElements(Array($p_txt,$img));
        }
        
        $hg_regl=new Hgroup();
        $hg_regl->setAttribute('id', '1');
        $hg_regl->setAttribute('class', 'b-pann');
        $num_art_reg=WidgetQuery::create()->filterByNumbloc(1)->findOne();
        if($num_art_reg){
            $art=ArticleQuery::create()->filterByNumart($num_art_reg->getNumarticle())->findOne();
            $img=new Img('/'.$art->getImgLaune());
            $p_txt=new H1();
            $p_txt->addElement(new Text($art->getTitre()));
            $hg_regl->addElements(Array($p_txt,$img));
        }
        
        $w_bloc->addElements(Array($hg_regl,$hg_qualite,$hg_stock,$hg_inst));
        
        $w_list=new Fieldset('Liste des articles publiés');
        $w_list->setAttribute('class', 'b-list');

        $input_find=new Input();
        $input_find->setAttribute('type','search');
        $input_find->setAttribute('class','search');
        $input_find->setAttribute('placeholder','Recherche');
        $input_find->setAttribute('value','');
        $input_find->setAttribute('oninput','search(this.value)');
        
        $ul_art=new Ul();
        $ul_art->setAttribute('class', 'b-list-widget');
        foreach (PublicationQuery::create()->filterByEtat(1)->find() as $pub) {
            $art=$pub->getArticle();
            $li=new Li(new Text($art->getTitre()), 'li-widget');
            $li->setAttribute('value', $art->getNumart());
            $ul_art->addLi($li);
        }
        $w_list->addElements(Array($input_find,$ul_art));
        
        $this->form->addElements(Array($w_bloc,$w_list));
        
    }
    
    function getForm() {
        return $this->form;
    }

}
