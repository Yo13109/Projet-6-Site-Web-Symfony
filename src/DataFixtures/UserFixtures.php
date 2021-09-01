<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setAvatar('Photo')
            ->setEmail('yoann.corsi@gmail.com')
            ->setPassword('Yoann13109') //hash  du  mot de passe
            ->setToken('fksdofkpfk')
            ->setActivated(1)
        ;
        $this->addReference('user1',$user);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($user);
        $manager->flush();
            
        
    }
}
