<?php

//src/Annonces/PlatformBundle/Controller/AdvertController

namespace Annonces\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{
    public function indexAction($page)
    {
        //$content = $this->get('templating')->render('OCPlatformBundle:Advert:index.html.twig');
		$content = $this->renderView('@AnnoncesPlatform/Advert/index.html.twig', array('nom' => 'Wizou','page' => $page));
		return new Response($content);
    }
	
	public function viewAction($id)
    {
		$content = $this->renderView('@AnnoncesPlatform/Advert/view.html.twig', array('id' => $id));
		return new Response($content);
    }
	
	public function viewCourtTextAction($_local, $annee, $courtText, $_format)
    {
		return new Response("afficher  :  en ".$_local."   ".$annee."  ".$courtText."  ".$_format);
    }
	
	
	public function ajouterAction()
    {
		return new Response("ajouter annonce formulaire");
    }
	
	public function modifierAction($id)
    {
		return new Response("modifier : ".$id);
    }
	
	public function supprimerAction($id)
    {
		return new Response("supprimer  : ".$id);
    }
	
}
