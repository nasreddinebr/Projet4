<?php

namespace OC\LouvreBundle\Services;
use Doctrine\ORM\EntityManager;

/**
 * Class GenereNumeroBillet
 *
 * @package \OC\LouvreBundle\Services
 */
class GenerateurNumeroBillet
{
    /**
     * @var EntityManager
     */
    protected $doctrine;

    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function genereNumBillet() {
        $dernierBillet = $this
            ->doctrine
            ->getRepository('OCLouvreBundle:Billets')
            ->recupDernierBilletAjouter();

        // Si le resultat renvoyé n'est pas vide en recupére les quatre chifre du numero de billet
        // Sinon $code vaut 1000
        if (!empty($derinerBillet)) {
            $code = (int) substr($dernierBillet->getNumeroBillet(), -4);
            $code++;
        }else {
            $code = 1000;
        }
        $dateA = date("YdM");
        $numerobillet = $dateA . '-' . $code;
        return $numerobillet;
    }
}
