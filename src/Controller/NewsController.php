<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
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
     * @return Response
     */
    public function show(Post $post, Request $request, ObjectManager $em, Security $security) : Response
    {
        $comment = new Comment();
        $user = $security->getUser();

        $form = $this->createForm(CommentType::class, $comment);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $comment->setPost($post);
                $comment->setUser($user);

                $this->em = $em;
                $this->em->persist($comment);

                $this->em->flush();
                if (!$user) {
                    return $this->json([
                        'message' => 'Il faut être connecté pour pouvoir signaler un commentaire !'
                    ], 401);
                } else {
                    $commentResponse = ['content' => $comment->getContent(), 'id' => $comment->getId(), 'user' => $user->getUsername()];
                    return $this->json([
                        'message' => 'Commentaire bien ajouté',
                        'comment' => json_encode($commentResponse),

                    ], 200);
                }

            } else {
                return $this->json([
                    'message' => 'Formulaire invalide veuillez entrer un commentaire valide'
                ], 409);
            }
        }


        return $this->render('news/show.html.twig', [
            'post' => $post,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Report a comment with AJAX
     * 
     * @route("/actualites/show/{post_id}/comment/{id}/report", name="comment_report", methods="GET|POST")
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
                'message' => 'Commentaire signalé avec succès'
            ], 200);
        }
    }

    /**
     * Delete a comment with AJAX
     * 
     * @route("/actualites/show/{post_id}/comment/{id}/delete", name="comment_delete", methods="GET|POST")
     *
     * @param Request $request
     * @param ObjectManager $em
     * @param Comment $comment
     * @param Security $security
     */
    public function deleteComment(Request $request, ObjectManager $em, Comment $comment, Security $security)
    {
        $user = $this->getUser();
        if ($user && $comment) {
            $userId = $user->getId();
            $commentUserId = $comment->getUser()->getId();
            $commentId = $comment->getId();
        }


        if (!$user) {
            return $this->json([
                'message' => 'Il faut être connecté pour pouvoir supprimer un commentaire !'
            ], 401);
        } elseif ($userId == $commentUserId || $security->isGranted('ROLE_ADMIN', $user)) {
            $em->remove($comment);
            $em->flush();
            return $this->json([
                'message' => 'Commentaire supprimé avec succès',
                'commentId' => $commentId
            ], 200);
        } else {
            return $this->json([
                'message' => 'Une erreur s\'est produite',
            ], 500);
        }

    }

}
