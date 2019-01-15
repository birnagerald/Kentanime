<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Page;
use App\Entity\Posts;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        //Créer 3 catégories fake

        for ($i = 1; $i <= 3; $i++) {
            $category = new Category;
            $category->setTitle($faker->word)
                ->setDescription($faker->paragraph());

            $manager->persist($category);

            // Créer 2 pages

            for ($j = 1; $j <= 2; $j++) {
                $page = new Page();
                $page->setTitle($faker->word)
                    ->setContent($faker->paragraphs($nb = 2, $asText = true))
                    ->setImage($faker->imageUrl($width = 1400, $height = 350))
                    ->setAuthor($faker->name)
                    ->setCategory($category)
                    ->setClassification(0);

                $manager->persist($page);
            }
            // Créer entre  4-6 posts

            for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                $post = new Posts();
                $post->setTitle($faker->sentence)
                    ->setContent($faker->paragraphs($nb = 3, $asText = true))
                    ->setImage($faker->imageUrl($width = 640, $height = 480))
                    ->setAuthor($faker->name)
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);

                $manager->persist($post);

                //On ajoute des commentaires au post

                for ($k = 1; $k <= mt_rand(0, 3); $k++) {

                    $comment = new Comment;

                    $now = new \DateTime();
                    $interval = $now->diff($post->getCreatedAt());
                    $days = $interval->days;
                    $minimum = '-' . $days . 'days';

                    $comment->setAuthor($faker->name)
                        ->setContent($faker->paragraphs($nb = 3, $asText = true))
                        ->setcreatedAt($faker->dateTimeBetween($minimum))
                        ->setPost($post);

                    $manager->persist($comment);
                }
            }

        }

        $manager->flush();
    }
}