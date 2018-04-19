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
		//Recuperation de la valeur de page par defaut seulement lorsqu'elle est vide
		if($page === '') 
		{ 
			$page = 1; 
		}
		
		// On ne sait pas combien de pages il y a
		// Mais on sait qu'une page doit être supérieure ou égale à 1
		
		if ($page < 1) {
			// On déclenche une exception NotFoundHttpException, cela va afficher
			// une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
			throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
		}
		
        //$content = $this->get('templating')->render('OCPlatformBundle:Advert:index.html.twig');
		$content = $this->render('@AnnoncesPlatform/Advert/index.html.twig', array('nom' => 'Wizou','page' => $page));
		
		return $content;
    }
	
	public function viewAction($id)
    {
		$content = $this->render('@AnnoncesPlatform/Advert/view.html.twig', array('id' => $id));
		
		return $content;
    }
	
	public function viewCourtTextAction($_local, $annee, $courtText, $_format)
    {
		return new Response("afficher  :  en ".$_local."   ".$annee."  ".$courtText."  ".$_format);
    }
	
	
	public function ajouterAction(Request $request)
    {
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

		// Même mécanisme que pour l'ajout
		if ($request->isMethod('POST')) {
		  $request->getSession()->getFlashBag()->add('info', 'Annonce bien modifiée.');
		  
		  return $this->redirectToRoute('annonces_view', array('id' => $id));
		}

		$content = $this->render('@AnnoncesPlatform/Advert/modifier.html.twig', array('id' => $id));
		
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
