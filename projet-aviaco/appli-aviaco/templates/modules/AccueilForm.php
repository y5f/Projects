<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AccueilForm extends Template {
    function __construct() {
        parent::__construct(new Hgroup());
        $this->form->addElement(new Text('Vous êtes dans la page d\'accueil'));
    }
}
