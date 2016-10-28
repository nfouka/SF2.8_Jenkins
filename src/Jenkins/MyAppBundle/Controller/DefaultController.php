<?php

namespace Jenkins\MyAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JenkinsMyAppBundle:Default:index.html.twig');
    }
}
