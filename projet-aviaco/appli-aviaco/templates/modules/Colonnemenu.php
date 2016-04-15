<?php
class Colonnemenu extends Template{

    function __construct() {
        
        parent::__construct(new Aside());
        $this->form->setAttribute('class', 'col-menu');
        
        //--- On selection les menu qui constituent la colonne de gauche --//
        $bloc_aside=new Hgroup();
        $ul_col=new Ul();
        foreach (RubriqueQuery::create()->filterByNiveau(1)->find() as $menu) {
            $li=new Li(new A(new Text($menu->getRubriqueCol()), '#'), 'it');
            $li->setAttribute('name', $menu->getURL());
            $li->setAttribute('etat', '0');
            //---- On teste si cette la rubrique courant possède des sous-rubriques --//
            if($menu->countRubriqueprimaires()>0){
                $li->addElement($this->getSousrubriqes($menu));
            }
            $ul_col->addLi($li);
        }
        $bloc_aside->addElement($ul_col);
        $this->form->addElement($bloc_aside);   
    }
    function getSousrubriqes(Rubrique $rub) {
        
        $rub_ul=new Ul();
        $rub_ul->setAttribute('id', $rub->getURL());
        foreach ($rub->getRubriqueprimaires() as $rp) {
            $li=new Li(new A(new Text($rp->getRubriqueCol()), '?rub='.$rp->getURL()), 'itp '.$rub->getURL());
            $li->setAttribute('name', $rp->getURL());
            $rub_ul->addLi($li);
        }
        return $rub_ul;
    }
}
