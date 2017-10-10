<?php

namespace OC\LouvreBundle\Repository;

/**
 * PaiementsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaiementsRepository extends \Doctrine\ORM\EntityRepository
{
    public function findEmail($id) {
        $query = $this->_em->createQuery('SELECT p.email FROM OCLouvreBundle:Paiements p WHERE p.id =:id');
        $query->setParameter('id', $id);
        return $query->getOneOrNullResult();
    }
}
