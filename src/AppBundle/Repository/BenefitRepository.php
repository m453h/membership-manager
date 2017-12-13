<?php

namespace AppBundle\Repository\Event;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{
    
    /**
     * @param array $options
     * @return QueryBuilder
     */
    public function findAllEvents($options=[])
    {
        $conn = $this->getEntityManager()->getConnection();

        $queryBuilder = new QueryBuilder($conn);
        $queryBuilder->select('
        e.event_id AS "eventId",
        title,description,
        start_date AS "startDate",
        end_date AS "endDate",
        DATE_FORMAT(start_date,"%e") AS "dayLabel",
        DATE_FORMAT(start_date,"%b") AS "monthLabel",
        location'
        )
            ->from('tbl_events', 'e');

        $queryBuilder = $this->setFilterOptions($options,$queryBuilder);
        $queryBuilder = $this->setSortOptions($options,$queryBuilder);

        return $queryBuilder;
    }

    public function setFilterOptions($options, QueryBuilder $queryBuilder)
    {
        if(!empty($options['title']))
        {
           return $queryBuilder->where('title LIKE :title')
                ->setParameter('title','%'.$options['description'].'%');
        }

        if(isset($options['token']))
        {
            $queryBuilder->addSelect(
                '('.$this->statusSelector().') AS "status"')
                ->setParameter('token',$options['token']);
        }
        
        return $queryBuilder;
    }

    public function statusSelector()
    {
        $conn = $this->getEntityManager()->getConnection();

        $queryBuilder = new QueryBuilder($conn);
        $queryBuilder->select('  
                CASE status 
                    WHEN "Y" THEN "Yes"
                    WHEN "N" THEN "No"
                    ELSE "Maybe"
                END AS "status"'
        )
            ->from('tbl_event_confirmation', 'c')
            ->join('c','app_users','u','u.user_id=c.user_id')
            ->where('u.token=:token AND c.event_id=e.event_id');


        return $queryBuilder->getSQL();
    }

    public function setSortOptions($options, QueryBuilder $queryBuilder)
    {

        if(isset($options['sortType']))
        {
            $options['sortType'] == 'desc' ? $sortType='desc': $sortType='asc';

            switch($options['sortBy'])
            {
                case 'title': $orderBy = 'title';break;
                case 'startDate': $orderBy = 'start_date';break;
                case 'endDate': $orderBy = 'end_date';break;
                default: $orderBy = 'event_id';
            }

            return $queryBuilder->addOrderBy($orderBy, $sortType);
        }

        return $queryBuilder->addOrderBy('e.event_id','desc');
    }

    public function countAllEvents(QueryBuilder $queryBuilder)
    {
       return function ($queryBuilder) {
               $queryBuilder->select('COUNT(DISTINCT e.event_id) AS total_results')
               ->setMaxResults(1);
           };
    }
    
}
