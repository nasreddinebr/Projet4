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
     * @var int
     *
     * @ORM\Column(name="id_produit", type="integer")
     */
    private $idProduit;

    /**
     * @var int
     *
     * @ORM\Column(name="id_paiement", type="integer")
     */
    private $idPaiement;


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

    /**
     * Set idProduit
     *
     * @param integer $idProduit
     *
     * @return Billets
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    /**
     * Get idProduit
     *
     * @return integer
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * Set idPaiement
     *
     * @param integer $idPaiement
     *
     * @return Billets
     */
    public function setIdPaiement($idPaiement)
    {
        $this->idPaiement = $idPaiement;

        return $this;
    }

    /**
     * Get idPaiement
     *
     * @return integer
     */
    public function getIdPaiement()
    {
        return $this->idPaiement;
    }
}
