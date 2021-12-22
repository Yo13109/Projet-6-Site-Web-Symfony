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
           1 => [
                'url' => 'https://www.youtube.com/embed/_hxLS2ErMiY',

            ],
          2 =>  [
                'url' => 'https://www.youtube.com/embed/gZFWW4Vus-Q',

            ],
          3 =>  [
                'url' => 'https://www.youtube.com/embed/vjVDW-q70ck',

            ],
           4 => [
                'url' => 'https://www.youtube.com/embed/X_WhGuIY9Ak',

            ],
          5 =>  [
                'url' => 'https://www.youtube.com/embed/hUddT6FGCws',

            ],
           6 => [
                'url' => 'https://www.youtube.com/embed/_CN_yyEn78M',

            ],
           7 => [
                'url' => 'https://www.youtube.com/embed/R3OG9rNDIcs',

            ],
           8 => [
                'url' => 'https://www.youtube.com/embed/e-7NgSu9SXg',

            ],
           9 => [
                'url' => 'https://www.youtube.com/embed/qyXO40y4fAE',

            ],
           10 => [
                'url' => 'https://www.youtube.com/embed/_Qq-YoXwNQY',

            ],
        ];

        foreach ($datas as  $videoData) {

        $video = new Video();
        $trick = $this->getReference('trick'.random_int(1,10));
        $video
            ->setUrl($videoData['url'])
            ->setTrick($trick);      
        ;
        $manager->persist($video);
        }
        $manager->flush();   
    }
    public function getDependencies()
    {
        return [
            TrickFixtures::class,
           
        ];
    }
}