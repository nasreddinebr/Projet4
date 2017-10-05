<?php

namespace OC\LouvreBundle\Repository;

/**
 * BilletsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BilletsRepository extends \Doctrine\ORM\EntityRepository
{
    public function recupDernierBilletAjouter() {
        // Verification sil existe des Billets
        $query = $this->_em->createQuery('SELECT 1 FROM OCLouvreBundle:Billets');
        $dernierBillets = $query->execute();

        // Si il existe des billets en recupére le dernier et en le renvoi
        if (!empty($dernierBillets)){
            $query = $this->_em->createQuery('SELECT b FROM OCLouvreBundle:Billets b ORDER BY b.id DESC ');
            $dernierBillets = $query->setMaxResults(1)->getOneOrNullResult();
        }
        return $dernierBillets;

    }
}
