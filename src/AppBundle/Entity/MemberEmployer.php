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
 * @ORM\Table(name="tbl_member_employer")
 * @Vich\Uploadable
 */
class MemberEmployer
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $memberEmployerId;


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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isCurrent;

    /**
     * @return mixed
     */
    public function getMemberEmployerId()
    {
        return $this->memberEmployerId;
    }

    /**
     * @param mixed $memberEmployerId
     */
    public function setMemberEmployerId($memberEmployerId)
    {
        $this->memberEmployerId = $memberEmployerId;
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
    public function getisCurrent()
    {
        return $this->isCurrent;
    }

    /**
     * @param mixed $isCurrent
     */
    public function setIsCurrent($isCurrent)
    {
        $this->isCurrent = $isCurrent;
    }

}