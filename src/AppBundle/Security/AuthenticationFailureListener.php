<?php

namespace AppBundle\Security;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class AuthenticationFailureListener implements EventSubscriberInterface
{


    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {

        $this->entityManager = $entityManager;
    }


    public static function getSubscribedEvents()
    {
        return array(
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccess',
        );
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {

        if($event->getAuthenticationException() instanceof BadCredentialsException)
        {
            $token = $event->getAuthenticationToken();

            $value = $token->getCredentials();

            $username = $value['_username'];

            $user = $this->entityManager->getRepository('AppBundle:User')->findOneBy(['username'=>$username]);

            $loginTries = $user->getLoginTries()+1;
   
            if($loginTries>3)
            {
                $user->setAccountStatus('B');
            }
            else
            {
                $user->setLoginTries($loginTries);
                try
                {
                    $this->entityManager->flush();
                }
                catch (OptimisticLockException $e)
                {

                }
            }

            try
            {
                $this->entityManager->flush();
            }
            catch (OptimisticLockException $e)
            {

            }

        }

    }

    public function onAuthenticationSuccess(AuthenticationEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        if(is_object($user))
        {
            if ($user->getLoginTries() > 0)
            {
                $user->setLoginTries('0');
                try
                {
                    $this->entityManager->flush();
                }
                catch (OptimisticLockException $e)
                {

                }
            }

        }

    }


}

