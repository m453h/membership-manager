<?php

namespace AppBundle\Service;


class MemberBenefitsCalculator
{


    public function calculateTypeOneBenefits($salary,$numberOfYears)
    {

        return $salary*0.5*$numberOfYears;

    }



}