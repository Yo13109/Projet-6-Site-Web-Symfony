<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class CheckerUser implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User)
        {
            return;
        }
        if (!$user->getActivated())
        {
            throw new CustomUserMessageAccountStatusException("Votre compte n'est pas encore activé");
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User)
        {
            return;
        }
    }

    
    
}