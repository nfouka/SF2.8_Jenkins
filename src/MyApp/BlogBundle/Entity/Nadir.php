<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MyApp\BlogBundle\Entity;

/**
 * Description of Nadir
 *
 * @author nadir
 */
class Nadir {
    //put your code here
    
    private $nom ; 
    private $date  ; 
    
    function __construct($nom, $date) {
        $this->nom = $nom;
        $this->date = $date;
    }

    function getNom() {
        return $this->nom;
    }

    function getDate() {
        return $this->date;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }
    public function __toString() {
        return $this->getNom().":".$this->getDate() ; 
    }
    function setDate($date) {
        $this->date = $date;
    }


    
    
}

