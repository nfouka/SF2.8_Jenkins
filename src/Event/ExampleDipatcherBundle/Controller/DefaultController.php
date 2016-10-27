<?php

namespace Event\ExampleDipatcherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EventExampleDipatcherBundle:Default:index.html.twig');
    }
    
    
public function queryAction(){
    
    
    $em = $this->getDoctrine()->getEntityManager() ;
    
    /*
    $film = new \MyApp\BlogBundle\Entity\Film() ; 
    $film->setName("HORROR2".  rand(0, 99999)) ; 
    
    $acteur1 = new \MyApp\BlogBundle\Entity\Acteur() ; 
    $acteur1->setDateNaissance(new \DateTime) ; 
    $acteur1->setFilm($film) ; 
    $acteur1->setPrenom("dsdsds65") ; 
    $acteur1->setNom("marcos1") ; 
    $acteur1->setSexe("M") ; 
    
    $acteur2 = new \MyApp\BlogBundle\Entity\Acteur() ; 
    $acteur2->setDateNaissance(new \DateTime) ; 
    $acteur2->setFilm($film) ; 
    $acteur2->setPrenom("dsdsds65".  rand(0, 99999)) ; 
    $acteur2->setNom("marcos2".  rand(0, 99999)) ; 
    $acteur2->setSexe("M") ; 
    
    $acteur3 = new \MyApp\BlogBundle\Entity\Acteur() ; 
    $acteur3->setDateNaissance(new \DateTime) ; 
    $acteur3->setFilm($film) ; 
    $acteur3->setPrenom("dsdsds65".  rand(0, 99999)) ; 
    $acteur3->setNom("marcos3".  rand(0, 99999)) ; 
    $acteur3->setSexe("M") ; 
    
    $em->persist($film) ; $em->persist($acteur1) ; $em->persist($acteur2) ; $em->persist($acteur3) ; 
    $em->flush() ; 
    
    $qb = $em->createQuery("SELECT f,a FROM MyApp\BlogBundle\Entity\Film f "
                         . "LEFT JOIN f.acteur a ORDER BY f.id DESC") ; 
    $acteurs = $qb->getArrayResult() ; 
     * 
     */
 return new \Symfony\Component\HttpFoundation\Response("ok") ; 
   // return new \Symfony\Component\HttpFoundation\JsonResponse($acteurs) ; 
    
}
}
