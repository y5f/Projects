<?php


Class PublicationForm{
    private $form;
    function __construct() {
            $this->form=new Div();
            $this->form->setAttribute('class', 'pub-form');
            
            // -- liste à publier -- //
            $listpub=new Hgroup();
            $listpub->setAttribute('class','l-pub');
            $tab_2pub=new Ul();
            $tab_2pub->setAttribute('align','center');  
            
            //--- Selection des articles à publier --//
            $art=ArticleQuery::create()->find();
            
            foreach ($art as $a) {
                $pub=PublicationQuery::create()->filterByArticle($a)->findOne();
                if(!$pub){
                    $em=new Em();
                    $em->addElement(new Text($a->getTitre().' ('.$a->getDateEdit()->format('d/m/Y').')'));
                    $li=new Li($em, 'item-pub '.$a->getNumart());
                    $tab_2pub->addLi($li);
                }
            }
            
            $field_2pub=new Fieldset('LISTE À PUBLIER');
            $field_2pub->setAttribute('class', 'list-a-pub');
            $field_2pub->addElement($tab_2pub);
            
            // -- liste publiée -- //
            $tab_pub=new Ul();
            $tab_pub->setAttribute('align','center');
            
            //--- Selection des articles déjà publiés --//
            $pub_1=PublicationQuery::create()->find();
            foreach ($pub_1 as $p) {
                $art=ArticleQuery::create()->filterByPublication($p)->findOne();
                $em=new Em();
                $em->addElement(new Text($art->getTitre().' ('.$p->getDatepublication()->format('d/m/Y').')'));
                $li=new Li($em, $p->getID());
                $tab_pub->addLi($li);
            }
            
            $field_pub=new Fieldset('LISTE PUBLIÉE');
            $field_pub->setAttribute('id', 'list-pub');
            $field_pub->addElement($tab_pub);
            
            $listpub->addElements(Array($field_2pub,$field_pub));

            // -- Publier ou modifier un article -- //
            $pub_mod=new Hgroup();
            $pub_mod->setAttribute('class','pub-mod');
            $p_num_art=new P();
            $l_num_art=new Label('');
            $l_num_art->setAttribute('class', 'lab');
            $l_num_art->addElement(New Text('N° Article :'));
            $input_num_art=new Input();
            $input_num_art->setAttribute('type', 'text');
            $input_num_art->setAttribute('disabled', '');
            $input_num_art->setAttribute('id', 'numart');
            $p_num_art->addElements(Array($l_num_art,$input_num_art));
            
            $p_titre_art=new P();
            $l_titre_art=new Label('');
            $l_titre_art->setAttribute('class', 'lab');
            $l_titre_art->addElement(New Text('Titre de l\'article :'));
            $input_titre_art=new Input();
            $input_titre_art->setAttribute('type', 'text');
            $input_titre_art->setAttribute('id', 'titreart');
            $p_titre_art->addElements(Array($l_titre_art,$input_titre_art));
            
            $p_date_art=new P();
            $l_date_art=new Label('');
            $l_date_art->setAttribute('class', 'lab');
            $l_date_art->addElement(New Text('Date de publication :'));
            $input_date_art=new Input();
            $input_date_art->setAttribute('type', 'date');
            $input_date_art->setAttribute('id', 'date-pub');
            $p_date_art->addElements(Array($l_date_art,$input_date_art));
            
            $p_auteur_art=new P();
            $l_auteur_art=new Label('');
            $l_auteur_art->setAttribute('class', 'lab');
            $l_auteur_art->addElement(New Text('Auteur article :'));
            $input_auteur_art=new Input();
            $input_auteur_art->setAttribute('type', 'text');
            $input_auteur_art->setAttribute('id', 'auteurart');
            $p_auteur_art->addElements(Array($l_auteur_art,$input_auteur_art));
            
            $p_etat_slider=new P();
            $p_etat_slider->setAttribute('class', 'p-e-s');
            $l_etat=new Label('');
            $l_etat->setAttribute('class', 'lab');
            $l_etat->addElement(New Text('Etat de publication :'));
            $select_etat=new Select();
            $select_etat->setAttribute('id','etat-pub');
            $opt_e_1=new Option();
            $opt_e_1->addElement(new Text('actif'));
            $opt_e_2=new Option();
            $opt_e_2->addElement(new Text('inactif'));
            $select_etat->addElements(Array($opt_e_2,$opt_e_1));
            
            $l_slider=new Label('');
            $l_slider->setAttribute('class', 'lab');
            $l_slider->addElement(New Text('Afficher dans le slider :'));
            $select_slider=new Select();
            $select_slider->setAttribute('id','slid-pub');
            $opt_ss_1=new Option();
            $opt_ss_1->addElement(new Text('actif'));
            $opt_ss_2=new Option();
            $opt_ss_2->addElement(new Text('inactif'));
            $select_slider->addElements(Array($opt_ss_2,$opt_ss_1));
            
            $p_etat_slider->addElements(Array($l_etat,$select_etat,$l_slider,$select_slider));
            
            $p_input_b=new P();
            $input_mod=new Input();
            $input_mod->setAttribute('value', 'Modifier');
            $input_mod->setAttribute('id', 'mod-pub');
            $input_mod->setAttribute('type', 'submit');
            $input_pub=new Input();
            $input_pub->setAttribute('value', 'Publier');
            $input_pub->setAttribute('id', 'pub-pub');
            $input_pub->setAttribute('type', 'submit');
            $p_input_b->addElements(Array($input_mod,$input_pub));      
            $pub_mod->addElements(Array($p_num_art,$p_titre_art,$p_date_art,$p_auteur_art,$p_etat_slider,$p_input_b));
           
            
            // -- Articles Actifs -- //
            $art_dep=new Hgroup();
            $art_dep->setAttribute('class','art-dep');
            $tab_art_act=new Ul();
            
            //--- On selectionne les article actif dans les site --//
            foreach (PublicationQuery::create()->filterByEtat(1)->find() as $actif) {
                $art=ArticleQuery::create()->filterByPublication($actif)->findOne();
                $em=new Em();
                $em->addElement(new Text($art->getTitre().' ('.$actif->getDatepublication()->format('d/m/Y').')'));
                $li=new Li($em, 'item-act '.$actif->getID());
                $tab_art_act->addLi($li);
            }
            $field_art_dep=new Fieldset('Articles actifs');
            $field_art_dep->setAttribute('class', 'art-act');
            $field_art_dep->addElement($tab_art_act);
            
             // -- Articles Inactifs -- //
           
            $tab_art_inact=new Ul();
            
            //--- On selectionne les article inactif dans les site --//
            foreach (PublicationQuery::create()->filterByEtat(0)->find() as $inactif) {
                $art=ArticleQuery::create()->filterByPublication($inactif)->findOne();
                $em=new Em();
                $em->addElement(new Text($art->getTitre().' ('.$inactif->getDatepublication()->format('d/m/Y').')'));
                $li=new Li($em, 'item-act '.$inactif->getID());
                $tab_art_inact->addLi($li);
            }
            $field_art_inact=new Fieldset('Articles inactifs'); 
            $field_art_inact->setAttribute('class', 'art-inact');
            $field_art_inact->addElement($tab_art_inact);
         
            
            // -- dépublier un article -- //
            
            $depublicate=new Hgroup();
            $depublicate->setAttribute('class', 'depub');
            
            //--- Numero de la publication en hidden --//
            $num_pub=new Input();
            $num_pub->setAttribute('type', 'hidden');
            $num_pub->setAttribute('value', '');
            $num_pub->setAttribute('id', 'num-pub');
            
            $p_d_e=new P();
            $l_de=new Label('');
            $l_de->setAttribute('class', 'lab');
            $l_de->addElement(New Text('Date d\'édition :'));
            
            $input_de=new Input();
            $input_de->setAttribute('type','date');
            $input_de->setAttribute('id', 'dte-edit');
            $l_e=new Label('');
            $l_e->setAttribute('class', 'selec lab');
            $l_e->addElement(New Text('Etat :'));
            $input_e=new Select();
            $input_e->setAttribute('id', 'e-pub');
            $opt_1=new Option();
            $opt_1->addElement(new Text('actif'));
            $opt_2=new Option();
            $opt_2->addElement(new Text('inactif'));
            $input_e->addElements(Array($opt_1,$opt_2));
            
            $p_d_s=new P();
            $l_dp=new Label('');
            $l_dp->setAttribute('class', 'lab');
            $l_dp->addElement(New Text('Date de publication :'));
            $input_dp=new Input();
            $input_dp->setAttribute('type','date');
            $input_dp->setAttribute('id', 'dte-pub');
            
            $l_s=new Label('');
            $l_s->setAttribute('class', 'selec lab');
            $l_s->addElement(New Text('Slider :'));
            $input_s=new Select();
            $input_s->setAttribute('id', 's-pub');
            $opt_s_1=new Option();
            $opt_s_1->addElement(new Text('actif'));
            $opt_s_2=new Option();
            $opt_s_2->addElement(new Text('inactif'));
            $input_s->addElements(Array($opt_s_1,$opt_s_2));
 
            $p_d_e->addElements(Array($l_de,$input_de,$l_dp,$input_dp));
            
            $l_a=new Label('');
            $l_a->setAttribute('class', 'selec lab');
            $l_a->addElement(New Text('Auteur :'));
            $input_a=new Input();
            $input_a->setAttribute('type', 'text');
            $input_a->setAttribute('id', 'aut-pub');
            
            $p_d_s->addElements(Array($l_e,$input_e,$l_s,$input_s,$l_a,$input_a));
            
            $input_depub=new Input();
            $input_depub->setAttribute('type', 'submit');
            $input_depub->setAttribute('id', 'dep-valider');
            $input_depub->setAttribute('value', 'Valider');
            
            $depublicate->addElements(Array($num_pub,$p_d_e,$p_d_s,$input_depub));
            $art_dep->addElements(Array($field_art_inact,$field_art_dep,$depublicate));
            //$depub->addElements(Array($p_d_e,$p_d_s,$p_a,$input_depub));
            
            
            
            
    $this->form->addElements(Array($listpub,$pub_mod,$art_dep));
}
    function getForm(){
        return $this->form;
    }


}