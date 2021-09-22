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
        $datas = [
           1=> [
                'url' => 'https://youtu.be/_hxLS2ErMiY',

            ],
          2=>  [
                'url' => 'https://youtu.be/gZFWW4Vus-Q',

            ],
          3=>  [
                'url' => 'https://youtu.be/vjVDW-q70ck',

            ],
           4=> [
                'url' => 'https://youtu.be/X_WhGuIY9Ak',

            ],
          5=>  [
                'url' => 'https://youtu.be/hUddT6FGCws',

            ],
           6=> [
                'url' => 'https://youtu.be/_CN_yyEn78M',

            ],
           7=> [
                'url' => 'https://youtu.be/R3OG9rNDIcs',

            ],
           8=> [
                'url' => 'https://youtu.be/e-7NgSu9SXg',

            ],
           9=> [
                'url' => 'https://youtu.be/qyXO40y4fAE',

            ],
           10=> [
                'url' => 'https://youtu.be/_Qq-YoXwNQY',

            ],
        ];

        foreach ($datas as  $videoData) {

        $video = new Video();
        $trick = $this->getReference('trick'.random_int(1,10));
        $video
            ->setUrl($videoData['url'])
            ->setTrick($trick);
            
            
        ;
        
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video);
        }
        $manager->flush();

       /* $video2 = new Video();
        $trick2 = $this->getReference('trick2');
        $video2
            ->setUrl('https://www.youtube.com/watch?v=y2MHu0mbzQw')
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
            ->setUrl('https://www.youtube.com/watch?v=wkQWksgCkYI')
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
            ->setUrl('https://www.youtube.com/watch?v=X_WhGuIY9Ak')
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
            ->setUrl('https://www.youtube.com/watch?v=hUddT6FGCws')
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
            ->setUrl('https://www.youtube.com/watch?v=_CN_yyEn78M')
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
            ->setUrl('https://www.youtube.com/watch?v=WRjNFodnOHk')
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
            ->setUrl('https://www.youtube.com/watch?v=e-7NgSu9SXg')
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
            ->setUrl('https://www.youtube.com/watch?v=qyXO40y4fAE')
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
            ->setUrl('https://www.youtube.com/watch?v=id8VKl9RVQw')
            ->setTrick($trick10);
            
            
        ;
        $this->addReference('video10',$video10);
        //$this->getReference('video1')

        //getDependancies()

        $manager->persist($video10);
        $manager->flush();*/
        
    }
    public function getDependencies()
    {
        return [
            TrickFixtures::class,
           
        ];
    }
}