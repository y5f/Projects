<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Formulaire
 *
 * @author StrawHat
 */
class CategorieForm {
    
    private $form;
    function __construct()
    {
        $this->form=new Div();
        // Premier bloc : selection
        $b_select=new Hgroup();
        $b_select->setAttribute('class', 'sel');
        $s_titre=new H1();
        $s_titre->addElement(new Text('Selection'));
        $bloc_cat=new Fieldset('Catégories');
        $s_titre->setAttribute('class', 'test');
        // selection des categories depuis la base de données 
        $mes_cats=CategorieQuery::create()->filterByNiveau(1)->find();
        
        $cat_ul=new Ul();
        
        foreach ($mes_cats as $cat){
            $em=new Em();
            $em->addElement(new Text($cat->getCategorie()));
            //echo 'ok tout v a bien ici...'.$_GET['rub'];
            $li=new Li($em,'item');
            $li->setAttribute('name', $cat->getURL());
            $li->setAttribute('value', $cat->getID());
            if($cat->countSouscategories()>0){
                $li->addElement($this->getSousCategorie($cat));
            }
            $cat_ul->addLi($li);
        }
        $bloc_cat->addElement($cat_ul);
        
        $bloc_art=new Fieldset('Articles');
        $pub=PublicationQuery::create()->filterByETAT(1)->find();
        $art_ul=new Ul();
        foreach ($pub as $p){
            $art=$p->getArticle(); 
            //print_r($art);
            $em=new Em();
            $em->addElement(new Text($art->getTitre()));
            $li=new Li($em,'');
            $art_ul->addLi($li);
        }
        $bloc_art->addElement($art_ul);
        $b_select->addElements(Array($s_titre,$bloc_cat,$bloc_art));
        // Deuxième bloc : propriétés catégorie
        $b_prop=new Hgroup();
        $b_prop->setAttribute('class', 'b-new');
        $prop_titre=new H1();
        $prop_titre->addElement(new Text('Propriétés de la catégorie'));
        
        // construction de formulaire //
        //$prop_form=new Form();
        //$prop_form->setAttribute('action', '');
        //$prop_form->setAttribute('method', 'POST');
        
        $prop_input_id=new Input();
        $prop_input_id->setAttribute('type', 'hidden');
        $prop_input_id->setAttribute('id', 'hidden');
        $prop_input_id->setAttribute('value', '');
        $prop_input_id->setAttribute('class', 'form-mod');
        
        $prop_p_p=new P();
        $prop_lab_p=new Label('');
        $prop_lab_p->addElement(new Text('Parent :'));
        $prop_input_p=new Input();
        $prop_input_p->setAttribute('type', 'text');
        $prop_input_p->setAttribute('name', 'parent');
        $prop_input_p->setAttribute('value', '');
        $prop_input_p->setAttribute('id', 'parent');
        $prop_input_p->setAttribute('class', 'form-mod');
        $prop_p_p->addElements(Array($prop_lab_p,$prop_input_p));
        
        $prop_p_cat=new P();
        $prop_p_cat->addElement(new Text('Catégorie :'));
        $prop_input_cat=new Input();
        $prop_input_cat->setAttribute('type', 'text');
        $prop_input_cat->setAttribute('name', 'cat');
        $prop_input_cat->setAttribute('value', '');
        $prop_input_cat->setAttribute('id', 'desc');
        $prop_input_cat->setAttribute('class', 'form-mod');
        $prop_p_cat_input=new P();
        $prop_p_cat_input->addElement($prop_input_cat);
        
        $prop_p_url=new P();
        $prop_p_url->addElement(new Text('URL :'));
        $prop_input_url=new Input();
        $prop_input_url->setAttribute('type', 'text');
        $prop_input_url->setAttribute('name', 'url');
        $prop_input_url->setAttribute('value', '');
        $prop_input_url->setAttribute('id', 'url');
        $prop_input_url->setAttribute('class', 'form-mod');
        $prop_p_url_input=new P();
        $prop_p_url_input->addElement($prop_input_url);
        
        $prop_p_ord=new P();
        $prop_p_ord->addElement(new Text('Ordre d\'affichage :'));
        $prop_input_ord=new Input();
        $prop_input_ord->setAttribute('type', 'number');
        $prop_input_ord->setAttribute('name', 'ord');
        $prop_input_ord->setAttribute('value', '');
        $prop_input_ord->setAttribute('id', 'ord');
        $prop_input_ord->setAttribute('class', 'form-mod');
        $prop_p_ord_input=new P();
        $prop_p_ord_input->addElement($prop_input_ord);
        
        $prop_p_com=new P();
        $prop_p_com->addElement(new Text('Commentaire :'));
        $prop_input_com=new Textarea();
        $prop_input_com->setAttribute('name', 'com');
        $prop_input_com->setAttribute('id', 'com');
        $prop_input_com->setAttribute('class', 'form-mod');
        $prop_p_com_input=new P();
        $prop_p_com_input->addElement($prop_input_com);
        
        
        $prop_p_bout=new P();
        
        // boutton modification
        $prop_input_bout=new Input();
        $prop_input_bout->setAttribute('type', 'submit');
        $prop_input_bout->setAttribute('value', 'Modifier');
        $prop_input_bout->setAttribute('id', 'prop-mod');
        //$prop_input_bout->setAttribute('class', 'el categorie');
        
        // boutton suppression
        $prop_input_bout_s=new Input();
        $prop_input_bout_s->setAttribute('type', 'submit');
        $prop_input_bout_s->setAttribute('value', 'Supprimer');
        $prop_input_bout_s->setAttribute('id', 'prop-sup');
        //$prop_input_bout_s->setAttribute('class', 'el categorie');
        
        $prop_p_bout->addElements(Array($prop_input_bout,$prop_input_bout_s));
        
        //$prop_form->addElements(Array($prop_titre,$prop_p_p,$prop_p_cat,$prop_p_cat_input,$prop_p_url,$prop_p_url_input,$prop_p_ord,$prop_p_ord_input,$prop_p_com,$prop_p_com_input,$prop_p_bout));
        $b_prop->addElements(Array($prop_titre,$prop_input_id,$prop_p_p,$prop_p_cat,$prop_p_cat_input,$prop_p_url,$prop_p_url_input,$prop_p_ord,$prop_p_ord_input,$prop_p_com,$prop_p_com_input,$prop_p_bout));
        
        // troisième bloc : nouvelle catégorie
        $b_new_categ=new Hgroup();
        $b_new_categ->setAttribute('class', 'b-categ');
        $new_titre=new H1();
        $new_titre->addElement(new Text('Nouvelle catégorie'));
        // construction de formulaire //
        //$new_form=new Form();
        //$new_form->setAttribute('action', '');
        //$new_form->setAttribute('method', 'POST');
        $new_p_p=new P();
        $new_lab_p=new Label('');
        $new_lab_p->addElement(new Text('Parent :'));
        $new_input_p=new Select();
        $opt=new Option();
        $opt->addElement(new Text('aucun'));
        $new_input_p->addElement($opt);
        $new_input_p->setAttribute('name', 'parent');
        $new_input_p->setAttribute('value', '');
        $new_input_p->setAttribute('id', 'n-parent');
        $new_input_p->setAttribute('class', 'form');
        $new_p_p->addElements(Array($new_lab_p,$new_input_p));
        
        $new_p_cat=new P();
        $new_p_cat->addElement(new Text('Catégorie :'));
        $new_input_cat=new Input();
        $new_input_cat->setAttribute('type', 'text');
        $new_input_cat->setAttribute('name', 'cat');
        $new_input_cat->setAttribute('value', '');
        $new_input_cat->setAttribute('id', 'cat');
        $new_input_cat->setAttribute('class', 'form');
        $new_p_cat_input=new P();
        $new_p_cat_input->addElement($new_input_cat);
        
        $new_p_url=new P();
        $new_p_url->addElement(new Text('URL :'));
        $new_input_url=new Input();
        $new_input_url->setAttribute('type', 'text');
        $new_input_url->setAttribute('name', 'url');
        $new_input_url->setAttribute('value', '');
        $new_input_url->setAttribute('id', 'n-url');
        $new_input_url->setAttribute('class', 'form');
        $new_p_url_input=new P();
        $new_p_url_input->addElement($new_input_url);
        
        $new_p_ord=new P();
        $new_p_ord->addElement(new Text('Ordre d\'affichage :'));
        $new_input_ord=new Input();
        $new_input_ord->setAttribute('type', 'number');
        $new_input_ord->setAttribute('name', 'ord');
        $new_input_ord->setAttribute('value', '');
        $new_input_ord->setAttribute('id', 'n-ord');
        $new_input_ord->setAttribute('class', 'form');
        $new_p_ord_input=new P();
        $new_p_ord_input->addElement($new_input_ord);
        
        $new_p_com=new P();
        $new_p_com->addElement(new Text('Commentaire :'));
        $new_input_com=new Textarea();
        $new_input_com->setAttribute('name', 'com');
        $new_input_com->setAttribute('id', 'n-com');
        $new_input_com->setAttribute('class', 'form');
        $new_p_com_input=new P();
        $new_p_com_input->addElement($new_input_com);
        
        $new_p_bout=new P();
        $new_input_bout=new Input();
        $new_input_bout->setAttribute('type', 'submit');
        $new_input_bout->setAttribute('value', 'Valider');
        $new_input_bout->setAttribute('id', 'new-valider');
        //$new_input_bout->setAttribute('class', 'el categorie');
        $new_p_bout->addElement($new_input_bout);
        
        //$new_form->addElements(Array($new_titre,$new_p_p,$new_p_cat,$new_p_cat_input,$new_p_url,$new_p_url_input,$new_p_ord,$new_p_ord_input,$new_p_com,$new_p_com_input,$new_p_bout));
        $b_new_categ->addElements(Array($new_titre,$new_p_p,$new_p_cat,$new_p_cat_input,$new_p_url,$new_p_url_input,$new_p_ord,$new_p_ord_input,$new_p_com,$new_p_com_input,$new_p_bout));
        $this->form->addElements(Array($b_select,$b_prop,$b_new_categ));
        
    }
    function getForm()
    {
        return $this->form;
    }
    
    function getSousCategorie(Categorie $cat){
        $ul=new Ul();
        foreach ($cat->getSouscategories() as $s_cat){
            $em=new Em();
            $em->addElement(new Text($s_cat->getSouscategorie()));
            $li=new Li($em,'item');
            $li->setAttribute('name',$s_cat->getURL());
            $li->setAttribute('value', $s_cat->getID());
            // on vérifie si la catégorie à des enfants //
            $s_categ=CategorieQuery::create()->filterByCATEGORIE($s_cat->getSOUSCATEGORIE())->find();
            foreach ($s_categ as $c) {
                if($c->getNiveau()!=$cat->getNiveau()){
                    $li->addElement($this->getSousCategorie($c));
                }
            }
            $ul->addLi($li);   
        }
        return $ul;
        
    }
    
}
