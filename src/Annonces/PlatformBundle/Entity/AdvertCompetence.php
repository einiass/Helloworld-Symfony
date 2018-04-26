<?php

namespace Annonces\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdvertCompetence
 *
 * @ORM\Table(name="annonces_advert_competence")
 * @ORM\Entity(repositoryClass="Annonces\PlatformBundle\Repository\AdvertCompetenceRepository")
 */
class AdvertCompetence
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
	 *@ORM\Column(name="niveau", type="string", length=255)
	 *
	 */
	 private $niveau;
	 
	/**
	 *@ORM\ManyToOne(targetEntity="Annonces\PlatformBundle\Entity\Advert")
	 *@ORM\JoinColumn(nullable=false)
	 */
	 private $advert;
	 
	 /**
	 *@ORM\ManyToOne(targetEntity="Annonces\PlatformBundle\Entity\Competence")
	 *@ORM\JoinColumn(nullable=false)
	 */
	 private $competence;
	 

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
     * Set niveau
     *
     * @param string $niveau
     *
     * @return AdvertCompetence
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set advert
     *
     * @param \Annonces\PlatformBundle\Entity\Advert $advert
     *
     * @return AdvertCompetence
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

    /**
     * Set competence
     *
     * @param \Annonces\PlatformBundle\Entity\Competence $competence
     *
     * @return AdvertCompetence
     */
    public function setCompetence(\Annonces\PlatformBundle\Entity\Competence $competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return \Annonces\PlatformBundle\Entity\Competence
     */
    public function getCompetence()
    {
        return $this->competence;
    }
}
