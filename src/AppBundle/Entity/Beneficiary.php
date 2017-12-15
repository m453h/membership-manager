<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BeneficiaryRepository")
 * @ORM\Table(name="tbl_beneficiaries")
 * @Vich\Uploadable
 */
class Beneficiary
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $beneficiaryId;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $firstName;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $surname;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $secondName;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $sex;


    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfBirth;



    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RelationshipType")
     * @ORM\JoinColumn(name="relationship_type_id", referencedColumnName="relationship_type_id",nullable=false)
     */
    private $relationshipType;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Member")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="member_id",nullable=false)
     */
    private $member;



    /**
     * @return mixed
     */
    public function getBeneficiaryId()
    {
        return $this->beneficiaryId;
    }

    /**
     * @param mixed $beneficiaryId
     */
    public function setBeneficiaryId($beneficiaryId)
    {
        $this->beneficiaryId = $beneficiaryId;
    }


    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * @param mixed $secondName
     */
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param mixed $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @param mixed $relationshipType
     */
    public function setRelationshipType($relationshipType)
    {
        $this->relationshipType = $relationshipType;
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

}