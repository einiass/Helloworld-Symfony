<?php

//src/Annonces/PlatformBundle/Controller/AdvertController

namespace Annonces\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdvertController extends Controller
{
    public function indexAction($page)
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
		$content = $this->render('@AnnoncesPlatform/Advert/index.html.twig', array('listAdverts' => $listAdverts));

		return $content;
    }
	
	public function menuAction($limit)
	{
		// On fixe en dur une liste ici, bien entendu par la suite
		// on la récupérera depuis la BDD !
		$listAdverts = array(
		  array('id' => 2, 'title' => 'Recherche développeur Symfony3'),
		  array('id' => 5, 'title' => 'Mission de webmaster'),
		  array('id' => 9, 'title' => 'Offre de stage webdesigner')
		);

		return $this->render('@AnnoncesPlatform/Advert/menu.html.twig', array(
		  // Tout l'intérêt est ici : le contrôleur passe
		  // les variables nécessaires au template !
		  'listAdverts' => $listAdverts
		));
	}
	
	public function viewAction($id)
    {
		
		$advert = array(
		  'title'   => 'Recherche développpeur Symfony3',
		  'id'      => $id,
		  'author'  => 'Alexandre',
		  'content' => 'Nous recherchons un développeur Symfony3 débutant sur Lyon. Blabla…',
		  'date'    => new \Datetime()
		);

		$content = $this->render('@AnnoncesPlatform/Advert/view.html.twig', array(
		  'advert' => $advert
		));
	
		return $content;
    }
	
	public function viewCourtTextAction($_local, $annee, $courtText, $_format)
    {
		return new Response("afficher  :  en ".$_local."   ".$annee."  ".$courtText."  ".$_format);
    }
	
	
	public function ajouterAction(Request $request)
    {
		// On récupère le service
		$antispam = $this->container->get('annonces.antispam');

		// Je pars du principe que $text contient le texte d'un message quelconque
		$text = ' Je pars du principe que $text contient le texte d un message quelconque Je pars du principe que $text contient le texte d un message quelconque';
		if ($antispam->isSpam($text)) {
			throw new \Exception('Votre message a été détecté comme spam !');
		}
		
		// La gestion d'un formulaire est particulière, mais l'idée est la suivante :
		
		// Si la requête est en POST, c'est que le visiteur a soumis le formulaire
		if ($request->isMethod('POST')) {
			
			// Ici, on s'occupera de la création et de la gestion du formulaire
			
			$request->getSession()->getFlashBag()->add('info', 'Annonce bien enregistrée.');
			
			// Puis on redirige vers la page de visualisation de cettte annonce
			return $this->redirectToRoute('annonces_view', array('id' => 5));
		}
		// Si on n'est pas en POST, alors on affiche le formulaire
		$content = $this->render('@AnnoncesPlatform/Advert/ajouter.html.twig');
		
		return $content;
    }
	
	public function modifierAction($id, Request $request)
    {
		// Ici, on récupérera l'annonce correspondante à $id
		$advert = array(
			'title'   => 'Recherche développpeur Symfony3',
			'id'      => $id,
			'author'  => 'Alexandre',
			'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
			'date'    => new \Datetime()
		);

		// Même mécanisme que pour l'ajout
		if ($request->isMethod('POST')) {
			$request->getSession()->getFlashBag()->add('info', 'Annonce bien modifiée.');

			return $this->redirectToRoute('annonces_view', array('id' => $id));
		}

		$content = $this->render('@AnnoncesPlatform/Advert/modifier.html.twig', array('advert' => $advert));
		
		return $content;
    }
	
	public function supprimerAction($id)
    {
		// Ici, on récupérera l'annonce correspondant à $id

		// Ici, on gérera la suppression de l'annonce en question

		$content = $this->render('@AnnoncesPlatform/Advert/supprimer.html.twig', array('id' => $id));
		
		return $content;
    }
	
}
