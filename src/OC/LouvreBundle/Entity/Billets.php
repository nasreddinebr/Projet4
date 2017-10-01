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
    private $dateReservation;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_total", type="decimal", precision=10, scale=2)
     */
    private $prixTotal;

    /**
     * @ORM\OneToOne(targetEntity="OC\LouvreBundle\Entity\Paiements", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $paiement;

    /**
     * @ORM\OneToOne(targetEntity="OC\LouvreBundle\Entity\Produits", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $produits;



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
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    /**
     * Get dateResrvation
     *
     * @return \DateTime
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
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
     * Set paiment
     *
     * @param \OC\LouvreBundle\Entity\Paiements $paiment
     *
     * @return Billets
     */
    public function setPaiment(\OC\LouvreBundle\Entity\Paiements $paiment)
    {
        $this->paiment = $paiment;

        return $this;
    }

    /**
     * Get paiment
     *
     * @return \OC\LouvreBundle\Entity\Paiements
     */
    public function getPaiment()
    {
        return $this->paiment;
    }

    /**
     * Set produit
     *
     * @param \OC\LouvreBundle\Entity\Produits $produits
     *
     * @return Produits
     */
    public function setProduits(Produits $produit)
    {
        $this->produits = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \OC\LouvreBundle\Entity\Produits
     */
    public function getProduits()
    {
        return $this->produits;
    }
}
