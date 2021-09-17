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
        /*  $trick = new Trick();
       
        $user = $this->getReference('user1');
        $date = new DateTime();
        $category = $this->getReference('category1');
        $trick
            ->setName('Methode Air')
            ->setContent('Un backside ou un air droit où le patineur attrape la planche sur le bord du talon entre les pieds avec sa main avant et cambre le corps en ramenant la planche vers l_arrière.')
            ->setCreateDate($date)
            ->setUpdateDate($date)
            ->setSlug($this->slugger->slug($trick->getName()))
            ->setUsers($user)
            ->setCategory($category);
            
    
        $this->addReference('trick1',$trick);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($trick);
        $manager->flush();

        $trick2 = new Trick();
        $user = $this->getReference('user1');
        $date = new DateTime();
        $category = $this->getReference('category1');
        $trick2
            ->setName('Nose Grab')
            ->setContent('Un Nosegrab est un trick de skateboard qui consiste à saisir la planche avec une main au niveau du nose le tout en l_air en faisant un ollie ... C_est sûrement un des grabs le plus facile.')
            ->setCreateDate($date)
            ->setUpdateDate($date)
            ->setSlug($this->slugger->slug($trick2->getName()))
            ->setUsers($user)
            ->setCategory($category);
            
    
        $this->addReference('trick2',$trick2);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($trick2);
        $manager->flush();
            
        $trick3 = new Trick();
        $user = $this->getReference('user1');
        $date = new DateTime();
        $category2 = $this->getReference('category2');
        $trick3
            ->setName('Double Back Flip')
            ->setContent('C_est un double retournement en arrière dans le plan qui est perpendiculaire à la pente.')
            ->setCreateDate($date)
            ->setUpdateDate($date)
            ->setSlug($this->slugger->slug($trick3->getName()))
            ->setUsers($user)
            ->setCategory($category2);
            
    
        $this->addReference('trick3',$trick3);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($trick3);
        $manager->flush();
        
        $trick4 = new Trick();
        $user = $this->getReference('user1');
        $date = new DateTime();
        $category = $this->getReference('category1');
        $trick4
            ->setName('Japan Air')
            ->setContent('saisie de l_avant de la planche, avec la main avant, du côté de la carre frontside.')
            ->setCreateDate($date)
            ->setUpdateDate($date)
            ->setSlug($this->slugger->slug($trick4->getName()))
            ->setUsers($user)
            ->setCategory($category);
            
    
        $this->addReference('trick4',$trick4);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($trick4);
        $manager->flush();


        $trick5 = new Trick();
        $user = $this->getReference('user1');
        $date = new DateTime();
        $category3 = $this->getReference('category3');
        $trick5
            ->setName('FrontSite 360')
            ->setContent('360, trois six pour un tour complet')
            ->setCreateDate($date)
            ->setUpdateDate($date)
            ->setSlug($this->slugger->slug($trick5->getName()))
            ->setUsers($user)
            ->setCategory($category3);
            
    
        $this->addReference('trick5',$trick5);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($trick5);
        $manager->flush();
        $trick6 = new Trick();
        $user = $this->getReference('user1');
        $date = new DateTime();
        $category = $this->getReference('category1');
        $trick6
            ->setName('Backside Air')
            ->setContent('le trick qui marque le plus ta personnalit')
            ->setCreateDate($date)
            ->setUpdateDate($date)
            ->setSlug($this->slugger->slug($trick6->getName()))
            ->setUsers($user)
            ->setCategory($category);
            
    
        $this->addReference('trick6',$trick6);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($trick6);
        $manager->flush();

        $trick7 = new Trick();
        $user = $this->getReference('user1');
        $date = new DateTime();
        $category4 = $this->getReference('category4');
        $trick7
            ->setName('Boardslide')
            ->setContent('Un slide est dit «board slide » lorsque le rider slide littéralement sur la board.')
            ->setCreateDate($date)
            ->setUpdateDate($date)
            ->setSlug($this->slugger->slug($trick7->getName()))
            ->setUsers($user)
            ->setCategory($category4);
            
    
        $this->addReference('trick7',$trick7);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($trick7);
        $manager->flush();

        $trick8 = new Trick();
        $user = $this->getReference('user1');
        $date = new DateTime();
        $category4 = $this->getReference('category4');
        $trick8
            ->setName('50-50')
            ->setContent('Un 50-50 consiste simplement à glisser le long d_un élement, le contact entre la board et la cible s_effectuant en l_occurrence- au niveau des deux axes')
            ->setCreateDate($date)
            ->setUpdateDate($date)
            ->setSlug($this->slugger->slug($trick8->getName()))
            ->setUsers($user)
            ->setCategory($category4);
            
    
        $this->addReference('trick8',$trick8);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($trick8);
        $manager->flush();

        $trick9 = new Trick();
        $user = $this->getReference('user1');
        $date = new DateTime();
        $category4 = $this->getReference('category4');
        $trick9
            ->setName('Front Bluntslide')
            ->setContent('Un slide où il faut faire passer le pied avant au-dessus du rail en arrivant, avec la board perpendiculaire au rail, et faire 3/4 d_un tour sur le rail.')
            ->setCreateDate($date)
            ->setUpdateDate($date)
            ->setSlug($this->slugger->slug($trick9->getName()))
            ->setUsers($user)
            ->setCategory($category4);
            
    
        $this->addReference('trick9',$trick9);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($trick9);
        $manager->flush();

        $trick10 = new Trick();
        $user = $this->getReference('user1');
        $date = new DateTime();
        $category = $this->getReference('category1');
        $trick10
            ->setName('Tail Grab')
            ->setContent('saisie de la partie arrière de la planche, avec la main arrière')
            ->setCreateDate($date)
            ->setUpdateDate($date)
            ->setSlug($this->slugger->slug($trick10->getName()))
            ->setUsers($user)
            ->setCategory($category);
            
    
        $this->addReference('trick10',$trick10);
        //$this->getReference('user1')

        //getDependancies()

        $manager->persist($trick10);
        $manager->flush();*/

        $datas = [
           1=> [
                'name' => 'Methode Air',
                'content' => 'Un backside ou un air droit où le patineur attrape la planche sur le bord du talon entre les pieds avec sa main avant et cambre le corps en ramenant la planche vers l_arrière.',
            ],
           2 => [
                'name' => 'Nose Grab',
                'content' => 'Un Nosegrab est un trick de skateboard qui consiste à saisir la planche avec une main au niveau du nose le tout en l_air en faisant un ollie ... C_est sûrement un des grabs le plus facile.',
            ],
           3 => [
                'name' => 'Double Back Flip',
                'content' => 'C_est un double retournement en arrière dans le plan qui est perpendiculaire à la pente.',
            ],
           4 =>  [
                'name' => 'Japan Air',
                'content' => 'saisie de l_avant de la planche, avec la main avant, du côté de la carre frontside.',
            ],
           5 =>  [
                'name' => 'FrontSite 360',
                'content' => '360, trois six pour un tour complet',
            ],
           6 =>  [
                'name' => 'Backside Air',
                'content' => 'le trick qui marque le plus ta personnalité',
            ],
           7 => [
                'name' => 'Boardslide',
                'content' => 'Un slide est dit «board slide » lorsque le rider slide littéralement sur la board.',
            ],
           8 =>  [
                'name' => '50-50',
                'content' => 'Un 50-50 consiste simplement à glisser le long d_un élement, le contact entre la board et la cible s_effectuant en l_occurrence- au niveau des deux axes',
            ],
           9 => [
                'name' => 'Front Bluntslide',
                'content' => 'Un slide où il faut faire passer le pied avant au-dessus du rail en arrivant, avec la board perpendiculaire au rail, et faire 3/4 d_un tour sur le rail.',
            ],
           10 =>[
                'name' => 'Tail Grab',
                'content' => 'saisie de la partie arrière de la planche, avec la main arrière',
            ],
        ];

        foreach ($datas as $key=> $trickData) {

            $trick = new Trick();
            $user = $this->getReference('user1');
            $date = new DateTime();
            $date2 = (new DateTime())->diff($trick->getCreateDate());
            $category = $this->getReference('category'. random_int(1,4));
            $trick
                ->setName($trickData['name'])
                ->setContent($trickData['content'])
                ->setCreateDate($date)
                ->setUpdateDate($date)
                ->setSlug($this->slugger->slug($trick->getName()))
                ->setUsers($user)
                ->setCategory($category);


            $this->addReference('trick'.$key , $trick);
            //$this->getReference('user1')

            //getDependancies()

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
