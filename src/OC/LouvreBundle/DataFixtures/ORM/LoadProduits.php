<?php

namespace OC\LouvreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\LouvreBundle\Entity\Produits;


class LoadProduits implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // liste des prodiuts
        $produits = array(
            'Journee',
            'Demi-journee'
        );

        foreach ($produits as $produit) {
            // On crée le produit
            $produitBillet = new Produits();
            $produitBillet->setNomProduit($produit);

            // On la persiste
            $manager->persist($produitBillet);
        }

        // On déclenche l'enregistrement de toutes les produits
        $manager->flush();
    }
}
