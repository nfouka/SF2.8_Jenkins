<?php

namespace Jenkins\ConfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JenkinsConfBundle:Default:index.html.twig');
    }
}
