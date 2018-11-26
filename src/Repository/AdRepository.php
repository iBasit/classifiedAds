<?php


namespace App\Repository;


use App\Entity\Ad;
use Doctrine\ORM\EntityRepository;

class AdRepository extends EntityRepository
{
    /**
     * get all the rows and order by latest ones first
     * @return Ad[]
     */
    public function getAll ()
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT a
                FROM App:Ad a
                ORDER BY a.created DESC
                ')
            ->getResult();
    }
}
