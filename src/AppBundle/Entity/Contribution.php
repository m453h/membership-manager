<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContributionRepository")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MemberEmployer")
     * @ORM\JoinColumn(name="member_employer_id", referencedColumnName="member_employer_id",nullable=false)
     */
    private $memberEmployer;


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
     * @ORM\Column(type="date")
     */
    private $contributionDate;

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
    public function getMemberEmployer()
    {
        return $this->memberEmployer;
    }

    /**
     * @param mixed $member
     */
    public function setMemberEmployer($memberEmployer)
    {
        $this->memberEmployer = $memberEmployer;
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