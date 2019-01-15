<?php

namespace App\Controller;

use App\Entity\Page;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    /**
     * @Route("/catalogue", name="catalogue")
     */
    public function index(PageRepository $repo)
    {
        $pages = $repo->findAll();
        return $this->render('pages/index.html.twig', [
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/catalogue/show/{id}", name="page_show")
     */
    public function show(Page $page)
    {   
        return $this->render('pages/show.html.twig',[
            'page' => $page,
        ]);
        
    }
}
