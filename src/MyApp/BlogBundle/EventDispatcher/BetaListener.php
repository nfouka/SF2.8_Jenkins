<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BetaListener
 *
 * @author nadir
 */


namespace MyApp\BlogBundle\EventDispatcher ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;



class BetaListener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface {

  protected $dateFin;
  protected $mailer;
  protected $twig;
  protected $logger ; 
  
  
  public function __construct($dateFin , \Swift_Mailer $mailer , \Twig_Environment $twig , \Symfony\Bridge\Monolog\Logger $logger )
  {
    $this->dateFin = new \Datetime($dateFin);
    $this->mailer = $mailer;
    $this->twig   = $twig  ; 
    $this->logger = $logger ; 
    
  }

  protected function displayBeta(Response $response, $joursRestant)
  {
    $content = $response->getContent();

    // Code à rajouter
    $html = '<div class="alert alert-warning" role="alert">Beta REST J-'.(int) $joursRestant.' Jour(s) ! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
         ; 

    // Insertion du code dans la page, dans le <h1> du header
    $content = preg_replace('#<h1>(.*?)</h1>#iU',
                            '<h1>$1'.$html.'</h1>',
                            $content,
                            1);

    $response->setContent($content);
    return $response;
  }
  
  
 
   public function onKernelResponse3(FilterResponseEvent $event)
  {

      $this->logger->info("methode 3 execute from kernel.response") ; 
             for($i=0 ; $i< 5 ; $i++) {
            
       $message = \Swift_Message::newInstance()
        ->setSubject('event is'.rand(0, 888888888))
        ->setFrom('a_kellal@hotmail.fr')
        ->setTo('smerouane78@yahoo.fr')
        ->setBody(
            $this->twig->render(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/registration.html.twig',
                array('name' => '')
            ),
            'text/html'
        )
    ;   
            $this->mailer->send($message);
            $this->logger->info('message has benn send to : N°'.$i) ; 
        }
  
  }
   public function onKernelResponse4(FilterResponseEvent $event)
  {

      $this->logger->info("methode 4 execute from kernel.response") ; 
      
             for($i=0 ; $i< 5 ; $i++) {
            
       $message = \Swift_Message::newInstance()
        ->setSubject('event is'. rand(0, 888888888))
        ->setFrom('a_kellal@hotmail.fr')
        ->setTo('nadir.fouka@gmail.com')
        ->setBody(
            $this->twig->render(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/registration.html.twig',
                array('name' => '')
            ),
            'text/html'
        )
    ;   
            $this->mailer->send($message);
            $this->logger->info('message has benn send to : N°'.$i) ; 
        }
  
  }
  
  public function onKernelResponse2(FilterResponseEvent $event)
  {

      $this->logger->info("methode 2 execute from kernel.response") ; 
  
  }

  public function onKernelResponse(FilterResponseEvent $event)
  {

    $response = $event->getResponse();
    if ($this->dateFin > new \Datetime()) {
      $joursRestant = $this->dateFin->diff(new \Datetime())->days;
      $response = $this->displayBeta($event->getResponse(), $joursRestant);
    }
    $event->setResponse($response);
  
  }  public function onKernelException(FilterResponseEvent $event)
    {
        
        $this->logger->info("methode 1 execute from kernel.response") ; 
    }


    
   static public function getSubscribedEvents() {
     return array(
     \Symfony\Component\HttpKernel\KernelEvents::RESPONSE => array(
               array('onKernelResponse2', 1),
               array('onKernelException', 2),
               array('onKernelResponse2', 100),
               array('onKernelResponse3', 3),
               array('onKernelResponse4', 4),
           )
        );
    }

}

