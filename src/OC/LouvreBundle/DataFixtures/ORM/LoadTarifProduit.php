<?php

namespace OC\LouvreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\LouvreBundle\Entity\TarifProduit;

/**
 * Class TarifProduit
 *
 * @package \OC\LouvreBundle\DataFixtures\ORM
 */
class LoadTarifProduit implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tarifsProduit = array(
            '1' => array(
                '1' => 16.00,
                '2' => 8.00,
                '3' => 12.00,
                '4' => 10
            ),
            '2' => array(
                '1' => 10.00,
                '2' => 5.00,
                '3' => 8.00,
                '4' => 6
            )
        );

        foreach ($tarifsProduit as $index => $values) {
            // On crée la list des traifs produits
            foreach ($values as $key => $value) {
                $tarifProduit = new TarifProduit();
                $tarifProduit->setProduit($index);
                $tarifProduit->setTarif($key);
                $tarifProduit->setPrixUnitaire($value);

                // On persiste
                $manager->persist($tarifProduit);
            }
        }

        // On enregistre tous les prix
        $manager->flush();
    }
}
