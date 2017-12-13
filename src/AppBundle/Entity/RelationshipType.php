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
 * @ORM\Table(name="cfg_relationship_type")
 * @Vich\Uploadable
 */
class RelationshipType
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $relationshipTypeId;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @return mixed
     */
    public function getRelationshipTypeId()
    {
        return $this->relationshipTypeId;
    }

    /**
     * @param mixed $relationshipTypeId
     */
    public function setRelationshipTypeId($relationshipTypeId)
    {
        $this->relationshipTypeId = $relationshipTypeId;
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