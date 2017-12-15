<?php

namespace AppBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class BeneficiaryRepository extends EntityRepository
{
    
    /**
     * @return QueryBuilder
     */
    public function findAllBeneficiary()
    {
        $conn = $this->getEntityManager()->getConnection();

        $queryBuilder = new QueryBuilder($conn);
        $queryBuilder->select('beneficiary_id', 'first_name', 'second_name', 'surname', 'sex', 'date_of_birth')
            ->from('tbl_beneficiaries', 'm')
            ->addOrderBy('beneficiary_id','DESC');

        return $queryBuilder;
    }

    public function countAllBeneficiary(QueryBuilder $queryBuilder)
    {
       return function ($queryBuilder) {
               $queryBuilder->select('COUNT(DISTINCT m.beneficiary_id) AS total_results')
               ->setMaxResults(1);
           };
    }
    
}
