<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Template
 *
 * @author Nicolas
 */
abstract class Template {
    protected $form;
    
    function __construct(Noeud $form) {
        $this->form=$form;
    }
    
    function getForm() {
        echo $this->form->toHTML();
    }
    function getObject() {
        return $this->form;
    }
}
