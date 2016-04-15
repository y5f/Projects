<?php

//----- Classe de chargement  ---------
require_once '../vendor/autoload.php';
require_once '../generated-conf/config.php';

if(isset($_POST['cat'])){
    $cat=  CategorieQuery::create()->filterByCategorie($_POST['cat'])->find();
    $sous_menu=SouscategorieQuery::create()->filterByCategorie($cat)->orderByOrdre('ASC')->find();
    $ul=new Ul();
    
    foreach ($sous_menu as $s_menu) {
        //-- On recupère les article liées à cette sous-catégorie --//
        //----- mais pour le moment on se contente d'afficher un seul article --//
        if($s_menu->getSouscategorie()!='autre'){
            $art=ArticleQuery::create()->filterByCategorie_FK($s_menu->getSouscategorie())->orderByNumart('DESC')->findOne();
            $li=new Li(new Text($s_menu->getSouscategorie()), $s_menu->getURL());
            if($art){
                $s_a=new A($li, '?url='.$s_menu->getURL().'&id='.$art->getNumart());
            }else{
                $s_a=new A($li, '?url='.$s_menu->getURL().'&'.$s_menu->getCommentaire());
            }
            $ul->addElement($s_a);
        }
    }
    echo $ul->toHTML();
}

function castURL($url) {
    $temps=strtolower($url);
    $tempss=preg_replace('#\s#', '-', $temps);
    return $tempss;
}

