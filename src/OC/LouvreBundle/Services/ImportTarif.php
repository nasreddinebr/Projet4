<?php

namespace OC\LouvreBundle\Services;



/**
 * Class ImportTarif
 *
 * @package \\${NAMESPACE}
 */
class ImportTarif
{
    protected $tarif;
    protected $getDoctrine;

    public function __construct(Tarif $tarif, $getDoctrine)
    {
        $this->tarif = $tarif;
        $this->getDoctrine = $getDoctrine;
    }

    public function creeIdTarif($datesNaissances, $dateReservation) {

        // On recupere les localistaeurs des tarif
        $tarifs = $this->tarif->isTarif($datesNaissances, $dateReservation);

        // Recuperation de idTarifs
        foreach ($tarifs as $key => $value) {
            $listTarifs = $this
                ->getDoctrine
                ->getRepository('OCLouvreBundle:Tarifs')
                ->findListTarifs($value);

            // Recuperation des id des tarifs
            foreach ($listTarifs as $key => $value) {
                $idTarifs[] = $value->getId();
            }
        }
        return $idTarifs;
    }

}
