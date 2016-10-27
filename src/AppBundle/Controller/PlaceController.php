<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get; // N'oublons pas d'inclure Get
use AppBundle\Entity\Place;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\Controller\Annotations\Put ; 
use FOS\RestBundle\Controller\Annotations\Post ; 

class PlaceController extends Controller
{

     /**
      * @Rest\View()
     * @Get("/rest/places_a.{ext}")
     */
    public function getPlacesAction(Request $request , $ext )
    {
        $places = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Place')
                ->findAll();
        /* @var $places Place[] */

        $formatted = [];
        foreach ($places as $place) {
            $formatted[] = [
               'id' => $place->getId(),
               'name' => $place->getName(),
               'address' => $place->getAdress() ,
            ];
        }

        // Récupération du view handler
        $viewHandler = $this->get('fos_rest.view_handler');

        // Création d'une vue FOSRestBundle
        $view = \FOS\RestBundle\View\View::create($formatted);
        $view->setFormat($ext);

        // Gestion de la réponse
        return $view;
    }

    /**
     * @Rest\View()
     * @Get("/rest/places_a/{id}")
     */
    public function getPlaceAction($id , Request $request)
    {
        $place = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Place')
                ->find($id);
        /* @var $place Place */

        if (empty($place)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        $formatted = [
           'id' => $place->getId(),
           'name' => $place->getName(),
           'address' => $place->getAdress(),
        ];

        return new JsonResponse($formatted);
    }
    

    /**
     * @Get("/rest/load/{n}")
     */
    public function loadDataFixturesAction($n){
        $em = $this->getDoctrine()->getEntityManager() ; 
        for($i=0 ; $i< $n ; $i++) {
            $place  = new Place() ; 
            $place->setName("XRDE ".  rand(0, 99999)) ; 
            $place->setAdress("XRDE RED ".  rand(0, 99999)) ; 
            $em->persist($place)  ; 
            $em->flush() ; 
                    }
                    
                    return new Response("load data OK") ; 
    }
    
 
     /**
     * @Rest\Delete("/app/users/{userId}")
     */
    public function deleteUsersByIdAction($userId)
    {
     
            $em = $this->getDoctrine()->getManager() ; 
            $place = $em
                ->getRepository('AppBundle:Place')
                ->find($userId);
            
            $em->remove($place) ; 
            $em->flush() ; 
            
            return new Response("delete ...");
    }
    
  /**
 * POST Route annotation.
 * @Rest\Post("/app/place/new")
 * @Rest\View
 * @return array
 */
    
        public function addPlacedAction(Request $request)
    {
     
            $place = new Place() ; 
            $form = $this->createForm(new \AppBundle\Form\PlaceType(), $place );
            $form->handleRequest($request);
            
            if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($place);
                    $em->flush();

                    return array('place' =>  $place ) ;
                    return new Response("ok") ;   
                }
 
           return new Response("ko") ;         
    }
    
    

}