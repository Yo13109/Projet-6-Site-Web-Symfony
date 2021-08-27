<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\Commentary;
use Symfony\Component\Validator\Constraints\DateTime;





class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
}}