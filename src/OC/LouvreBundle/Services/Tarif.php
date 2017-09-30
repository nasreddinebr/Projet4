<?php

namespace OC\LouvreBundle\Services;
/**
 * Class Tarif
 *
 * @package \\${NAMESPACE}
 */
class Tarif
{
    private $servicedatesNaissances;


    const NORMALE = 13;
    const ENFANT = 12;
    const SENIOR = 60;

    public function __construct(DateNaissance $dateNaissance)
    {
        $this->servicedatesNaissances = $dateNaissance;
    }

    public function isTarif($clients, $dateVisite) {
        // Rassemblement des date de naissance
        $datesNaissances = $this->servicedatesNaissances->datesNaissances($clients);

        // Calcule d'age du visiteur le jour de la visite
        $dateVisite = explode('-', $dateVisite);
        foreach ($datesNaissances as $dateNaissance) {
            // Calcule d'age du visiteur
            $age = (($dateNaissance['month'] < $dateVisite[1]) ||
                ($dateNaissance['month'] == $dateVisite['1'] && $dateNaissance['day'] <= $dateVisite['0'])) ?
                $dateVisite[2] - $dateNaissance['year'] : $dateVisite[2] - $dateNaissance['year']-1;

            // Recuperation du tarif
            if ($age >= 4 && $age <= 12) {
                $localisateurTarif[] = self::ENFANT;
            }elseif ($age > 12 && $age < 60) {
                $localisateurTarif[] = self::NORMALE;
            }elseif ($age <= 60) {
                $localisateurTarif[] = self::SENIOR;
            }
        }
        return $localisateurTarif;
    }
}
