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
 * @ORM\Table(name="tbl_member_benefit")
 * @Vich\Uploadable
 */
class MemberBenefit
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $memberBenefitId;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Member")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="member_id",nullable=false)
     */
    private $member;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Benefit")
     * @ORM\JoinColumn(name="benefit_id", referencedColumnName="benefit_id",nullable=false)
     */
    private $benefit;


    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;



    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;



    /**
     * @return mixed
     */
    public function getMemberBenefitId()
    {
        return $this->memberBenefitId;
    }

    /**
     * @param mixed $memberBenefitId
     */
    public function setMemberBenefitId($memberBenefitId)
    {
        $this->memberBenefitId = $memberBenefitId;
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
    public function getBenefit()
    {
        return $this->benefit;
    }

    /**
     * @param mixed $benefit
     */
    public function setBenefit($benefit)
    {
        $this->benefit = $benefit;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


}