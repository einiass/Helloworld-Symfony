<?php

//src/Annonces/PlatformBundle/Controller/AdvertController

namespace Annonces\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Annonces\PlatformBundle\Entity\Advert;
use Annonces\PlatformBundle\Entity\Image;
use Annonces\PlatformBundle\Entity\Candidature;
use Annonces\PlatformBundle\Entity\Categorie;
use Annonces\PlatformBundle\Entity\AdvertCompetence;
use Annonces\PlatformBundle\Entity\Competence;

class AdvertController extends Controller
{
	
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
		//$advert = $this->getDoctrine()->getManager()->find('AnnoncesPlatformBundle:Advert', $id)
		
		$em = $this->getDoctrine()->getManager();
		
		$depot = $em->getRepository('AnnoncesPlatformBundle:Advert');
		
		$advert = $depot->find($id);
		

		//$advert est donc une instance de Annonces\PlatformBundle\Entity\Advert
		// ou null si l'id $id  n'existe pas, d'où ce if :
		if(null === $advert) {
			throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
		}
		
		//on recupere la liste de candidature
		$listCandidatures = $em->getRepository('AnnoncesPlatformBundle:Candidature')->findBy(array('advert' => $advert));
		
		$listAdvertCompetences = $em->getRepository('AnnoncesPlatformBundle:AdvertCompetence')->findBy(array('advert' => $advert));
		
		$content = $this->render('@AnnoncesPlatform/Advert/view.html.twig', array('advert' => $advert, 'listCandidatures' => $listCandidatures, 'listAdvertCompetences' => $listAdvertCompetences));
		
