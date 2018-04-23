<?php

namespace Annonces\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction()
    {
		// ...
		// Notre liste d'annonce en dur
		$listAdverts = array(
			array(
				'title'   => 'Recherche développpeur Symfony3',
				'id'      => 1,
				'author'  => 'Alexandre',
				'content' => 'Nous recherchons un développeur Symfony3 débutant sur Lyon. Blabla…',
				'date'    => new \Datetime()
			),
			array(
				'title'   => 'Mission de webmaster',
				'id'      => 2,
				'author'  => 'Hugo',
				'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
				'date'    => new \Datetime()
			),
			array(
				'title'   => 'Offre de stage webdesigner',
				'id'      => 3,
				'author'  => 'Mathieu',
				'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
				'date'    => new \Datetime()
			)
		);
		
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