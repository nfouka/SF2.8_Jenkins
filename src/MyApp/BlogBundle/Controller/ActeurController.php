<?php

namespace MyApp\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse ; 
use Symfony\Component\HttpFoundation\Request;
use MyApp\BlogBundle\Entity\Acteur ; 
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
 use GuzzleHttp\Client;


class ActeurController extends Controller
{

    
public function setLocaleAction($language = null)
{
    if($language != null)
    {
        // On enregistre la langue en session
        $this->get('session')->set('locale', $language);
    }
    
    // on tente de rediriger vers la page d'origine
    $url = $this->container->get('request')->headers->get('referer');
    if(empty($url)) {
        $url = $this->container->get('router')->generate('my_app_my_fos_homepage');
    }
    return new RedirectResponse($url);
    
}
    
public function ajouterAction(Request $request)
{
  $message='loading ... ';
  $acteur = new Acteur();
  $form = $this->container->get('form.factory')->create(new \MyApp\BlogBundle\Form\ActeurType, $acteur);


  if ($request->getMethod() == 'POST') 
  {
     $form->handleRequest($request);

    if ($form->isValid()) 
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($acteur);
      $em->flush();
      $message='Acteur ajouté avec succès !' ;
    }
  }
  
  

  return $this->container->get('templating')->renderResponse(
            'MyAppBlogBundle:Acteur:ajouter.html.twig',
  array(
    'form' => $form->createView(),
    'message' => $message,
      'entity' => $acteur , 
  ));
}

    
  public function deleteAction($id){
        
  $em = $this->getDoctrine()->getManager();
  $acteur = $em->find('MyAppBlogBundle:Acteur', $id);
        
  if (!$acteur) 
  {
    throw new NotFoundHttpException("Acteur non trouvé");
  }
       
  $em->remove($acteur);
  $em->flush();  
  return new RedirectResponse($this->container->get('router')->generate('top_acteur'));
  
    }

    public function topActeurAction($max = 12 , Request $request )
    {

      $session = $request->getSession();

        $authErrorKey = \Symfony\Component\Security\Core\Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

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
        
    $em = $this->getDoctrine()->getManager() ; 
    $qb = $em->createQueryBuilder();
    $qb->select('a')
      ->from('MyAppBlogBundle:Acteur', 'a')
      ->orderBy('a.dateNaissance', 'DESC')
      ->setMaxResults($max);

    $query = $qb->getQuery();
    $acteurs = $query->getResult();
    $user = $this->container->get('security.context')->getToken()->getUser() ; 
        
        return $this->render('MyAppBlogBundle:Acteur:top_acteur.html.twig', array(
                             'acteurs'          => $acteurs,
                              'last_username'   => $lastUsername,
                              'error'           => $error,
                              'csrf_token'      => $csrfToken,
                              'user'            => $user
        ));
    }
    
    
    
    public function loginAction(Request $request)
    {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

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

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function renderLogin(array $data)
    {
        return $this->render('FOSUserBundle:Security:login.html.twig', $data);
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
    
        public function jsonAction($max = 1200 , Request $request )
    {

   
    $em = $this->getDoctrine()->getManager() ; 
    $qb = $em->createQueryBuilder();
    $qb->select('a')
      ->from('MyAppBlogBundle:Acteur', 'a')
      ->leftJoin('a.user', 'u')
      ->orderBy('a.dateNaissance', 'DESC')
      ->setMaxResults($max);

    $query = $qb->getQuery();
    $acteurs = $query->getArrayResult();
    return new \Symfony\Component\HttpFoundation\JsonResponse($acteurs) ; 
    
    }
    

    
    public function guzzleAction()
{

      $client = new \GuzzleHttp\Client();
      $result = $client->get('http://localhost/blog2/web/app_dev.php/en/all.json') ; 

      $contents =  $result->getBody() ; 
      $json = json_decode($contents) ; 
      print_r($json) ; 

      $nadirs[] =  array(new \MyApp\BlogBundle\Entity\Nadir("", "")) ; 

      foreach($json as $key=>$value){
            echo $value->{'nom'}." , ".$value->{'dateNaissance'}->{'date'}."</br/>" ;
            array_push($nadirs, new \MyApp\BlogBundle\Entity\Nadir($value->{'nom'}, $value->{'dateNaissance'}->{'date'}) );
        }
      
foreach ($nadirs as $n) {
    print $n->getNom() ; 
}
        
       return $this->render('MyAppBlogBundle:Acteur:top_acteur2.html.twig', array(
                             'acteurs'          => $nadirs
        ));
    
}




}
