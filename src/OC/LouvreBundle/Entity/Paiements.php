<?php

namespace OC\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiements
 *
 * @ORM\Table(name="paiements")
 * @ORM\Entity(repositoryClass="OC\LouvreBundle\Repository\PaiementsRepository")
 */
class Paiements
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
     * @ORM\Column(name="titulaire_carte", type="string", length=255)
     */
    private $titulaireCarte;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="stripe_client_id", type="string", length=255)
     */
    private $stripeClientId;

    /**
     * @var string
     *
     * @ORM\Column(name="stripe_charge_id", type="string", length=255)
     */
    private $stripeChargeId;

    /**
     * @var string
     *
     * @ORM\Column(name="somme_payee", type="decimal", precision=10, scale=2)
     */
    private $sommePayee;


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
     * Set titulaireCarte
     *
     * @param string $titulaireCarte
     *
     * @return Paiements
     */
    public function setTitulaireCarte($titulaireCarte)
    {
        $this->titulaireCarte = $titulaireCarte;

        return $this;
    }

    /**
     * Get titulaireCarte
     *
     * @return string
     */
    public function getTitulaireCarte()
    {
        return $this->titulaireCarte;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Paiements
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set stripeClientId
     *
     * @param string $stripeClientId
     *
     * @return Paiements
     */
    public function setStripeClientId($stripeClientId)
    {
        $this->stripeClientId = $stripeClientId;

        return $this;
    }

    /**
     * Get stripeClientId
     *
     * @return string
     */
    public function getStripeClientId()
    {
        return $this->stripeClientId;
    }

    /**
     * Set stripeChargeId
     *
     * @param string $stripeChargeId
     *
     * @return Paiements
     */
    public function setStripeChargeId($stripeChargeId)
    {
        $this->stripeChargeId = $stripeChargeId;

        return $this;
    }

    /**
     * Get stripeChargeId
     *
     * @return string
     */
    public function getStripeChargeId()
    {
        return $this->stripeChargeId;
    }

    /**
     * Set sommePayee
     *
     * @param string $sommePayee
     *
     * @return Paiements
     */
    public function setSommePayee($sommePayee)
    {
        $this->sommePayee = $sommePayee;

        return $this;
    }

    /**
     * Get sommePayee
     *
     * @return string
     */
    public function getSommePayee()
    {
        return $this->sommePayee;
    }

    /**
     * @param array $billet
     * @param Paiements $paiement
     * @param $numeroBillet
     * @param $total
     */
    public function hydrate(array $paiement){
        // Parcourire l'objet
        foreach ($paiement as $key => $valeu){
            // Onrecupére le nom du setter
            $methode = 'set' . ucfirst($key);

            // Si la le setter existe
            if (method_exists($this, $methode)) {
                // On apelle le seter corespondant et en le hydrate
                $this->$methode($valeu);
            }
        }
        $this->setNumeroBillet($numeroBillet);
        $this->setPrixTotal($total);
        $this->setPaiement($paiement);
    }

}

