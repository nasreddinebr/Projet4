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
    const JOUR = 0;
    const MOI = 1;
    const ANNEE = 2;

    /**
     * @param $datesNaissances
     * @param $dateVisite
     * @return array
     */
    public function isTarif($dateNaissance, $dateVisite) {

        // Calcule d'age du visiteur le jour de la visite
        $dateVisite = explode('-', $dateVisite);
        $age = (($dateNaissance[self::MOI] < $dateVisite[self::MOI]) ||
            ($dateNaissance[self::MOI] == $dateVisite[self::MOI] && $dateNaissance[self::JOUR] <= $dateVisite[self::JOUR])) ?
            $dateVisite[self::ANNEE] - $dateNaissance[self::ANNEE] : $dateVisite[self::ANNEE] - $dateNaissance[self::ANNEE]-1;

        // Recuperation de localisateur du tarif
        if ($age >= 4 && $age <= 12) {
            $localisateurTarif = self::ENFANT;
        }elseif ($age > 12 && $age < 60) {
            $localisateurTarif = self::NORMALE;
        }elseif ($age >= 60) {
            $localisateurTarif = self::SENIOR;
        }
        return $localisateurTarif;
    }
}
