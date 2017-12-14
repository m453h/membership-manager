<?php

namespace AppBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class EmployerTypeRepository extends EntityRepository
{

    /**
     * @return QueryBuilder
     */
    public function findAllEmployerType()
    {
        $conn = $this->getEntityManager()->getConnection();

        $queryBuilder = new QueryBuilder($conn);
        $queryBuilder->select('employer_type_id', 'description')
            ->from('cfg_employer_types', 'et')
            ->addOrderBy('employer_type_id','DESC');

        return $queryBuilder;
    }

    public function countAllEmployerType(QueryBuilder $queryBuilder)
    {
        return function ($queryBuilder) {
            $queryBuilder->select('COUNT(DISTINCT et.employer_type_id) AS total_results')
                ->setMaxResults(1);
        };
    }

}