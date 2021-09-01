<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category
            ->setName('Photo')
        ;
        $this->addReference('category1',$category);
        //$this->getReference('category1')

        //getDependancies()

        $manager->persist($category);
        $manager->flush();
            
        
    }
}
