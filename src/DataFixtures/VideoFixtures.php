<?php

namespace App\DataFixtures;

use App\Entity\Video;
use App\Entity\Picture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class VideoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $video = new Video();
        $video
            ->setUrl('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            
            
        ;
        $this->addReference('video1',$video);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video);
        $manager->flush();
            
        
    }
}