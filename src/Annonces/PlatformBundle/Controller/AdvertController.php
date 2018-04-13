<?php

//src/Annonces/PlatformBundle/Controller/AdvertController

namespace Annonces\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{
    public function indexAction()
    {
        //$content = $this->get('templating')->render('OCPlatformBundle:Advert:index.html.twig');
		//$content = $this->get('templating')->render('@AnnoncesPlatform/Advert/index.html.twig');
		$content = $this->renderView('@AnnoncesPlatform/Advert/index.html.twig', array('nom' => 'Wizou'));
		return new Response($content);
    }
	
	public function logoutAction()
    {
		$content = $this->renderView('@AnnoncesPlatform/Advert/logout.html.twig', array('nom' => 'Wizou'));
		return new Response($content);
    }
}
