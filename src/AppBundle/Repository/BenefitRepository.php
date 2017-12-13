<?php

namespace AppBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class BenefitRepository extends EntityRepository
{
    
    /**
     * @return QueryBuilder
     */
    public function findAllBenefits()
    {
        $conn = $this->getEntityManager()->getConnection();

        $queryBuilder = new QueryBuilder($conn);
        $queryBuilder->select('benefit_id', 'description')
            ->from('cfg_benefits', 'e')
            ->addOrderBy('benefit_id','DESC');

        return $queryBuilder;
    }

    public function countAllBenefits(QueryBuilder $queryBuilder)
    {
       return function ($queryBuilder) {
               $queryBuilder->select('COUNT(DISTINCT e.benefit_id) AS total_results')
               ->setMaxResults(1);
           };
    }
    
}
