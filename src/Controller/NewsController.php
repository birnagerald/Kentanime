<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsController extends AbstractController
{
    /**
     * @Route("/actualites", name="news_index")
     */
    public function index(PostRepository $repo)
    {
        $posts = $repo->findAll();
        return $this->render('news/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/actualites/show/{id}", name="news_show")
     * @param Post $post
     * @param Security $security
     */
    public function show(Post $post, Request $request, Security $security)
    {   
        $comment = new Comment();
        // $form = $this->createForm(CommentType::class, $comment);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {

        //     $comment->setAuthor($this->getUser()->getUsername());
        //     $comment->setUser($user);

        //     $this->em = $em;
        //     $this->em->persist($comment);

        //     $this->em->flush();
        //     $this->addFlash('success', 'Commentaire posté avec succès');
            
        //     return $this->redirectToRoute('news_show');
        // }


        return $this->render('news/show.html.twig',[
            // 'form' => $form->createView(),
            'post' => $post,
        ]);
    }
}
