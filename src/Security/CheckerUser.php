<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class CheckerUser implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        $this->checkAuth($user);
    }

    public function checkPostAuth(UserInterface $user)
    {
        $this->checkAuth($user);
    }

    private function checkAuth (UserInterface $user)
    {
        if (!$user instanceof User)
        {
            return;
        }
       // if (str_contains($user->getActivated(false)))
        {
            throw new CustomUserMessageAccountStatusException("Votre compte n'est pas encore activé");
        }
    }
    
}