<?php

namespace OC\LouvreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\LouvreBundle\Entity\JoursFermeture;


class LoadJoursFermeture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // liste des jours de fermeture
        $jours_fremeture = array(
            '01/05',
            '01/11',
            '25/12'
        );

        foreach ($jours_fremeture as $jour) {
            // On crée la catégorie
            $jourFermeture = new JoursFermeture();
            $jourFermeture->setJoursFermeture($jour);

            // On la persiste
            $manager->persist($jourFermeture);
        }

        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }

}
