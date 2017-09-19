<?php

namespace OC\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JoursFermeture
 *
 * @ORM\Table(name="jours_fermeture")
 * @ORM\Entity(repositoryClass="OC\LouvreBundle\Repository\JoursFermetureRepository")
 */
class JoursFermeture
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
     * @ORM\Column(name="jours_fermeture", type="string")
     */
    private $joursFermeture;


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
     * Set dateFermeture
     *
     * @param \DateTime $dateFermeture
     *
     * @return JoursFermeture
     */
    public function setJoursFermeture($joursFermeture)
    {
        $this->joursFermeture = $joursFermeture;

        return $this;
    }

    /**
     * Get dateFermeture
     *
     * @return \DateTime
     */
    public function getJoursFermeture()
    {
        return $this->joursFermeture;
    }
}

