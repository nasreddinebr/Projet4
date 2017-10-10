<?php

namespace OC\LouvreBundle\Services;
/**
 * Class Tarif
 *
 * @package \\${NAMESPACE}
 */
class TarifService
{

    const NORMALE = 13;
    const ENFANT = 12;
    const SENIOR = 60;

    /**
     * @param $datesNaissances
     * @param $dateVisite
     * @return array
     */
    public function isTarif($dateNaissance, $dateVisite) {

        // Calcule d'age du visiteur le jour de la visite
        $dateVisite = explode('-', $dateVisite);
        $age = (($dateNaissance[1] < $dateVisite[1]) ||
            ($dateNaissance[1] == $dateVisite['1'] && $dateNaissance[0] <= $dateVisite[0])) ?
            $dateVisite[2] - $dateNaissance[2] : $dateVisite[2] - $dateNaissance[2]-1;

        // Recuperation de localisateur du tarif
        if ($age >= 4 && $age <= 12) {
            $localisateurTarif[] = self::ENFANT;
        }elseif ($age > 12 && $age < 60) {
            $localisateurTarif[] = self::NORMALE;
        }elseif ($age >= 60) {
            $localisateurTarif[] = self::SENIOR;
        }
        return $localisateurTarif;
    }
}
