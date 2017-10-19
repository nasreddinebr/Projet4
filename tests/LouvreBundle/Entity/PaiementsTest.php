<?php
namespace Tests\LouvreBundle\Entity;


use OC\LouvreBundle\Entity\Paiements;
use PHPUnit\Framework\TestCase;


class PaiementsTest extends TestCase
{
    /**
     * Test que l'enssemble des attributs de l'entité Paiements
     * son coréctement valoriser
     */
    public function testHydrate() {
        // Si
        $donnee = array(
            'titulaireCarte' => 'Toto',
            'email' => 'toto@gmail.com',
            'stripeClientId' => 'Cli_4545FGHFGHFG',
            'stripeChargeId' => 'Char_hjkkkill455',
            'sommePayee' => 20.00
        );



        // Quand
        $paiment = new Paiements();
        $paiment->hydrate($donnee);

        // Alors
        $this->assertEquals($paiment->getTitulaireCarte(), 'Toto');
        $this->assertEquals($paiment->getEmail(), 'toto@gmail.com');
        $this->assertEquals($paiment->getStripeClientId(), 'Cli_4545FGHFGHFG');
        $this->assertEquals($paiment->getStripeChargeId(), 'Char_hjkkkill455');
        $this->assertEquals($paiment->getSommePayee(), 20.00);


    }

}
