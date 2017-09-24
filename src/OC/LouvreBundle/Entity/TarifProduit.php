<?php

namespace OC\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TarifProduit
 *
 * @ORM\Table(name="tarif_produit")
 * @ORM\Entity(repositoryClass="OC\LouvreBundle\Repository\TarifProduitRepository")
 */
class TarifProduit
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
     * @var int
     *
     * @ORM\Column(name="localisateur_prix", type="integer", unique=true)
     */
    private $localisateurPrix;

    /**
     * @var string
     *
     * @ORM\Column(name="prixUnitaire", type="decimal", precision=10, scale=2)
     */
    private $prixUnitaire;

    /**
     * @ORM\ManyToOne(targetEntity="OC\LouvreBundle\Entity\Tarifs"))
     * @ORM\JoinColumn(nullable=false)
     */
    private $tarif;

    /**
     * @ORM\ManyToOne(targetEntity="OC\LouvreBundle\Entity\Produits"))
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;


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
     * Set localisateurPrix
     *
     * @param integer $localisateurPrix
     *
     * @return TarifProduit
     */
    public function setLocalisateurPrix($localisateurPrix)
    {
        $this->localisateurPrix = $localisateurPrix;

        return $this;
    }

    /**
     * Get localisateurPrix
     *
     * @return integer
     */
    public function getLocalisateurPrix()
    {
        return $this->localisateurPrix;
    }

    /**
     * Set prixUnitaire
     *
     * @param string $prixUnitaire
     *
     * @return TarifProduit
     */
    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    /**
     * Get prixUnitaire
     *
     * @return string
     */
    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    /**
     * Set tarif
     *
     * @param \OC\LouvreBundle\Entity\Tarifs $tarif
     *
     * @return TarifProduit
     */
    public function setTarif(\OC\LouvreBundle\Entity\Tarifs $tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return \OC\LouvreBundle\Entity\Tarifs
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set produit
     *
     * @param \OC\LouvreBundle\Entity\Produits $produit
     *
     * @return TarifProduit
     */
    public function setProduit(\OC\LouvreBundle\Entity\Produits $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \OC\LouvreBundle\Entity\Produits
     */
    public function getProduit()
    {
        return $this->produit;
    }
}
