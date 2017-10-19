<?php

namespace Tests\LouvreBundle\Entity;


use OC\LouvreBundle\Entity\Billets;
use OC\LouvreBundle\Entity\Paiements;
use OC\LouvreBundle\Entity\Produits;
use PHPUnit\Framework\TestCase;


class BilletsTest extends TestCase
{
    public function testHydrate() {
        // Si
        $id = 1;

        // Dummy (Paiments, Produits)
        $paiement = $this->getMock('OC\LouvreBundle\Entity\Paiements');
        $produit = $this->getMock('OC\LouvreBundle\Entity\Produits');

        // Parametre à passer à la methode hydrate
        $donnee = array(
            array('dateReservation' => '28-11-2017'),
            array('produit' => $produit)
        );

        // Mock (doublure)
        $billet = $this->getMockBuilder('OC\LouvreBundle\Entity\Billets')
            ->disableOriginalConstructor()
            ->setMethods(['getProduit', 'getPaiement', 'getDateReservation'])
            ->getMock();
        $billet
            ->method('getProduit')
            ->willReturn($id);
        $billet
            ->method('getPaiement')
            ->willReturn($id);
        $billet
            ->method('getDateReservation')
            ->willReturn('28-11-2017');

        // Quand
        $billet->hydrate($donnee, $paiement, '201711OCT-1000', 20.00);

        // Alor
        $this->assertEquals($billet->getDateReservation(), '28-11-2017');
        $this->assertEquals($billet->getNumeroBillet(), '201711OCT-1000');
        $this->assertEquals($billet->getPrixTotal(), 20.00);
        $this->assertEquals($billet->getProduit(), 1);
        $this->assertEquals($billet->getPaiement(), 1);
    }

}
