<?php

namespace AppBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class EmployerRepository extends EntityRepository
{

    /**
     * @return QueryBuilder
     */
    public function findAllEmployer()
    {
        $conn = $this->getEntityManager()->getConnection();

        $queryBuilder = new QueryBuilder($conn);
        $queryBuilder->select('employer_id', 'email', 'name', 'mobile', 'fax', 'employer_type_id')
            ->from('tbl_employers', 'e')
            ->addOrderBy('employer_id','DESC');
            ->

        return $queryBuilder;
    }

    public function countAllEmployer(QueryBuilder $queryBuilder)
    {
        return function ($queryBuilder) {
            $queryBuilder->select('COUNT(DISTINCT e.employer_id) AS total_results')
                ->setMaxResults(1);
        };
    }

}