<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Trick;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager) 
    {
        $datas = [
           1 => [
                'name' => 'Methode Air',
                'content' => 'Un backside ou un air droit où le patineur attrape la planche sur le bord du talon entre les pieds avec sa main avant et cambre le corps en ramenant la planche vers l_arrière.',
                'category' => 1,
            ],
           2 => [
                'name' => 'Nose Grab',
                'content' => 'Un Nosegrab est un trick de skateboard qui consiste à saisir la planche avec une main au niveau du nose le tout en l_air en faisant un ollie ... C_est sûrement un des grabs le plus facile.',
                'category' => 1,
            ],
           3 => [
                'name' => 'Double Back Flip',
                'content' => 'C_est un double retournement en arrière dans le plan qui est perpendiculaire à la pente.',
                'category' => 2,
            ],
           4 =>  [
                'name' => 'Japan Air',
                'content' => 'saisie de l_avant de la planche, avec la main avant, du côté de la carre frontside.',
                'category' => 1,
            ],
           5 =>  [
                'name' => 'FrontSite 360',
                'content' => '360, trois six pour un tour complet',
                'category' => 3,
                'pictures' => 5,
            ],
           6 =>  [
                'name' => 'Backside Air',
                'content' => 'le trick qui marque le plus ta personnalité',
                'category' => 1,
            ],
           7 => [
                'name' => 'Boardslide',
                'content' => 'Un slide est dit «board slide » lorsque le rider slide littéralement sur la board.',
                'category' => 4,
            ],
           8 => [
                'name' => '50-50',
                'content' => 'Un 50-50 consiste simplement à glisser le long d_un élement, le contact entre la board et la cible s_effectuant en l_occurrence- au niveau des deux axes',
                'category' => 4,
            ],
           9 => [
                'name' => 'Front Bluntslide',
                'content' => 'Un slide où il faut faire passer le pied avant au-dessus du rail en arrivant, avec la board perpendiculaire au rail, et faire 3/4 d_un tour sur le rail.',
                'category' => 4,
            ],
           10 => [
                'name' => 'Tail Grab',
                'content' => 'saisie de la partie arrière de la planche, avec la main arrière',
                'category' => 1,
            ],
        ];

        foreach ($datas as $key => $trickData)
        {
            $trick = new Trick();
            $user = $this->getReference('user1');
            $date = new DateTime();
            $category = $this->getReference('category'. $trickData[ 'category' ]);
            $trick
                ->setName($trickData[ 'name' ])
                ->setContent($trickData[ 'content' ])
                ->setCreateDate($date) 
                ->setUpdateDate($date)
                ->setSlug($this->slugger->slug($trick->getName()))
                ->setUsers($user)
                ->setCategory($category)
                ;
            $this->addReference('trick' . $key, $trick);
            $manager->persist($trick);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}