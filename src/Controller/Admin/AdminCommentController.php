<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="admin_comment_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(CommentRepository $commentRepo) : Response
    {
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $commentRepo->findBy(
                array('report' => 1), // Critere
                array('updatedAt' => 'desc')  // Tri
            )
        ]);
    }

    /**
     * Edit a comment
     * 
     * @Route("/admin/comment/{id}/edit", name="admin_comment_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Request $request
     * @param Comment $category
     * @return Response
     */
    public function edit(Request $request, Comment $comment) : Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Commentaire édité avec succès');

            return $this->redirectToRoute('admin_comment_index');
        }

        return $this->render('admin/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete a comment
     * 
     * @Route("/admin/comment/{id}", name="admin_comment_delete", methods={"DELETE"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     *
     * @param Request $request
     * @param Comment $category
     * @return Response
     */
    public function delete(Request $request, Comment $comment) : Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Commentaire supprimé avec succès');
        }

        return $this->redirectToRoute('admin_comment_index');
    }
}
