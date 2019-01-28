<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
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
        $user = $security->getUser();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setPost($post);
            $comment->setUser($user);

            $this->em = $em;
            $this->em->persist($comment);

            $this->em->flush();

            return $this->redirectToRoute('news_show', array('id' => $post->getId()));
        }


        return $this->render('news/show.html.twig', [
            'post' => $post,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Permet de report un commentaire
     * 
     * @route("/actualites/show/{post_id}/comment/{id}/report", name="comment_report")
     *
     * @param Request $request
     * @param Comment $comment
     * @param ObjectManager $em
     * @return Response
     */
    public function reportComment(Request $request, ObjectManager $em, Comment $comment) : Response
    {

        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'message' => 'Il faut être connecté pour pouvoir signaler un commentaire !'
            ], 401);
        } elseif ($comment->getReport()) {
            return $this->json([
                'message' => 'Commentaire déjà signalé par la communauté'
            ], 403);
        } else {

            $comment->setReport(true);
            $em->flush();
            return $this->json([
                'message' => 'Commentaire bien signalé'
            ], 200);
        }
    }

    public function deleteComment()
    {

    }

}
