<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\TrickFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PictureFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $picture = new Picture();
        $trick = $this->getReference('trick1');
        $picture
            ->setFilename('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setMain('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setTricks($trick);
            
        ;
        $this->addReference('picture1',$picture);
        //$this->getReference('picture1')

        //getDependancies()

        $manager->persist($picture);
        $manager->flush();
            
        
    }
    public function getDependencies()
    {
        return [
            TrickFixtures::class,
            UserFixtures::class,
        ];
    }
}
