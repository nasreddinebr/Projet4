<?php

namespace OC\LouvreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\LouvreBundle\Entity\TarifProduit;

/**
 * Class TarifsProduits
 *
 * @package \OC\LouvreBundle\DataFixtures\ORM
 */
class LoadTarifsProduits implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // liste des tarifs des prduit
        $tarifsProduit = array(
            '1' => array(
                '1' => 16.00,
                '2' => 8.00,
                '3' => 12.00,
                '4' => 10.00
            ),
            '2' => array(
                '1' => 10.00,
                '2' => 5.00,
                '3' => 8.00,
                '4' => 6.00
            )
        );

        foreach ($tarifsProduit as $index => $values) {

            foreach ($values as $key => $value) {
                // On crée la list des traifs produits
                $listTarifProduit = new TarifProduit();
                $listTarifProduit->setProduitId($index);
                $listTarifProduit->setTarifId($key);
                $listTarifProduit->setPrixUnitaire($value);
                //var_dump($listTarifProduit);
                // On la persiste
                $manager->persist($listTarifProduit);
            }
        }

        // On déclenche l'enregistrement de toutes les produits
        $manager->flush();
    }

}
