<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $user
            ->setUserName('Admin')
            ->setEmail('yoann.corsi@gmail.com')
            ->setAvatar('yoann.jpg')
            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                'Yoann13109'
            ))
            ->setToken($token)
            ->setActivated(1);
        $this->addReference('user1', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
