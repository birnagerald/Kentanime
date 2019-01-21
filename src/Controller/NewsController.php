<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Posts;
use App\Repository\PostsRepository;

class NewsController extends AbstractController
{
    /**
     * @Route("/actualites", name="news_index")
     */
    public function index(PostsRepository $repo)
    {
        $posts = $repo->findAll();
        return $this->render('news/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/actualites/show/{id}", name="news_show")
     */
    public function show(Posts $post)
    {   
        
        return $this->render('news/show.html.twig',[
            'post' => $post,
        ]);
    }
}
