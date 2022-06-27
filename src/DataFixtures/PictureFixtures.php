<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use App\DataFixtures\TrickFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $datas = [
            1 =>    [
                'filename' => 'MethodeAir.jpg',
                'tricks' => 1
            ],
            2 =>  [
                'filename' => 'NoseGrab.jpg',
                'tricks' => 2
            ],
            3 =>  [
                'filename' => 'double.jpg',
                'tricks' => 3
            ],
            4 => [
                'filename' => 'japanAir.jpg',
                'tricks' => 4
            ],
            5 =>  [
                'filename' => 'frontsite.jpg',
                'tricks' => 5
            ],
            6 => [
                'filename' => 'toto.jpg',
                'tricks' => 6
            ],
            7 => [
                'filename' => 'Boardslide.jpg',
                'tricks' => 7
            ],
            8 =>  [
                'filename' => '50-50.png',
                'tricks' => 8
            ],
            9 =>  [
                'filename' => 'FrontBluntslide.jpg',
                'tricks' => 9
            ],
            10 =>  [
                'filename' => 'TailGrab.jpg',
                'tricks' => 10

            ],
        ];

        foreach ($datas as $pictureData) {
            $picture = new Picture();
            $trick = $this->getReference('trick' . $pictureData[ 'tricks' ]);
            $picture
                ->setFilename($pictureData['filename'])
                ->setMain(true)
                ->setTricks($trick);;
            $manager->persist($picture);
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
