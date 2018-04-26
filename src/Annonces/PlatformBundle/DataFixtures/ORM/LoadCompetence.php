<?php
// src/Annonces/PlatformBundle/DataFixtures/ORM/LoadCompetence.php

namespace Annonces\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Annonces\PlatformBundle\Entity\Competence;

class LoadCompetence implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
	 // Liste des noms de compétences à ajouter
    $noms = array('PHP', 'Symfony', 'C++', 'Java', 'Photoshop', 'Blender', 'Bloc-note');

    foreach ($noms as $nom) {
      // On crée la compétence
      $competence = new Competence();
      $competence->setNom($nom);
      // On la persiste
      $manager->persist($competence);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}