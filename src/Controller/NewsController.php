<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Posts;

class NewsController extends AbstractController
{
    /**
     * @Route("/actualites", name="news")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Posts::class);
        $posts = $repo->findAll();
        return $this->render('news/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/actualites/show/{id}", name="news_show")
     */
    public function show($id)
    {   
        $repo = $this->getDoctrine()->getRepository(Posts::class);
        $post = $repo->find($id);
        return $this->render('news/show.html.twig',[
            'post' => $post,
        ]);
    }
}
