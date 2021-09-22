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
        1=>    [
                'filename' => 'MethodeAir.jpg',

            ],
          2=>  [
                'filename' => 'NoseGrab.jpg',

            ],
          3=>  [
                'filename' => 'doublebackflip.png',

            ],
           4=> [
                'filename' => 'japanAir.jpg',

            ],
          5=>  [
                'filename' => 'frontsite.jpg',

            ],
           6=> [
                'filename' => 'backsideAir.jpg',

            ],
           7=> [
                'filename' => 'Boardslide.jpeg',

            ],
          8=>  [
                'filename' => '50-50.png',

            ],
          9=>  [
                'filename' => 'FrontBluntslide.jpg',

            ],
          10=>  [
                'filename' => 'TailGrab.jpg',

            ],
        ];

        foreach ($datas as  $pictureData) {
            $picture = new Picture();
            $trick = $this->getReference('trick'.random_int(1,10));
            $picture
                ->setFilename($pictureData['filename'])
                ->setMain('0')
                ->setTricks($trick);;

            //$this->getReference('picture1')

            //getDependancies()

            $manager->persist($picture);
        }
        $manager->flush();



        /*$picture2 = new Picture();
        $trick = $this->getReference('trick2');
        $picture2
            ->setFilename('https://ultimatesnowsports.com/wp-content/uploads/2015/08/Nose-grab-330x220.jpg')
            ->setMain('https://i.ytimg.com/vi/y2MHu0mbzQw/hqdefault.jpg')
            ->setTricks($trick);;

        //$this->getReference('picture1')

        //getDependancies()

        $manager->persist($picture2);
        $manager->flush();

        $picture3 = new Picture();
        $trick = $this->getReference('trick3');
        $picture3
            ->setFilename('https://img.redbull.com/images/c_fill,w_1500,h_1000,g_auto,f_auto,q_auto/redbullcom/2013/04/29/1331588070338_1/le-double-backflip-de-brage-richenberg')
            ->setMain('https://i.ytimg.com/vi/kmCqi3Pa4Cg/maxresdefault.jpg')
            ->setTricks($trick);;

        //$this->getReference('picture1')

        //getDependancies()

        $manager->persist($picture3);
        $manager->flush();

        $picture4 = new Picture();
        $trick = $this->getReference('trick4');
        $picture4
            ->setFilename('https://www.alexandrecorroy.fr/snowtricks/uploads/pictures/front_japan_air.jpg')
            ->setMain('https://i.ytimg.com/vi/jH76540wSqU/hqdefault.jpg')
            ->setTricks($trick);;

        //$this->getReference('picture1')

        //getDependancies()

        $manager->persist($picture4);
        $manager->flush();

        $picture5 = new Picture();
        $trick = $this->getReference('trick5');
        $picture5
            ->setFilename('https://live.staticflickr.com/2075/2319855559_2887938f5b_b.jpg')
            ->setMain('https://d3j2bju5c7tc02.cloudfront.net/2016_44/open-uri20150528-41247-smtz0c')
            ->setTricks($trick);;

        //$this->getReference('picture1')

        //getDependancies()

        $manager->persist($picture5);
        $manager->flush();



        $picture6 = new Picture();
        $trick = $this->getReference('trick6');
        $picture6
            ->setFilename('https://coresites-cdn-adm.imgix.net/onboard/wp-content/uploads/2013/10/LetItRide_CraigKelly_WorldChampionshipColorado_1990cJonFoster_Red_Bull_Content_Pool-620x418.jpg')
            ->setMain('https://www.snowsurf.com/media/Cody%20Rosenthal.png')
            ->setTricks($trick);;

        //$this->getReference('picture1')

        //getDependancies()

        $manager->persist($picture6);
        $manager->flush();

        $picture7 = new Picture();
        $trick = $this->getReference('trick7');
        $picture7
            ->setFilename('https://miro.medium.com/max/4096/1*QDE76DCnVHn1i84l5Ml4GA.jpeg')
            ->setMain('http://cdn.shopify.com/s/files/1/0230/2239/articles/How_To_Frontside_Boardslide_1024x1024.jpg?v=1556157786')
            ->setTricks($trick);;

        //$this->getReference('picture1')

        //getDependancies()

        $manager->persist($picture7);
        $manager->flush();

        $picture8 = new Picture();
        $trick = $this->getReference('trick8');
        $picture8
            ->setFilename('https://c8.alamy.com/compfr/pgy67t/un-snowboarder-freestyle-50-50-fait-glisser-sur-un-rail-pgy67t.jpg')
            ->setMain('http://cdn.shopify.com/s/files/1/0230/2239/articles/Fronside5050Blank_1024x1024.png?v=1473020198')
            ->setTricks($trick);;

        //$this->getReference('picture1')

        //getDependancies()

        $manager->persist($picture8);
        $manager->flush();

        $picture9 = new Picture();
        $trick = $this->getReference('trick9');
        $picture9
            ->setFilename('https://cdn.shopify.com/s/files/1/0230/2239/files/2_d9cffdae-d6f6-4b1f-8a9b-1980600a86dd_large.jpg?v=1508887005')
            ->setMain('http://cdn.shopify.com/s/files/1/0230/2239/articles/Snowboard_Trick_Terminology_1024x1024.jpg?v=1556396922')
            ->setTricks($trick);;

        //$this->getReference('picture1')

        //getDependancies()

        $manager->persist($picture9);
        $manager->flush();

        $picture10 = new Picture();
        $trick = $this->getReference('trick10');
        $picture10
            ->setFilename('https://upload.wikimedia.org/wikipedia/commons/1/13/Snowboarding_Frontside_Tail_Grab.jpg')
            ->setMain('https://snowboard.frederic-malard.com/illustrations/tail-6.jpg')
            ->setTricks($trick);;

        //$this->getReference('picture1')

        //getDependancies()

        $manager->persist($picture10);
        $manager->flush();*/
    }
    public function getDependencies()
    {
        return [
            TrickFixtures::class,
        ];
    }
}
