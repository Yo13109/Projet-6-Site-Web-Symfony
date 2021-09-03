<?php

namespace App\DataFixtures;


use DateTime;
use App\Entity\Trick;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $trick = new Trick();
       
        $user = $this->getReference('user1');
        $date = new DateTime();
        $category = $this->getReference('category1');
        $trick
            ->setName('Photo')
            ->setSlug('Photo')
            ->setContent('la photo date de 5 ans')
            ->setCreateDate($date)
            ->setUpdateDate($date)
            ->setUsers($user)
            ->setCategory($category);
            
    
        $this->addReference('trick1',$trick);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($user);
        $manager->flush();
            
        
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
