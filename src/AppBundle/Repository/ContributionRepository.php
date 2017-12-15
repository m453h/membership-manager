<?php

namespace AppBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;


class ContributionRepository extends EntityRepository
{
    public function AllContribution($MemberEmpID){
        $conn = $this->getEntityManager()->getConnection();
        $queryBuilder = new QueryBuilder($conn);
        $queryBuilder->select('employee_contribution','employer_contribution','total_contribution','contribution_date')
                     ->from('tbl_contributions','tc')->orderBy('contribution_date','ASC');
        return $queryBuilder;
    }

    public function CountMemberContr(QueryBuilder $queryBuilder){

        return function ($queryBuilder){
            $queryBuilder->select('COUNT(DISTINCT tc.contribution_id) AS total_results')
                ->setMaxResults(1);
        };

    }
}