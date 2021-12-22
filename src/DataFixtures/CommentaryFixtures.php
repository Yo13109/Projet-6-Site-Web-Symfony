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
        $datas = [
            [
                'content' => 'ok pas de soucis',

            ],
            [
                'content' => 'je trouve la figure superbe',

            ],

        ];

        foreach ($datas as $commentaryData) {
            $comment = new Commentary();
            $user = $this->getReference( 'user1' );
            $trick = $this->getReference( 'trick' . random_int( 1 , 10));
            $date = new DateTime();
            $comment
                ->setContent($commentaryData[ 'content' ])
                ->setDate($date)
                ->setUser($user)
                ->setTrick($trick);

            $manager->persist($comment);
        }
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
