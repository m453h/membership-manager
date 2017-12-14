<?php

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;

class MemberBenefitsCalculator
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculateTypeOneBenefits($salary,$numberOfYears)
    {

        return $salary*0.5*$numberOfYears;
    }



}