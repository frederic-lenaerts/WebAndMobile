<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StatusRepository extends EntityRepository
{
    public function findByLocation( $location )
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT * FROM AppBundle:Status s WHERE s.location_id = '.$location
            )
            ->getResult();
    }
}