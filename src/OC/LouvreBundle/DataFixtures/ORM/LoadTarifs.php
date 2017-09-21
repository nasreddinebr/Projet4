<?php

namespace OC\LouvreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\LouvreBundle\Entity\Tarifs;

/**
 * Class LoadTarifs
 *
 * @package \\${NAMESPACE}
 */
class LoadTarifs implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // liste des tarifs
        $tarifs = array(
            'normal',
            'enfant',
            'senior',
            'reduit'
        );

        foreach ($tarifs as $tarif) {
            // On crée le produit
            $tarifBillet = new Tarifs();
            $tarifBillet->setNomTarif($tarif);

            // On la persiste
            $manager->persist($tarifBillet);
        }

        // On déclenche l'enregistrement de toutes les produits
        $manager->flush();
    }
}
