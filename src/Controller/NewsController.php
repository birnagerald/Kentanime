<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
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
     * @param ObjectManager $em
     * @param Request $request
     */
    public function show(Post $post, Request $request, ObjectManager $em, Security $security)
    {   
        $comment = new Comment();
        
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setAuthor($this->getUser()->getUsername());
            $comment->setPost($post);

            $this->em = $em;
            $this->em->persist($comment);

            $this->em->flush();
            
            return $this->redirectToRoute('news_show', array('id' => $post->getId()));
        }


        return $this->render('news/show.html.twig',[
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
