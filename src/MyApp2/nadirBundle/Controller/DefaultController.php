<?php

namespace MyApp2\nadirBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyApp2nadirBundle:Default:index.html.twig');
    }
}
