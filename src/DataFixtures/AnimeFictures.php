<?php

namespace App\DataFixtures;

use App\Entity\Anime;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AnimeFictures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        //Créer 3 animes fake
        for ($i = 1; $i <= 3; $i++) {
            $anime = new Anime;
            $anime->setTitle($faker->word)
                ->setDescription($faker->paragraph())
                ->setAnneeDeProduction(mt_rand(2000, 2020))
                ->setStudio($faker->word)
                ->setClassification(mt_rand(0, 3))
                ->setNote(mt_rand(0.0, 5.0));

            $manager->persist($anime);
        }

        // Créer 5 episodes

        for ($j = 1; $j <= 5; $j++) {
            $episode = new Episode();
            $episode->setTitre($faker->word)
                ->setNumero(mt_rand(1, 5))
                ->setLien('https://www.google.com')
                ->setAnime($anime);

            $manager->persist($episode);
        }

        $manager->flush();
    }
}
