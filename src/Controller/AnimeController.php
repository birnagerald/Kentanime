<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Repository\AnimeRepository;
use App\Repository\EpisodeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnimeController extends AbstractController
{
    /**
     * @Route("/anime", name="anime")
     */
    public function index(AnimeRepository $repo)
    {

        $animes = $repo->findAll();

        return $this->render('anime/index.html.twig', [
            'animes' => $animes,

        ]);
    }

    /**
     * @Route("/anime/show/{id}", name="anime_show")
     * @param EpisodeRepository $repoEpisode
     * @param Anime $anime
     */
    public function show(Anime $anime, EpisodeRepository $repoEpisode)
    {   
        $episodes = $repoEpisode->findBy(
            array('anime' => $anime->getId()), // Critere
            array('created_at' => 'asc')  // Tri
        );


        $choice = (Anime::CLASSIFICATION);
        switch ($anime->getClassification()) {
            case 0:
                $choice = $choice[0];
                break;
            case 1:
                $choice = $choice[1];
                break;
            case 2:
                $choice = $choice[2];
                break;
            case 3:
                $choice = $choice[3];
                break;
            default:
                $choice = $choice[0];
        }
        return $this->render('anime/show.html.twig', [
            'anime' => $anime,
            'choice' => $choice,
            'episodes' => $episodes
        ]);
    }
}
