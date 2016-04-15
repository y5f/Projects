<?php
class PATH {

    private $objetToload;
    function __construct() {
        
        if(!isset($_GET['rub'])){
            $this->objetToload=new AccueilForm();
        }else{
            if(!isset($_GET['s-rub'])){
                if($_GET['rub']==='new-part'){
                    $this->objetToload=new Helicocontact();
                }elseif($_GET['rub']==='societe'){
                    $this->objetToload=new FiltreForm();
                }elseif($_GET['rub']==='stock'){
                    $this->objetToload=new StockForm();
                }elseif($_GET['rub']==='new-app'){
                    $this->objetToload=new AppareilForm();
                }elseif($_GET['rub']==='liste'){
                    $this->objetToload=new Paperboard();
                }elseif($_GET['rub']==='paperboard'){
                    $this->objetToload=new SearchPaperboadForm();
                }elseif($_GET['rub']==='pn'){
                    $this->objetToload=new PNForm();
                }elseif($_GET['rub']==='imp-soc'){
                    $this->objetToload=new Importsociete();
                }else{
                    $this->objetToload=new AccueilForm();
                }
            }else{
                if($_GET['s-rub']==='annonceurs'){
                    $this->objetToload=new AnnonceurForm();
                }elseif($_GET['s-rub']==='base-de-donnees-helicoptere'){
                    $this->objetToload=new BaseinfoForm();
                }elseif($_GET['s-rub']==='informations-financieres'){
                    $this->objetToload=new FinanceForm();
                }elseif($_GET['s-rub']==='alerte-fraude'){
                    $this->objetToload=new AlertForm();
                }elseif($_GET['s-rub']==='fiche-par-piece'){
                    $this->objetToload=new FicheForm();
                }elseif($_GET['s-rub']==='fiche-par-societe'){
                    $this->objetToload=new FichePS();
                }elseif($_GET['s-rub']==='fiche-par-groupe-de-pieces'){
                    $this->objetToload=new FicheGP();
                }else{
                    $this->objetToload=new AccueilForm();
                }
            }
        }
    }
    function getForm(){
        return $this->objetToload->getObject();
    }

}