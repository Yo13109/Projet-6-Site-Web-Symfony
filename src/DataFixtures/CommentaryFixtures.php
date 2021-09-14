<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Commentary;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\TrickFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentaryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $comment = new Commentary();
        $user = $this->getReference('user1');
        $trick = $this->getReference('trick1');
        $date = new DateTime();
        $comment
            ->setContent('ok pas de soucis')
            ->setDate($date)
            ->setUser($user)
            ->setTrick($trick);
        $this->addReference('comment1', $comment);
        //$this->getReference('comment1')

        //getDependancies()

        $manager->persist($comment);
        $manager->flush(); 
        
        $comment2 = new Commentary();
        $user = $this->getReference('user1');
        $trick = $this->getReference('trick1');
        $date = new DateTime();
        $comment2
            ->setContent('je trouve la figure superbe')
            ->setDate($date)
            ->setUser($user)
            ->setTrick($trick);
        $this->addReference('comment2', $comment2);
        //$this->getReference('comment1')

        //getDependancies()

        $manager->persist($comment2);
        $manager->flush();  
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TrickFixtures::class,
        ];
    }
}
