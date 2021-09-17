<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {

        $datas = [
           1 => [
                'name' => 'Grab',

            ],
           2 => [
                'name' => 'Flip',

            ],
           3 => [
                'name' => 'Rotation',

            ],
            4 =>[
                'name' => 'Slide',

            ],
        ];
        foreach ($datas as $key => $categoryData) {
            $category = new Category();
            $category
                ->setName($categoryData['name']);
                   
            $this->addReference('category'. $key , $category);



            $manager->persist($category);
        }
        $manager->flush();
    }
}

        /*$category2 = new Category();
        $category2
            ->setName('Flip');
        $this->addReference('category2', $category2);
        $manager->persist($category2);
        $manager->flush();

        $category3 = new Category();
        $category3
            ->setName('Rotation');
        $this->addReference('category3', $category3);
        $manager->persist($category3);
        $manager->flush();

        $category4 = new Category();
        $category4
            ->setName('Slide');
        $this->addReference('category4', $category4);
        $manager->persist($category4);
        $manager->flush();
    }*/
