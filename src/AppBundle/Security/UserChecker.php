<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserChecker as BaseUserChecker;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker extends BaseUserChecker
{
    public function checkPreAuth(UserInterface $user)
    {
        parent::checkPreAuth($user);

    }

    public function checkPostAuth(UserInterface $user)
    {
        parent::checkPostAuth($user);

        if($user->getAccountStatus()=='B')
        {
            throw(
                    new CustomUserMessageAuthenticationException('User account is locked please contact your administrator.')
            );
        }


    }
}