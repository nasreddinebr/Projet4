<?php

namespace OC\LouvreBundle\Services;

/**
 * Class DateNaissance
 *
 * @package \OC\LouvreBundle\Services
 */
class DateNaissance
{
    public function datesNaissances($clients){
        foreach ($clients as $client){
            if (array_key_exists("dateNaissance", $client)) {
                $dateNaissance[] = $client['dateNaissance'];
            }
        }
        return $dateNaissance;
    }

}
