<?php

namespace OC\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clients
 *
 * @ORM\Table(name="clients")
 * @ORM\Entity(repositoryClass="OC\LouvreBundle\Repository\ClientsRepository")
 */
class Clients
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255)
     */
    private $pays;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tarifReduit", type="boolean", nullable=true)
     */
    private $tarifReduit;

    /**
     * @ORM\ManyToOne(targetEntity="OC\LouvreBundle\Entity\Billets"))
     * @ORM\JoinColumn(nullable=false)
     */
    private $billet;

    /**
     * @ORM\ManyToOne(targetEntity="OC\LouvreBundle\Entity\Tarifs"))
     * @ORM\JoinColumn(nullable=false)
     */
    private $tarif;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Clients
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Clients
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Clients
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Clients
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }
    

    /**
     * Set billet
     *
     * @param \OC\LouvreBundle\Entity\Billets $billet
     *
     * @return Billets
     */
    public function setBillet(Billets $billet)
    {
        $this->billet = $billet;

        return $this;
    }

    /**
     * Get billet
     *
     * @return \OC\LouvreBundle\Entity\Billets
     */
    public function getBillet()
    {
        return $this->billet;
    }

    public function hydrate(Clients $client){
        // Parcourire l'objet
        foreach ($client as $key => $valeu){
            // Onrecupére le nom du setter
            $methode = 'set' . ucfirst($key);

            // Si la le setter existe
            if (method_exists($this, $methode)) {
                // On apelle le seter corespondant et en le hydrate
                $this->$methode($valeu);
            }
        }
    }



    /**
     * Set tarifReduit
     *
     * @param boolean $tarifReduit
     *
     * @return Clients
     */
    public function setTarifReduit($tarifReduit)
    {
        $this->tarifReduit = $tarifReduit;

        return $this;
    }

    /**
     * Get tarifReduit
     *
     * @return boolean
     */
    public function getTarifReduit()
    {
        return $this->tarifReduit;
    }

    /**
     * Set tarif
     *
     * @param \OC\LouvreBundle\Entity\Tarifs $tarif
     *
     * @return Clients
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
}
