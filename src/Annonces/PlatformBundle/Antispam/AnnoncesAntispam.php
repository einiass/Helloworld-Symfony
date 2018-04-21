<?php
// src/Annonces/PlatformBundle/Antispam/AnnoncesAntispam.php

namespace Annonces\PlatformBundle\Antispam;

class AnnoncesAntispam
{
	private $mailer;
	private $locale;
	private $minLength;
	
	public function __construct(\Swift_Mailer $mailer, $locale, $minLength)
	{
		$this->mailer = $mailer;
		$this->locale = $locale;
		$this->minLength = (int) $minLength;
	}
	/**
	* Vérifie si le texte est un spam ou non
	*
	* @param string $text
	* @return bool
	*/
	public function isSpam($text)
	{
		if( strlen($text) < $this->minLength)
			return true;
		else
			return false;
	}
}