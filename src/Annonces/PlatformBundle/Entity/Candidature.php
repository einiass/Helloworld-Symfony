<?php

namespace Annonces\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidature
 *
 * @ORM\Table(name="annonces_candidature")
 * @ORM\Entity(repositoryClass="Annonces\PlatformBundle\Repository\CandidatureRepository")
 */
class Candidature
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
	 *@ORM\Column(name="auteur", type="string", length=255)
	 */
	 private $auteur;
	 
	 /**
	 *@ORM\Column(name="contenu", type="text")
	 */
	 private $contenu;
	 /**
	 *@ORM\Column(name="date", type="datetime")
	 */
	 private $date;
	
	/**
	 *@ORM\ManyToOne(targetEntity="Annonces\PlatformBundle\Entity\Advert", inversedBy="candidatures")
	 *@ORM\JoinColumn(nullable=false)
	 */
	 private $advert;
	 
	//Constructeur////////////////////////////////////////:
	public function __construct()
	{
		$this->date = new \Datetime();
	}

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Candidature
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
     * @return Candidature
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
     * Set date
     *
     * @param \datetimez $date
     *
     * @return Candidature
     */
    public function setDate(\datetime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \datetimez
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set advert
     *
     * @param \Annonces\PlatformBundle\Entity\Advert $advert
     *
     * @return Candidature
     */
    public function setAdvert(\Annonces\PlatformBundle\Entity\Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \Annonces\PlatformBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }
}
