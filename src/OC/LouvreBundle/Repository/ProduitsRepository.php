<?php

namespace OC\LouvreBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ProduitsRepository extends EntityRepository
{
    public function getLikeQueryBuilder($pattern)
    {
        return $this
            ->createQueryBuilder('c')
            ->where('c.produit LIKE :pattern')
            ->setParameter('pattern', $pattern)
            ;
    }
}
