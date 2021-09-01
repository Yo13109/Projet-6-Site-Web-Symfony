<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PictureFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $picture = new Picture();
        $picture
            ->setFilename('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setMain('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            
        ;
        $this->addReference('picture1',$picture);
        //$this->getReference('picture1')

        //getDependancies()

        $manager->persist($picture);
        $manager->flush();
            
        
    }
}
