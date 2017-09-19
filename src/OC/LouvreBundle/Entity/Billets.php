<?php

namespace OC\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Billets
 *
 * @ORM\Table(name="billets")
 * @ORM\Entity(repositoryClass="OC\LouvreBundle\Repository\BilletsRepository")
 */
class Billets
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
     * @var string
     *
     * @ORM\Column(name="numero_billet", type="string", length=255)
     */
    private $numeroBillet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_resrvation", type="date")
     */
    private $dateResrvation;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_total", type="decimal", precision=10, scale=2)
     */
    private $prixTotal;


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
     * Set numeroBillet
     *
     * @param string $numeroBillet
     *
     * @return Billets
     */
    public function setNumeroBillet($numeroBillet)
    {
        $this->numeroBillet = $numeroBillet;

        return $this;
    }

    /**
     * Get numeroBillet
     *
     * @return string
     */
    public function getNumeroBillet()
    {
        return $this->numeroBillet;
    }

    /**
     * Set dateResrvation
     *
     * @param \DateTime $dateResrvation
     *
     * @return Billets
     */
    public function setDateResrvation($dateResrvation)
    {
        $this->dateResrvation = $dateResrvation;

        return $this;
    }

    /**
     * Get dateResrvation
     *
     * @return \DateTime
     */
    public function getDateResrvation()
    {
        return $this->dateResrvation;
    }

    /**
     * Set prixTotal
     *
     * @param string $prixTotal
     *
     * @return Billets
     */
    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    /**
     * Get prixTotal
     *
     * @return string
     */
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }
}
