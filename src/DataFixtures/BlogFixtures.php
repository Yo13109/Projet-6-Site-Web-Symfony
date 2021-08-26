<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\Category;




class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $trick = new Trick();
        $trick->setName("mute")
            ->setContent("saisie de la carre frontside de la planche entre les deux pieds avec la main avant")
            ->setCreateDate(new \DateTime())
            ->setSlug("mute-1")
            ->setUpdateDate(new \DateTime())
            ->setCategory(new Category);

        $manager->persist($trick);
        $manager->flush();
    }
}
