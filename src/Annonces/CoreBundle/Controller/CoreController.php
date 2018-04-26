<?php

namespace Annonces\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Annonces\PlatformBundle\Entity\Advert;
use Annonces\PlatformBundle\Entity\Image;
use Annonces\PlatformBundle\Entity\Candidature;
use Annonces\PlatformBundle\Entity\Categorie;

class CoreController extends Controller
{
    public function indexAction()
    {
		// ...
		// Notre liste d'annonce en dur

		$em = $this->getDoctrine()->getManager();
		
		$listAdverts = $em->getRepository('AnnoncesPlatformBundle:Advert')->findAll();
		
		// On a donc accès au conteneur :
		$mailer = $this->container->get('mailer'); 
		
		// Et modifiez le 2nd argument pour injecter notre liste
		$content = $this->render('@AnnoncesCore/Core/index.html.twig', array('listAdverts' => $listAdverts));

		return $content;
    }	

    public function contactAction(Request $request)
    {
		$session = $request->getSession();
		$session->getFlashBag()->add('info','Vous etes redirigé à l\'accueil, la page de contact n’est pas encore disponible');
		
		return $this->redirectToRoute('annonces_accueil');
    }	
}