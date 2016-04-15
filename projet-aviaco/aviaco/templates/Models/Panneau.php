<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Panneau {

    private $panneau;
    private $htmlAcces;
    
    function __construct() {
        
        $this->htmlAcces=new simple_html_dom();
        $this->panneau=new Div();
        $this->panneau->setAttribute('class', 'panneau');
                
        //-- AJOUT DES BLOCS -- LIGHTBOX ---//
        $blocs=new Div();
        $blocs->setAttribute('class', 'row blocs');
                
        //--- Le bloc actualités ---
        $actu=new Div();
        //$actu->addElement(new Text('Actualité'));
        $actu->setAttribute('class','blk actu col-xs-12 col-sm-7 col-lg-7');
                
        //--- On va chercher l'actur sur le site : http://www.ladepeche.fr/actu/high-tech-sciences/aeronautique-espace
        $lien=new Label('lien');
        $lien->setAttribute('id', 'lien');
        $lien->setAttribute('cible', 'http://www.ladepeche.fr');
        
        //--- S'il y a accès internet, on se connecte au site indiqué et on recupère des infos ---//
        if(@fsockopen('www.google.fr', 80, $num, $error, 5)){
            $this->htmlAcces->load_file('http://www.ladepeche.fr/actu/high-tech-sciences/aeronautique-espace');
            $obj=new Text($this->htmlAcces->find('.article',0));
            //--- On teste s'il tya une iùage ou pas sur l'article ---//
            //$img=new Img('upload/img_3.jpg');
            
            $actu->addElement($obj);
            //$actu->addElement($img);
            $actu->addElement($lien);
        }else{
            $err=new P();
            $err->addElement(new Text('ERREUR DE CONNEXION AU SITE'));
            $actu->addElement($err);
        }
                
        //--- Le bloc REGLEMENTATION ---------
        $reg=new Div();
        //$reg->addElement(new Text('Reglémentation'));
        $reg->setAttribute('class', 'blk reg col-xs-12 col-sm-5 col-lg-5');
        $reg->setAttribute('id', 'reg');
        $num_art_reg=WidgetQuery::create()->filterByNumbloc(1)->findOne();
        if($num_art_reg){
            $art=ArticleQuery::create()->filterByNumart($num_art_reg->getNumarticle())->findOne();
            $img=new Img('/'.$art->getImgLaune());
            $titre_reg=new H2();
            $titre_reg->addElement(new A(new Text($art->getTitre()),'?url='.$art->getUrl().'&id='.$art->getNumart()));
            $par=new P();
            $par->addElement(new Text($art->getResume()));
            $lien=new A($par,'?url='.$art->getUrl().'&id='.$art->getNumart());
            
            $reg->addElements(Array($titre_reg,$lien,$img));
        }
                
                
        //---- Le bloc qualité -----
        $qualite=new Div();
        //$helico->addElement(new Text('Hélico à Vendre'));
        $qualite->setAttribute('class', 'blk helico col-xs-12 col-sm-6 col-lg-5');
        $num_art_qte=WidgetQuery::create()->filterByNumbloc(2)->findOne();
        if($num_art_qte){
            $art=ArticleQuery::create()->filterByNumart($num_art_qte->getNumarticle())->findOne();
            $img=new Img('/'.$art->getImgLaune());
            $titre_qualite=new H2();
            $titre_qualite->addElement(new A(new Text($art->getTitre()),'?url='.$art->getUrl().'&id='.$art->getNumart()));
            $par=new P();
            $par->addElement(new Text($art->getResume()));
            $lien=new A($par,'?url='.$art->getUrl().'&id='.$art->getNumart());
            $qualite->addElements(Array($titre_qualite,$lien,$img));
        }    
        //---- Le bloc stock ---------
        $stock=new Div();
        $stock->setAttribute('class', 'blk b-stock col-xs-12 col-sm-6 col-lg-4');
        $num_art_stk=WidgetQuery::create()->filterByNumbloc(3)->findOne();
        if($num_art_stk){
            $art=ArticleQuery::create()->filterByNumart($num_art_stk->getNumarticle())->findOne();
            $img=new Img('/'.$art->getImgLaune());
            $titre_stk=new H2();
            $titre_stk->addElement(new A(new Text($art->getTitre()),'?url='.$art->getUrl().'&id='.$art->getNumart()));
            $par=new P();
            $par->addElement(new Text($art->getResume()));
            $lien=new A($par,'?url='.$art->getUrl().'&id='.$art->getNumart());
            $stock->addElements(Array($titre_stk,$lien,$img));
        } 
                
        //---- Un bloc libre 1----------
        $libre=new Div();
        //$libre->addElement(new Text('Bloc libre 1'));
        $libre->setAttribute('class', 'blk libre col-xs-12 col-sm-4 col-lg-3');
        $num_art_inst=WidgetQuery::create()->filterByNumbloc(4)->findOne();
        if($num_art_inst){
            $art=ArticleQuery::create()->filterByNumart($num_art_inst->getNumarticle())->findOne();
            $img=new Img('/'.$art->getImgLaune());
            $titre_libre=new H2();
            $titre_libre->addElement(new A(new Text($art->getTitre()),'?url='.$art->getUrl().'&id='.$art->getNumart()));
            $par=new P();
            $par->addElement(new Text($art->getResume()));
            $lien=new A($par,'?url='.$art->getUrl().'&id='.$art->getNumart());
            $libre->addElements(Array($titre_libre,$lien,$img));
        } 
                
        //--- Le bloc MAP ---------
        $map=new Div();
        $txt=new H3;
        $txt->addElement(new Text('Géolocalisation -- Google-App'));
        $map->addElement($txt);
        $map->setAttribute('class', 'blk map col-xs-12 col-sm-8 col-lg-4');
        $map->setAttribute('id', 'map');
                
        //--- Le bloc PARTENAIRES ---------
        $part=new Div();
        $part->setAttribute('class', 'blk part col-xs-12 col-sm-12 col-lg-8');
        
        // Ajout de 1er patenaires
        $partenaires=new Div();
        $partenaires->setAttribute('class', 'pt');
        
        $descr=new P();
        $descr->addElement(new Text('Nous travaillons avec nos partenaires. Nous avons la confiance des grandes entreprises'.
                ' qui travaillent dans l\'aéronautique. De Airbus Helicopters aux petits propriétaires'.
                ' nous avons la solution pour chacun d\'entre eux.'));
        $partenaires->addElement($descr);
        
        $part_1= new Figure();
        $part_1->addImg(Array('src'=>'upload/logo_airbus.jpg'));
        $lien_part_1=new A($part_1, '?url=partenaires&lien=airbus');
        $partenaires->addElement($lien_part_1);
        
        // Ajout de 2eme partenaires
        $part_2= new Figure();
        $part_2->addImg(Array('src'=>'upload/logo_inaer.jpg'));
        $lien_part_2=new A($part_2, '?url=partenaires&lien=inaer');
        $partenaires->addElement($lien_part_2);
        
        //Ajout 3eme partenaires
        $part_3= new Figure();
        $part_3->addImg(Array('src'=>'upload/logo_sofema.png'));
        $lien_part_3=new A($part_3, '?url=partenaires&lien=sofema');
        $partenaires->addElement($lien_part_3);
        
        // Ajout du 4eme partenaires
        $part_4= new Figure();
        $part_4->addImg(Array('src'=>'upload/logo_nhe.png'));
        $lien_part_4=new A($part_4, '?url=partenaires&lien=nhe');
        $partenaires->addElement($lien_part_4);
        $part->addElement($partenaires);
        
        //---- Un bloc libre 2 ----------
        //** Ce bloc n'est pas ajouté dans l'affichage ------
        $libre1=new Div();
        $libre1->addElement(new Text('Bloc libre 2'));
        $libre1->setAttribute('class', 'blk libre-un col-xs-12 col-sm-3 hidden-lg');
                
        $blocs->addElements(Array($actu,$reg,$qualite,$stock,$libre));
                
        $this->panneau->addElement($blocs);
         
    }
    
    function getContents() {
        return $this->panneau;
    }
    function castURL($url) {
        $temps=strtolower($url);
        $tempss=preg_replace('#\s#', '-', $temps);
        return $tempss;
    }

}
