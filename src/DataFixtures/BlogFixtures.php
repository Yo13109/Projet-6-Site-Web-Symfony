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
        $faker = \Faker\Factory::create('fr_FR');

        //Creer 3 catégories fakées

        for ($i = 1; $i <= 3;$i++){

             $category = new Category();
             $category -> setName($faker->sentence());

        $manager->persist($category);

   //Creer 3 users fakées

   for($k = 1; $k <= 3; $k++ ) {
       $user = new User();
       $user->setEmail($faker->freeEmail())
            ->setAvatar($faker->imageUrl())
            ->setRoles($faker->sentence())
            ->setPassword($faker->sentence())
            ->setToken($faker->sentence())
            ->setActivated($faker->boolean());

       $manager->persist($user);
            

   }

//Creer des figures

for ($j = 1; $j <= 10; $j++ ) {

        $trick = new Trick();
        $content = '<p>'. join($faker->paragraphs(5),'</p><p>') . '</p>';
        $trick->setName($faker->sentence())
            ->setContent($content)
            ->setCreateDate($faker->dateTimeBetween('-6 days'))
            ->setSlug($faker->sentence())
            ->setUpdateDate($faker->dateTimeBetween('-6 days'))
            ->setCategory($category)
            ->setUsers($user);

        $manager->persist($trick);

        }
        // Creer des commentaires aux figures
        for ($l = 1; $l = mt_rand(2,5); $l++ ) {
            
            $commentary = new Commentary();
            $content = '<p>'. join($faker->paragraphs(1),'</p><p>') . '</p>';
            $days = (new DateTime())->diff($trick->getCreateDate())->$days;

            $commentary->setContent($content)
                       ->setDate($faker->dateTimeBetween('-'. $days .'days'))
                       ->setUser($user)
                       ->setTrick($trick);
            $manager->persist($commentary);
        
    }

        
        $manager->flush();
    }
}