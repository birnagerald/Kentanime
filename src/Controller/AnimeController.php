<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Repository\AnimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     */
    public function show(Anime $anime)
    {   
        
        return $this->render('anime/show.html.twig',[
            'anime' => $anime,
        ]);
    }
}
