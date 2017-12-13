<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity
 * @ORM\Table(name="tbl_employers")
 * @Vich\Uploadable
 */
class Employer
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $employerId;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;


    /**
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    private $mobile;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $fax;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;

    /**
     * @return mixed
     */
    public function getEmployerId()
    {
        return $this->employerId;
    }

    /**
     * @param mixed $employerId
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

}