<?php

namespace OC\LouvreBundle\Repository;

/**
 * ClientsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientsRepository extends \Doctrine\ORM\EntityRepository
{
    public function countVisitorsOfDate($dateReservation) {
        $query = $this->_em->createQuery('SELECT COUNT (cl) FROM OCLouvreBundle:Clients cl WHERE cl.dateReservation=:dateRes');
        $query->setParameter('dateRes', $dateReservation);
        return $query->getSingleResult();
    }

}
