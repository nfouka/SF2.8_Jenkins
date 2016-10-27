<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoadUserData
 *
 * @author nadir
 */

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $acteur = new MyApp\BlogBundle\Entity\Acteur() ; 
        $acteur->setDateNaissance(new Symfony\Component\Validator\Constraints\DateTime()) ; 
        $acteur->setImage(null) ; 
        $acteur->setNom("nadir") ; 
        $acteur->setPrenom("Fouka") ; 
        $acteur->setPrenom("M") ; 
        $acteur->setUser(null) ; 
        
        $manager->persist($userAdmin);
        $manager->flush();
    }
}