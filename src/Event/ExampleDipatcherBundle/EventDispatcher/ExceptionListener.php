<?php


namespace  Event\ExampleDipatcherBundle\EventDispatcher ; 

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ExceptionListener

{
    protected $mailer;
    protected $twig;
    protected $logger ; 
            
    
    function __construct( \Swift_Mailer $mailer , \Twig_Environment $twig , \Symfony\Bridge\Monolog\Logger $logger ) {
        $this->mailer = $mailer;
        $this->twig   = $twig  ; 
        $this->logger = $logger ; 
    }

    
    
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        
        for($i=0 ; $i< 2 ; $i++) {
            
       $message = \Swift_Message::newInstance()
        ->setSubject('event is'.$event->getException()->getMessage()."".  rand(0, 888888888))
        ->setFrom('a_kellal@hotmail.fr')
        ->setTo('nadir.fouka@gmail.com')
        ->setBody(
            $this->twig->render(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/registration.html.twig',
                array('name' => $event->getException()->getMessage())
            ),
            'text/html'
        )
    ;   
            $this->mailer->send($message);
            $this->logger->info('message has benn send to : N°'.$i) ; 
        }
    }
}