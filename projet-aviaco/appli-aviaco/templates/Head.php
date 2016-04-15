<?php

class Head {

    private $entete;

    function __construct() {
        
        //-- Création de l'objet Header : une balise  HTML 5 ----//
        
        $this->entete=new Header();
        $this->entete->setAttribute('id', 'h-wrapper');
        
        //-- Le div contenant les menu standard --//
        $mon_menu=new Hgroup();
        $mon_menu->setAttribute('class', 'm-menu');
        
        //--- Bloc menu global ------//
        $b_menu=new Div();
        $b_menu->setAttribute('class', 'h-menu');
        
        //-- Ajout d'un menu standard --//
        $stnd_menu=new Ul();
        $sm_1=new Li(new A(new Text('Aviaco-site'),'http://aviaco.fr'), '');
        $sm_2=new Li(new A(new Text('Accueil'),'http://appli-aviaco.org'), '');
        $sm_3=new Li(new Text('Opérations'), '');
        $ul_op=new Ul();
        $ul_op->setAttribute('class', 'b-op');
        $li_op_1=new Li(new A(new Text('Nouveau partenaire'),'?rub=new-part'), '');
        $li_op_1->setAttribute('name', 'new-part');
        $li_op_2=new Li(new A(new Text('Nouvel Appareil'),'#'), 'new-app');
        $li_op_3=new Li(new A(new Text('Nouveau Pays'),'#'), 'new-pays');
        $li_op_3->setAttribute('name', 'new-certificat');
        $ul_op->addLis(Array($li_op_1,$li_op_2,$li_op_3));
        $sm_3->addElement($ul_op);
        
        $sm_4=new Li(new Text('Importations'), '');
        $ul_imp=new Ul();
        $ul_imp->setAttribute('class', 'b-imp');
        $li_imp_1=new Li(new A(new Text('Sociétés'),'?rub=imp-soc'), 'imp-part');
        //$li_imp_1->setAttribute('name', 'new-part');
        $li_imp_2=new Li(new A(new Text('Appareils'),'#'), 'imp-app');
        $li_imp_3=new Li(new A(new Text('Pieces'),'#'), 'imp-pieces');
        //$li_op_3->setAttribute('name', 'new-certificat');
        $ul_imp->addLis(Array($li_imp_1,$li_imp_2,$li_imp_3));
        $sm_4->addElement($ul_imp);
        
        $stnd_menu->addLis(Array($sm_1,$sm_2,$sm_3,$sm_4));
        $b_menu->addElement($stnd_menu);
        
        //--- Bloc infos utilisateur --///
        
        $b_user=new Div();
        $b_user->setAttribute('class', 'h-user');
        
        $stnd_user=new Ul();
        
        //--- Image du bonhomme  de deconnexion --//
        $bh_img=new Img('upload/usr.png');
        $bh_img->setAttribute('id', 'h-user-bh');
        
        //---- Les rubrique : infos perso et deconnexion --//
        if(isset($_SESSION['aviaco']['adm'])){
            $usr=EmployeQuery::create()->filterByEmail($_SESSION['aviaco']['adm'])->findOne();
            if($usr){
                $su_1=new Li(new Text($usr->getPrenoom().'('.$usr->getNom().')'), '');
            $su_1->setAttribute('class', 'u-infos');
            
            $ul_rub=new Ul();
            $ul_rub->setAttribute('id', 'dec-ul');
            $ul_rub->addLi(new Li(new A(new Text('Infos perso'),'?action=updte&user='.$usr->getIdEmploye()), 'dec-infos'));
            $ul_rub->addLi(new Li(new A(new Text('Deconnexion'),'?action=dec&user='.$usr->getIdEmploye()), 'dec'));
            }
            
            $su_2=new Li($bh_img, '');
            $su_2->setAttribute('class', 'u-bh');
            $su_2->addElement($ul_rub);
            $stnd_user->addLis(Array($su_2,$su_1));
            $b_user->addElement($stnd_user);
        }
        
        $mon_menu->addElements(Array($b_menu,$b_user));
        
        //-- Le second menu pour les détails de chaque rubrique --//
        $details_rub=new Hgroup();
        $details_rub->setAttribute('class', 'h-details');
        
        //-- Bloc menu de l'ensemble --//
        $menu_rub=new Div();
        $menu_rub->setAttribute('class', 'menu-fixed');
        $p_menu=new P();
        $p_menu->addElement(new Text('Menu'));
        $menu_rub->addElement($p_menu);
        //-- Le div pour les menu détails --//
        $menu_det=new Div();
        $menu_det->setAttribute('id', 'm-details');
        if(isset($_GET['rub'])){
            //--- On recupère la rubrique primaire cliqué ---
            $rub=RubriqueQuery::create()->filterByURL($_GET['rub'])->findOne();
            if($rub){
                //print_r($rub);
                if($rub->countRubriquesecondaires()>0){
                    $ul=new Ul();
                    foreach ($rub->getRubriquesecondaires() as $rp) {
                        $soc='';
                        if(isset($_GET['soc'])){
                            $soc='&soc='.$_GET['soc'];
                        }
                        if(isset($_GET['ref'])){
                            $ref='&ref='.$_GET['ref'];
                            //--- On recupère la société qui passé la commande de N° ref ----
                            $cmd=CommandeQuery::create()->filterByIDCommande($_GET['ref'])->findOne();
                            if($cmd){
                                $soc='&soc='.$cmd->getSociete()->getID();
                            }
                            $li=new Li(new A(new Text($rp->getRubriqueCol()),'?rub='.$rub->getURL().'&s-rub='.$rp->getURL().$soc.$ref), 'its');
                        }else{
                            $li=new Li(new A(new Text($rp->getRubriqueCol()),'?rub='.$rub->getURL().'&s-rub='.$rp->getURL().$soc), 'its');
                        }
                        
                        $ul->addLi($li);
                    }
                    $menu_det->addElement($ul);
                }
            }
        }
       
       $details_rub->addElements(Array($menu_rub,$menu_det));
        
       $this->entete->addElements(Array($mon_menu,$details_rub));
        
    }
    function getHeaders() {
        echo $this->entete->toHTML();
        
        //--- On inser m$eme temp la colonne --//
        $col=new Colonnemenu();
        $col->getForm();
    }

}