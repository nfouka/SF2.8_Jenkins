<?php

namespace MyApp\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyAppBlogBundle:Default:index.html.twig');
    }
}
