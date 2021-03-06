<?php

namespace BrowserCreative\CrudBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CrudItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CrudItemRepository extends EntityRepository
{
    public function getLatestActiveItems()
    {
        return $this->getLatestItems(true);
    }

    public function getLatestItems($activeRequired = false)
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->add('orderBy', 'c.date_created DESC');

        if ($activeRequired) {
            $queryBuilder->add('where', 'c.active = :active')->setParameter('active', true);
        }

        return $queryBuilder;
    }
}