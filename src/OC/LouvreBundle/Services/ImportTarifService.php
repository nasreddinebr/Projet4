<?php

namespace OC\LouvreBundle\Services;



/**
 * Class ImportTarif
 *
 * @package \\${NAMESPACE}
 */
class ImportTarifService
{
    protected $localisatorTarif;
    protected $getDoctrine;

    public function __construct(TarifService $tarif, $getDoctrine)
    {
        $this->localisatorTarif = $tarif;
        $this->getDoctrine = $getDoctrine;
    }

    /**
     * @param $datesNaissances
     * @param $dateReservation
     * @return array
     */
    public function getIdTarif($datesNaissances, $dateReservation) {

        // On recupere les localistaeurs des tarif depuis le service
        // TarifService
        $localisatorTarifs = $this->localisatorTarif->isTarif($datesNaissances, $dateReservation);

        // Recuperation des idTarifs depuis la DB
        $idTarif = $this
            ->getDoctrine
            ->getRepository('OCLouvreBundle:Tarifs')
            ->findTarifByLocalisator($localisatorTarifs);

        return $idTarif;
    }

}
