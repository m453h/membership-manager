<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_contributions")
 * @Vich\Uploadable
 */
class Contribution
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $contributionId;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Member")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="member_id",nullable=false)
     */
    private $member;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employer")
     * @ORM\JoinColumn(name="employer_id", referencedColumnName="employer_id",nullable=false)
     */
    private $employer;


    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $employeeContribution;


    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $employerContribution;


    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalContribution;

    /**
     * @return mixed
     */
    public function getContributionId()
    {
        return $this->contributionId;
    }

    /**
     * @param mixed $contributionId
     */
    public function setContributionId($contributionId)
    {
        $this->contributionId = $contributionId;
    }

    /**
     * @return mixed
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param mixed $member
     */
    public function setMember($member)
    {
        $this->member = $member;
    }

    /**
     * @return mixed
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @param mixed $employer
     */
    public function setEmployer($employer)
    {
        $this->employer = $employer;
    }

    /**
     * @return mixed
     */
    public function getEmployeeContribution()
    {
        return $this->employeeContribution;
    }

    /**
     * @param mixed $employeeContribution
     */
    public function setEmployeeContribution($employeeContribution)
    {
        $this->employeeContribution = $employeeContribution;
    }

    /**
     * @return mixed
     */
    public function getEmployerContribution()
    {
        return $this->employerContribution;
    }

    /**
     * @param mixed $employerContribution
     */
    public function setEmployerContribution($employerContribution)
    {
        $this->employerContribution = $employerContribution;
    }

    /**
     * @return mixed
     */
    public function getTotalContribution()
    {
        return $this->totalContribution;
    }

    /**
     * @param mixed $totalContribution
     */
    public function setTotalContribution($totalContribution)
    {
        $this->totalContribution = $totalContribution;
    }

}