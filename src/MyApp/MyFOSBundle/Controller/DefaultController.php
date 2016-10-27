<?php

namespace MyApp\MyFOSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $session = $request->getSession();

        $authErrorKey = \Symfony\Component\Security\Core\Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = \Symfony\Component\Security\Core\Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;
        

    $user = $this->container->get('security.context')->getToken()->getUser() ; 
        
        return $this->render('MyAppMyFOSBundle:Default:index.html.twig', array(
                            
                              'last_username'   => $lastUsername,
                              'error'           => $error,
                              'csrf_token'      => $csrfToken,
                              'user'            => $user
        ));
        
        
    }
}