		return $content;
    }	
	
	public function viewCandidatureAction($id)
    {	
	
		$em = $this->getDoctrine()->getManager();
		
		$depot = $em->getRepository('AnnoncesPlatformBundle:Candidature');
		
		$candidature = $depot->find($id);
		
		$content = $this->render('@AnnoncesPlatform/Advert/viewcandidature.html.twig', array('candidature' => $candidature));
		
		return $content;
    }	
	public function viewCourtTextAction($_local, $annee, $courtText, $_format)
    {
		return new Response("afficher  :  en ".$_local."   ".$annee."  ".$courtText."  ".$_format);
    }
	
	
	public function ajouterAction(Request $request)
    {
		
		$advert01 = new Advert();
		$advert01->setTitre('Rech développeur Symfony. Competence');
		$advert01->setAuteur('Elhadji');
		$advert01->setContenu('Nous recherchons un développeur Competent Symfony débutant sur Lyon. Blabla…');
		
		// On peut ne pas définir ni la date ni la publication,
		// car ces attributs sont définis automatiquement dans le constructeur

		// Création de l'entité Image
		$image = new Image();
		$image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
		$image->setAlt('Job de rêve');
		
		$advert01->setImage($image);
		
		// On récupère l'EntityManager
		$em = $this->getDoctrine()->getManager();
		
		//on recupere toutes les entités possible
		$listeCompetences = $em->getRepository('AnnoncesPlatformBundle:Competence')->findAll();
		
		foreach($listeCompetences as $competence)
		{
			//on crée une relation entre l'annonce et la competence
			$advertCompetence = new AdvertCompetence();
			
			// On la lie à l'annonce, qui est ici toujours la même
			$advertCompetence->setAdvert($advert01);
			
			// On la lie à la compétence, qui change ici dans la boucle foreach
			$advertCompetence->setCompetence($competence);
			
			// Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert
			$advertCompetence->setNiveau('Expert');
			
			// Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
			$em->persist($advertCompetence);
		}
		
		// Doctrine ne connait pas encore l'entité $advert. Si vous n'avez pas défini la relation AdvertSkill
		// avec un cascade persist (ce qui est le cas si vous avez utilisé mon code), alors on doit persister $advert
		$em->persist($advert01);
			
		/*
		//Ajout candidature 01
		$candidature01 = new Candidature();
		$candidature01->setAuteur('Marine');
		$candidature01->setContenu("J'ai toutes les qualités requises.");
		
		//Ajout candidature 02
		$candidature02 = new Candidature();
		$candidature02->setAuteur('Pierre');
		$candidature02->setContenu("Je suis très motivé.");
		
		//on lie les candidatures avec l'annonce
		$candidature01->setAdvert($advert01);
		$candidature02->setAdvert($advert01);
		// Étape 1 : On « persiste » l'entité
		//$em->persist($advert01); ----------
		
		// Étape 2 : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
		// définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
		
		//$em->persist($candidature01);---------------
		//$em->persist($candidature02);---------------
		
		// On récupère l'annonce d'id 1. On n'a pas encore vu cette méthode find(),
		// mais elle est simple à comprendre. Pas de panique, on la voit en détail
		// dans un prochain chapitre dédié aux repositories
		$advertRepo01 = $em->getRepository('AnnoncesPlatformBundle:Advert')->find(2);
		
		//on modifie la date de l'annonce récupérée
		//$date = new \Datetime();
		//$advertRepo01->setDate($date->modify('+2 hour'));
		// Ici, pas besoin de faire un persist() sur $advert2. En effet, comme on a

		// récupéré cette annonce via Doctrine, il sait déjà qu'il doit gérer cette
		// entité. Rappelez-vous, un persist ne sert qu'à donner la responsabilité
		// de l'objet à Doctrine. il est initule de faire un persiste
		//$em->persist($advertRepo01);
		
		// Étape 2 : On « flush » tout ce qui a été persisté avant
		// Enfin, on applique les deux changements à la base de données :
		// Un INSERT INTO pour ajouter $advert01
		// Et un UPDATE pour mettre à jour la date de $advertRepo01
		
		//retourne true si l'entité donnée en argument est gérée par l'EntityManager (s'il y a eu unpersist()sur l'entité donc)
		//var_dump($em->contains($advert01));
		*/
		// On déclenche l'enregistrement
		$em->flush();
		
		
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
		$em = $this->getDoctrine()->getManager();
		$advert = $em->getRepository('AnnoncesPlatformBundle:Advert')->find($id);
		
		$listCategories = $em->getRepository('AnnoncesPlatformBundle:Categorie')->findAll();
		
		$listeCompetences = $em->getRepository('AnnoncesPlatformBundle:Competence')->findAll();
		
		foreach($listeCompetences as $competence)
		{
			//on crée une relation entre l'annonce et la competence
			$advertCompetence = new AdvertCompetence(); //entité propriétaire
			
			// On la lie à l'annonce, qui est ici toujours la même
			$advertCompetence->setAdvert($advert);
			
			// On la lie à la compétence, qui change ici dans la boucle foreach
			$advertCompetence->setCompetence($competence);
			
			// Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert
			$advertCompetence->setNiveau('Expert');
			
			// Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
			$em->persist($advertCompetence);
		}
		
		foreach($listCategories as $categorie)
		{
			$advert->addCategory($categorie);
		}
		// Même mécanisme que pour l'ajout
		if ($request->isMethod('POST')) {
			$request->getSession()->getFlashBag()->add('info', 'Annonce bien modifiée.');

			return $this->redirectToRoute('annonces_view', array('id' => $id));
		}
		
		$em->flush();
		
		$content = $this->render('@AnnoncesPlatform/Advert/modifier.html.twig', array('advert' => $advert));
		
		return $content;
    }
	
	public function supprimerAction($id)
    {
				// Ici, on récupérera l'annonce correspondante à $id
		$em = $this->getDoctrine()->getManager();
		$advert = $em->getRepository('AnnoncesPlatformBundle:Advert')->find($id);
		
		$listCategories = $em->getRepository('AnnoncesPlatformBundle:Categorie')->findAll();
		
		
		foreach($listCategories as $categorie)
		{
			$advert->removeCategory($categorie);
		}
		// Même mécanisme que pour l'ajout
		if ($request->isMethod('POST')) {
			$request->getSession()->getFlashBag()->add('info', 'Annonce bien modifiée.');

			return $this->redirectToRoute('annonces_view', array('id' => $id));
		}
		
		$em->flush();

		$content = $this->render('@AnnoncesPlatform/Advert/supprimer.html.twig', array('id' => $id));
		return $content;
    }
}
