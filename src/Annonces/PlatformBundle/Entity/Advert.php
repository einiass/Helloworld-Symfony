<?php

namespace Annonces\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Advert
 *
 * @ORM\Table(name="annonces_advert")
 * @ORM\Entity(repositoryClass="Annonces\PlatformBundle\Repository\AdvertRepository")
 */
class Advert
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

	/**
     * @var boolean
     *
     * @ORM\Column(name="publiee", type="boolean")
     */
    private $publiee = true;
	
	/**
	 *@ORM\OneToOne(targetEntity="Annonces\PlatformBundle\Entity\Image", cascade={"persist"})
	 *
	 */
	 private $image;
	 
	/**
	 *@ORM\ManyToMany(targetEntity="Annonces\PlatformBundle\Entity\Categorie", cascade={"persist"})
	 *@ORM\JoinTable(name="annonces_advert_categorie")
	 */
	private $categories;
	  
	/**
	 *@ORM\OneToMany(targetEntity="Annonces\PlatformBundle\Entity\Candidature", mappedBy="advert")
	 *@ORM\JoinColumn(nullable=false)
	 */
	private $candidatures;
	  
	//Constructeur ////////////////////////////////////
	public function __construct() 
	{
		$this->date = new \DateTime();
		$this->categories = new ArrayCollection();
	}

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Advert
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Advert
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Advert
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set publiee
     *
     * @param boolean $publiee
     *
     * @return Advert
     */
    public function setPubliee($publiee)
    {
        $this->publiee = $publiee;

        return $this;
    }

    /**
     * Get publiee
     *
     * @return boolean
     */
    public function getPubliee()
    {
        return $this->publiee;
    }

    /**
     * Set image
     *
     * @param \Annonces\PlatformBundle\Entity\Image $image
     *
     * @return Advert
     */
    public function setImage(\Annonces\PlatformBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Annonces\PlatformBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }



    /**
     * Set categories
     *
     * @param \Annonces\PlatformBundle\Entity\Categorie $categories
     *
     * @return Advert
     */
    public function setCategories(\Annonces\PlatformBundle\Entity\Categorie $categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return \Annonces\PlatformBundle\Entity\Categorie
     */
    public function getCategories()
    {
        return $this->categories;
    }
 
    /**
     * Add category
     *
     * @param \Annonces\PlatformBundle\Entity\Categorie $category
     *
     * @return Advert
     */
    public function addCategory(\Annonces\PlatformBundle\Entity\Categorie $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Annonces\PlatformBundle\Entity\Categorie $category
     */
    public function removeCategory(\Annonces\PlatformBundle\Entity\Categorie $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Add candidature
     *
     * @param \Annonces\PlatformBundle\Entity\Candidature $candidature
     *
     * @return Advert
     */
    public function addCandidature(\Annonces\PlatformBundle\Entity\Candidature $candidature)
    {
        $this->candidatures[] = $candidature;
		
		// On lie l'annonce à la candidature
		$candidature->setAdvert($this);
		
        return $this;
    }

    /**
     * Remove candidature
     *
     * @param \Annonces\PlatformBundle\Entity\Candidature $candidature
     */
    public function removeCandidature(\Annonces\PlatformBundle\Entity\Candidature $candidature)
    {
        $this->candidatures->removeElement($candidature);
		
		// Et si notre relation était facultative (nullable=true, ce qui n'est pas notre cas ici attention) :        
		// $application->setAdvert(null);
    }

    /**
     * Get candidatures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCandidatures()
    {
        return $this->candidatures;
    }
}
