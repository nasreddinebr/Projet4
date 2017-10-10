<?php

namespace OC\LouvreBundle\Services;

/**
 * Class DateNaissance
 *
 * @package \OC\LouvreBundle\Services
 */
class DateNaissanceService
{
    /**
     * @param $clients
     * @return array
     */
    public function datesNaissances($client){
        //foreach ($clients as $client){
            $datesNaissance = explode('-',$client
                ->getDateNaissance()
                ->format('d-m-Y')
            );

       // }
        return $datesNaissance;
    }
}
