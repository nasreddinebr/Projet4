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
     * @ORM\Column(name="produitId", type="integer")
     */
    private $produitId;

    /**
     * @var int
     *
     * @ORM\Column(name="tarifId", type="integer")
     */
    private $tarifId;

    /**
     * @var string
     *
     * @ORM\Column(name="prixUnitaire", type="decimal", precision=10, scale=2)
     */
    private $prixUnitaire;


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
     * Set produitId
     *
     * @param integer $produitId
     *
     * @return TarifProduit
     */
    public function setProduitId($produitId)
    {
        $this->produitId = $produitId;

        return $this;
    }

    /**
     * Get produitId
     *
     * @return int
     */
    public function getProduitId()
    {
        return $this->produitId;
    }

    /**
     * Set tarifId
     *
     * @param integer $tarifId
     *
     * @return TarifProduit
     */
    public function setTarifId($tarifId)
    {
        $this->tarifId = $tarifId;

        return $this;
    }

    /**
     * Get tarifId
     *
     * @return int
     */
    public function getTarifId()
    {
        return $this->tarifId;
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
}

