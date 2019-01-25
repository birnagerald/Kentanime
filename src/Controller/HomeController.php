<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $posts = $paginator->paginate(
            $repo->createQuery(),

            $request->query->getInt('page', 1),
            3
        );

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
        ]);
    }

}
