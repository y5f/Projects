<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class MenuForm {

    private $form;
    function __construct() {
        
        $this->form=new Div();
        
        // Premier bloc : selection
        $b_select=new Hgroup();
        $b_select->setAttribute('class', 'sel-menu');
        $s_titre=new H1();
        $s_titre->addElement(new Text('Selection'));
        $s_titre->setAttribute('class', 'test');
        
        
        //--- Selection des menu existants depuis la base ---
        $bloc_menu=new Fieldset('Menus');
        
        //$mes_menu=MENU_BOXQuery::create()->filterByNIVEAU(1)->find();
        $menu_ul=$this->getMenus(true);
        //--- Bouton d'ajout de menu de gauche à droite ---//
        $add_b=new Input();
        $add_b->setAttribute('type', 'submit');
        $add_b->setAttribute('class', 'ad-m');
        $add_b->setAttribute('value', '>>');
        
        $bloc_menu->addElements(Array($menu_ul,$add_b));
        
        // selection des categories depuis la base de données
        $bloc_cat=new Fieldset('Catégories');
        $mes_cats=CategorieQuery::create()->filterByNIVEAU(1)->find();
        
        $cat_ul=new Ul();
        
        foreach ($mes_cats as $cat){
            $c_box=new Input();
            $c_box->setAttribute('type', 'checkbox');
            $c_box->setAttribute('class', 'cbx');
            $c_box->setAttribute('name', $cat->getURL());
            $c_box->setAttribute('value', $cat->getID());
            $em=new Em();
            $em->addElements(Array($c_box,new Text($cat->getCategorie())));
            //$c_box->setAttribute('checked', 'checked');
            $li=new Li($em,'');
            $li->setAttribute('name', $cat->getURL());
            if($cat->countSouscategories()>0){
                $li->addElement($this->getSousCategorie($cat));
            }
            $cat_ul->addElement($li);
        }
        
        //--- Bouton d'ajout de menu de gauche à droite ---//
        $add_bout=new Input();
        $add_bout->setAttribute('type', 'submit');
        $add_bout->setAttribute('class', 'add');
        $add_bout->setAttribute('value', '>>');
        
        $bloc_cat->addElements(Array($cat_ul,$add_bout));
        
        $bloc_art=new Fieldset('Articles');
        $pub=PublicationQuery::create()->filterByEtat(1)->find();
        $art_ul=new Ul();
        foreach ($pub as $p){
            $art=$p->getArticle();
            $c_box=new Input();
            $c_box->setAttribute('type', 'checkbox');
            $c_box->setAttribute('class', 'cbx');
            $c_box->setAttribute('value', $art->getUrl());
            $c_box->setAttribute('name', $art->getTitre());
            $em=new Em();
            $em->addElement(new Text($c_box->toHTML().$art->getTitre()));
            $li=new Li($em,'');
            $art_ul->addLi($li);
        }
        //--- Bouton d'ajout de menu de gauche à droite ---//
        $add_a=new Input();
        $add_a->setAttribute('type', 'submit');
        $add_a->setAttribute('class', 'ad-a');
        $add_a->setAttribute('value', '>>');
        
        $bloc_art->addElements(Array($art_ul,$add_a));
        $hr=new Hr();
        $b_select->addElements(Array($s_titre,$bloc_menu,$hr,$bloc_cat,$hr,$bloc_art));
        
        // Deuxième bloc : propriétés catégorie
        $b_prop=new Hgroup();
        $b_prop->setAttribute('class', 'b-new');
        $prop_titre=new H1();
        $prop_titre->addElement(new Text('Ajouter un Menu'));
        
        
        // construction de formulaire //
        //$prop_form=new Form();
        //$prop_form->setAttribute('action', '');
        //$prop_form->setAttribute('method', 'POST');
        
        $prop_input_id=new Input();
        $prop_input_id->setAttribute('type', 'hidden');
        $prop_input_id->setAttribute('id', 'hidden');
        $prop_input_id->setAttribute('value', '');
        $prop_input_id->setAttribute('class', 'form form-mod');
        
        $prop_p_p=new P();
        $prop_lab_p=new Label('');
        $prop_lab_p->addElement(new Text('Parent :'));
        $prop_input_p=new Select();
        $prop_input_p->setAttribute('name', 'parent');
        $aucun=new Option();
        $aucun->addElement(new Text('aucun'));
        $prop_input_p->addElement($aucun);
        foreach (MenusQuery::create()->find() as $m) {
            $opt=new Option();
            $opt->addElement(new Text($m->getMenu()));
            $prop_input_p->addElement($opt);
        }
        $prop_input_p->setAttribute('id', 'parent');
        $prop_input_p->setAttribute('class', 'form form-mod');
        $prop_p_p->addElements(Array($prop_lab_p,$prop_input_p));
        
        $s_prop_p_p=new P();
        $s_prop_lab_p=new Label('');
        $s_prop_lab_p->addElement(new Text('Sous-Parent :'));
        $s_prop_input_p=new Select();
        $s_prop_input_p->setAttribute('name', 's-parent');
        $s_aucun=new Option();
        $s_aucun->addElement(new Text('aucun'));
        $s_prop_input_p->addElement($aucun);

        $s_prop_input_p->setAttribute('id', 's-parent');
        $s_prop_input_p->setAttribute('class', 'form-mod');
        $s_prop_p_p->addElements(Array($s_prop_lab_p,$s_prop_input_p));
        
        $prop_p_desc=new P();
        $prop_p_desc->addElement(new Text('Description :'));
        $prop_input_desc=new Input();
        $prop_input_desc->setAttribute('type', 'text');
        $prop_input_desc->setAttribute('name', 'desc');
        $prop_input_desc->setAttribute('value', '');
        $prop_input_desc->setAttribute('id', 'desc');
        $prop_input_desc->setAttribute('class', 'form form-mod');
        $prop_p_desc_input=new P();
        $prop_p_desc_input->addElement($prop_input_desc);
        
        $prop_p_url=new P();
        $prop_p_url->addElement(new Text('URL :'));
        $prop_input_url=new Input();
        $prop_input_url->setAttribute('type', 'text');
        $prop_input_url->setAttribute('name', 'url');
        $prop_input_url->setAttribute('value', '');
        $prop_input_url->setAttribute('id', 'url');
        $prop_input_url->setAttribute('class', 'form form-mod');
        $prop_p_url_input=new P();
        $prop_p_url_input->addElement($prop_input_url);
        
        $prop_p_ord=new P();
        $prop_p_ord->addElement(new Text('Ordre d\'affichage :'));
        $prop_input_ord=new Input();
        $prop_input_ord->setAttribute('type', 'number');
        $prop_input_ord->setAttribute('name', 'ord');
        $prop_input_ord->setAttribute('value', '');
        $prop_input_ord->setAttribute('id', 'ord');
        $prop_input_ord->setAttribute('class', 'form form-mod');
        $prop_p_ord_input=new P();
        $prop_p_ord_input->addElement($prop_input_ord);
        
        $prop_p_com=new P();
        $prop_p_com->addElement(new Text('Commentaire :'));
        $prop_input_com=new Textarea();
        $prop_input_com->setAttribute('name', 'com');
        $prop_input_com->setAttribute('id', 'com');
        $prop_input_com->setAttribute('class', 'form form-mod');
        $prop_p_com_input=new P();
        $prop_p_com_input->addElement($prop_input_com);
        
        
        $prop_p_bout=new P();
        
        //-- Bouton insertion ---
        $prop_input_bout_ins=new Input();
        $prop_input_bout_ins->setAttribute('type', 'submit');
        $prop_input_bout_ins->setAttribute('value', 'Inserer');
        $prop_input_bout_ins->setAttribute('id', 'add-menu');
        $prop_input_bout_ins->setAttribute('class', 'new-menu');
        
        //-- Bouton insertion ---
        $prop_input_bout_res=new Input();
        $prop_input_bout_res->setAttribute('type', 'submit');
        $prop_input_bout_res->setAttribute('value', 'Reset');
        $prop_input_bout_res->setAttribute('id', 'reset-menu');
        $prop_input_bout_res->setAttribute('class', 'new-menu');
        
        // boutton modification
        $prop_input_bout=new Input();
        $prop_input_bout->setAttribute('type', 'submit');
        $prop_input_bout->setAttribute('value', 'Modifier');
        $prop_input_bout->setAttribute('id', 'menu-mod');
        $prop_input_bout->setAttribute('class', 'ajour');
        
        $prop_p_bout->addElements(Array($prop_input_bout_ins,$prop_input_bout_res,$prop_input_bout));
        
        //$prop_form->addElements(Array($prop_titre,$prop_p_p,$prop_p_desc,$prop_p_desc_input,$prop_p_url,$prop_p_url_input,$prop_p_ord,$prop_p_ord_input,$prop_p_com,$prop_p_com_input,$prop_p_bout));
        $b_prop->addElements(Array($prop_titre,$prop_input_id,$prop_p_p,$s_prop_p_p,$prop_p_desc,$prop_p_desc_input,$prop_p_url,$prop_p_url_input,$prop_p_ord,$prop_p_ord_input,$prop_p_com,$prop_p_com_input,$prop_p_bout));
        
        
        
        // troisième bloc : nouvelle catégorie
        $b_new_categ=new Hgroup();
        $b_new_categ->setAttribute('class', 'b-categ');
        $new_titre=new H1();
        $new_titre->addElement(new Text('Menu'));
        
        // construction de formulaire //
        $m=$this->getMenus(false);
        $b_new_categ->addElements(Array($new_titre,$m));
        
        $this->form->addElements(Array($b_select,$b_prop,$b_new_categ));
    }
    function getForm() {
        return $this->form;
    }
    function getSousCategorie(Categorie $cat){
        $ul=new Ul();
        foreach ($cat->getSouscategories() as $s_cat){
            $c_box=new Input();
            $c_box->setAttribute('type', 'checkbox');
            $c_box->setAttribute('class', 'cbx');
            $c_box->setAttribute('value', $s_cat->getID());
            $c_box->setAttribute('name', $s_cat->getURL());
            $em=new Em();
            $em->addElements(Array($c_box,new Text($s_cat->getSouscategorie())));
            $li=new Li($em,'');
            $li->setAttribute('name',$s_cat->getURL());
            // on vérifie si la catégorie à des enfants //
            $s_categ=CategorieQuery::create()->filterByCategorie($s_cat->getSouscategorie())->find();
            foreach ($s_categ as $c) {
                if($c->getNiveau()!=$cat->getNiveau()){
                    $li->addElement($this->getSousCategorie($c));
                }
            }
            $ul->addElement($li);   
        }
        return $ul;
        
    }
    
    function getSousMenu(Menus $mn,$bool){
        $ul=new Ul();
        foreach (SousmenuQuery::create()->filterByMenus($mn)->orderByORDRE('ASC')->find() as $s_mn){
            if($bool){
                $c_box=new Input();
                $c_box->setAttribute('type', 'checkbox');
                $c_box->setAttribute('class', 'cbx');
                $c_box->setAttribute('value', $s_mn->getURL());
                $em=new Em();
                $em->addElements(Array($c_box,new Text($s_mn->getSousmenu())));
                $attr='';
            }else{
                $em=new Em();
                $lab_del=new Label('X');
                $lab_del->addElement(new Text('X'));
                $lab_del->setAttribute('class', 'del-menu');
                $lab_del->setAttribute('id', $s_mn->getID());
                $lab_del->setAttribute('for', $s_mn->getSousmenu());
                $em->addElements(Array(new Text($s_mn->getSousmenu()),$lab_del));
                $attr='it';
            }
            
            $li=new Li($em,$attr);
            $li->setAttribute('name',$s_mn->getURL());
            // on vérifie si la catégorie à des enfants //
            $s_categ=MenusQuery::create()->filterByMenu($s_mn->getSousmenu())->find();
            foreach ($s_categ as $c) {
                if($c->getNIVEAU()!=$mn->getNIVEAU()){
                    $li->addElement($this->getSousMenu($c,$bool));
                }
            }
            $ul->addElement($li); 
        }
        return $ul;
        
    }
    function getMenus($bool){
        $menu_ul=new Ul();
        foreach (MenusQuery::create()->filterByNiveau(1)->orderByOrdre('ASC')->find() as $mn) {
            if($bool){
                $c_box=new Input();
                $c_box->setAttribute('type', 'checkbox');
                $c_box->setAttribute('class', 'cbx');
                $c_box->setAttribute('value', $mn->getID());
                $c_box->setAttribute('name', $mn->getURL());
                $em=new Em();
                $em->addElements(Array($c_box,new Text($mn->getMenu()))); 
                $attr='';
            }else{
                $em=new Em();
                $lab_del=new Label('X');
                $lab_del->addElement(new Text('X'));
                $lab_del->setAttribute('class', 'del-menu');
                $lab_del->setAttribute('id', $mn->getID());
                $lab_del->setAttribute('for', 'aucun');
                $em->addElements(Array(new Text($mn->getMenu()),$lab_del)); 
                $attr='it';
            }
            
            //$c_box->setAttribute('checked', 'checked');
            $li=new Li($em,$attr);
            $li->setAttribute('name', $mn->getURL());
            $li->setAttribute('value', $mn->getID());
            if($mn->countSousmenus()>0){
                $li->addElement($this->getSousMenu($mn,$bool));
            }
            $menu_ul->addElement($li);
        }
        return $menu_ul;
    }

}