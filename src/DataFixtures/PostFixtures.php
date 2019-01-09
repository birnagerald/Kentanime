<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Posts;
use Faker;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 10; $i++){
            $post = new Posts();
            $post->setTitle($faker->sentence)
                    ->setContent($faker->text($maxNbChars = 5000))
                    ->setImage($faker->imageUrl($width = 640, $height = 480))
                    ->setAuthor($faker->name)
                    ->setCategory($faker->word)
                    ->setCreatedAt(new \DateTime());
            $manager->persist($post);
        }

        $manager->flush();
    }
}
