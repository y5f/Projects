<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PATH {

    private $objectToload;
    function __construct() {
        
        if(isset($_GET['rub'])){
            if($_GET['rub']==='categorie'){
                $this->objectToload=new CategorieForm();
            }elseif($_GET['rub']==='article'){
                if(isset($_GET['new-art'])){
                    $this->objectToload=new ArticleForm(NULL);
                }else{
                    if(isset($_GET['edit'])){
                        $this->objectToload=new ArticleForm($_GET['edit']);
                    }else{
                        $this->objectToload=new ListArticle();
                    }
                }
            }elseif($_GET['rub']==='publication'){
                $this->objectToload=new PublicationForm();
            }elseif($_GET['rub']==='user'){
                $this->objectToload=new UserForm();
            }else{
                $this->objectToload=new MenuForm();
            }
        }else{
            $this->objectToload=new Accueil();
        }
    }
    
    function getForm(){
        return $this->objectToload->getForm();
    }
}
