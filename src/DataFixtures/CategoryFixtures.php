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
            4 => [
                'name' => 'Slide',

            ],
        ];
        foreach ($datas as $key => $categoryData) {
            $category = new Category();
            $category
                ->setName($categoryData[ 'name' ]);  
            $this->addReference('category' . $key, $category);
            $manager->persist($category);
        }
        $manager->flush();
    }
 }