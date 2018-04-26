<?php
// src/Annonces/PlatformBundle/DataFixtures/ORM/LoadCategorie.php

namespace Annonces\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Annonces\PlatformBundle\Entity\Categorie;

class LoadCategorie implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $noms = array(
      'Développement web',
      'Développement mobile',
      'Graphisme',
      'Intégration',
      'Réseau'
    );

    foreach ($noms as $nom) {
      // On crée la catégorie
      $categorie = new Categorie();
      $categorie->setNom($nom);

      // On la persiste
      $manager->persist($categorie);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}