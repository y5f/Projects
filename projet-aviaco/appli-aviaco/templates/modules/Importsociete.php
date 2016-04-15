<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Importsociete
 *
 * @author Nicolas
 */
class Importsociete extends Template {
    function __construct() {
        parent::__construct(new Div());
        $this->form->setAttribute('class','import-form');
        $titre=new H2();
        $titre->addElement(new Text("Espace d'importations pour les sociétés..."));
        
        //--- Infos imôrtante --//
        $infos=new P();
        $infos->addElement(new Text('IMPORTANT! > Selection la colonne qui correspond à vos données !'));
        
        // Chargement du fichier Excel
        $objPHPExcel = PHPExcel_IOFactory::load("upload/app.xlsx");
        
        /**
        * récupération de la première feuille du fichier Excel
        * @var PHPExcel_Worksheet $sheet
        */
        $sheet = $objPHPExcel->getSheet(0);

        $tab=new Table();
        
        //--- On calcule l'entete du tableau ---//
        $thead=new Thead();
        
        //--- On selection les colonnes de la table Société --//
        $cols_soc=  \Map\SocieteTableMap::getFieldNames(Propel\Runtime\Map\TableMap::TYPE_CAMELNAME);
        $sel_cols=new Select();
        $defçcol=new Option();
        $defçcol->addElement(new Text('aucun'));
        $sel_cols->addElement($defçcol);
        foreach ($cols_soc as $field) {
            $opt=new Option();
            $opt->addElement(new Text($field));
            $sel_cols->addElement($opt);
        }
        $lng=0;
        $tr_h=new Tr();
        //-- On cherche la ligne la plus longue ---//
        foreach ($sheet->getRowIterator() as $ligne) {
                $tmp=0;
                foreach ($ligne->getCellIterator() as $cell) {
                    $tmp=$tmp+1;
                }
                if($tmp>$lng){
                    $lng=$tmp;
                }
        }
        for($i=0;$i<$lng;$i++){
            $th=new Th();
            $th->addElement($sel_cols);
            $tr_h->addElement($th);
        }
        $thead->addElement($tr_h);
        
        // On boucle sur les lignes
        $tbody=new Tbody();
        foreach($sheet->getRowIterator() as $row) {
            $tr=new Tr();
 
            // On boucle sur les cellule de la ligne
            foreach ($row->getCellIterator() as $cell) {
                $td=new Td();
                $td->addElement(new Text($cell->getValue()));
                $tr->addElement($td);
                //echo $td->toHTML().'<br>';
            }
            $tbody->addElement($tr);
        }
        $tab->addElements(Array($thead,$tbody));
        $div_tab=new Div();
        $div_tab->addElement($tab);
        $this->form->addElements(Array($titre,$infos,$div_tab));
    }
}
