<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BenefitRepository")
 * @ORM\Table(name="cfg_benefits")
 * @Vich\Uploadable
 */
class Benefit
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $benefitId;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @return mixed
     */
    public function getBenefitId()
    {
        return $this->benefitId;
    }

    /**
     * @param mixed $benefitId
     */
    public function setBenefitId($benefitId)
    {
        $this->benefitId = $benefitId;
    }


    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

}