<?php
/**
 * Created by PhpStorm.
 * User: christian.elinisa
 * Date: 12/14/2017
 * Time: 2:59 PM
 */

namespace AppBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class EmpRepository
{
    /**
     * @return QueryBuilder
     */
    public function findAllEmployer()
    {
        $conn = $this->getEntityManager()->getConnection();

        $queryBuilder = new QueryBuilder($conn);
        $queryBuilder->select('employer_id', 'e.email', 'e.name', 'e.mobile', 'e.fax', 'et.description')
            ->from('tbl_employers', 'e')
            ->innerJoin('e', 'cfg_employer_types', 'et', 'et.id = e.employer_type_id')
            ->addOrderBy('employer_id','DESC');

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