<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MyApp\BlogBundle\EventDispatcher;

/**
 * Description of LocaleListener
 *
 * @author nadir
 */

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Monolog\Logger ; 
use Symfony\Component\HttpKernel\Log\LoggerInterface;
 
class LocaleListener extends \Symfony\Bundle\FrameworkBundle\Controller\Controller implements EventSubscriberInterface 
{
    private $defaultLocale;
 
    public function __construct($defaultLocale = 'en' )
    {
        $this->defaultLocale = $defaultLocale;
        
    }
 
    public function onKernelRequest(GetResponseEvent $event)
    {
           
         $this->logger->info('Im here');
         
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }
 
        // On essaie de voir si la locale a été fixée dans le paramètre de routing _locale
        if ($locale = $request->attributes->get('locale')) {
            $request->getSession()->set('locale', $locale);
            $logger->info('local :'.$locale);
        } else {
            // Si aucune locale n'a été fixée explicitement dans la requête, on utilise celle de la session
            $request->setLocale($request->getSession()->get('locale', $this->defaultLocale));
        }
    }
 
    public static function getSubscribedEvents()
    {
        return array(
            // Doit être enregistré avant le Locale listener par défaut
            KernelEvents::REQUEST => array(array('onKernelRequest', 1 )),
        );
    }



}