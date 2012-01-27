<?php

namespace Hub\NewsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CrudItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CrudItemRepository extends EntityRepository
{
    public function getLatestActiveNewsItemsQueryBuilder()
    {
        $queryBuilder = $this->createQueryBuilder('n')
            ->add('orderBy', 'n.date_created DESC');

        return $queryBuilder;
    }
}