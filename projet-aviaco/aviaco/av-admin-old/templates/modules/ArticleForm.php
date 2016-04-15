<?php


class ArticleForm {
    private $form;
    
    function __construct($id_art) {
        $this->form=new Form();
        $this->form->setAttribute('id', 'edit-form');
        //$this->form->setAttribute('action', 'scripts/script.php');
        $this->form->setAttribute('method', 'post');
        $this->form->setAttribute('class', 'new-art');
        
        //--- Si art est différent de NULL, on charge l'article à modifier --//
        if($id_art){
            $art=ArticleQuery::create()->filterByNumart($id_art)->findOne();
            
            //-- On retient le num de l'article dans champs hidden --//
            $num_art=new Input();
            $num_art->setAttribute('type', 'hidden');
            $num_art->setAttribute('id', 'id-art');
            $num_art->setAttribute('name', 'id-art');
            $num_art->setAttribute('value', $id_art);
        }
        // -- Premier Hgroup -- //     
        $hg1=new Hgroup();
        $hg1->setAttribute('class', 'h-art');
        
        // titre
        $p_titre=new P();
        $l_titre=new Label('');
        $l_titre->setAttribute('class', 'lab');
        $l_titre->addElement(New Text('Titre :'));
        $input_titre=new Input();
        
        if($id_art){
            $input_titre->setAttribute('value', $art->getTitre());
        }
        $input_titre->setAttribute('type', 'text');
        $input_titre->setAttribute('id', 'titre');
        $input_titre->setAttribute('name', 'titre');
        // URL
        $l_url=new Label('');
        $l_url->setAttribute('class', 'lab');
        $l_url->addElement(New Text('URL :'));
        $input_url=new Input();
        if($id_art){
            $input_url->setAttribute('value', $art->getUrl());
        }
        $input_url->setAttribute('type', 'text');
        $input_url->setAttribute('required','');
        $input_url->setAttribute('id', 'url');
        $input_url->setAttribute('name', 'url');
        if($id_art){
            $p_titre->addElements(Array($num_art,$l_titre,$input_titre,$l_url,$input_url));
        }else{
            $p_titre->addElements(Array($l_titre,$input_titre,$l_url,$input_url));
        }
        
        //Catégorie + choix Model
        $p_cat_choix=new P();
        $l_cat=new Label('');
        $l_cat->setAttribute('class', 'lab');
        $l_cat->addElement(New Text('Catégorie:'));
        $sel_cat=new Select();
        $sel_cat->setAttribute('id', 'categ');
        $sel_cat->setAttribute('name', 'categ');
        $def_opt=new Option();
        if($id_art){
            $def_opt->addElement(new Text($art->getCategorie_FK()));
        }else{
            $def_opt->addElement(new Text('aucun'));
        }
        
        $sel_cat->addElement($def_opt);
        foreach (CategorieQuery::create()->filterByNiveau(1)->orderByCategorie('ASC')->find() as $cat) {
            $opt=new Option();
            $opt->setAttribute('value', $cat->getURL());
            $opt->addElement(new Text($cat->getCategorie()));
            $sel_cat->addElement($opt);
        }
        $l_sous_cat=new Label('');
        $l_sous_cat->setAttribute('class', 'lab');
        $l_sous_cat->addElement(New Text('Sous catégorie :'));
        $sel_sous_cat=new Select();
        $sel_sous_cat->setAttribute('id', 's-categ');
        $sel_sous_cat->setAttribute('name', 's-categ');
        //foreach (SouscategorieQuery::create()->orderBySouscategorie('ASC')->find() as $s_cat) {
        $opt=new Option();
        if($id_art){
            $opt->addElement(new Text($art->getSouscategorie_FK()));
        }else{
            $opt->addElement(new Text('aucun'));
        }
            
        $sel_sous_cat->addElement($opt);
        //}
        $p_cat_choix->addElements(Array($l_cat,$sel_cat,$l_sous_cat,$sel_sous_cat));
        $hg1->addElements(Array($p_titre,$p_cat_choix));
        
        // -- Deuxième Hgroup -- //
        $hg2=new Hgroup();
        $hg2->setAttribute('name', 'edit');
        
        // textarea
        $text_area=new Textarea();
        $text_area->setAttribute('id', 'zone');
        $text_area->setAttribute('name', 'zone');
        if($id_art){
            $text_area->addElement(new Text($art->getContenu()));
        }
       
        //--- Zone resymé --//
        $p_resume=new P();
        $p_resume->setAttribute('class', 'p-resume');
        $l_resume=new Label('');
        $l_resume->setAttribute('class', 'lab');
        $l_resume->addElement(new Text('Ajouter un resumé à l\'article'));
        $resurme=new Textarea();
        $resurme->setAttribute('id', 'edit-resume');
        $resurme->setAttribute('name', 'edit-resume');
        $resurme->setAttribute('class', 'edit-resume');
        if($id_art){
            $resurme->addElement(new Text($art->getResume()));
        }
        $p_resume->addElements(Array($l_resume,$resurme));
        
        $bout_inser=new Input();
        $bout_inser->setAttribute('type', 'submit');
        
        if($id_art){
            
            $bout_inser->setAttribute('id', 'edit-mod');
            $bout_inser->setAttribute('name', 'edit-mod');
            $bout_inser->setAttribute('value', 'Mettre à jour');
        }else{
            $bout_inser->setAttribute('id', 'inserer');
            $bout_inser->setAttribute('name', 'edit-save');
            $bout_inser->setAttribute('value', 'Ajouter nouvel article');
        }
        
        $scr_ckedit=new Script();
        $scr_ckedit->addElement(new Text("CKEDITOR.replace('zone',{
	filebrowserBrowseUrl: '../ckfinder/ckfinder.html',
	filebrowserUploadUrl: '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
} )"));
        $scr_ckedit->addElement(new Text("var editor = CKEDITOR.replace( 'ckfinder' );"));
        $scr_ckedit->addElement(new Text("CKFinder.setupCKEditor( editor );"));
        
        $hg2->addElements(Array($text_area,$scr_ckedit,$p_resume,$bout_inser));
        //$hg2->addElements(Array($text_area,$p_resume,$bout_inser));
        $this->form->addElements(Array($hg1,$hg2));

    }
    function getForm(){
        return $this->form;
    }
 
}

