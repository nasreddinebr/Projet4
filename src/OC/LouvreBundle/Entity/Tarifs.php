<?php

namespace OC\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarifs
 *
 * @ORM\Table(name="tarifs")
 * @ORM\Entity(repositoryClass="OC\LouvreBundle\Repository\TarifsRepository")
 */
class Tarifs
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
     * @ORM\Column(name="nom_tarif", type="string", length=255)
     */
    private $nomTarif;

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
     * Set nomTarif
     *
     * @param string $nomTarif
     *
     * @return Tarifs
     */
    public function setNomTarif($nomTarif)
    {
        $this->nomTarif = $nomTarif;

        return $this;
    }

    /**
     * Get nomTarif
     *
     * @return string
     */
    public function getNomTarif()
    {
        return $this->nomTarif;
    }
}
