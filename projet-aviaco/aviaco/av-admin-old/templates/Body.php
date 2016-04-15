<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Body {

    private $body;
    function __construct() {
        
        $this->body=new Hgroup();
        $this->body->setAttribute('id', 'b-wrapper');
        
        //--- On crée la colonne de gauche : aside ---//
        $left_col=new Aside();
        $left_col->setAttribute('class', 'left-col');
        
        //---- Les différente rubriques ---//
        $aside_ul=new Ul();
        
        //--- Bloc catégorie ---//
        $lab_cat=new Label('cat');
        $lab_cat->addElement(new A(new Text('Catégories'), '?rub=categorie'));
        $lab_cat->setAttribute('name', 'for');
        $lab_cat->setAttribute('class', 'rub');
        $lab_cat->setAttribute('etat', '0');
        $cat_li=new Li($lab_cat, '');
        $bloc_cat=new Ul();
        $bloc_cat->setAttribute('id', 'for');
        $bloc_cat->setAttribute('class', 'nav');
        $li_cat_1=new Li(new Text('Nouvelles ctégorie'), 'categorie');
        //$cat_a_1=new A($li_cat_1, '?url=categorie&sl=new-cat');
        $li_cat_2=new Li(new Text('Liste des catégories'), 'categorie');
        //$cat_a_2=new A($li_cat_2, '?url=categorie&sl=liste');
        $li_cat_3=new Li(new Text('Tags'), 'categorie');
        //$cat_a_3=new A($li_cat_3, '?url=categorie&sl=tag');
        $bloc_cat->addElements(Array(new A($li_cat_1,'?rub=categorie&new-cat'),new A($li_cat_2,'?rub=categorie&list-cat'),new A($li_cat_3,'?rub=categorie&tag')));
        $cat_li->addElement($bloc_cat);
        
        //--- Bloc article ---//
        $lab_art=new Label('art');
        $lab_art->addElement(new A(new Text('Articles'),'?rub=article'));
        $lab_art->setAttribute('name', 'art');
        $lab_art->setAttribute('class', 'rub');
        $lab_art->setAttribute('etat', '0');
        $art_li=new Li($lab_art, '');
        $bloc_art=new Ul();
        $bloc_art->setAttribute('id', 'art');
        $bloc_art->setAttribute('class', 'nav');
        $li_art_1=new Li(new Text('Nouvelle article'), 'new-art');
       // $art_a_1=new A($li_art_1, '?url=article&sl=new-art');
        $li_art_2=new Li(new Text('Liste des articles'), 'list-art');
       // $art_a_2=new A($li_art_2, '?url=article&sl=liste');
        $bloc_art->addElements(Array(new A($li_art_1,'?rub=article&new-art'),new A($li_art_2,'?rub=article&list-art')));
        $art_li->addElement($bloc_art);
        
        //--- Bloc Publication ---//
        $lab_pub=new Label('pub');
        $lab_pub->addElement(new A(new Text('publications'),'?rub=publication'));
        $lab_pub->setAttribute('name','pub');
        $lab_pub->setAttribute('class','rub');
        $lab_pub->setAttribute('etat', '0');
        $pub_li=new Li($lab_pub,'');
        $bloc_pub=new Ul();
        $bloc_pub->setAttribute('id','pub');
        $bloc_pub->setAttribute('class', 'nav');
        $li_pub_1=new Li(new Text('Nouvelle publication'), 'new-pub');
        //$pub_p_1=new A($li_pub_1, '?url=article&sl=new-pub');
        $li_pub_2=new Li(new Text('Liste des publications'), 'new-pub');
        //$pub_p_2=new A($li_pub_2, '?url=article&sl=liste');
        $bloc_pub->addElements(Array(new A($li_pub_1,'?rub=publication&new-pub'),new A($li_pub_2,'?rub=publication&list-pub')));
        $pub_li->addElement($bloc_pub);
        
        //--- Bloc Utilisateur ---//
        $lab_user=new Label('user');
        $lab_user->addElement(new A(new Text('utilisateurs'),'?rub=user'));
        $lab_user->setAttribute('name','user');
        $lab_user->setAttribute('class','rub');
        $lab_user->setAttribute('etat', '0');
        $user_li=new Li($lab_user,'');
        $bloc_user=new Ul();
        $bloc_user->setAttribute('id','user');
        $bloc_user->setAttribute('class', 'nav');
        $li_user_1=new Li(new Text('Nouveau utilisateur'), 'new-user');
       // $user_u_1=new A($li_user_1, '?url=article&sl=new-user');
        $li_user_2=new Li(new Text('Liste des utilisateurs'), 'list-user');
        //$user_u_2=new A($li_user_2, '?url=article&sl=liste');
        $bloc_user->addElements(Array(new A($li_user_1,'?rub=user&new-user'),new A($li_user_2,'?rub=user&list-user')));
        $user_li->addElement($bloc_user);
        
        //--- Bloc Configuration ---//
        $lab_conf=new Label('conf');
        $lab_conf->addElement(new A(new Text('configurations'),'?rub=config'));
        $lab_conf->setAttribute('name','conf');
        $lab_conf->setAttribute('class','rub');
        $lab_conf->setAttribute('etat', '0');
        $conf_li=new Li($lab_conf,'');
        $bloc_conf=new Ul();
        $bloc_conf->setAttribute('id','conf');
        $bloc_conf->setAttribute('class', 'nav');
        $li_conf_1=new Li(new Text('Menus'), 'menus');
       // $conf_c_1=new A($li_conf_1, '?url=article&sl=menus');
        $li_conf_2=new Li(new Text('Widgets'), 'wid');
       // $conf_c_2=new A($li_conf_2, '?url=article&sl=menus');
        $li_conf_3=new Li(new Text('Option'), 'option');
       // $conf_c_3=new A($li_conf_3, '?url=article&sl=option');
        $li_conf_4=new Li(new Text('éditer'), 'edit');
        //$conf_c_4=new A($li_conf_4, '?url=article&sl=editer');
        $bloc_conf->addElements(Array(new A($li_conf_1,'?rub=config&menu'),new A($li_conf_2,'?rub=config&widget'),new A($li_conf_3,'?rub=config&options'),new A($li_conf_4,'?rub=config&edit')));
        $conf_li->addElement($bloc_conf);
        $aside_ul->addLis(Array($cat_li,$art_li,$pub_li,$user_li,$conf_li));
        $left_col->addElement($aside_ul);
        
        //-- bloc de section -- //
        $b_section=new Section();
        $b_section->setAttribute('class', 's-bloc');
        
        //--- On crée un objet PATh qui nous donnera le contenu adequat --//
        $contenu=new PATH();
        if($contenu->getForm()){
            $b_section->addElement($contenu->getForm());
        }
        
        $this->body->addElements(Array($left_col,$b_section));
        
        
    }
    function getBody() {
        echo $this->body->toHTML();
    }
}
