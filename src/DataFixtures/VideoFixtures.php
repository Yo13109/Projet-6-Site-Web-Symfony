<?php

namespace App\DataFixtures;

use App\Entity\Video;
use App\Entity\Picture;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\TrickFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $video = new Video();
        $trick = $this->getReference('trick1');
        $video
            ->setUrl('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setTrick($trick);
            
            
        ;
        $this->addReference('video1',$video);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video);
        $manager->flush();

        $video2 = new Video();
        $trick2 = $this->getReference('trick2');
        $video2
            ->setUrl('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setTrick($trick2);
            
            
        ;
        $this->addReference('video2',$video2);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video2);
        $manager->flush();

        $video3 = new Video();
        $trick3 = $this->getReference('trick3');
        $video3
            ->setUrl('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setTrick($trick3);
            
            
        ;
        $this->addReference('video3',$video3);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video3);
        $manager->flush();

        $video4 = new Video();
        $trick4 = $this->getReference('trick4');
        $video4
            ->setUrl('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setTrick($trick4);
            
            
        ;
        $this->addReference('video4',$video4);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video4);
        $manager->flush();

        $video5 = new Video();
        $trick5 = $this->getReference('trick5');
        $video5
            ->setUrl('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setTrick($trick5);
            
            
        ;
        $this->addReference('video5',$video5);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video5);
        $manager->flush();

        $video6 = new Video();
        $trick6 = $this->getReference('trick6');
        $video6
            ->setUrl('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setTrick($trick6);
            
            
        ;
        $this->addReference('video6',$video6);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video6);
        $manager->flush();

        $video7 = new Video();
        $trick7 = $this->getReference('trick7');
        $video7
            ->setUrl('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setTrick($trick7);
            
            
        ;
        $this->addReference('video7',$video7);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video7);
        $manager->flush();

        $video8 = new Video();
        $trick8 = $this->getReference('trick8');
        $video8
            ->setUrl('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setTrick($trick8);
            
            
        ;
        $this->addReference('video8',$video8);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video8);
        $manager->flush();

        $video9 = new Video();
        $trick9 = $this->getReference('trick9');
        $video9
            ->setUrl('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setTrick($trick9);
            
            
        ;
        $this->addReference('video9',$video9);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video9);
        $manager->flush();
            

        $video10 = new Video();
        $trick10 = $this->getReference('trick10');
        $video10
            ->setUrl('https://snowtricks.jeandescorps.fr/images/stalefish.jpg')
            ->setTrick($trick10);
            
            
        ;
        $this->addReference('video10',$video10);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video10);
        $manager->flush();
        
    }
    public function getDependencies()
    {
        return [
            TrickFixtures::class,
           
        ];
    }
}