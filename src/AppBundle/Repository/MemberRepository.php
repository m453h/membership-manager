<?php

namespace AppBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class MemberRepository extends EntityRepository
{
    
    /**
     * @return QueryBuilder
     */
    public function findAllMembers()
    {
        $conn = $this->getEntityManager()->getConnection();

        $queryBuilder = new QueryBuilder($conn);
        $queryBuilder->select('member_id', 'first_name', 'second_name', 'surname', 'sex', 'date_of_birth')
            ->from('tbl_members', 'm')
            ->addOrderBy('member_id','DESC');

        return $queryBuilder;
    }

    public function countAllMember(QueryBuilder $queryBuilder)
    {
       return function ($queryBuilder) {
               $queryBuilder->select('COUNT(DISTINCT m.member_id) AS total_results')
               ->setMaxResults(1);
           };
    }
    
}
