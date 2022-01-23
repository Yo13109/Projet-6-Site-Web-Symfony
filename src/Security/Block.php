<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\Mailer;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class Block extends UserCheckerInterface
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