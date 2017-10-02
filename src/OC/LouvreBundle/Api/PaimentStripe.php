<?php

namespace OC\LouvreBundle\Api;

use OC\LouvreBundle\Entity\Paiements;

/**
 * Class Paiment
 *
 * @package \OC\LouvreBundle\Api
 */
class PaimentStripe
{
    private $token;
    private $email;
    private $name;
    private $total;

    public function __construct($token, $email, $name, $total)
    {
        $this->token = $token;
        $this->email = $email;
        $this->name  = $name;
        $this->total = $total;
    }

    /**
     * Création du nouveaux client
     */
    public function creeClient(Stripe $stripe) {
        // Ici on va crée un customer (client) on utilisent la bibliothech curl de php
        $customer = $stripe->api('customers', [
                        'source' 		=> $this->token,
                        'description' 	=> $this->name,
                        'email'			=> $this->email
                    ]);
        return $customer;
    }

    /**
     * On effectu le paiement
     */
    public function paiementStripe(Stripe $stripe, $customer) {
        $charge = $stripe->api('charges', array(
                        "amount" => $this->total * 100,
                        "currency" => "eur",
                        "customer" => $customer->id,
                    ));
        return $charge;
    }

    /**
     * Construction de l'objet paiment
     */
    public function creePaiement(){
        $stripe = new Stripe('sk_test_mMtQzCgpyghkqStGTvCbJeNj');
        $customer = $this->creeClient($stripe);
        $charge = $this->paiementStripe($stripe, $customer);

        $paiement = new Paiements();
        $paiement->setEmail($this->email);
        $paiement->setStripeClientId($charge->customer);
        $paiement->setStripeChargeId($charge->id);
        $paiement->setTitulaireCarte($this->name);
        $paiement->setSommePayee((float) $charge->amount / 100);

        return $paiement;
    }

}
