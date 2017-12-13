<?php


namespace AppBundle\Security;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ACLSecurityProvider
{

    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var TokenStorageInterface
     */
    private $storageInterface;
   

    /**
     * ACLSecurityProvider constructor.
     * @param EntityManager $em
     * @param TokenStorageInterface $storageInterface
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManager $em, TokenStorageInterface $storageInterface, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->storageInterface = $storageInterface;
    }


    public function getCurrentACLs($subject)
    {
        $user = $this->storageInterface->getToken()->getUser();
        
        $userRoles = $user->getRoleIds();
       
        if(!empty($userRoles))
        {

            return $this->em->getRepository('AppBundle:UserAccounts\Permission')
                ->getCurrentUserACLs($subject, $userRoles);
        }
        else
        {
            return [];
        }

    }

    public function hasPermission($action,$ACLs)
    {
        if(is_array($ACLs)) {

            if (in_array($action, $ACLs))
                return true;
        }

        throw new AccessDeniedException('You have no permission to perform this action');
    }

}