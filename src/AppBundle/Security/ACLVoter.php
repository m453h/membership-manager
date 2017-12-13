<?php


namespace AppBundle\Security;



use AppBundle\Entity\UserAccounts\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ACLVoter extends Voter
{

    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const ADD = 'add';
    const EDIT = 'edit';
    const DELETE = 'delete';
    const BLOCK = 'block';
    const UNBLOCK = 'unblock';
    const RESET = 'reset';
    const BULK_UPLOAD = 'bulk-upload';
    const UPLOAD = 'upload';
    const COMPLETE_REGISTRATION = 'complete-register';
    const REGISTER_MODULES = 'register-modules';
    const APPROVE = 'approve';
    const DECLINE = 'decline';



    /**
     * @var ACLSecurityProvider
     */
    private $acl;


    /**
     * ACLVoter constructor.
     * @param ACLSecurityProvider $acl
     */
    public function __construct(ACLSecurityProvider $acl)
    {
        $this->acl = $acl;
    }


    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::DELETE, self::BLOCK, self::UNBLOCK, self::RESET,self::ADD,self::COMPLETE_REGISTRATION,self::REGISTER_MODULES,self::APPROVE,self::DECLINE,self::BULK_UPLOAD,self::UPLOAD))) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        $permissions = $this->acl->getCurrentACLs($subject);

        if(is_array($permissions)) {

            if (in_array($attribute, $permissions)) {
                return true;
            }
        }

        return false;

    }


}