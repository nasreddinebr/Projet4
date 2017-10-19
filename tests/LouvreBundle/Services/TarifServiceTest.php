<?php

namespace Tests\LouvreBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class TarifServiceTest extends WebTestCase
{
    /**
     * Test si le service TarifService fonctionne coréctement et renvoi
     * le bon localisateur des tarifs
     */
    public function testTarif() {
        // Si
        $dateNaissance = array('17', '08', '1980');
        $dateVisite = '28-11-2017';

        // Quand
        // On crée le kernel puis On recupére le container pour
        // appeler le service TarifService
        $kernel = static::createKernel();
        $kernel->boot();
        $container = $kernel->getContainer();
        $tarifService = $container->get('oc_louvre.tarifs');
        $localisateurTarif = $tarifService->isTarif($dateNaissance, $dateVisite);

        // Alor
        $this->assertEquals($localisateurTarif, 13);

    }

}
