<?php

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity
 * @ORM\Table(name="user_accounts")
 *@ORM\Entity
 */
class User implements  UserInterface,EquatableInterface,\Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=25,unique=true)
     */
    private $username;


    /**
     * @ORM\Column(type="string")
     */
    private $fullName;

    /**
     * @ORM\Column(type="string")
     */
    private $role;


    /**
     * @ORM\Column(type="string", length=1, options={"fixed" = true})
     */
    private $accountStatus;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $mobilePhone;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $loginTries;

    /**
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastActivity;



    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRoles()
    {
        return [$this->role];
    }


    public function getPassword()
    {
        return $this->password;
    }


    public function getSalt()
    {

    }

    public function eraseCredentials()
    {
       // $this->password = null;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function getAccountStatus()
    {
        return $this->accountStatus;
    }
    
    public function setAccountStatus($accountStatus)
    {
        $this->accountStatus = $accountStatus;
    }

    public function getLoginTries()
    {
        return $this->loginTries;
    }
    
    public function setLoginTries($loginTries)
    {
        $this->loginTries = $loginTries;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        if (!($this->getLastActivity() == $user->getLastActivity())) {
            return false;
        }

        return true;
    }


    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->lastActivity
        ));
    }


    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->lastActivity
            ) = unserialize($serialized);
    }

    /**
     * @return mixed
     */
    public function getLastActivity()
    {
        return $this->lastActivity;
    }

    /**
     * @param mixed $lastActivity
     */
    public function setLastActivity($lastActivity)
    {
        $this->lastActivity = $lastActivity;
    }


    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param mixed $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }


}